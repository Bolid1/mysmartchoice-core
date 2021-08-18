<template>
  <!-- Page Heading -->
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <inertia-link class="underline" :href="route('integrations.index')"
          >Integrations</inertia-link
        >
        -> {{ integration.title || "Create" }}
      </h2>
    </div>
  </header>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <form
          @submit.prevent="
            integration.id
              ? form.patch(route('integrations.update', integration))
              : form.post(route('integrations.store'))
          "
          class="p-4"
        >
          <!-- title -->
          <div class="pt-2">
            <breeze-label for="title">Title</breeze-label>
            <breeze-input
              id="title"
              type="text"
              v-model="form.title"
              class="mt-1 block w-full"
              required
              autofocus
            />
            <div v-if="form.errors.title">{{ form.errors.title }}</div>
          </div>

          <!-- description -->
          <div class="pt-2">
            <breeze-label for="description">Description</breeze-label>
            <breeze-input
              id="description"
              type="text"
              v-model="form.description"
              class="mt-1 block w-full"
              required
              autofocus
            />
            <div v-if="form.errors.description">
              {{ form.errors.description }}
            </div>
          </div>

          <!-- Auth section-->
          <div class="pt-2">
            <ul class="flex cursor-pointer">
              <li class="py-2 px-6 ml-1 bg-white rounded-t-lg">OAuth2</li>
              <li
                class="
                  py-2
                  px-6
                  ml-1
                  bg-white
                  rounded-t-lg
                  text-gray-500
                  bg-gray-200
                "
              >
                Key
              </li>
              <li
                class="
                  py-2
                  px-6
                  ml-1
                  bg-white
                  rounded-t-lg
                  text-gray-500
                  bg-gray-200
                "
              >
                Has no auth
              </li>
            </ul>
          </div>

          <!-- oauth2_client_id -->
          <div class="pt-2">
            <breeze-label for="oauth2_client_id"
              >Select OAuth client</breeze-label
            >

            <el-select
              v-model="form.settings.oauth2_client_id"
              placeholder="Please, select..."
              class="mt-1 block w-full"
              filterable
            >
              <el-option
                v-for="client in oauth_clients.data"
                :key="client.id"
                :label="`${client.name} [${client.redirect}]`"
                :value="client.id"
              >
              </el-option>
            </el-select>
            <div v-if="form.errors['settings.oauth2_client_id']">
              {{ form.errors["settings.oauth2_client_id"] }}
            </div>
          </div>

          <!-- submit -->
          <div class="pt-2" v-if="integration.id">
            <breeze-button
              type="submit"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Save
            </breeze-button>
          </div>
          <div class="pt-2" v-else>
            <breeze-button
              type="submit"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Create
            </breeze-button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
  import AuthenticatedLayout from "@/Layouts/Authenticated"
  import BreezeButton from "@/Components/Button"
  import BreezeInput from "@/Components/Input"
  import BreezeLabel from "@/Components/Label"
  import BreezeValidationErrors from "@/Components/ValidationErrors"
  import { ElOption, ElSelect } from "element-plus"
  import { useForm } from "@inertiajs/inertia-vue3"
  import { has, get, extend } from "lodash"

  export default {
    layout: AuthenticatedLayout,
    props: ["integration", "oauth_clients"],
    components: {
      BreezeButton,
      BreezeInput,
      BreezeLabel,
      BreezeValidationErrors,
      ElSelect,
      ElOption,
    },
    setup(props) {
      const form = useForm({
        title: props.integration.title,
        description: props.integration.description,
        settings: extend(
          {
            auth: "oauth2",
            oauth2_client_id: "",
          },
          props.integration.settings
        ),
      })

      return { form }
    },
    methods: {
      has,
      get,
    },
  }
</script>

<style scoped></style>

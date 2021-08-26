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

  <el-card class="mt-2">
    <el-form label-position="left" label-width="100px" :model="form">
      <el-form-item label="Title" :error="form.errors.title">
        <el-input
          id="title"
          type="text"
          v-model="form.title"
          class="mt-1 block w-full"
          required
          autofocus
        />
      </el-form-item>

      <el-form-item label="Description" :error="form.errors.description">
        <el-input
          id="description"
          type="text"
          v-model="form.description"
          class="mt-1 block w-full"
          required
          autofocus
        />
      </el-form-item>

      <el-tabs>
        <el-tab-pane label="OAuth2">
          <el-form-item
            label="Client"
            :error="form.errors['settings.oauth2_client_id']"
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
          </el-form-item>

          <el-form-item
            label="Scopes"
            :error="form.errors['settings.oauth2_scopes']"
          >
            <el-select
              v-model="form.settings.oauth2_scopes"
              placeholder="Please, select..."
              class="mt-1 block w-full"
              filterable
              multiple
            >
              <el-option
                v-for="scope in oauth_scopes"
                :key="scope.key"
                :label="scope.description"
                :value="scope.key"
              >
              </el-option>
            </el-select>
          </el-form-item>
        </el-tab-pane>
        <el-tab-pane disabled label="Key"></el-tab-pane>
        <el-tab-pane disabled label="No auth"></el-tab-pane>
      </el-tabs>

      <el-button
        v-if="!integration.id"
        :disabled="form.processing"
        type="primary"
        @click="form.post(route('integrations.store'))"
        >Create</el-button
      >
      <el-button
        v-if="integration.id"
        :disabled="form.processing"
        type="primary"
        @click="form.patch(route('integrations.update', { integration }))"
        >Save</el-button
      >
      <el-button
        v-if="integration.id"
        :disabled="form.processing"
        type="danger"
        @click="form.delete(route('integrations.destroy', { integration }))"
        >Delete</el-button
      >
    </el-form>
  </el-card>
</template>

<script>
  import AuthenticatedLayout from "@/Layouts/Authenticated"
  import { useForm } from "@inertiajs/inertia-vue3"
  import { has, get, extend } from "lodash"
  import { scopesManager } from "@/Managers/OAuth/Scopes"

  export default {
    layout: AuthenticatedLayout,
    props: ["integration"],
    data() {
      return {
        oauth_clients: {},
        oauth_scopes: [],
      }
    },
    setup(props) {
      const form = useForm({
        title: props.integration.title,
        description: props.integration.description,
        settings: extend(
          {
            auth: "oauth2",
            oauth2_client_id: "",
            oauth2_scopes: [],
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
    created() {
      axios.get("/api/oauth/clients").then((response) => {
        this.oauth_clients = response.data
      })
      scopesManager.load().then((scopes) => {
        this.oauth_scopes = scopes
      })
    },
  }
</script>

<style scoped></style>

<template>
  <!--  <template #header>-->
  <!--    <h2 class="font-semibold text-xl text-gray-800 leading-tight">-->
  <!--      {{ form.name }}-->
  <!--    </h2>-->
  <!--  </template>-->

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <form
          @submit.prevent="form.patch($route('users.update', user))"
          class="p-4"
        >
          <!-- name -->
          <div class="pt-2">
            <breeze-label for="name">Name</breeze-label>
            <breeze-input
              id="name"
              type="text"
              v-model="form.name"
              class="mt-1 block w-full"
              required
              autofocus
            />
            <div v-if="form.errors.name">{{ form.errors.name }}</div>
          </div>

          <!-- email -->
          <div class="pt-2">
            <breeze-label for="email">Email</breeze-label>
            <breeze-input
              id="email"
              type="email"
              v-model="form.email"
              class="mt-1 block w-full bg-gray-100"
              required
              disabled
            />
            <div v-if="form.errors.email">{{ form.errors.email }}</div>
          </div>

          <!-- password -->
          <div class="pt-2">
            <breeze-label for="password">Password</breeze-label>
            <breeze-input
              id="password"
              type="password"
              v-model="form.password"
              class="mt-1 block w-full bg-gray-100"
              disabled
            />
            <div v-if="form.errors.password">{{ form.errors.password }}</div>
          </div>

          <!-- submit -->
          <div class="pt-2">
            <breeze-button
              type="submit"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Save
            </breeze-button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
  import { useForm } from "@inertiajs/inertia-vue3"
  import AuthenticatedLayout from "@/Layouts/Authenticated"
  import BreezeButton from "@/Components/Button"
  import BreezeInput from "@/Components/Input"
  import BreezeLabel from "@/Components/Label"
  import BreezeValidationErrors from "@/Components/ValidationErrors"

  export default {
    layout: AuthenticatedLayout,
    props: ["user"],
    components: {
      BreezeButton,
      BreezeInput,
      BreezeLabel,
      BreezeValidationErrors,
    },
    setup(props) {
      const form = useForm({
        name: props.user.name,
        email: props.user.email,
        password: null,
      })

      return { form }
    },
  }
</script>

<template>
  <!-- Page Heading -->
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <inertia-link class="underline" :href="route('firms.show', firm)">{{
          firm.title
        }}</inertia-link>
        ->
        <inertia-link
          class="underline"
          :href="route('firms.accounts.index', firm)"
          >Accounts</inertia-link
        >
        -> {{ account.title || "Create" }}
      </h2>
    </div>
  </header>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <form
          @submit.prevent="
            account.id
              ? form.patch(route('firms.accounts.update', { firm, account }))
              : form.post(route('firms.accounts.store', firm))
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

          <!-- balance -->
          <div class="pt-2">
            <breeze-label for="balance">Balance</breeze-label>
            <breeze-input
              id="balance"
              type="number"
              min="-1000000000"
              max="1000000000"
              step="0.01"
              v-model="form.balance"
              class="mt-1 block w-full"
              required
            />
            <div v-if="form.errors.balance">{{ form.errors.balance }}</div>
          </div>

          <!-- submit -->
          <div class="pt-2" v-if="account.id">
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
  import { useForm } from "@inertiajs/inertia-vue3"
  import AuthenticatedLayout from "@/Layouts/Authenticated"
  import BreezeButton from "@/Components/Button"
  import BreezeInput from "@/Components/Input"
  import BreezeLabel from "@/Components/Label"
  import BreezeValidationErrors from "@/Components/ValidationErrors"

  export default {
    layout: AuthenticatedLayout,
    props: ["firm", "account"],
    components: {
      BreezeButton,
      BreezeInput,
      BreezeLabel,
      BreezeValidationErrors,
    },
    setup(props) {
      const form = useForm({
        title: props.account.title,
        balance: props.account.balance,
      })

      return { form }
    },
  }
</script>

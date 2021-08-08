<template>
  <!-- Page Heading -->
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight flex-grow">
        <inertia-link class="underline" :href="route('firms.show', firm)">{{
          firm.title
        }}</inertia-link>
        -> Accounts
      </h2>
      <div class="flex-shrink-1">
        <inertia-link :href="route('firms.accounts.create', firm)"
          ><breeze-button>Create</breeze-button></inertia-link
        >
      </div>
    </div>
  </header>

  <div class="pt-6 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <div class="bg-white overflow-hidden shadow-sm">
        <div class="py-6 px-4 sm:px-6 lg:px-8">
          <div v-for="account in accounts.data">
            <inertia-link
              class="underline"
              :href="route('firms.accounts.show', { firm, account })"
            >
              Account "{{ account.title }}" balance =
              {{ formatMoney(account.currency, account.balance) }}
            </inertia-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import AuthenticatedLayout from "@/Layouts/Authenticated"
  import BreezeButton from "@/Components/Button"
  import { formatMoney } from "@/Helpers/Money"

  export default {
    layout: AuthenticatedLayout,
    props: ["firm", "accounts"],
    components: {
      BreezeButton,
    },
    methods: {
      formatMoney,
    },
  }
</script>

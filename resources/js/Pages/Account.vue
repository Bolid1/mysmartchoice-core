<template>
  <!-- Page Heading -->
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight flex-grow">
        <inertia-link class="underline" :href="$route('firms.show', firm)">{{
          firm.title
        }}</inertia-link>
        ->
        <inertia-link
          class="underline"
          :href="$route('firms.accounts.index', firm)"
          >Accounts</inertia-link
        >
        -> {{ account.title }}
      </h2>
      <div class="flex-shrink-1">
        <inertia-link :href="$route('firms.accounts.edit', { firm, account })"
          ><el-button plain type="primary">Edit</el-button></inertia-link
        >
        <inertia-link
          :href="$route('firms.accounts.destroy', { firm, account })"
          method="delete"
          ><el-button plain type="danger">Delete</el-button></inertia-link
        >
      </div>
    </div>
  </header>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          balance: {{ formatMoney(account.currency, account.balance) }}
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
    props: ["firm", "account"],
    components: {
      BreezeButton,
    },
    methods: {
      formatMoney,
    },
  }
</script>

<style scoped></style>

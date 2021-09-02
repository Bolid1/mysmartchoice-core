<template>
  <!-- Page Heading -->
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight flex-grow">
        <Link class="underline" :href="this.$route('firms.show', firm)">{{
          firm.title
        }}</Link>
        ->
        <Link
          class="underline"
          :href="this.$route('firms.accounts.index', firm)"
          >Accounts</Link
        >
        -> {{ account.title }}
      </h2>
      <div class="flex-shrink-1">
        <Link :href="this.$route('firms.accounts.edit', { firm, account })"
          ><el-button plain type="primary">Edit</el-button></Link
        >
        <Link
          :href="this.$route('firms.accounts.destroy', { firm, account })"
          method="delete"
          as="button"
          ><el-button plain type="danger">Delete</el-button></Link
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
  import BreezeButton from "@/Components/Button"
  import { formatMoney } from "@/Helpers/Money"
  import { Link } from "@inertiajs/inertia-vue3"
  import { defineComponent } from "vue"

  export default defineComponent({
    props: ["firm", "account"],
    components: {
      BreezeButton,
      Link,
    },
    methods: {
      formatMoney,
    },
  })
</script>

<style scoped></style>

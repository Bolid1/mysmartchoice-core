<template>
  <!-- Page Heading -->
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight flex-grow">
        <Link class="underline" :href="this.$route('firms.show', firm)">{{
          firm.title
        }}</Link>
        -> Accounts
      </h2>
      <div class="flex-shrink-1">
        <Link :href="this.$route('firms.accounts.create', firm)"
          ><breeze-button>Create</breeze-button></Link
        >
      </div>
    </div>
  </header>

  <div class="pt-6 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <div class="bg-white overflow-hidden shadow-sm">
        <div class="py-6 px-4 sm:px-6 lg:px-8">
          <div v-for="account in accounts.data">
            <Link
              class="underline"
              :href="this.$route('firms.accounts.show', { firm, account })"
            >
              Account "{{ account.title }}" balance =
              {{ formatMoney(account.currency, account.balance) }}
            </Link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import BreezeButton from "@/Components/Button"
  import { formatMoney } from "@/Helpers/Money"
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"

  export default defineComponent({
    props: ["firm", "accounts"],
    components: {
      BreezeButton,
      Link,
    },
    methods: {
      formatMoney,
    },
  })
</script>

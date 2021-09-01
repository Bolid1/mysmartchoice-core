<template>
  <!-- Page Heading -->
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ firm.title }}
      </h2>
    </div>
  </header>

  <div class="pt-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <el-row :gutter="12" justify="space-between">
      <el-col
        v-for="(balance, currency) in balances"
        :xs="12"
        :sm="6"
        :md="4"
        :lg="4"
        :xl="3"
        class="mt-2"
      >
        <el-card>
          {{ formatMoney(currency, balance) }}
        </el-card>
      </el-col>
    </el-row>
  </div>

  <div class="pt-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
          <h3 class="font-semibold text-xl text-gray-800 leading-tight">
            <inertia-link
              class="underline"
              :href="$route('firms.accounts.index', firm)"
            >
              Accounts
            </inertia-link>
          </h3>
        </div>
      </header>

      <div class="bg-white overflow-hidden shadow-sm">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <div v-for="account in firm.accounts">
            <inertia-link
              class="underline"
              :href="$route('firms.accounts.show', { firm, account })"
            >
              Account "{{ account.title }}" balance = {{ account.balance }}
            </inertia-link>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="pt-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
          <h3 class="font-semibold text-xl text-gray-800 leading-tight">
            <inertia-link
              class="underline"
              :href="$route('firms.users.index', firm)"
            >
              Users
            </inertia-link>
          </h3>
        </div>
      </header>

      <div class="bg-white overflow-hidden shadow-sm">
        <div
          class="
            max-w-7xl
            mx-auto
            py-6
            px-4
            sm:px-6
            lg:px-8
            flex flex-wrap
            justify-center
          "
        >
          <div
            v-for="user in firm.users"
            class="max-w-md py-4 px-8 bg-white shadow-lg rounded-lg my-20 mx-2"
          >
            <user-card :user="user" />
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="pt-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
          <h3 class="font-semibold text-xl text-gray-800 leading-tight">
            <inertia-link
              class="underline"
              :href="$route('firms.firm_integrations.index', { firm })"
            >
              Integrations
            </inertia-link>
          </h3>
        </div>
      </header>

      <div class="bg-white overflow-hidden shadow-sm">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex flex-wrap">
          <firm-integration-card
            v-for="install in firm.integrations_installs"
            :install="install"
            class="w-72 p-6 py-4 px-8 bg-white shadow-lg rounded-lg my-2 mx-2"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  // @ts-ignore
  import AuthenticatedLayout from "@/Layouts/Authenticated"
  // @ts-ignore
  import UserCard from "@/Components/UserCard"
  // @ts-ignore
  import FirmIntegrationCard from "@/Components/FirmIntegrationCard"
  import { formatMoney } from "@/Helpers/Money"
  import { defineComponent } from "vue"

  export default defineComponent({
    layout: AuthenticatedLayout,
    components: { FirmIntegrationCard, UserCard },
    props: {
      firm: Object,
      balances: Object,
    },
    setup() {
      return {
        formatMoney,
      }
    },
  })
</script>

<style scoped></style>

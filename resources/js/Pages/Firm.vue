<template>
  <!-- Page Heading -->
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ firm.title }}
      </h2>
    </div>
  </header>

  <div class="pt-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
          <h3 class="font-semibold text-xl text-gray-800 leading-tight">
            <inertia-link
              class="underline"
              :href="route('firms.accounts.index', firm)"
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
              :href="route('firms.accounts.show', { firm, account })"
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
              :href="route('firms.users.index', firm)"
            >
              Users
            </inertia-link>
          </h3>
        </div>
      </header>

      <div class="bg-white overflow-hidden shadow-sm">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <div v-for="user in firm.users">
            User with name "{{ user.name }}" registered with email "{{
              user.email
            }}"
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import AuthenticatedLayout from "@/Layouts/Authenticated"

  export default {
    layout: AuthenticatedLayout,
    props: ["firm"],
  }
</script>

<style scoped></style>

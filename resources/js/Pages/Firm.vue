<template>
  <!-- Page Heading -->
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ firm.title }}
      </h2>
    </div>
  </header>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div v-for="user in firm.users">
          User with name "{{ user.name }}" registered with email "{{
            user.email
          }}"
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

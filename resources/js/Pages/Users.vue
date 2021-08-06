<template>
  <!--    <template #header>-->
  <!--      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Users</h2>-->
  <!--    </template>-->

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div v-for="user in users.data">
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
    props: ["users"],
  }
</script>

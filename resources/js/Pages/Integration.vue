<template>
  <!-- Page Heading -->
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight flex-grow">
        <inertia-link class="underline" :href="$route('integrations.index')"
          >Integrations</inertia-link
        >
        -> {{ integration.title }}
      </h2>
      <div class="flex-shrink-1">
        <inertia-link
          :href="$route('integrations.destroy', { integration })"
          method="delete"
          class="mr-2"
          ><breeze-button color="red">Delete</breeze-button></inertia-link
        >
        <inertia-link :href="$route('integrations.edit', { integration })"
          ><breeze-button>Edit</breeze-button></inertia-link
        >
      </div>
    </div>
  </header>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          Id: {{ integration.id }}<br />
          Title: {{ integration.title }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import AuthenticatedLayout from "@/Layouts/Authenticated"
  import BreezeButton from "@/Components/Button"

  export default {
    layout: AuthenticatedLayout,
    props: ["integration"],
    components: {
      BreezeButton,
    },
  }
</script>

<style scoped></style>

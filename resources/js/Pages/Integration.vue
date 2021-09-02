<template>
  <!-- Page Heading -->
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight flex-grow">
        <Link class="underline" :href="this.$route('integrations.index')"
          >Integrations</Link
        >
        -> {{ integration.title }}
      </h2>
      <div class="flex-shrink-1">
        <Link
          :href="this.$route('integrations.destroy', { integration })"
          method="delete"
          as="button"
          class="mr-2"
          ><breeze-button color="red">Delete</breeze-button></Link
        >
        <Link :href="this.$route('integrations.edit', { integration })"
          ><breeze-button>Edit</breeze-button></Link
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
  import BreezeButton from "@/Components/Button"
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"

  export default defineComponent({
    props: ["integration"],
    components: {
      BreezeButton,
      Link,
    },
  })
</script>

<style scoped></style>

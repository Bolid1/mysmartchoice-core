<template>
  <h1>{{ integration.title }} settings</h1>

  <p>{{ integration.description }}</p>

  <button>Install</button>

  <form class="flex flex-col">
    <label> <input type="checkbox" /> Accounts </label>
    <label> <input type="checkbox" /> Transactions </label>
  </form>
</template>

<script>
  import AuthenticatedLayout from "@/Layouts/Authenticated"

  export default {
    layout: AuthenticatedLayout,
    props: ["install"],
    computed: {
      firm() {
        return this.install.firm || {}
      },
      integration() {
        return this.install.integration || {}
      },
    },
  }
</script>

<style scoped></style>

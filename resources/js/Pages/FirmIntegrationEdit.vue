<template>
  <h1>Integration settings</h1>

  <div>
    {{ install }}
  </div>
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

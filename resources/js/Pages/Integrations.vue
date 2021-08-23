<template>
  <page-header>
    <template #right>
      <inertia-link :href="route('integrations.create')"
        ><breeze-button color="green">Create</breeze-button></inertia-link
      >
    </template>
  </page-header>

  <div class="pt-6 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <div class="bg-white overflow-hidden shadow-sm">
        <div class="py-6 px-4 sm:px-6 lg:px-8">
          <div v-for="integration in integrations.data">
            <inertia-link
              class="underline"
              :href="route('integrations.show', integration)"
            >
              Integration#{{ integration.id }} ({{ integration.title }})
            </inertia-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import AuthenticatedLayout from "@/Layouts/Authenticated"
  import BreezeButton from "@/Components/Button"
  import PageHeader from "@/Components/PageHeader"

  export default {
    layout: AuthenticatedLayout,
    props: ["integrations"],
    components: {
      PageHeader,
      BreezeButton,
    },
  }
</script>

<style scoped></style>

<template>
  <page-header>
    <template #default>
      <inertia-link class="underline" :href="$route('firms.show', firm)">{{
        firm.title
      }}</inertia-link>
      -> Integrations
    </template>
    <template #right>
      <inertia-link :href="$route('firms.firm_integrations.create', firm)"
        ><breeze-button>Create</breeze-button></inertia-link
      >
    </template>
  </page-header>

  <page-block v-if="firm_integrations.meta?.total">
    <h3>Installed {{ firm_integrations.meta.total }} integration(s)</h3>

    <div class="flex flex-wrap">
      <firm-integration-card
        class="w-72 p-6 py-4 px-8 bg-white shadow-lg rounded-lg my-1 mx-1"
        v-for="firm_integration in firm_integrations.data"
        :install="firm_integration"
      />
    </div>
  </page-block>

  <page-block v-if="integrations.meta?.total">
    <h3>
      There are {{ integrations.meta.total }} integrations can be installed
    </h3>

    <div class="flex flex-wrap">
      <div
        class="w-72 p-6 py-4 px-8 bg-white shadow-lg rounded-lg my-1 mx-1"
        v-for="integration in integrations.data"
      >
        <h4>{{ integration.title }}</h4>
        <p>{{ integration.description }}</p>
      </div>
    </div>
  </page-block>
</template>

<script>
  import AuthenticatedLayout from "@/Layouts/Authenticated"
  import PageHeader from "@/Components/PageHeader"
  import PageBlock from "@/Components/PageBlock"
  import FirmIntegrationCard from "@/Components/FirmIntegrationCard"
  import BreezeButton from "@/Components/Button"

  export default {
    layout: AuthenticatedLayout,
    components: { BreezeButton, FirmIntegrationCard, PageBlock, PageHeader },
    props: ["firm", "firm_integrations", "integrations"],
  }
</script>

<style scoped></style>

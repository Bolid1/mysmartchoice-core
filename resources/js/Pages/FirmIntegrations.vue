<template>
  <page-header>
    <template #default>
      <Link class="underline" :href="this.$route('firms.show', firm)">{{
        firm.title
      }}</Link>
      -> Integrations
    </template>
    <template #right>
      <Link :href="this.$route('firms.firm_integrations.create', firm)"
        ><breeze-button>Create</breeze-button></Link
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
  import PageHeader from "@/Components/PageHeader"
  import PageBlock from "@/Components/PageBlock"
  import FirmIntegrationCard from "@/Components/FirmIntegrationCard"
  import BreezeButton from "@/Components/Button"
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"

  export default defineComponent({
    components: {
      BreezeButton,
      Link,
      FirmIntegrationCard,
      PageBlock,
      PageHeader,
    },
    props: ["firm", "firm_integrations", "integrations"],
  })
</script>

<style scoped></style>

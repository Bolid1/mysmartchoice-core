<template>
  <page-header>
    <template #right>
      <inertia-link :href="route('o_auth_clients.create')"
        ><breeze-button color="green">Create</breeze-button></inertia-link
      >
    </template>
  </page-header>

  <page-block>
    <div v-for="o_auth_client in o_auth_clients.data" class="p-2">
      <inertia-link
        class="underline"
        :href="route('o_auth_clients.show', o_auth_client)"
      >
        OAuthClient#{{ o_auth_client.id }} [{{ o_auth_client.name }}]
      </inertia-link>
    </div>
  </page-block>
</template>

<script>
  import AuthenticatedLayout from "@/Layouts/Authenticated"
  import PageHeader from "@/Components/PageHeader"
  import BreezeButton from "@/Components/Button"
  import PageBlock from "@/Components/PageBlock"

  export default {
    layout: AuthenticatedLayout,
    components: { PageBlock, PageHeader, BreezeButton },
    props: ["o_auth_clients"],
  }
</script>

<style scoped></style>

<template>
  <page-header>
    <template #default>
      <inertia-link class="underline" :href="route('o_auth_clients.index')"
        >OAuth Clients</inertia-link
      >
      -> {{ o_auth_client.name }}
    </template>
    <template #right>
      <inertia-link
        :href="route('o_auth_clients.destroy', o_auth_client)"
        class="pr-2"
        method="delete"
        ><breeze-button color="red">Delete</breeze-button></inertia-link
      >
      <inertia-link :href="route('o_auth_clients.edit', o_auth_client)"
        ><breeze-button color="green">Edit</breeze-button></inertia-link
      >
    </template>
  </page-header>

  <page-block>
    <div class="px-2 pt-2">id: {{ o_auth_client.id }}</div>
    <div class="px-2 pt-2">secret: {{ o_auth_client.secret }}</div>
    <div class="px-2 pt-2">name: {{ o_auth_client.name }}</div>
    <div class="px-2 pt-2">
      redirect:
      <a :href="o_auth_client.redirect" target="_blank">{{
        o_auth_client.redirect
      }}</a>
    </div>
  </page-block>
</template>

<script>
  import PageHeader from "@/Components/PageHeader"
  import BreezeButton from "@/Components/Button"
  import PageBlock from "@/Components/PageBlock"
  import AuthenticatedLayout from "@/Layouts/Authenticated"
  export default {
    layout: AuthenticatedLayout,
    components: { PageBlock, BreezeButton, PageHeader },
    props: ["o_auth_client"],
  }
</script>

<style scoped></style>

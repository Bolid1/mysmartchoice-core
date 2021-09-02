<template>
  <page-header>
    <template #default>
      <Link class="underline" :href="this.$route('o_auth_clients.index')"
        >OAuth Clients</Link
      >
      -> {{ o_auth_client.name }}
    </template>
    <template #right>
      <Link
        :href="this.$route('o_auth_clients.destroy', o_auth_client)"
        class="pr-2"
        method="delete"
        as="button"
        ><breeze-button color="red">Delete</breeze-button></Link
      >
      <Link :href="this.$route('o_auth_clients.edit', o_auth_client)"
        ><breeze-button color="green">Edit</breeze-button></Link
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
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"

  export default defineComponent({
    components: { PageBlock, BreezeButton, Link, PageHeader },
    props: ["o_auth_client"],
  })
</script>

<style scoped></style>

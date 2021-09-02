<template>
  <page-header>
    <template #default>
      <Link class="underline" :href="this.$route('oauth_clients.index')"
        >OAuth Clients</Link
      >
      -> {{ oauth_client.name }}
    </template>
    <template #right>
      <Link
        :href="this.$route('oauth_clients.destroy', oauth_client)"
        class="pr-2"
        method="delete"
        as="button"
        ><breeze-button color="red">Delete</breeze-button></Link
      >
      <Link :href="this.$route('oauth_clients.edit', oauth_client)"
        ><breeze-button color="green">Edit</breeze-button></Link
      >
    </template>
  </page-header>

  <page-block>
    <div class="px-2 pt-2">id: {{ oauth_client.id }}</div>
    <div class="px-2 pt-2">secret: {{ oauth_client.secret }}</div>
    <div class="px-2 pt-2">name: {{ oauth_client.name }}</div>
    <div class="px-2 pt-2">
      redirect:
      <a :href="oauth_client.redirect" target="_blank">{{
        oauth_client.redirect
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
    props: ["oauth_client"],
  })
</script>

<style scoped></style>

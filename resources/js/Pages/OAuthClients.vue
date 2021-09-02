<template>
  <page-header>
    <template #right>
      <Link :href="this.$route('o_auth_clients.create')"
        ><breeze-button color="green">Create</breeze-button></Link
      >
    </template>
  </page-header>

  <page-block>
    <div v-for="o_auth_client in o_auth_clients.data" class="p-2">
      <Link
        class="underline"
        :href="this.$route('o_auth_clients.show', o_auth_client)"
      >
        OAuthClient#{{ o_auth_client.id }} [{{ o_auth_client.name }}]
      </Link>
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
    components: { PageBlock, PageHeader, Link, BreezeButton },
    props: ["o_auth_clients"],
  })
</script>

<style scoped></style>

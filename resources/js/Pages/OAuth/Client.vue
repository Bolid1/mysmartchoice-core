<template>
  <el-container>
    <el-header class="flex items-center">
      <card-header
        :exists="Boolean(client.id)"
        :title="client.name"
        :list-href="this.$route('oauth_clients.index')"
        :delete-href="() => this.$route('oauth_clients.destroy', client)"
        :edit-href="() => this.$route('oauth_clients.edit', client)"
      />
    </el-header>

    <el-main>
      <el-card>
        Id: {{ client.id }}<br />
        Secret: {{ client.secret }}<br />
        Name: {{ client.name }}<br />
        Redirect:
        <el-link :href="client.redirect" target="_blank">{{
          client.redirect
        }}</el-link>
      </el-card>
    </el-main>
  </el-container>
</template>

<script>
  import PageHeader from "@/Components/PageHeader"
  import BreezeButton from "@/Components/Button"
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"
  import DeleteButton from "@/Components/Buttons/DeleteButton"
  import EditButton from "@/Components/Buttons/EditButton"
  import CardHeader from "@/Components/CardHeader"

  export default defineComponent({
    components: {
      CardHeader,
      EditButton,
      DeleteButton,
      BreezeButton,
      Link,
      PageHeader,
    },
    props: ["client"],
  })
</script>

<style scoped></style>

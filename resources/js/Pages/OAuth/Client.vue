<template>
  <el-container>
    <el-header class="flex items-center">
      <card-header
        :exists="Boolean(client.id)"
        :title="client.name"
        :list-href="this.$route('oauth.clients.index')"
        :delete-href="() => this.$route('oauth.clients.destroy', client)"
        :edit-href="() => this.$route('oauth.clients.edit', client)"
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
      Link,
    },
    props: ["client"],
  })
</script>

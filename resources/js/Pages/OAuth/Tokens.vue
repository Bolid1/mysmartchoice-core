<template>
  <page-header>
    <template #right>
      <inertia-link :href="route('oauth.tokens.issue')">
        <breeze-button color="green">Issue</breeze-button>
      </inertia-link>
    </template>
  </page-header>

  <div class="flex p-6">
    <el-card v-for="token in tokens" class="mr-2">
      <h5>{{ token.client.name }}</h5>
      <div>Created at {{ token.created_at }}</div>
      <div>Expire at {{ token.expires_at }}</div>
      <breeze-button @click="revokeToken(token)" as="button" color="red"
        >revoke</breeze-button
      >
    </el-card>
  </div>
</template>

<script>
  import AuthenticatedLayout from "@/Layouts/Authenticated"
  import PageHeader from "@/Components/PageHeader"
  import BreezeButton from "@/Components/Button"
  import PageBlock from "@/Components/PageBlock"

  export default {
    layout: AuthenticatedLayout,
    components: { PageBlock, BreezeButton, PageHeader },
    data() {
      return {
        tokens: [],
      }
    },
    created() {
      axios.get("/api/oauth/tokens/").then((response) => {
        this.tokens = response.data
      })
    },
    methods: {
      loadTokens() {
        axios.get("/api/oauth/tokens/").then((response) => {
          this.tokens = response.data
        })
      },
      revokeToken(token) {
        axios
          .delete(`/api/oauth/tokens/${token.id}`)
          .then(() => this.loadTokens())
      },
    },
  }
</script>

<style scoped></style>

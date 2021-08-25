<template>
  <page-header>
    <template #right>
      <inertia-link :href="route('oauth.tokens.issue')">
        <el-button type="primary">Issue</el-button>
      </inertia-link>
    </template>
  </page-header>

  <el-row :gutter="12">
    <el-col
      v-for="token in tokens"
      :xs="24"
      :sm="12"
      :md="8"
      :lg="6"
      :xl="4"
      class="mt-2"
    >
      <el-card class="mr-2">
        <h5>{{ token.client.name }}</h5>
        <div>Created at {{ token.created_at }}</div>
        <div>Expire at {{ token.expires_at }}</div>
        <div>
          Scopes:
          <ol>
            <li v-for="scope in token.scopes">{{ scope }}</li>
          </ol>
        </div>
        <el-button @click="revokeToken(token)" type="danger">
          Revoke
        </el-button>
      </el-card>
    </el-col>
  </el-row>
</template>

<script>
  import AuthenticatedLayout from "@/Layouts/Authenticated"
  import PageHeader from "@/Components/PageHeader"

  export default {
    layout: AuthenticatedLayout,
    components: { PageHeader },
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

<template>
  <page-header>
    <template #right>
      <inertia-link :href="$route('oauth.tokens.issue')">
        <el-button plain type="success">Issue</el-button>
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
      <token-card class="mr-2" :token="token" @revoked="loadTokens()" />
    </el-col>
  </el-row>
</template>

<script>
  import AuthenticatedLayout from "@/Layouts/Authenticated"
  import PageHeader from "@/Components/PageHeader"
  import { tokensManager } from "@/Managers/OAuth/Tokens"
  import TokenCard from "@/Components/OAuth/TokenCard"

  export default {
    layout: AuthenticatedLayout,
    components: { TokenCard, PageHeader },
    data() {
      return {
        tokens: [],
      }
    },
    created() {
      this.loadTokens()
    },
    methods: {
      loadTokens() {
        tokensManager.load().then((tokens) => (this.tokens = tokens))
      },
    },
  }
</script>

<style scoped></style>

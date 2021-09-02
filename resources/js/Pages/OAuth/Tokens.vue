<template>
  <el-row :gutter="12">
    <list-col v-for="token in tokens">
      <token-card class="h-full" :token="token" @revoked="loadTokens()" />
    </list-col>
    <list-col>
      <list-card>
        <el-skeleton :rows="4" />
        <template #buttons>
          <Link :href="this.$route('oauth.tokens.issue')" class="ml-2">
            <el-button plain type="success">Create</el-button>
          </Link>
        </template>
      </list-card>
    </list-col>
  </el-row>
</template>

<script>
  import PageHeader from "@/Components/PageHeader"
  import { tokensManager } from "@/Managers/OAuth/Tokens"
  import TokenCard from "@/Components/OAuth/TokenCard"
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"
  import ListCol from "@/Components/ListCol"
  import ListCard from "@/Components/ListCard"

  export default defineComponent({
    components: { ListCard, ListCol, Link, TokenCard, PageHeader },
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
  })
</script>

<style scoped></style>

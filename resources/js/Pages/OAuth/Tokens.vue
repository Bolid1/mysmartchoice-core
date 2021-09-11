<template>
  <el-row :gutter="12">
    <list-col v-for="token in tokens">
      <token-card class="h-full" :token="token" @revoked="loadTokens()" />
    </list-col>
    <list-col-create :rows="4" :href="this.$route('oauth.tokens.issue')" />
  </el-row>
</template>

<script>
  import { tokensManager } from "@/Managers/OAuth/Tokens"
  import { defineComponent } from "vue"
  import ListColCreate from "@/Components/ListColCreate"
  import ListCol from "@/Components/ListCol"
  import TokenCard from "@/Components/OAuth/TokenCard"

  export default defineComponent({
    components: { TokenCard, ListCol, ListColCreate },
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

<template>
  <el-card>
    <h5>{{ token.client.name }}</h5>
    <div>Created at {{ token.created_at }}</div>
    <div>Expire at {{ token.expires_at }}</div>
    <div>
      Scopes:
      <ol>
        <li v-for="scope in token.scopes">{{ scope }}</li>
      </ol>
    </div>
    <el-button @click="revokeToken(token)" type="danger"> Revoke </el-button>
  </el-card>
</template>

<script>
  import { tokensManager } from "@/Managers/OAuth/Tokens"

  export default {
    props: ["token"],
    emits: ["revoked"],
    methods: {
      revokeToken() {
        tokensManager.revoke(this.token).then(() => {
          this.$emit("revoked")
        })
      },
    },
  }
</script>

<style scoped></style>

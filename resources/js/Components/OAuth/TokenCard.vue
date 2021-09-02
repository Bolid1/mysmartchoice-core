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
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"

  export default defineComponent({
    props: ["token"],
    emits: ["revoked"],
    components: { Link },
    methods: {
      revokeToken() {
        tokensManager.revoke(this.token).then(() => {
          this.$emit("revoked")
        })
      },
    },
  })
</script>

<style scoped></style>

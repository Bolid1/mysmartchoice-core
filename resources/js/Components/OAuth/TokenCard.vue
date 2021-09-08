<template>
  <list-card>
    <h5 v-if="token.client">{{ token.client.name }}</h5>
    <div>Created at {{ token.created_at }}</div>
    <div>Expire at {{ token.expires_at }}</div>
    <div>
      Scopes:
      <ol>
        <li v-for="scope in token.scopes">{{ scope }}</li>
      </ol>
    </div>
    <template #buttons>
      <el-button plain type="danger" @click="revokeToken(token)"
        >Revoke</el-button
      >
    </template>
  </list-card>
</template>

<script>
  import { tokensManager } from "@/Managers/OAuth/Tokens"
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"
  import ListCard from "@/Components/ListCard"
  import DeleteButton from "@/Components/Buttons/DeleteButton"

  export default defineComponent({
    props: ["token"],
    emits: ["revoked"],
    components: { DeleteButton, ListCard, Link },
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

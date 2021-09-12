<template>
  <el-card>
    <h1>Authorization Request</h1>

    <p>
      <strong>{{ client.name }}</strong> is requesting permission to access your
      account.
    </p>

    <div class="scopes" v-if="scopes.length">
      <p><strong>This application will be able to:</strong></p>

      <ul>
        <li v-for="scope in scopes" :key="scope.id">
          ✅ {{ scope.description }}
        </li>
      </ul>
    </div>

    <div class="flex">
      <form method="post" :action="this.$route('passport.authorizations.deny')">
        <input type="hidden" name="_token" :value="csrf_token" />
        <input type="hidden" name="_method" value="DELETE" />
        <input type="hidden" name="state" :value="request.state" />
        <input type="hidden" name="client_id" :value="client.id" />
        <input type="hidden" name="auth_token" :value="auth_token" />
        <el-button type="danger" native-type="submit">Cancel</el-button>
      </form>

      <form
        class="ml-2"
        method="post"
        :action="this.$route('passport.authorizations.approve')"
      >
        <input type="hidden" name="_token" :value="csrf_token" />
        <input type="hidden" name="state" :value="request.state" />
        <input type="hidden" name="client_id" :value="client.id" />
        <input type="hidden" name="auth_token" :value="auth_token" />
        <el-button type="success" native-type="submit">Authorize</el-button>
      </form>
    </div>
  </el-card>
</template>

<script lang="ts">
  import LinkButton from "@/Components/Buttons/LinkButton.vue"
  import { defineComponent, PropType } from "vue"

  export default defineComponent({
    name: "AuthorizePage",
    components: { LinkButton },
    props: {
      client: {
        type: Object as PropType<{
          id: string
          user_id: number
          name: string
          provider: any
          redirect: string
          personal_access_client: boolean
          password_client: boolean
          revoked: boolean
          created_at: string
          updated_at: string
        }>,
        required: true,
      },
      user: {
        type: Object as PropType<{
          id: number
          name: string
          created_at: string
          updated_at: string
        }>,
        required: true,
      },
      scopes: {
        type: Object as PropType<Array<{ id: string; description: string }>>,
        required: true,
      },
      request: {
        type: Object as PropType<{
          client_id: string
          redirect_uri: string
          response_type: string
          scope: string[]
          state: string
        }>,
        required: true,
      },
      auth_token: {
        type: String,
        required: true,
      },
      csrf_token: {
        type: String,
        required: true,
      },
    },
  })
</script>

<style scoped></style>

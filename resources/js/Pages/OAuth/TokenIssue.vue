<template>
  <page-header>
    <template #default>
      <inertia-link class="underline" :href="route('oauth.tokens.index')"
        >Tokens</inertia-link
      >
      -> Issue
    </template>
  </page-header>

  <page-block>
    <form @submit.prevent="true" class="p-4">
      <!-- Client select -->
      <div class="pt-2">
        <breeze-label for="client_id">Client</breeze-label>
        <el-select
          v-model="form.client_id"
          placeholder="Please, select..."
          class="mt-1 block w-full"
          filterable
        >
          <el-option
            v-for="client in clients.data"
            :key="client.id"
            :label="`${client.name} [${client.redirect}]`"
            :value="client.id"
          >
          </el-option>
        </el-select>
        <div v-if="form.errors.client_id">{{ form.errors.client_id }}</div>
      </div>

      <!-- submit -->
      <div class="pt-2" v-if="client">
        <inertia-link
          class="underline"
          :href="
            route('passport.authorizations.authorize', {
              client_id: client.id,
              redirect_uri: client.redirect,
              response_type: 'code',
              scope: '',
              state: JSON.stringify({
                client_id: client.id,
                interface: '/oauth/tokens/issue',
              }),
              skips_authorization: true,
            })
          "
          ><breeze-button
            type="submit"
            color="green"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Issue
          </breeze-button></inertia-link
        >
      </div>
    </form>
  </page-block>
</template>

<script>
  import AuthenticatedLayout from "@/Layouts/Authenticated"
  import BreezeButton from "@/Components/Button"
  import PageBlock from "@/Components/PageBlock"
  import PageHeader from "@/Components/PageHeader"
  import { ElOption, ElSelect } from "element-plus"
  import BreezeLabel from "@/Components/Label"
  import BreezeValidationErrors from "@/Components/ValidationErrors"
  import { useForm } from "@inertiajs/inertia-vue3"
  import { find } from "lodash"

  export default {
    layout: AuthenticatedLayout,
    components: {
      BreezeButton,
      BreezeLabel,
      BreezeValidationErrors,
      ElSelect,
      ElOption,
      PageBlock,
      PageHeader,
    },
    data() {
      return {
        clients: {},
      }
    },
    setup() {
      const form = useForm({
        client_id: "",
      })

      return { form }
    },
    computed: {
      client() {
        return (
          (this.form.client_id &&
            find(this.clients.data, { id: this.form.client_id })) ||
          null
        )
      },
    },
    created() {
      axios.get("/api/o_auth_clients/").then((response) => {
        this.clients = response.data
      })
    },
  }
</script>

<style scoped></style>

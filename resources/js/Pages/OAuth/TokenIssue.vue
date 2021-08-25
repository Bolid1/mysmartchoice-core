<template>
  <page-header>
    <template #default>
      <inertia-link class="underline" :href="route('oauth.tokens.index')"
        >Tokens</inertia-link
      >
      -> Issue
    </template>
  </page-header>

  <el-card class="mt-2">
    <el-form label-position="left" label-width="100px" :model="form">
      <el-form-item label="Client" :error="form.errors.client_id">
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
      </el-form-item>

      <el-form-item label="Firm" :error="form.errors.firm_id">
        <el-select
          v-model="form.firm_id"
          placeholder="Please, select..."
          class="mt-1 block w-full"
          filterable
        >
          <el-option
            v-for="firm in firms.data"
            :key="firm.id"
            :label="firm.title"
            :value="firm.id"
          >
          </el-option>
        </el-select>
      </el-form-item>

      <el-form-item label="Firm scopes" :error="form.errors.firm_scopes">
        <el-select
          v-model="form.firm_scopes"
          placeholder="Please, select..."
          class="mt-1 block w-full"
          filterable
          multiple
        >
          <el-option
            v-for="scope in firm_scopes"
            :key="scope"
            :label="scope"
            :value="scope"
          >
          </el-option>
        </el-select>
      </el-form-item>

      <el-form-item v-if="client && firm">
        <inertia-link
          :href="
            route('passport.authorizations.authorize', {
              client_id: client.id,
              redirect_uri: client.redirect,
              response_type: 'code',
              scope: union(
                map(form.firm_scopes, (scope) => `${scope}-firm-${firm.id}`)
              ).join(' '),
              state: JSON.stringify({
                client_id: client.id,
                interface: '/oauth/tokens/issue',
              }),
              skips_authorization: true,
            })
          "
        >
          <el-button :disabled="form.processing" type="primary"
            >Issue</el-button
          ></inertia-link
        >
      </el-form-item>
    </el-form>
  </el-card>
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
  import { find, map, union } from "lodash"
  import axios from "axios"

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
        firms: {},
        firm_scopes: ["view", "update", "destroy"],
      }
    },
    setup() {
      const form = useForm({
        client_id: "",
        firm_id: "",
        firm_scopes: "",
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
      firm() {
        return (
          (this.form.firm_id &&
            find(this.firms.data, { id: this.form.firm_id })) ||
          null
        )
      },
    },
    created() {
      axios.get("/api/o_auth_clients/").then((response) => {
        this.clients = response.data
      })
      axios.get("/api/firms/").then((response) => {
        this.firms = response.data
      })
    },
    methods: {
      map,
      union,
    },
  }
</script>

<style scoped></style>

<template>
  <el-container>
    <el-header class="flex items-center">
      <card-header
        :exists="false"
        :list-href="this.$route('oauth.tokens.index')"
      />
    </el-header>

    <el-main>
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

        <el-form-item label="Plain scopes" :error="form.errors.plain_scopes">
          <el-select
            v-model="form.plain_scopes"
            placeholder="Please, select..."
            class="mt-1 block w-full"
            filterable
            multiple
          >
            <el-option
              v-for="scope in plain_scopes"
              :key="scope.key"
              :label="scope.description"
              :value="scope.key"
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
              v-for="scope in available_firm_scopes"
              :key="scope.key"
              :label="
                String(scope.description).replace('{firm}', firm?.title || '')
              "
              :value="scope.key"
            >
            </el-option>
          </el-select>
        </el-form-item>

        <el-form-item v-if="client && firm">
          <Link
            :href="
              this.$route('passport.authorizations.authorize', {
                client_id: client.id,
                redirect_uri: client.redirect,
                response_type: 'code',
                scope: union(
                  map(form.firm_scopes, (scope) =>
                    String(scope).replace('{firm}', String(form.firm_id))
                  ),
                  form.plain_scopes
                ).join(' '),
                state: JSON.stringify({
                  client_id: client.id,
                  interface: '/oauth/tokens/issue',
                  user_id: Number(this.$page.props.auth.user.id),
                  firm_id: Number(form.firm_id),
                }),
                skips_authorization: true,
              })
            "
          >
            <el-button :disabled="form.processing" type="success"
              >Issue
            </el-button>
          </Link>
        </el-form-item>
      </el-form>
    </el-main>
  </el-container>
</template>

<script>
  import { Link, useForm } from "@inertiajs/inertia-vue3"
  import { filter, find, map, union } from "lodash"
  import axios from "axios"
  import { scopesManager } from "@/Managers/OAuth/Scopes"
  import { defineComponent } from "vue"
  import CardHeader from "@/Components/CardHeader"

  export default defineComponent({
    components: {
      CardHeader,
      Link,
    },
    data() {
      return {
        clients: {},
        firms: {},
        available_firm_scopes: {},
        plain_scopes: {},
      }
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
    methods: {
      map,
      union,
    },
    setup() {
      const form = useForm({
        client_id: "",
        firm_id: "",
        firm_scopes: "",
        plain_scopes: "",
      })

      return { form }
    },
    created() {
      axios.get("/api/oauth_clients/").then((response) => {
        this.clients = response.data
      })
      axios.get("/api/firms/").then((response) => {
        this.firms = response.data
      })

      scopesManager.load().then((scopes) => {
        this.available_firm_scopes = filter(
          scopes,
          (scope) => String(scope.key).indexOf("{firm}") !== -1
        )
        this.plain_scopes = filter(
          scopes,
          (scope) => String(scope.key).indexOf("{") === -1
        )
      })
    },
  })
</script>

<style scoped></style>

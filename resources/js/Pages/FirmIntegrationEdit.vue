<template>
  <page-header>
    <inertia-link class="underline" :href="route('firms.show', firm)">{{
      firm.title
    }}</inertia-link>
    ->
    <inertia-link
      class="underline"
      :href="route('firms.firm_integrations.index', firm)"
      >Integrations</inertia-link
    >
    -> {{ firm_integration.id || "Connect new" }}
  </page-header>

  <el-tabs type="border-card">
    <el-tab-pane label="Settings">
      <el-form
        @submit.prevent="
          firm_integration.id
            ? form.patch(
                route('firms.firm_integrations.update', {
                  firm,
                  firm_integration,
                })
              )
            : form.post(route('firms.firm_integrations.store', firm))
        "
        label-position="left"
        label-width="100px"
        :model="form"
      >
        <el-form-item label="Integration" :error="form.errors.integration_id">
          <el-select
            v-model="form.integration_id"
            placeholder="Integration"
            class="mt-1 block w-full"
            filterable
            :disabled="Boolean(firm_integration.id)"
          >
            <el-option
              v-for="integration in integrations.data"
              :key="integration.id"
              :label="`${integration.title} [${integration.description}]`"
              :value="integration.id"
            >
            </el-option>
          </el-select>
        </el-form-item>

        <el-form-item>
          <el-button-group>
            <el-button type="primary" :disabled="form.processing">
              {{ firm_integration.id ? "Update" : "Install" }}
            </el-button>

            <a
              v-if="
                firm_integration.id &&
                integration?.settings.auth === 'oauth2' &&
                integration.client
              "
              :href="
                route('passport.authorizations.authorize', {
                  client_id: integration.settings.oauth2_client_id,
                  redirect_uri: integration.client.redirect,
                  response_type: 'code',
                  scope: String(
                    join(integration.settings.oauth2_scopes || [], ' ')
                  ).replaceAll('{firm}', String(firm.id)),
                  state: JSON.stringify({
                    client_id: integration.settings.oauth2_client_id,
                    interface: `/firms/${firm.id}/firm_integrations/${firm_integration.id}/edit`,
                  }),
                })
              "
            >
              <el-button :disabled="form.processing" type="primary"
                >Authorize</el-button
              ></a
            >
          </el-button-group>
          <p class="text-sm">
            by clicking the button you agree to provide access for your firm
            data to the 3rd party
          </p>
        </el-form-item>
      </el-form>
    </el-tab-pane>
    <el-tab-pane label="Tokens">
      <el-row>
        <el-col v-for="token in tokens">
          <token-card :token="token" @revoked="loadTokens()" />
        </el-col>
      </el-row>
    </el-tab-pane>
  </el-tabs>
</template>

<script>
  import AuthenticatedLayout from "@/Layouts/Authenticated"
  import PageHeader from "@/Components/PageHeader"
  import { useForm } from "@inertiajs/inertia-vue3"
  import { head, filter, find, join } from "lodash"
  import { tokensManager } from "@/Managers/OAuth/Tokens"
  import TokenCard from "@/Components/OAuth/TokenCard"

  export default {
    layout: AuthenticatedLayout,
    components: {
      TokenCard,
      PageHeader,
    },
    props: ["firm", "firm_integration", "integrations"],
    data() {
      return {
        tokens: [],
      }
    },
    setup(props) {
      const form = useForm({
        integration_id: props.firm_integration.integration_id,
      })

      return { form }
    },
    computed: {
      integration() {
        return head(this.integrations.data)
      },
    },
    methods: {
      join,
      loadTokens() {
        const regexp = new RegExp(`firm-${this.firm.id}[^\d]*`)

        tokensManager.load().then(
          (tokens) =>
            (this.tokens = filter(tokens, {
              client_id: this.integration.client?.id,
            }).filter((token) =>
              find(token.scopes, (scope) => regexp.test(String(scope)))
            ))
        )
      },
    },
    created() {
      if (this.firm_integration.id) {
        this.loadTokens()
      }
    },
  }
</script>

<style scoped></style>

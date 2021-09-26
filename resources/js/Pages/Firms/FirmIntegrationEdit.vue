<template>
  <el-container>
    <el-header class="flex items-center">
      <el-page-header
        icon="el-icon-arrow-left"
        :title="firm.title"
        @back="this.$inertia.get(this.$route('firms.show', { firm }))"
      >
        <template #content>
          <el-page-header
            icon=""
            title="Integrations"
            :content="integration.title"
            @back="
              this.$inertia.get(
                this.$route('firms.firm_integrations.index', { firm })
              )
            "
          />
        </template>
      </el-page-header>

      <el-button-group class="ml-auto">
        <delete-button
          :href="
            this.$route('firms.firm_integrations.destroy', {
              firm,
              firm_integration: install,
            })
          "
        />
        <a
          v-if="integration.settings.auth === 'oauth2'"
          class="el-button el-button--warning"
          :href="
            this.$route('firms.firm_integrations.authorize', {
              firm,
              firm_integration: install,
            })
          "
          target="_blank"
          >Authorize</a
        >
      </el-button-group>
    </el-header>

    <el-main>
      <el-tabs type="border-card">
        <el-tab-pane label="Settings" id="integration-settings">
          This integration has no settings
        </el-tab-pane>
      </el-tabs>
    </el-main>
  </el-container>
</template>

<script>
  import { defineComponent } from "vue"
  import DeleteButton from "@/Components/Buttons/DeleteButton"
  import ShowButton from "@/Components/Buttons/ShowButton"
  import ListCol from "@/Components/ListCol"

  export default defineComponent({
    components: {
      ListCol,
      ShowButton,
      DeleteButton,
    },
    props: {
      firm: {
        required: true,
        type: Object,
      },
      install: {
        required: true,
        type: Object,
      },
      integration: {
        required: true,
        type: Object,
      },
    },
    created() {
      if (this.integration.settings.javascript_file) {
        this.$loadScript(this.integration.settings.javascript_file)
          .then(() => {
            // Script is loaded, do something
          })
          .catch(() => {
            // Failed to fetch script
          })
      }

      return {}
    },
  })
</script>

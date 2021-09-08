<template>
  <el-container>
    <el-header class="flex items-center">
      <card-header
        :exists="false"
        :back-title="firm.title"
        title="Integrations"
        :list-href="this.$route('firms.show', firm)"
      />
    </el-header>

    <el-main>
      <el-row :gutter="12">
        <list-col v-for="install in integrations_installs">
          <list-card>
            <h5>{{ install.integration.title }}</h5>
            <p>{{ install.integration.description }}</p>
            <template #buttons>
              <el-button type="text" disabled>{{ install.status }}</el-button>
              <edit-button
                :href="
                  this.$route('firms.firm_integrations.edit', {
                    firm,
                    firm_integration: install,
                  })
                "
              />
            </template>
          </list-card>
        </list-col>
      </el-row>

      <el-divider v-if="integrations_installs?.length"></el-divider>

      <el-row :gutter="12">
        <list-col v-for="integration in integrations">
          <list-card>
            <h5>{{ integration.title }}</h5>
            <p>{{ integration.description }}</p>
            <template #buttons>
              <create-button
                :href="this.$route('firms.firm_integrations.store', { firm })"
                text="Install"
                method="post"
                :data="{
                  integration_id: integration.id,
                }"
              />
            </template>
          </list-card>
        </list-col>
      </el-row>
    </el-main>
  </el-container>
</template>

<script>
  import { defineComponent } from "vue"
  import CardHeader from "@/Components/CardHeader"
  import ListColCreate from "@/Components/ListColCreate"
  import ListCol from "@/Components/ListCol"
  import ListCard from "@/Components/ListCard"
  import EditButton from "@/Components/Buttons/EditButton"
  import CreateButton from "@/Components/Buttons/CreateButton"

  export default defineComponent({
    components: {
      CreateButton,
      EditButton,
      ListCard,
      ListCol,
      ListColCreate,
      CardHeader,
    },
    props: {
      firm: {
        type: Object,
        required: true,
      },
      integrations_installs: {
        type: Array,
        required: true,
      },
      integrations: {
        type: Array,
        required: true,
      },
    },
  })
</script>

<style scoped></style>

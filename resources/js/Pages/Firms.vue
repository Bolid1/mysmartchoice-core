<template>
  <page-header>
    <template #right>
      <inertia-link :href="route('firms.create')">
        <el-button :disabled="!can.add" plain type="success">
          Create
        </el-button>
      </inertia-link>
    </template>
  </page-header>

  <el-row :gutter="12">
    <el-col
      v-for="firm in firms.data"
      :xs="24"
      :sm="12"
      :md="8"
      :lg="6"
      :xl="4"
      class="mt-2"
    >
      <el-card class="mr-2" shadow="hover">
        <h5>{{ firm.title }}</h5>
        <div class="mt-2 flex justify-end">
          <inertia-link :href="route('firms.show', { firm })" class="ml-2">
            <el-button plain type="primary">View</el-button>
          </inertia-link>
          <inertia-link :href="route('firms.edit', { firm })" class="ml-2"
            ><el-button plain type="primary">Edit</el-button></inertia-link
          >
        </div>
      </el-card>
    </el-col>
  </el-row>
</template>

<script>
  import AuthenticatedLayout from "@/Layouts/Authenticated"
  import PageHeader from "@/Components/PageHeader"

  export default {
    layout: AuthenticatedLayout,
    components: { PageHeader },
    props: ["can", "firms"],
  }
</script>

<style scoped></style>

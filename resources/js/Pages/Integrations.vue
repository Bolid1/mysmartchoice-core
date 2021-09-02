<template>
  <el-row :gutter="12">
    <el-col
      v-for="integration in integrations.data"
      :xs="24"
      :sm="12"
      :md="8"
      :lg="6"
      :xl="4"
      class="mt-2"
    >
      <el-card class="mr-2" shadow="hover">
        <h5>{{ integration.title }}</h5>
        <p>{{ integration.description }}</p>
        <div class="mt-2 flex justify-end">
          <Link
            :href="this.$route('integrations.show', { integration })"
            class="ml-2"
          >
            <el-button plain type="primary">View</el-button>
          </Link>
          <Link
            :href="this.$route('integrations.edit', { integration })"
            class="ml-2"
            ><el-button plain type="primary">Edit</el-button></Link
          >
        </div>
      </el-card>
    </el-col>
    <el-col :xs="24" :sm="12" :md="8" :lg="6" :xl="4" class="mt-2">
      <el-card class="mr-2" shadow="hover">
        <el-skeleton :rows="2" />
        <div class="mt-2 flex justify-end">
          <Link :href="this.$route('integrations.create')" class="ml-2">
            <el-button plain type="success">Create</el-button>
          </Link>
        </div>
      </el-card>
    </el-col>
  </el-row>
</template>

<script>
  import BreezeButton from "@/Components/Button"
  import PageHeader from "@/Components/PageHeader"
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"

  export default defineComponent({
    props: ["integrations"],
    components: {
      PageHeader,
      BreezeButton,
      Link,
    },
  })
</script>

<style scoped></style>

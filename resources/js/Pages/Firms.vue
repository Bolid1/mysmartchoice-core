<template>
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
          <Link :href="this.$route('firms.show', { firm })" class="ml-2">
            <el-button plain type="primary">View</el-button>
          </Link>
          <Link :href="this.$route('firms.edit', { firm })" class="ml-2"
            ><el-button plain type="primary">Edit</el-button></Link
          >
        </div>
      </el-card>
    </el-col>
    <el-col :xs="24" :sm="12" :md="8" :lg="6" :xl="4" class="mt-2">
      <el-card class="mr-2" shadow="hover">
        <el-skeleton :rows="0" />
        <div class="mt-2 flex justify-end">
          <Link :href="this.$route('firms.create')" class="ml-2">
            <el-button plain type="success">Create</el-button>
          </Link>
        </div>
      </el-card>
    </el-col>
  </el-row>
</template>

<script>
  import PageHeader from "@/Components/PageHeader"
  import { Link } from "@inertiajs/inertia-vue3"
  import { defineComponent } from "vue"

  export default defineComponent({
    components: { Link, PageHeader },
    props: ["can", "firms"],
  })
</script>

<style scoped></style>

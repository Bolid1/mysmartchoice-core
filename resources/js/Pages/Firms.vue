<template>
  <el-row :gutter="12">
    <list-col v-for="firm in firms.data">
      <list-card>
        <h5>{{ firm.title }}</h5>
        <template #buttons>
          <Link :href="this.$route('firms.show', { firm })" class="ml-2">
            <el-button plain type="primary">View</el-button>
          </Link>
          <Link :href="this.$route('firms.edit', { firm })" class="ml-2"
            ><el-button plain type="primary">Edit</el-button></Link
          >
        </template>
      </list-card>
    </list-col>
    <list-col>
      <list-card class="h-full" shadow="hover">
        <el-skeleton :rows="0" />
        <template #buttons>
          <Link :href="this.$route('firms.create')" class="ml-2">
            <el-button plain type="success">Create</el-button>
          </Link>
        </template>
      </list-card>
    </list-col>
  </el-row>
</template>

<script>
  import PageHeader from "@/Components/PageHeader"
  import { Link } from "@inertiajs/inertia-vue3"
  import { defineComponent } from "vue"
  import ListCol from "@/Components/ListCol"
  import ListCard from "@/Components/ListCard"

  export default defineComponent({
    components: { ListCard, ListCol, Link, PageHeader },
    props: ["can", "firms"],
  })
</script>

<style scoped></style>

<template>
  <el-row :gutter="12">
    <list-col v-for="integration in integrations.data">
      <list-card class="h-full" shadow="hover">
        <h5>{{ integration.title }}</h5>
        <p>{{ integration.description }}</p>
        <template #buttons>
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
        </template>
      </list-card>
    </list-col>
    <list-col>
      <list-card>
        <el-skeleton :rows="2" />
        <template #buttons>
          <Link :href="this.$route('integrations.create')" class="ml-2">
            <el-button plain type="success">Create</el-button>
          </Link>
        </template>
      </list-card>
    </list-col>
  </el-row>
</template>

<script>
  import BreezeButton from "@/Components/Button"
  import PageHeader from "@/Components/PageHeader"
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"
  import ListCol from "@/Components/ListCol"
  import ListCard from "@/Components/ListCard"

  export default defineComponent({
    props: ["integrations"],
    components: {
      ListCard,
      ListCol,
      PageHeader,
      BreezeButton,
      Link,
    },
  })
</script>

<style scoped></style>

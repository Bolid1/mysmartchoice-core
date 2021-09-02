<template>
  <el-row :gutter="12">
    <list-col v-for="oauth_client in oauth_clients.data" :key="oauth_client.id">
      <list-card>
        <h5>{{ oauth_client.name }}</h5>
        <p>
          <el-link :href="oauth_client.redirect" target="_blank">{{
            oauth_client.redirect
          }}</el-link>
        </p>
        <template #buttons>
          <Link
            :href="this.$route('oauth_clients.show', oauth_client)"
            class="ml-2"
          >
            <el-button plain type="primary">View</el-button>
          </Link>
          <Link
            :href="this.$route('oauth_clients.edit', oauth_client)"
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
          <Link :href="this.$route('oauth_clients.create')" class="ml-2">
            <el-button plain type="success">Create</el-button>
          </Link>
        </template>
      </list-card>
    </list-col>
  </el-row>
</template>

<script>
  import PageHeader from "@/Components/PageHeader"
  import BreezeButton from "@/Components/Button"
  import PageBlock from "@/Components/PageBlock"
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"
  import ListCard from "@/Components/ListCard"
  import ListCol from "@/Components/ListCol"

  export default defineComponent({
    components: {
      ListCol,
      ListCard,
      PageBlock,
      PageHeader,
      Link,
      BreezeButton,
    },
    props: ["oauth_clients"],
  })
</script>

<style scoped></style>

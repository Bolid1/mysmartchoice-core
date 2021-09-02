<template>
  <el-row :gutter="12">
    <el-col
      v-for="oauth_client in o_auth_clients.data"
      :xs="24"
      :sm="12"
      :md="8"
      :lg="6"
      :xl="4"
      class="mt-2"
    >
      <el-card class="mr-2" shadow="hover">
        <h5>{{ oauth_client.name }}</h5>
        <p>
          <el-link :href="oauth_client.redirect" target="_blank">{{
            oauth_client.redirect
          }}</el-link>
        </p>
        <div class="mt-2 flex justify-end">
          <Link
            :href="this.$route('o_auth_clients.show', oauth_client)"
            class="ml-2"
          >
            <el-button plain type="primary">View</el-button>
          </Link>
          <Link
            :href="this.$route('o_auth_clients.edit', oauth_client)"
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
          <Link :href="this.$route('o_auth_clients.create')" class="ml-2">
            <el-button plain type="success">Create</el-button>
          </Link>
        </div>
      </el-card>
    </el-col>
  </el-row>
</template>

<script>
  import PageHeader from "@/Components/PageHeader"
  import BreezeButton from "@/Components/Button"
  import PageBlock from "@/Components/PageBlock"
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"

  export default defineComponent({
    components: { PageBlock, PageHeader, Link, BreezeButton },
    props: ["o_auth_clients"],
  })
</script>

<style scoped></style>

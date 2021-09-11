<template>
  <el-row :gutter="12">
    <list-col v-for="client in oauth_clients.data" :key="client.id">
      <list-card>
        <h5>{{ client.name }}</h5>
        <p>
          <el-link :href="client.redirect" target="_blank">{{
            client.redirect
          }}</el-link>
        </p>
        <template #buttons>
          <show-button
            class="ml-2"
            :href="this.$route('oauth_clients.show', client)"
          />
          <edit-button
            class="ml-2"
            :href="this.$route('oauth_clients.edit', client)"
          />
        </template>
      </list-card>
    </list-col>

    <list-col-create :rows="2" :href="this.$route('oauth_clients.create')" />
  </el-row>
</template>

<script>
  import { defineComponent } from "vue"
  import ListCard from "@/Components/ListCard"
  import ListCol from "@/Components/ListCol"
  import ListColCreate from "@/Components/ListColCreate"
  import ShowButton from "@/Components/Buttons/ShowButton"
  import EditButton from "@/Components/Buttons/EditButton"

  export default defineComponent({
    components: {
      EditButton,
      ShowButton,
      ListColCreate,
      ListCol,
      ListCard,
    },
    props: ["oauth_clients"],
  })
</script>

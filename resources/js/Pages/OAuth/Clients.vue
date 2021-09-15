<template>
  <el-row :gutter="12">
    <list-col v-for="client in clients" :key="client.id">
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
            :href="this.$route('oauth.clients.show', client)"
          />
          <edit-button
            class="ml-2"
            :href="this.$route('oauth.clients.edit', client)"
          />
        </template>
      </list-card>
    </list-col>

    <list-col-create :rows="2" :href="this.$route('oauth.clients.create')" />
  </el-row>
</template>

<script lang="ts">
  import { defineComponent } from "vue"
  import ListCard from "@/Components/ListCard.vue"
  import ListCol from "@/Components/ListCol.vue"
  import ListColCreate from "@/Components/ListColCreate.vue"
  import ShowButton from "@/Components/Buttons/ShowButton.vue"
  import EditButton from "@/Components/Buttons/EditButton.vue"

  export default defineComponent({
    components: {
      EditButton,
      ShowButton,
      ListColCreate,
      ListCol,
      ListCard,
    },
    props: {
      clients: {
        type: Array,
        required: true,
      },
    },
  })
</script>

<template>
  <el-row :gutter="12">
    <list-col v-for="integration in integrations">
      <list-card class="h-full" shadow="hover">
        <h5>{{ integration.title }}</h5>
        <p>{{ integration.description }}</p>
        <template #buttons>
          <show-button
            class="ml-2"
            :href="this.$route('integrations.show', { integration })"
          />
          <edit-button
            class="ml-2"
            :href="this.$route('integrations.edit', { integration })"
          />
        </template>
      </list-card>
    </list-col>
    <list-col-create :href="this.$route('integrations.create')" :rows="2" />
  </el-row>
</template>

<script>
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"
  import ListCol from "@/Components/ListCol"
  import ListCard from "@/Components/ListCard"
  import ListColCreate from "@/Components/ListColCreate"
  import ShowButton from "@/Components/Buttons/ShowButton"
  import EditButton from "@/Components/Buttons/EditButton"

  export default defineComponent({
    props: ["integrations"],
    components: {
      EditButton,
      ShowButton,
      ListColCreate,
      ListCard,
      ListCol,
      Link,
    },
  })
</script>

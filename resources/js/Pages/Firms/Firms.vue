<template>
  <el-row :gutter="12">
    <list-col v-for="firm in firms">
      <list-card>
        <h5>{{ firm.title }}</h5>
        <template #buttons>
          <show-button
            class="ml-2"
            :href="this.$route('firms.show', { firm })"
          />
          <edit-button
            class="ml-2"
            :href="this.$route('firms.edit', { firm })"
          />
        </template>
      </list-card>
    </list-col>
    <list-col-create :href="this.$route('firms.create')" />
  </el-row>
</template>

<script>
  import PageHeader from "@/Components/PageHeader"
  import { Link } from "@inertiajs/inertia-vue3"
  import { defineComponent } from "vue"
  import ListCol from "@/Components/ListCol"
  import ListCard from "@/Components/ListCard"
  import CreateButton from "@/Components/Buttons/CreateButton"
  import EditButton from "@/Components/Buttons/EditButton"
  import ShowButton from "@/Components/Buttons/ShowButton"
  import ListColCreate from "@/Components/ListColCreate"

  export default defineComponent({
    components: {
      ListColCreate,
      ShowButton,
      EditButton,
      CreateButton,
      ListCard,
      ListCol,
      Link,
      PageHeader,
    },
    props: ["can", "firms"],
  })
</script>

<style scoped></style>

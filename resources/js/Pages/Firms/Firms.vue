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
  import { defineComponent } from "vue"
  import ListCol from "@/Components/ListCol"
  import ListCard from "@/Components/ListCard"
  import ListColCreate from "@/Components/ListColCreate"
  import ShowButton from "@/Components/Buttons/ShowButton"
  import EditButton from "@/Components/Buttons/EditButton"

  export default defineComponent({
    components: {
      EditButton,
      ShowButton,
      ListColCreate,
      ListCard,
      ListCol,
    },
    props: ["can", "firms"],
  })
</script>

<style scoped></style>

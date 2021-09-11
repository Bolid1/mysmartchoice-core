<template>
  <list-col>
    <list-card class="h-full" shadow="hover">
      <el-skeleton :rows="rows || 0" />
      <template #buttons>
        <create-button :href="href" />
      </template>
    </list-card>
  </list-col>
</template>

<script>
  import ListCol from "@/Components/ListCol"
  import ListCard from "@/Components/ListCard"
  import CreateButton from "@/Components/Buttons/CreateButton"

  export default {
    name: "ListColCreate",
    components: { CreateButton, ListCard, ListCol },
    props: {
      href: {
        type: String,
      },
      rows: {
        type: Number,
      },
    },
  }
</script>

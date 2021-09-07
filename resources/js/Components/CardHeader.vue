<template>
  <el-page-header
    icon="el-icon-arrow-left"
    title="List"
    :content="title"
    @back="this.$inertia.get(listHref)"
  />
  <el-button-group v-if="exists" class="ml-auto">
    <delete-button v-if="deleteHref" :href="deleteHref()" />
    <show-button v-if="showHref" :href="showHref()" />
    <edit-button v-if="editHref" :href="editHref()" />
  </el-button-group>
</template>

<script>
  import DeleteButton from "@/Components/Buttons/DeleteButton"
  import ShowButton from "@/Components/Buttons/ShowButton"
  import EditButton from "@/Components/Buttons/EditButton"
  export default {
    name: "CardHeader",
    components: { EditButton, ShowButton, DeleteButton },
    props: {
      exists: {
        type: Boolean,
        required: true,
      },
      title: {
        type: String,
        default: "New",
      },
      listHref: {
        type: String,
        required: true,
      },
      deleteHref: {
        type: Function,
        required: false,
      },
      showHref: {
        type: Function,
        required: false,
      },
      editHref: {
        type: Function,
        required: false,
      },
    },
  }
</script>

<style scoped></style>

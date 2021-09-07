<template>
  <el-button-group>
    <form-create-button
      v-if="!exists"
      :disabled="form.processing"
      @click="form.post(storeHref)"
    />
    <form-update-button
      v-if="exists"
      :disabled="form.processing"
      @click="form.patch(updateHref)"
    />
    <form-delete-button
      v-if="exists"
      :disabled="form.processing"
      @click="form.delete(destroyHref)"
    />
  </el-button-group>
</template>

<script>
  import FormDeleteButton from "@/Components/Buttons/FormDeleteButton"
  import FormUpdateButton from "@/Components/Buttons/FormUpdateButton"
  import FormCreateButton from "@/Components/Buttons/FormCreateButton"

  export default {
    name: "FormButtonsGroup",
    components: { FormCreateButton, FormUpdateButton, FormDeleteButton },
    props: {
      exists: Boolean,
      form: Object,
      storeHref: String,
      updateHref: String,
      destroyHref: String,
    },
  }
</script>

<style scoped></style>

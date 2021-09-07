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
      @click="form.patch(updateHref())"
    />
    <form-delete-button
      v-if="exists"
      :disabled="form.processing"
      @click="form.delete(destroyHref())"
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
      exists: {
        type: Boolean,
        required: true,
      },
      form: {
        type: Object,
        required: true,
      },
      storeHref: {
        type: String,
        required: true,
      },
      updateHref: {
        type: Function,
        required: true,
      },
      destroyHref: {
        type: Function,
        required: true,
      },
    },
  }
</script>

<style scoped></style>

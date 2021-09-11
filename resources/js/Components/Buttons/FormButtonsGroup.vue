<template>
  <el-button-group>
    <form-create-button
      v-if="!exists && storeHref"
      :disabled="form.processing"
      @click="form.post(storeHref)"
    />
    <form-update-button
      v-if="exists && updateHref"
      :disabled="form.processing"
      @click="form.patch(updateHref())"
    />
    <form-delete-button
      v-if="exists && destroyHref"
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
        required: false,
      },
      updateHref: {
        type: Function,
        required: false,
      },
      destroyHref: {
        type: Function,
        required: false,
      },
    },
  }
</script>

<template>
  <Link
    method="delete"
    as="button"
    class="el-button el-button--danger is-plain"
    >{{ text }}</Link
  >
</template>

<script>
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"

  export default defineComponent({
    name: "DeleteButton",
    components: { Link },
    props: {
      text: {
        type: String,
        required: false,
        default: "Delete",
      },
    },
  })
</script>

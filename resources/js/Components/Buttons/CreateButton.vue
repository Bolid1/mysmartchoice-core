<template>
  <Link as="button" class="el-button el-button--success is-plain">{{
    text
  }}</Link>
</template>

<script>
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"

  export default defineComponent({
    name: "CreateButton",
    components: { Link },
    props: {
      text: {
        type: String,
        required: false,
        default: "Create",
      },
    },
  })
</script>

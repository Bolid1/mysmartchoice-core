<template>
  <Link
    :href="href"
    method="delete"
    as="button"
    class="el-button el-button--danger is-plain"
    >Delete</Link
  >
</template>

<script>
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"

  export default defineComponent({
    name: "DeleteButton",
    components: { Link },
    props: {
      href: {
        type: String,
        required: false,
      },
    },
  })
</script>

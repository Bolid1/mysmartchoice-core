<template>
  <Link :href="href" as="button" class="el-button el-button--primary is-plain"
    >Edit</Link
  >
</template>

<script>
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"

  export default defineComponent({
    name: "EditButton",
    components: { Link },
    props: {
      href: {
        type: String,
      },
    },
  })
</script>

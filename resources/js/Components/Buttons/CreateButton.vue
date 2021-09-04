<template>
  <Link :href="href" as="button" class="el-button el-button--success is-plain"
    >Create</Link
  >
</template>

<script>
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"

  export default defineComponent({
    name: "CreateButton",
    components: { Link },
    props: {
      href: {
        type: String,
      },
    },
  })
</script>

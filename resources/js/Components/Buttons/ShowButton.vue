<template>
  <Link :href="href" as="button" class="el-button el-button--info is-plain"
    >View</Link
  >
</template>

<script>
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"

  export default defineComponent({
    name: "ShowButton",
    components: { Link },
    props: {
      href: {
        type: String,
      },
    },
  })
</script>

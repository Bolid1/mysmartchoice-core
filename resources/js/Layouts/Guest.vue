<template>
  <div
    class="
      min-h-screen
      flex flex-col
      sm:justify-center
      items-center
      pt-6
      sm:pt-0
      bg-gray-100
    "
  >
    <slot />
  </div>
</template>

<script>
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"

  export default defineComponent({
    components: {
      Link,
    },
  })
</script>

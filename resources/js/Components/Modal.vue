<template>
  <div
    class="
      min-w-screen
      h-screen
      animated
      fadeIn
      faster
      fixed
      left-0
      top-0
      flex
      justify-center
      items-center
      inset-0
      z-50
      outline-none
      focus:outline-none
      bg-no-repeat bg-center bg-cover
    "
    id="modal-id"
  >
    <div class="absolute bg-black opacity-80 inset-0 z-0"></div>
    <div
      class="
        w-full
        max-w-lg
        p-5
        relative
        mx-auto
        my-auto
        rounded-xl
        shadow-lg
        bg-white
      "
    >
      <!--content-->
      <div class="">
        <!--body-->
        <slot />
        <!--footer-->
        <div class="p-3 mt-2 text-center space-x-4 md:block">
          <slot name="footer" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import BreezeButton from "@/Components/Button"
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"

  export default defineComponent({
    components: {
      BreezeButton,
      Link,
    },
  })
</script>

<style scoped></style>

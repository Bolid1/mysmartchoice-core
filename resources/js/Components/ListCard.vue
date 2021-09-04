<template>
  <el-card
    class="h-full"
    :body-style="{
      padding: '20px',
      height: '100%',
      display: 'flex',
      'flex-direction': 'column',
    }"
    shadow="hover"
  >
    <slot />
    <div
      class="flex-grow flex justify-end items-end mt-1.5"
      v-if="this.$slots.buttons"
    >
      <slot name="buttons" />
    </div>
  </el-card>
</template>

<script>
  import { defineComponent } from "vue"

  export default defineComponent({
    name: "ListCard",
  })
</script>

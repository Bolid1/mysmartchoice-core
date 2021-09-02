<template>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <el-card>
        <slot />
      </el-card>
    </div>
  </div>
</template>

<script>
  import { defineComponent } from "vue"

  export default defineComponent({})
</script>

<style scoped></style>

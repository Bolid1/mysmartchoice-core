<template>
  <el-col :xs="24" :sm="12" :md="8" :lg="6" :xl="4">
    <slot />
  </el-col>
</template>

<script>
  import { defineComponent } from "vue"

  export default defineComponent({
    name: "ListCol",
  })
</script>

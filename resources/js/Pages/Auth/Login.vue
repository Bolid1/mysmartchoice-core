<template>
  <el-card class="w-full sm:max-w-md">
    <login-form />
  </el-card>
</template>

<script lang="ts">
  import { defineComponent } from "vue"
  import GuestLayout from "@/Layouts/Guest.vue"
  import LoginForm from "@/Components/Auth/LoginForm.vue"

  export default defineComponent({
    name: "LoginPage",
    layout: GuestLayout,
    components: { LoginForm },
  })
</script>

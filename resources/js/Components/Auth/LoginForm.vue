<template>
  <el-form
    class="m-auto"
    label-position="left"
    label-width="100px"
    :model="form"
    @submit.prevent="form.submit('post', this.$route('login'))"
  >
    <el-form-item required label="Email" :error="form.errors.email">
      <el-input
        v-model="form.email"
        required
        autofocus
        autocomplete="email"
      ></el-input>
    </el-form-item>
    <el-form-item required label="Password" :error="form.errors.password">
      <el-input
        type="password"
        v-model="form.password"
        required
        autocomplete="password"
      ></el-input>
    </el-form-item>
    <el-form-item label="Remember" :error="form.errors.remember">
      <el-switch v-model="form.remember"> </el-switch>
    </el-form-item>
    <el-form-item>
      <div class="flex justify-end">
        <el-link class="mr-2"
          ><Link :href="this.$route('register')">register</Link></el-link
        >
        <el-link class="mr-2"
          ><Link :href="this.$route('password.request')">forgot?</Link></el-link
        >
        <el-button
          :disabled="form.processing"
          type="success"
          native-type="submit"
          >Login</el-button
        >
      </div>
    </el-form-item>
  </el-form>
</template>

<script lang="ts">
  import { defineComponent } from "vue"
  import { useForm } from "@inertiajs/inertia-vue3"
  import { Link } from "@inertiajs/inertia-vue3"

  export default defineComponent({
    name: "LoginForm",
    components: { Link },
    setup() {
      const form = useForm({
        email: null,
        password: null,
        remember: false,
      })

      return { form }
    },
  })
</script>

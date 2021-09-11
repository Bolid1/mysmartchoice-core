<template>
  <el-card class="w-full sm:max-w-md">
    <el-form
      class="m-auto"
      label-position="left"
      label-width="100px"
      :model="form"
      @submit.prevent="form.submit('post', this.$route('register'))"
    >
      <el-form-item required label="Name" :error="form.errors.name">
        <el-input
          v-model="form.name"
          required
          autofocus
          autocomplete="name"
        ></el-input>
      </el-form-item>
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
      <el-form-item
        label="Do you accept service terms?"
        label-width="200px"
        :error="form.errors.terms"
      >
        <el-switch v-model="form.terms"> </el-switch>
      </el-form-item>
      <el-form-item>
        <div class="flex justify-end">
          <el-link class="mr-2"
            ><Link :href="this.$route('login')"
              >already registered?</Link
            ></el-link
          >
          <el-button
            :disabled="form.processing"
            type="success"
            native-type="submit"
            >Register</el-button
          >
        </div>
      </el-form-item>
    </el-form>
  </el-card>
</template>

<script>
  import { defineComponent } from "vue"
  import { Link, useForm } from "@inertiajs/inertia-vue3"
  import GuestLayout from "@/Layouts/Guest"

  export default defineComponent({
    name: "RegisterPage",
    layout: GuestLayout,
    components: {
      Link,
    },
    setup() {
      const form = useForm({
        name: null,
        email: null,
        password: null,
        terms: true,
      })

      return { form }
    },
  })
</script>

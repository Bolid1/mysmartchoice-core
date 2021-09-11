<template>
  <el-card class="w-full sm:max-w-md">
    <el-form
      class="m-auto"
      label-position="left"
      label-width="100px"
      :model="form"
      @submit.prevent="form.submit('post', this.$route('password.update'))"
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

      <el-form-item>
        <div class="flex justify-end">
          <el-link class="mr-2"
            ><Link :href="this.$route('login')">login</Link></el-link
          >
          <el-button
            :disabled="form.processing"
            type="success"
            native-type="submit"
            >Reset</el-button
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
    name: "ResetPasswordPage",
    layout: GuestLayout,
    components: {
      Link,
    },
    props: {
      email: {
        type: String,
        required: true,
      },
      token: {
        type: String,
        required: true,
      },
    },
    setup(props) {
      const form = useForm({
        token: props.token,
        email: props.email,
        password: "",
      })

      return {
        form,
      }
    },
  })
</script>

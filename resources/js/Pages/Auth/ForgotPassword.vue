<template>
  <el-card v-if="status" class="w-full sm:max-w-md">
    <h3 class="text-xl text-center">{{ status }}</h3>
    <el-link class="text-lg text-center w-full"
      ><Link href="/">to main page</Link></el-link
    >
  </el-card>
  <el-card v-else class="w-full sm:max-w-md">
    <p class="mb-4 text-sm text-gray-600">
      Forgot your password? No problem. Just let us know your email address and
      we will email you a password reset link that will allow you to choose a
      new one.
    </p>

    <el-form
      class="m-auto"
      label-position="left"
      label-width="100px"
      :model="form"
      @submit.prevent="form.submit('post', this.$route('password.email'))"
    >
      <el-form-item required label="Email" :error="form.errors.email">
        <el-input
          v-model="form.email"
          required
          autofocus
          autocomplete="email"
        ></el-input>
      </el-form-item>

      <el-form-item>
        <div class="flex justify-end">
          <el-link class="mr-2"
            ><Link :href="this.$route('register')">register</Link></el-link
          >
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
  import GuestLayout from "@/Layouts/Guest"
  import { defineComponent } from "vue"
  import { Link, useForm } from "@inertiajs/inertia-vue3"

  export default defineComponent({
    layout: GuestLayout,
    components: {
      Link,
    },
    props: {
      status: {
        type: String,
      },
    },
    setup() {
      const form = useForm({
        email: null,
      })

      return { form }
    },
  })
</script>

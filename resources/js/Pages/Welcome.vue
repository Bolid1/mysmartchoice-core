<template>
  <el-card class="w-full sm:max-w-md" v-if="!authorized">
    <login-form />
  </el-card>
  <div v-else class="m-auto">
    <h1 class="text-center text-3xl">Welcome, {{ name }}!</h1>
    <h2 class="text-center text-2xl">You can click any of this links:</h2>
    <el-carousel indicator-position="outside">
      <el-carousel-item>
        <Link
          class="h-full flex items-center justify-center text-xl"
          :href="this.$route('firms.index')"
          >Firms</Link
        >
      </el-carousel-item>
      <el-carousel-item>
        <Link
          class="h-full flex items-center justify-center text-xl"
          :href="this.$route('integrations.index')"
          >Integrations</Link
        >
      </el-carousel-item>
      <el-carousel-item>
        <Link
          class="h-full flex items-center justify-center text-xl"
          :href="this.$route('oauth.clients.index')"
          >Auth Clients</Link
        >
      </el-carousel-item>
      <el-carousel-item>
        <Link
          class="h-full flex items-center justify-center text-xl"
          :href="this.$route('oauth.tokens.index')"
          >Auth Tokens</Link
        >
      </el-carousel-item>
    </el-carousel>
    <ul>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
    </ul>
  </div>
</template>

<script lang="ts">
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"
  import GuestLayout from "@/Layouts/Guest.vue"
  import LoginForm from "@/Components/Auth/LoginForm.vue"

  export default defineComponent({
    components: { Link, LoginForm },
    layout: GuestLayout,
    setup(props, context) {
      const user: {
        id: number
        name: string
        created_at: string
        updated_at: string
      } = (context.attrs.auth as any).user || {}

      return { authorized: Boolean(user.id), name: user.name }
    },
  })
</script>

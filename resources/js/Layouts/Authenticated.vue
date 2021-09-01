<template>
  <el-container class="max-h-screen">
    <el-aside :width="isMenuCollapsed ? '64px' : null" class="transition-all">
      <el-menu
        class="min-h-screen"
        :default-active="activeIndex"
        background-color="#545c64"
        text-color="#fff"
        active-text-color="#ffd04b"
        :collapse="isMenuCollapsed"
      >
        <el-menu-item @click="toggleMenuCollapsed()">
          <i
            :class="{
              'el-icon-s-fold': !isMenuCollapsed,
              'el-icon-s-unfold': isMenuCollapsed,
            }"
          ></i>
          <span>App name</span>
        </el-menu-item>
        <el-menu-item v-for="menuItem in menuItems" :index="menuItem.route">
          <Link :href="menuItem.href" class="block w-full">
            <i :class="menuItem.icon"></i>
            <span>{{ menuItem.title }}</span>
          </Link>
        </el-menu-item>
      </el-menu>
    </el-aside>

    <el-container>
      <el-header class="flex justify-end">
        <el-dropdown class="mt-8">
          <span>{{ $page.props.auth.user.name }}</span>
          <template #dropdown>
            <el-dropdown-menu>
              <el-dropdown-item>
                <Link
                  :href="this.$route('users.edit', this.$page.props.auth.user)"
                  >Profile</Link
                >
              </el-dropdown-item>
              <el-dropdown-item>
                <Link :href="this.$route('logout')" method="post" as="button"
                  >Log Out</Link
                >
              </el-dropdown-item>
            </el-dropdown-menu>
          </template>
        </el-dropdown>
      </el-header>

      <el-main>
        <slot />
      </el-main>
    </el-container>
  </el-container>
</template>

<script>
  import { Link } from "@inertiajs/inertia-vue3"
  import { defineComponent } from "vue"

  export default defineComponent({
    components: { Link },

    data() {
      return {
        isMenuCollapsed: true,
        menuItemsRaw: [
          {
            title: "Firms",
            route: "firms.index",
            icon: "el-icon-s-cooperation",
          },
          {
            title: "Integrations",
            route: "integrations.index",
            icon: "el-icon-menu",
          },
          {
            title: "Auth Clients",
            route: "o_auth_clients.index",
            icon: "el-icon-connection",
          },
          {
            title: "Auth Tokens",
            route: "oauth.tokens.index",
            icon: "el-icon-key",
          },
        ],
      }
    },

    computed: {
      menuItems() {
        return this.menuItemsRaw.map(({ title, route, icon }) => {
          const href = this.$route(route, {}, false)

          return {
            title,
            route,
            icon,
            href,
            active: this.$page.url.startsWith(href),
          }
        })
      },
      activeIndex() {
        return this.menuItems.find(({ active }) => active)?.route
      },
    },

    methods: {
      toggleMenuCollapsed() {
        this.isMenuCollapsed = !this.isMenuCollapsed
      },
    },
  })
</script>

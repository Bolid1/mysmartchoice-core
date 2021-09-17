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
        <el-sub-menu index="user">
          <template #title>
            <i
              :class="{
                'el-icon-s-fold': !isMenuCollapsed,
                'el-icon-s-unfold': isMenuCollapsed,
              }"
              @click="toggleMenuCollapsed()"
            ></i>
            <span>{{ $page.props.auth.user.name }}</span>
          </template>

          <el-menu-item>
            <Link
              class="block w-full text-left"
              :href="this.$route('logout')"
              method="post"
              as="button"
              >Log Out</Link
            >
          </el-menu-item>
        </el-sub-menu>
        <el-menu-item v-for="menuItem in menuItems" :index="menuItem.route">
          <Link :href="menuItem.href" class="block w-full">
            <el-tooltip
              effect="dark"
              :content="menuItem.title"
              placement="right"
              :disabled="!isMenuCollapsed"
            >
              <i :class="menuItem.icon"></i>
            </el-tooltip>
            <span>{{ menuItem.title }}</span>
          </Link>
        </el-menu-item>
      </el-menu>
    </el-aside>

    <el-main>
      <slot />
    </el-main>
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
            route: "oauth.clients.index",
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

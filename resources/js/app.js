require("./bootstrap")

// Import modules...
import { createApp, h } from "vue"
import { createInertiaApp } from "@inertiajs/inertia-vue3"
import { InertiaProgress } from "@inertiajs/progress"

// Plugins
// Element Plus, a Vue 3.0 based component library
// @link https://element-plus.org
import ElementPlus from "element-plus"
import "element-plus/lib/theme-chalk/index.css"

createInertiaApp({
  resolve: (name) => require(`./Pages/${name}`),
  setup({ el, app, props, plugin }) {
    createApp({ render: () => h(app, props) })
      .mixin({ methods: { route } })
      .use(plugin)
      .use(ElementPlus)
      .mount(el)
  },
})

InertiaProgress.init({ color: "#4B5563" })

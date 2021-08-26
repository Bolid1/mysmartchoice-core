require("./bootstrap")

// Import modules...
import { createApp, h } from "vue"

// InertiaJS good for quickstart with vue in laravel ecosystem
// https://inertiajs.com
import { createInertiaApp } from "@inertiajs/inertia-vue3"
import { InertiaProgress } from "@inertiajs/progress"

// Plugins
// Element Plus, a Vue 3.0 based component library
// @link https://element-plus.org
import ElementPlus from "element-plus"
import "element-plus/lib/theme-chalk/index.css"

// A Vue plugin for injecting remote scripts.
// @link https://github.com/tserkov/vue-plugin-load-script/tree/vue3
import LoadScript from "vue-plugin-load-script"

createInertiaApp({
  resolve: (name) => require(`./Pages/${name}`),
  setup({ el, app, props, plugin }) {
    createApp({ render: () => h(app, props) })
      .mixin({ methods: { route } })
      .use(plugin)
      .use(ElementPlus)
      .use(LoadScript)
      .mount(el)
  },
})

InertiaProgress.init({ color: "#4B5563" })

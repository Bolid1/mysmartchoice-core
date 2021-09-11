require("./bootstrap")

// Import modules...
import { createApp, h } from "vue"
//@ts-ignore
import Layout from "./Layouts/Authenticated"

// InertiaJS good for quickstart with vue in laravel ecosystem
// https://inertiajs.com
import { createInertiaApp } from "@inertiajs/inertia-vue3"
import { InertiaProgress } from "@inertiajs/progress"

// Plugins
// Element Plus, a Vue 3.0 based component library
// @link https://element-plus.org
import ElementPlus from "element-plus"
import "element-plus/dist/index.css"

// A Vue plugin for injecting remote scripts.
// @link https://github.com/tserkov/vue-plugin-load-script/tree/vue3
//@ts-ignore
import LoadScript from "vue-plugin-load-script"

createInertiaApp({
  resolve: (name) => {
    const page = require(`./Pages/${name}`).default
    if (page.layout === undefined) {
      page.layout = Layout
    }

    return page
  },
  setup({ el, app, props, plugin }) {
    createApp({ render: () => h(app, props) })
      //@ts-ignore
      .mixin({ methods: { $route: route } })
      .use(plugin)
      .use(ElementPlus)
      .use(LoadScript)
      .mount(el)
  },
})

InertiaProgress.init({ color: "#4B5563" })

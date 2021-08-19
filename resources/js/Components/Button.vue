<template>
  <button
    :type="type"
    class="
      inline-flex
      items-center
      px-4
      py-2
      border border-transparent
      rounded-md
      font-semibold
      text-xs
      uppercase
      tracking-widest
      focus:outline-none
      transition
      ease-in-out
      duration-150
    "
    :class="{
      [`bg-${color}-${bg}`]: true,
      [`hover:bg-${color}-${hover_bg}`]: true,
      [`active:bg-${color}-${active_bg}`]: true,
      [`focus:border-${color}-${focus_border}`]: true,
      [`focus:shadow-outline-${color}`]: true,
      'text-white': theme === 'dark',
      'text-gray-900': theme === 'light',
    }"
  >
    <slot />
  </button>
</template>

<script>
  export default {
    props: {
      type: {
        type: String,
        default: "submit",
      },
      color: {
        type: String,
        default: "gray",
      },
      theme: {
        type: String,
        default: "dark",
      },
    },
    computed: {
      bg() {
        return this.theme === "dark" ? 800 : "300"
      },
      hover_bg() {
        return this.theme === "dark" ? 700 : "200"
      },
      active_bg() {
        return this.theme === "dark" ? 900 : "400"
      },
      focus_border() {
        return this.theme === "dark" ? 900 : "400"
      },
    },
  }
</script>

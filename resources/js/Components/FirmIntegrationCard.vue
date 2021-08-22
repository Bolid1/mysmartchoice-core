<template>
  <div
    class="
      bg-white
      rounded-xl
      shadow-xl
      hover:shadow-2xl hover:scale-105
      transition-all
      transform
      duration-500
      flex flex-col
    "
  >
    <img
      v-if="integration.logo"
      class="w-64 object-cover rounded-t-md"
      :src="integration.logo"
      alt=""
    />
    <img
      v-else
      class="w-64 object-cover rounded-t-md"
      src="https://images.unsplash.com/photo-1509223197845-458d87318791"
      alt=""
    />
    <div class="mt-4 flex flex-col flex-grow">
      <h1 class="text-2xl font-bold text-gray-700 flex-grow">
        {{ integration.title }}
      </h1>
      <p class="text-sm mt-2 text-gray-700 flex-grow">
        {{ integration.description }}
      </p>
      <div class="mt-4 mb-2 flex justify-between">
        <button class="block text-xl font-semibold text-gray-700 cursor-auto">
          {{ install.status }}
        </button>
        <inertia-link
          v-if="install.status === 'installable'"
          class="
            text-lg
            block
            font-semibold
            py-2
            px-6
            text-white
            hover:text-green-100
            bg-green-400
            rounded-lg
            shadow
            hover:shadow-md
            transition
            duration-300
          "
          :href="route('firms.firm_integrations.create', { firm })"
          as="button"
          >Install</inertia-link
        >
        <inertia-link
          v-else-if="install.status === 'installed'"
          class="
            text-lg
            block
            font-semibold
            py-2
            px-6
            text-white
            hover:text-green-100
            bg-green-400
            rounded-lg
            shadow
            hover:shadow-md
            transition
            duration-300
          "
          :href="
            route('firms.firm_integrations.edit', {
              firm,
              firm_integration: install,
            })
          "
          as="button"
          >Settings</inertia-link
        >
        <span
          v-else
          class="
            text-lg
            block
            font-semibold
            py-2
            px-6
            text-white
            hover:text-green-100
            bg-green-400
            rounded-lg
            shadow
            hover:shadow-md
            transition
            duration-300
          "
          >...</span
        >
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: ["install"],
    computed: {
      firm() {
        return this.install.firm || {}
      },
      integration() {
        return this.install.integration || {}
      },
      initials() {
        return String(this.integration.title)
          .split(" ")
          .slice(0, 2)
          .map((part) => part.substr(0, 1))
          .join("")
      },
    },
  }
</script>

<style scoped></style>

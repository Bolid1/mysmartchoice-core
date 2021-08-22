<template>
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight flex-grow">
        <slot />
      </h2>
      <div class="flex-shrink-1">
        <slot name="right" />
      </div>
    </div>
  </header>
</template>

<script>
  export default {}
</script>

<style scoped></style>

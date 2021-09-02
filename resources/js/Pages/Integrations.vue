<template>
  <page-header>
    <template #right>
      <Link :href="this.$route('integrations.create')"
        ><breeze-button color="green">Create</breeze-button></Link
      >
    </template>
  </page-header>

  <div class="pt-6 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <div class="bg-white overflow-hidden shadow-sm">
        <div class="py-6 px-4 sm:px-6 lg:px-8">
          <div v-for="integration in integrations.data">
            <Link
              class="underline"
              :href="this.$route('integrations.show', integration)"
            >
              Integration#{{ integration.id }} ({{ integration.title }})
            </Link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import BreezeButton from "@/Components/Button"
  import PageHeader from "@/Components/PageHeader"
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"

  export default defineComponent({
    props: ["integrations"],
    components: {
      PageHeader,
      BreezeButton,
      Link,
    },
  })
</script>

<style scoped></style>

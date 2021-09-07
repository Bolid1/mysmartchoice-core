<template>
  <el-container>
    <el-header class="flex items-center">
      <el-page-header
        icon="el-icon-arrow-left"
        title="List"
        content="Integrations"
        @back="this.$inertia.get(this.$route('integrations.index'))"
      />
      <el-button-group class="ml-auto">
        <delete-button
          :href="this.$route('integrations.destroy', integration)"
        />
        <edit-button :href="this.$route('integrations.edit', integration)" />
      </el-button-group>
    </el-header>

    <el-main>
      <el-card>
        Id: {{ integration.id }}<br />
        Title: {{ integration.title }}
      </el-card>
    </el-main>
  </el-container>
</template>

<script>
  import BreezeButton from "@/Components/Button"
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"
  import DeleteButton from "@/Components/Buttons/DeleteButton"
  import EditButton from "@/Components/Buttons/EditButton"

  export default defineComponent({
    props: ["integration"],
    components: {
      EditButton,
      DeleteButton,
      BreezeButton,
      Link,
    },
  })
</script>

<style scoped></style>

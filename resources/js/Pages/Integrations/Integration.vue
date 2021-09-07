<template>
  <el-container>
    <el-header class="flex items-center">
      <card-header
        :exists="Boolean(integration.id)"
        :title="integration.title"
        :list-href="this.$route('integrations.index')"
        :delete-href="() => this.$route('integrations.destroy', integration)"
        :edit-href="() => this.$route('integrations.edit', integration)"
      />
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
  import CardHeader from "@/Components/CardHeader"

  export default defineComponent({
    props: ["integration"],
    components: {
      CardHeader,
      EditButton,
      DeleteButton,
      BreezeButton,
      Link,
    },
  })
</script>

<style scoped></style>

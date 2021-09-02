<template>
  <page-header>
    <template #default>
      <Link class="underline" :href="this.$route('firms.index')">Firms</Link>
      -> {{ firm.title || "Create" }}
    </template>
  </page-header>

  <el-card class="mt-2">
    <el-form label-position="left" label-width="100px" :model="form">
      <el-form-item label="Title" :error="form.errors.title">
        <el-input v-model="form.title"></el-input>
      </el-form-item>

      <el-form-item>
        <el-button
          v-if="!firm.id"
          :disabled="form.processing"
          type="primary"
          @click="form.post($route('firms.store'))"
          >Create</el-button
        >
        <el-button
          v-if="firm.id"
          :disabled="form.processing"
          type="primary"
          @click="form.patch($route('firms.update', { firm }))"
          >Save</el-button
        >
        <el-button
          v-if="firm.id"
          :disabled="form.processing"
          type="danger"
          @click="form.delete($route('firms.destroy', { firm }))"
          >Delete</el-button
        >
      </el-form-item>
    </el-form>
  </el-card>
</template>

<script>
  import PageHeader from "@/Components/PageHeader"
  import { Link, useForm } from "@inertiajs/inertia-vue3"
  import { defineComponent } from "vue"

  export default defineComponent({
    components: { Link, PageHeader },
    props: ["firm"],
    setup(props) {
      const form = useForm({
        title: props.firm.title,
      })

      return { form }
    },
  })
</script>

<style scoped></style>

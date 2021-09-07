<template>
  <el-container>
    <el-header class="flex items-center">
      <el-page-header
        icon="el-icon-arrow-left"
        title="List"
        :content="firm.title"
        @back="this.$inertia.get(this.$route('firms.index'))"
      />
      <el-button-group class="ml-auto">
        <delete-button :href="this.$route('firms.destroy', firm)" />
        <show-button :href="this.$route('firms.show', firm)" />
      </el-button-group>
    </el-header>

    <el-main>
      <el-card class="mt-2">
        <el-form label-position="left" label-width="100px" :model="form">
          <el-form-item label="Title" :error="form.errors.title">
            <el-input v-model="form.title"></el-input>
          </el-form-item>

          <el-form-item>
            <FormButtonsGroup
              :exists="Boolean(firm.id)"
              :form="form"
              :storeHref="this.$route('firms.store')"
              :updateHref="this.$route('firms.update', { firm })"
              :destroyHref="this.$route('firms.destroy', { firm })"
            />
          </el-form-item>
        </el-form>
      </el-card>
    </el-main>
  </el-container>
</template>

<script>
  import PageHeader from "@/Components/PageHeader"
  import { Link, useForm } from "@inertiajs/inertia-vue3"
  import { defineComponent } from "vue"
  import DeleteButton from "@/Components/Buttons/DeleteButton"
  import ShowButton from "@/Components/Buttons/ShowButton"
  import FormCreateButton from "@/Components/Buttons/FormCreateButton"
  import FormUpdateButton from "@/Components/Buttons/FormUpdateButton"
  import FormDeleteButton from "@/Components/Buttons/FormDeleteButton"
  import FormButtonsGroup from "@/Components/Buttons/FormButtonsGroup"

  export default defineComponent({
    components: {
      FormButtonsGroup,
      FormDeleteButton,
      FormUpdateButton,
      FormCreateButton,
      ShowButton,
      DeleteButton,
      Link,
      PageHeader,
    },
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

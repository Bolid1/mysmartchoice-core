<template>
  <el-container>
    <el-header class="flex items-center">
      <card-header
        :exists="Boolean(firm.id)"
        :title="firm.title"
        :list-href="this.$route('firms.index')"
        :delete-href="() => this.$route('firms.destroy', firm)"
        :show-href="() => this.$route('firms.show', firm)"
      />
    </el-header>

    <el-main>
      <el-card class="mt-2">
        <el-form label-position="left" label-width="100px" :model="form">
          <el-form-item label="Title" :error="form.errors.title">
            <el-input v-model="form.title"></el-input>
          </el-form-item>

          <el-form-item>
            <form-buttons-group
              :exists="Boolean(firm.id)"
              :form="form"
              :store-href="this.$route('firms.store')"
              :update-href="() => this.$route('firms.update', { firm })"
              :destroy-href="() => this.$route('firms.destroy', { firm })"
            />
          </el-form-item>
        </el-form>
      </el-card>
    </el-main>
  </el-container>
</template>

<script>
  import { Link, useForm } from "@inertiajs/inertia-vue3"
  import { defineComponent } from "vue"
  import DeleteButton from "@/Components/Buttons/DeleteButton"
  import ShowButton from "@/Components/Buttons/ShowButton"
  import FormCreateButton from "@/Components/Buttons/FormCreateButton"
  import FormUpdateButton from "@/Components/Buttons/FormUpdateButton"
  import FormDeleteButton from "@/Components/Buttons/FormDeleteButton"
  import FormButtonsGroup from "@/Components/Buttons/FormButtonsGroup"
  import CardHeader from "@/Components/CardHeader"

  export default defineComponent({
    components: {
      CardHeader,
      FormButtonsGroup,
      FormDeleteButton,
      FormUpdateButton,
      FormCreateButton,
      ShowButton,
      DeleteButton,
      Link,
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

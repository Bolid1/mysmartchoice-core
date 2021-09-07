<template>
  <el-container>
    <el-header class="flex items-center">
      <el-page-header
        icon="el-icon-arrow-left"
        :title="firm.title"
        @back="this.$inertia.get(this.$route('firms.show', { firm }))"
      >
        <template #content>
          <el-page-header
            icon=""
            title="Users"
            :content="user.name || 'New'"
            @back="
              this.$inertia.get(this.$route('firms.users.index', { firm }))
            "
          />
        </template>
      </el-page-header>
    </el-header>

    <el-main>
      <el-form label-position="left" label-width="100px" :model="form">
        <el-form-item label="Name" :error="form.errors.name">
          <el-input
            v-model="form.name"
            required
            autocomplete="username"
          ></el-input>
        </el-form-item>

        <el-form-item label="Email" :error="form.errors.email">
          <el-input
            v-model="form.email"
            type="email"
            required
            autocomplete="email"
          ></el-input>
        </el-form-item>

        <el-form-item label="Password" :error="form.errors.password">
          <el-input
            v-model="form.password"
            type="password"
            required
            autocomplete="new-password"
          ></el-input>
        </el-form-item>

        <el-form-item>
          <form-buttons-group
            :exists="Boolean(user.id)"
            :form="form"
            :update-href="
              () => this.$route('firms.users.update', { firm, user })
            "
          />
        </el-form-item>
      </el-form>
    </el-main>
  </el-container>
</template>

<script>
  import { useForm } from "@inertiajs/inertia-vue3"
  import { defineComponent } from "vue"
  import FormButtonsGroup from "@/Components/Buttons/FormButtonsGroup"

  export default defineComponent({
    props: {
      user: {
        type: Object,
        required: true,
      },
      firm: {
        type: Object,
        required: true,
      },
    },
    components: {
      FormButtonsGroup,
    },
    setup(props) {
      const form = useForm({
        name: props.user.name,
        email: props.user.email,
        password: null,
      })

      return { form }
    },
  })
</script>

<template>
  <el-container>
    <el-header class="flex items-center">
      <card-header
        :exists="Boolean(client.id)"
        :title="client.name"
        :list-href="this.$route('oauth_clients.index')"
        :delete-href="() => this.$route('oauth_clients.destroy', client)"
        :show-href="() => this.$route('oauth_clients.show', client)"
      />
    </el-header>

    <el-main>
      <el-form label-position="left" label-width="100px" :model="form">
        <el-form-item label="Name" :error="form.errors.name">
          <el-input v-model="form.name"></el-input>
        </el-form-item>
        <el-form-item label="Redirect URL" :error="form.errors.redirect">
          <el-input v-model="form.redirect"></el-input>
        </el-form-item>

        <el-form-item>
          <form-buttons-group
            :exists="Boolean(client.id)"
            :form="form"
            :store-href="this.$route('oauth_clients.store')"
            :update-href="() => this.$route('oauth_clients.update', client)"
            :destroy-href="() => this.$route('oauth_clients.destroy', client)"
          />
        </el-form-item>
      </el-form>
    </el-main>
  </el-container>
</template>

<script>
  import { useForm } from "@inertiajs/inertia-vue3"
  import { defineComponent } from "vue"
  import CardHeader from "@/Components/CardHeader"
  import FormButtonsGroup from "@/Components/Buttons/FormButtonsGroup"

  export default defineComponent({
    components: { FormButtonsGroup, CardHeader },
    props: {
      client: {
        type: Object,
        required: true,
      },
    },
    setup(props) {
      const form = useForm({
        name: props.client.name,
        redirect: props.client.redirect,
      })

      return { form }
    },
  })
</script>

<style scoped></style>

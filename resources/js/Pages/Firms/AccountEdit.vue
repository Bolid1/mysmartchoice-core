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
            title="Accounts"
            :content="account.title || 'New'"
            @back="
              this.$inertia.get(this.$route('firms.accounts.index', { firm }))
            "
          />
        </template>
      </el-page-header>

      <el-button-group v-if="account.id" class="ml-auto">
        <delete-button
          :href="this.$route('firms.accounts.destroy', { firm, account })"
        />
        <show-button
          :href="this.$route('firms.accounts.show', { firm, account })"
        />
      </el-button-group>
    </el-header>

    <el-main>
      <el-form label-position="left" label-width="100px" :model="form">
        <el-form-item label="Title" :error="form.errors.title">
          <el-input v-model="form.title" required></el-input>
        </el-form-item>
        <el-form-item label="Balance" :error="form.errors.balance">
          <el-input-number
            class="w-full"
            v-model="form.balance"
            :min="-1000000000"
            :max="1000000000"
            :step="0.01"
            :precision="2"
            required
          ></el-input-number>
        </el-form-item>
        <el-form-item label="Currency" :error="form.errors.currency">
          <el-select
            v-model="form.currency"
            placeholder="Currency"
            class="mt-1 block w-full"
            filterable
            :disabled="Boolean(account.id)"
            required
          >
            <el-option
              v-for="currency in currencies"
              :key="currency.country + '_' + currency.code"
              :label="currency.code + ' [' + currency.country + ']'"
              :value="currency.code"
            >
            </el-option>
          </el-select>
        </el-form-item>

        <el-form-item>
          <form-buttons-group
            :exists="Boolean(account.id)"
            :form="form"
            :store-href="this.$route('firms.accounts.store', { firm })"
            :update-href="
              () => this.$route('firms.accounts.update', { firm, account })
            "
            :destroy-href="
              () => this.$route('firms.accounts.destroy', { firm, account })
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
  import DeleteButton from "@/Components/Buttons/DeleteButton"
  import EditButton from "@/Components/Buttons/EditButton"
  import ShowButton from "@/Components/Buttons/ShowButton"

  export default defineComponent({
    props: ["firm", "account", "currencies"],
    components: {
      ShowButton,
      EditButton,
      DeleteButton,
      FormButtonsGroup,
    },
    setup(props) {
      const form = useForm({
        title: props.account.title,
        balance: props.account.balance,
        currency: props.account.currency,
      })

      return { form }
    },
  })
</script>

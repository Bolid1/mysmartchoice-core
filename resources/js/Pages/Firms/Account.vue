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
            :content="account.title"
            @back="
              this.$inertia.get(this.$route('firms.accounts.index', { firm }))
            "
          />
        </template>
      </el-page-header>

      <el-button-group class="ml-auto">
        <delete-button
          :href="this.$route('firms.accounts.destroy', { firm, account })"
        />
        <edit-button
          :href="this.$route('firms.accounts.edit', { firm, account })"
        />
      </el-button-group>
    </el-header>

    <el-main>
      <el-card>
        Id: {{ account.id }}<br />
        Title: {{ account.title }}<br />
        Balance: {{ formatMoney(account.currency, account.balance) }}
      </el-card>
    </el-main>
  </el-container>
</template>

<script>
  import { formatMoney } from "@/Helpers/Money"
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"
  import DeleteButton from "@/Components/Buttons/DeleteButton"
  import ShowButton from "@/Components/Buttons/ShowButton"
  import EditButton from "@/Components/Buttons/EditButton"

  export default defineComponent({
    props: ["firm", "account"],
    components: {
      EditButton,
      ShowButton,
      DeleteButton,
      Link,
    },
    methods: {
      formatMoney,
    },
  })
</script>

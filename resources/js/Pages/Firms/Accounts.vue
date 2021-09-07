<template>
  <el-container>
    <el-header class="flex items-center">
      <card-header
        :exists="false"
        :back-title="firm.title"
        title="Accounts"
        :list-href="this.$route('firms.show', firm)"
      />
    </el-header>

    <el-main>
      <el-row :gutter="12">
        <list-col v-for="account in accounts">
          <list-card>
            <h5>{{ account.title }}</h5>
            <h6>{{ formatMoney(account.currency, account.balance) }}</h6>
            <template #buttons>
              <show-button
                class="ml-2"
                :href="this.$route('firms.accounts.show', { firm, account })"
              />
              <edit-button
                class="ml-2"
                :href="this.$route('firms.accounts.edit', { firm, account })"
              />
            </template>
          </list-card>
        </list-col>
        <list-col-create
          :href="this.$route('firms.accounts.create', { firm })"
        />
      </el-row>
    </el-main>
  </el-container>
</template>

<script>
  import { formatMoney } from "@/Helpers/Money"
  import { defineComponent } from "vue"
  import EditButton from "@/Components/Buttons/EditButton"
  import ShowButton from "@/Components/Buttons/ShowButton"
  import ListColCreate from "@/Components/ListColCreate"
  import ListCard from "@/Components/ListCard"
  import ListCol from "@/Components/ListCol"
  import CardHeader from "@/Components/CardHeader"

  export default defineComponent({
    props: ["firm", "accounts"],
    components: {
      CardHeader,
      EditButton,
      ShowButton,
      ListColCreate,
      ListCard,
      ListCol,
    },
    methods: {
      formatMoney,
    },
  })
</script>

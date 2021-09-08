<template>
  <el-container>
    <el-header class="flex items-center">
      <card-header
        :exists="Boolean(firm.id)"
        :title="firm.title"
        :list-href="this.$route('firms.index')"
        :delete-href="() => this.$route('firms.destroy', firm)"
        :edit-href="() => this.$route('firms.edit', firm)"
      />
    </el-header>

    <el-main>
      <el-row :gutter="12" justify="space-between">
        <el-col
          v-for="(balance, currency) in balances"
          :xs="12"
          :sm="6"
          :md="4"
          :lg="4"
          :xl="3"
          class="mt-2"
        >
          <el-card>
            {{ formatMoney(currency, balance) }}
          </el-card>
        </el-col>
      </el-row>

      <Link
        class="underline cursor-pointer mt-6 text-lg"
        :href="this.$route('firms.accounts.index', firm)"
        as="h3"
      >
        Accounts
      </Link>

      <el-row :gutter="12">
        <list-col v-for="account in accounts">
          <list-card>
            <h5>{{ account.title }}</h5>
            <template #buttons>
              <show-button
                :href="this.$route('firms.accounts.show', { firm, account })"
              />
              <edit-button
                :href="this.$route('firms.accounts.edit', { firm, account })"
              />
            </template>
          </list-card>
        </list-col>
        <list-col-create
          :rows="0"
          :href="this.$route('firms.accounts.create', { firm })"
        />
      </el-row>

      <Link
        class="underline cursor-pointer mt-6 text-lg"
        :href="this.$route('firms.users.index', firm)"
        as="h3"
      >
        Users
      </Link>

      <el-row :gutter="12">
        <list-col v-for="user in users">
          <list-card>
            <h5>{{ user.name }}</h5>
            <template #buttons>
              <edit-button
                :href="this.$route('firms.users.edit', { firm, user })"
              />
            </template>
          </list-card>
        </list-col>
      </el-row>

      <Link
        class="underline cursor-pointer mt-6 text-lg"
        :href="this.$route('firms.firm_integrations.index', firm)"
        as="h3"
      >
        Installed integrations
      </Link>

      <el-row :gutter="12" v-if="integrations_installs?.length">
        <list-col v-for="install in integrations_installs">
          <list-card>
            <h5>{{ install.integration.title }}</h5>
            <p>{{ install.integration.description }}</p>
            <template #buttons>
              <el-button type="text" disabled>{{ install.status }}</el-button>
              <edit-button
                :href="
                  this.$route('firms.firm_integrations.edit', {
                    firm,
                    firm_integration: install,
                  })
                "
              />
            </template>
          </list-card>
        </list-col>
      </el-row>
    </el-main>
  </el-container>
</template>

<script>
  import { formatMoney } from "@/Helpers/Money"
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"
  import DeleteButton from "@/Components/Buttons/DeleteButton"
  import EditButton from "@/Components/Buttons/EditButton"
  import ListCol from "@/Components/ListCol"
  import ListCard from "@/Components/ListCard"
  import CreateButton from "@/Components/Buttons/CreateButton"
  import ListColCreate from "@/Components/ListColCreate"
  import ShowButton from "@/Components/Buttons/ShowButton"
  import CardHeader from "@/Components/CardHeader"

  export default defineComponent({
    components: {
      CardHeader,
      ShowButton,
      ListColCreate,
      CreateButton,
      ListCard,
      ListCol,
      EditButton,
      DeleteButton,
      Link,
    },
    props: {
      firm: Object,
      balances: Object,
      users: Array,
      accounts: Array,
      integrations_installs: Array,
    },
    setup() {
      return {
        formatMoney,
      }
    },
  })
</script>

<style scoped></style>

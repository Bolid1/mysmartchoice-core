<template>
  <el-container>
    <el-header class="flex items-center">
      <card-header
        :exists="false"
        :back-title="firm.title"
        title="Users"
        :list-href="this.$route('firms.show', firm)"
      />
    </el-header>

    <el-main>
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
    </el-main>
  </el-container>
</template>

<script>
  import { defineComponent } from "vue"
  import CardHeader from "@/Components/CardHeader"
  import ListCol from "@/Components/ListCol"
  import ListCard from "@/Components/ListCard"
  import EditButton from "@/Components/Buttons/EditButton"

  export default defineComponent({
    components: { EditButton, ListCard, ListCol, CardHeader },
    props: ["firm", "users"],
  })
</script>

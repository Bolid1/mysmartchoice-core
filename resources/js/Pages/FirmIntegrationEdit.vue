<template>
  <page-header>
    <inertia-link class="underline" :href="route('firms.show', firm)">{{
      firm.title
    }}</inertia-link>
    ->
    <inertia-link
      class="underline"
      :href="route('firms.firm_integrations.index', firm)"
      >Integrations</inertia-link
    >
    -> {{ firm_integration.id || "Connect new" }}
  </page-header>

  <page-block>
    <form
      @submit.prevent="
        firm_integration.id
          ? form.patch(
              route('firms.firm_integrations.update', {
                firm,
                firm_integration,
              })
            )
          : form.post(route('firms.firm_integrations.store', firm))
      "
      class="p-4"
    >
      <!-- Integration select -->
      <div class="pt-2">
        <breeze-label for="integration">Integration</breeze-label>

        <el-select
          v-model="form.integration_id"
          placeholder="Integration"
          class="mt-1 block w-full"
          filterable
          :disabled="Boolean(firm_integration.id)"
        >
          <el-option
            v-for="integration in integrations.data"
            :key="integration.id"
            :label="`${integration.title} [${integration.description}]`"
            :value="integration.id"
          >
          </el-option>
        </el-select>

        <div v-if="form.errors.integration_id">
          {{ form.errors.integration_id }}
        </div>
      </div>

      <!-- submit -->
      <div class="pt-2">
        <breeze-button
          type="submit"
          color="green"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          {{ firm_integration.id ? "Update" : "Install" }}
        </breeze-button>
        <p v-if="!firm_integration.id" class="text-sm">
          by clicking the button you agree to provide access for your firm data
          to the 3rd party
        </p>
      </div>
    </form>
  </page-block>
</template>

<script>
  import AuthenticatedLayout from "@/Layouts/Authenticated"
  import PageBlock from "@/Components/PageBlock"
  import PageHeader from "@/Components/PageHeader"
  import { useForm } from "@inertiajs/inertia-vue3"
  import BreezeButton from "@/Components/Button"
  import BreezeInput from "@/Components/Input"
  import BreezeLabel from "@/Components/Label"
  import BreezeValidationErrors from "@/Components/ValidationErrors"
  import { ElOption, ElSelect } from "element-plus"

  export default {
    layout: AuthenticatedLayout,
    components: {
      BreezeButton,
      BreezeInput,
      BreezeLabel,
      BreezeValidationErrors,
      ElSelect,
      ElOption,
      PageBlock,
      PageHeader,
    },
    props: ["firm", "firm_integration", "integrations"],
    setup(props) {
      const form = useForm({
        integration_id: props.firm_integration.integration_id,
      })

      return { form }
    },
  }
</script>

<style scoped></style>

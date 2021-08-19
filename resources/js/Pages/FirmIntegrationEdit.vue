<template>
  <!-- Page Heading -->
  <page-header>
    <inertia-link class="underline" :href="route('firms.show', firm)">{{
      firm.title
    }}</inertia-link>
    ->

    <!-- fixme: :href="route('firms.installs.index', { firm })" -->
    <inertia-link
      class="underline"
      :href="route('firms.integrations.installs.index', { firm, integration })"
      >Firm integrations</inertia-link
    >
    ->

    <inertia-link
      class="underline"
      :href="route('firms.integrations.installs.index', { firm, integration })"
      >{{ integration.title }}</inertia-link
    >
    ->

    {{ install.id || "Install" }}
  </page-header>

  <page-block>
    <p class="p-4">{{ integration.description }}</p>

    <div class="pt-2" v-if="!install.id">
      <breeze-button type="button" v-on:click="toggleInstallConfirmation()">
        Install
      </breeze-button>
    </div>
  </page-block>

  <page-block v-if="install.id">
    <form class="flex flex-col">
      <label> <input type="checkbox" /> Accounts </label>
      <label> <input type="checkbox" /> Transactions </label>
    </form>
  </page-block>

  <modal v-if="need_install_confirmation">
    <template v-slot:default>
      <div class="text-center p-5 flex-auto justify-center">
        <h2 class="text-xl font-bold py-4">Are you sure?</h2>
        <p class="text-sm text-gray-500 px-8">
          Do you really want to install this integration? After installation,
          integration will receive access for all data of "{{ firm.title }}"
          firm
        </p>
      </div>
    </template>
    <template v-slot:footer>
      <breeze-button
        @click="toggleInstallConfirmation()"
        type="button"
        color="gray"
        theme="light"
      >
        Cancel
      </breeze-button>

      <inertia-link
        method="post"
        :href="
          route('firms.integrations.installs.store', { firm, integration })
        "
        as="button"
        ><breeze-button type="button" color="green">
          Install
        </breeze-button></inertia-link
      >
    </template>
  </modal>
</template>

<script>
  import AuthenticatedLayout from "@/Layouts/Authenticated"
  import BreezeButton from "@/Components/Button"
  import BreezeInput from "@/Components/Input"
  import BreezeLabel from "@/Components/Label"
  import BreezeValidationErrors from "@/Components/ValidationErrors"
  import { ElOption, ElSelect } from "element-plus"
  import Modal from "@/Components/Modal"
  import PageHeader from "@/Components/PageHeader"
  import PageBlock from "@/Components/PageBlock"

  export default {
    layout: AuthenticatedLayout,
    props: ["install"],
    components: {
      PageBlock,
      PageHeader,
      Modal,
      BreezeButton,
      BreezeInput,
      BreezeLabel,
      BreezeValidationErrors,
      ElSelect,
      ElOption,
    },
    computed: {
      firm() {
        return this.install.firm || {}
      },
      integration() {
        return this.install.integration || {}
      },
    },
    data() {
      return {
        need_install_confirmation: false,
      }
    },
    methods: {
      toggleInstallConfirmation() {
        this.need_install_confirmation = !this.need_install_confirmation
      },
    },
  }
</script>

<style scoped></style>

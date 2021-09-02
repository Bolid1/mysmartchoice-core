<template>
  <page-header>
    <template #default>
      <Link class="underline" :href="this.$route('oauth_clients.index')"
        >OAuth Clients</Link
      >
      -> {{ oauth_client.name || "Create" }}
    </template>
    <template #right>
      <Link
        v-if="oauth_client.id"
        :href="this.$route('oauth_clients.destroy', oauth_client)"
        method="delete"
        as="button"
        class="pr-2"
        ><breeze-button color="red">Delete</breeze-button></Link
      >
      <Link
        v-if="oauth_client.id"
        :href="this.$route('oauth_clients.show', oauth_client)"
        ><breeze-button color="gray">View</breeze-button></Link
      >
    </template>
  </page-header>

  <page-block>
    <form
      @submit.prevent="
        oauth_client.id
          ? form.patch(
              $route('oauth_clients.update', {
                oauth_client,
              })
            )
          : form.post($route('oauth_clients.store'))
      "
      class="p-4"
    >
      <!-- id -->
      <div class="pt-2" v-if="oauth_client.id">
        <breeze-label for="id">Id</breeze-label>
        <breeze-input
          id="id"
          type="text"
          v-model="oauth_client.id"
          class="mt-1 block w-full bg-gray-100"
          disabled
        />
      </div>

      <!-- secret -->
      <div class="pt-2" v-if="oauth_client.secret">
        <breeze-label for="secret">Secret</breeze-label>
        <breeze-input
          id="secret"
          type="text"
          v-model="oauth_client.secret"
          class="mt-1 block w-full bg-gray-100"
          disabled
        />
      </div>

      <!-- name -->
      <div class="pt-2">
        <breeze-label for="name">Name</breeze-label>
        <breeze-input
          id="name"
          type="text"
          v-model="form.name"
          class="mt-1 block w-full"
          placeholder="Client name"
          required
          autofocus
        />
        <div v-if="form.errors.name">{{ form.errors.name }}</div>
      </div>

      <!-- redirect -->
      <div class="pt-2">
        <breeze-label for="redirect">Redirect</breeze-label>
        <breeze-input
          id="redirect"
          type="url"
          v-model="form.redirect"
          class="mt-1 block w-full"
          placeholder="https://example.com/callback"
          required
        />
        <div v-if="form.errors.redirect">{{ form.errors.redirect }}</div>
      </div>

      <!-- submit -->
      <div class="pt-2">
        <breeze-button
          type="submit"
          color="green"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          {{ oauth_client.id ? "Update" : "Create" }}
        </breeze-button>
      </div>
    </form>
  </page-block>
</template>

<script>
  import BreezeButton from "@/Components/Button"
  import BreezeInput from "@/Components/Input"
  import BreezeLabel from "@/Components/Label"
  import BreezeValidationErrors from "@/Components/ValidationErrors"
  import PageBlock from "@/Components/PageBlock"
  import PageHeader from "@/Components/PageHeader"
  import { Link, useForm } from "@inertiajs/inertia-vue3"
  import { defineComponent } from "vue"

  export default defineComponent({
    components: {
      BreezeButton,
      BreezeInput,
      BreezeLabel,
      BreezeValidationErrors,
      PageBlock,
      PageHeader,
      Link,
    },
    props: ["oauth_client"],
    setup(props) {
      const form = useForm({
        name: props.oauth_client.name,
        redirect: props.oauth_client.redirect,
      })

      return { form }
    },
  })
</script>

<style scoped></style>

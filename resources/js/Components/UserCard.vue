<template>
  <div>
    <div class="flex justify-center md:justify-end -mt-16">
      <div
        class="
          w-20
          h-20
          object-cover
          rounded-full
          border-2 border-indigo-500
          relative
        "
      >
        <div
          class="
            group
            w-full
            h-full
            rounded-full
            overflow-hidden
            shadow-inner
            text-center
            bg-purple
            pointer-events-none
            select-none
            flex
            justify-center
          "
        >
          <span
            v-if="!user.avatar"
            class="group-hover:table-cell font-bold self-center"
            >{{ initials }}</span
          >
          <img
            v-if="user.avatar"
            :src="user.avatar"
            alt="lovely avatar"
            class="
              object-cover object-center
              w-full
              h-full
              visible
              group-hover:hidden
            "
          />
        </div>
      </div>
    </div>
    <div>
      <h2 class="text-gray-800 text-3xl font-semibold">Manager</h2>
      <p class="mt-2 text-gray-600">Total transactions: 134</p>
      <p class="text-gray-600">Total income: 134</p>
      <p class="text-gray-600">Total spent: 543</p>
    </div>
    <div class="flex justify-end mt-4">
      <inertia-link
        class="text-xl font-medium text-indigo-500"
        :href="$route('users.edit', user)"
        >{{ user.name }}</inertia-link
      >
    </div>
  </div>
</template>

<script>
  export default {
    props: ["user"],
    computed: {
      initials() {
        return String(this.user.name)
          .split(" ")
          .slice(0, 2)
          .map((part) => part.substr(0, 1))
          .join("")
      },
    },
  }
</script>

<style scoped></style>

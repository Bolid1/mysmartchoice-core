<template>
  <Link
    as="button"
    class="el-button"
    :class="{
      'el-button--primary': type === 'primary',
      'el-button--success': type === 'success',
      'el-button--warning': type === 'warning',
      'el-button--danger': type === 'danger',
      'el-button--info': type === 'info',
      'el-button--text': type === 'text',
      'is-plain': plain,
      // todo
      'is-round': round,
      'is-circle': circle,
      'is-loading': loading,
      'is-disabled': disabled,
      'is-autofocus': autofocus,
      size: false,
      icon: false,
      'native-type': false,
    }"
  >
    <slot></slot>
  </Link>
</template>

<script>
  import { defineComponent } from "vue"
  import { Link } from "@inertiajs/inertia-vue3"

  export default defineComponent({
    name: "LinkButton",
    components: { Link },
    props: {
      size: {
        type: String,
        description: "button size",
        // medium / small / mini	—
      },
      type: {
        type: String,
        description: "button type",
        // primary / success / warning / danger / info / text	—
      },
      plain: {
        type: Boolean,
        description: "determine whether it's a plain button",
      },
      round: {
        type: Boolean,
        description: "determine whether it's a round button",
      },
      circle: {
        type: Boolean,
        description: "determine whether it's a circle button",
      },
      loading: {
        type: Boolean,
        description: "determine whether it's loading",
      },
      disabled: {
        type: Boolean,
        description: "disable the button",
      },
      icon: {
        type: String,
        description: "icon class name",
      },
      autofocus: {
        type: Boolean,
        description: "same as native button's autofocus",
      },
      "native-type": {
        type: String,
        description: "same as native button's type",
        // button / submit / reset	button
      },
    },
  })
</script>

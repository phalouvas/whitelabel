<template>
  <select
    class="
      border-gray-300
      focus:border-indigo-300
      focus:ring focus:ring-indigo-200 focus:ring-opacity-50
      rounded-md
      shadow-sm
    "
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    ref="input"
  >
    <option v-for="option in options" v-bind:value="option.id">
      {{ option.name }}
    </option>
  </select>
</template>

<script>
export default {
  props: ["modelValue", "options"],

  emits: ["update:modelValue"],

  methods: {
    focus() {
      this.$refs.input.focus();
    },
  },
};
</script>


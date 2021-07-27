<template>
  <label class="block font-medium text-sm text-gray-700">
    <span v-if="value">{{ formatMoney(value) }}</span>
  </label>
</template>

<script>
export default {
  props: ["value"],

  methods: {
    formatMoney(value) {
      var formatter = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "EUR",
      });

      return formatter.format(value);
    },
  },
};
</script>

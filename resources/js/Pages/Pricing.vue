<template>
  <guest-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Pricing
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div
            class="
              p-3
              prose prose-sm
              sm:prose
              lg:prose-lg
              xl:prose-2xl
              m-5
              focus:outline-none
            "
          >
            <div class="col-span-6 sm:col-span-6">
              <jet-label for="country" value="Select Country" />
              <select
                class="
                  border-gray-300
                  focus:border-indigo-300
                  focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                  rounded-md
                  shadow-sm
                "
                v-model="country"
                ref="input"
              >
                <option v-for="country in countries" v-bind:value="country">
                  {{ country.name }}
                </option>
              </select>
            </div>
          </div>

          <div
            class="
              p-3
              prose prose-sm
              sm:prose
              lg:prose-lg
              xl:prose-2xl
              m-5
              focus:outline-none
            "
          >
            <jet-money v-if="country" :value="country.price"></jet-money>
          </div>
        </div>
      </div>
    </div>
  </guest-layout>
</template>

<script>
import GuestLayout from "@/Layouts/GuestLayout";
import JetSelect from "@/Jetstream/Select";
import JetLabel from "@/Jetstream/Label";
import JetMoney from "@/Jetstream/Money";
import JetActionMessage from "@/Jetstream/ActionMessage";

export default {
  components: {
    GuestLayout,
    JetActionMessage,
    JetSelect,
    JetLabel,
    JetMoney
  },

  props: ["countries"],

  data() {
    return {
      country: null,
    };
  },

};
</script>

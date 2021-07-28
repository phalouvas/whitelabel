<template>
  <div>
    <div class="mt-4 p-6 bg-grey align-middle justify-content-center flex">
      <jet-input
        name="recipient"
        id="recipient"
        type="text"
        class="m-2 mt-1 block w-full"
        placeholder="Recipient..."
        v-model="form.to"
        @change="filterSms"
      />
      <jet-select v-model="form.status" :options="statuses" @change="filterSms"/>
      <jet-input
        name="created_at"
        id="created_at"
        type="date"
        class="m-2 mt-1 block w-full"
        placeholder="Pick Date..."
        v-model="form.created_at"
        @change="filterSms"
      />
      <button @click="filterSms" title="Go" class="hover:bg-red-100">
        <i class="p-2 text-blue-400 fas fa-search fa-2x"></i>
      </button>
      <button @click="clearFilter" title="Clear" class="hover:bg-red-100">
        <i class="p-2 text-red-400 fas fa-times"></i>
      </button>
    </div>
    <div class="mt-4 p-6">
      <table class="min-w-full bg-white">
        <thead class="bg-gray-800 text-white">
          <tr>
            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">ID</th>
            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Recipient</th>
            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Sender ID</th>
            <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Message</th>
            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Cost</th>
            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Status</th>
            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Sent At</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          <tr class="border-t" v-for="item in $page.props.messages.data">
            <td class="text-left py-3 px-4">{{ item._id }}</td>
            <td class="text-left py-3 px-4">{{ item.to }}</td>
            <td class="text-left py-3 px-4">{{ item.sender_id }}</td>
            <td class="w-1/3 text-left py-3 px-4 truncate">{{ item.message }}</td>
            <td class="text-left py-3 px-4">{{ item.client_cost }}</td>
            <td class="text-left py-3 px-4">{{ item.status }}</td>
            <td class="text-left py-3 px-4">{{ item.sent_at }}</td>
          </tr>
        </tbody>
      </table>

      <pagination class="mt-6" :links="$page.props.messages.links" />
    </div>
  </div>
</template>

<script>
import JetButton from "@/Jetstream/Button";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import JetSuccessButton from "@/Jetstream/SuccessButton";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetEditor from "@/Jetstream/Editor";
import JetCheckbox from "@/Jetstream/Checkbox";
import JetMoney from "@/Jetstream/Money";
import Pagination from "@/Jetstream/Pagination";
import JetSelect from "@/Jetstream/Select";
import "vue-tel-input/dist/vue-tel-input.css";

export default {
  components: {
    JetActionMessage,
    JetButton,
    JetSuccessButton,
    JetSecondaryButton,
    JetFormSection,
    JetInput,
    JetInputError,
    JetLabel,
    JetMoney,
    JetEditor,
    JetCheckbox,
    JetSelect,
    Pagination,
  },

  data() {
    return {
      processing: false,
      form: this.$inertia.form({
        status: null,
        created_at: null,
        to: null,
      }),
      statuses: [
          {id: 'DELIVERED', name: 'DELIVERED'},
          {id: 'FAILED', name: 'FAILED'},
          {id: 'PENDING', name: 'PENDING'},
          {id: 'REJECTED', name: 'REJECTED'},
          {id: 'NO FUNDS', name: 'NO FUNDS'},
          {id: 'ONGOING', name: 'ONGOING'},
          {id: 'SENT', name: 'SENT'},
          {id: 'UNDELIVERED', name: 'UNDELIVERED'},
          {id: 'UNSUBSCRIBED', name: 'UNSUBSCRIBED'},
          {id: 'SENDING', name: 'SENDING'},
          {id: 'EXPIRED', name: 'EXPIRED'},
          {id: 'QUEUED', name: 'QUEUED'},
          {id: 'SCHEDULED', name: 'SCHEDULED'},
      ]
    };
  },

  mounted() {
    this.form.status = this.$page.props.filter.status;
    this.form.created_at = this.$page.props.filter.created_at;
    this.form.to = this.$page.props.filter.to;
  },

  methods: {
    filterSms() {
      this.processing = true;
      this.form.get(route("sms.index"), {
        preserveScroll: true,
        onSuccess: () => (this.form.recentlySuccessful = false),
      });
      this.processing = false;
    },

    clearFilter() {
        this.form.reset();
        this.filterSms();
    }
  },
};
</script>

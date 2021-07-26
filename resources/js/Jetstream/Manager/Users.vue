<template>
  <div>
    <div class="mt-4 p-6 bg-grey align-middle justify-content-center flex">
      <jet-label for="onlyTrashed">
        <div class="flex items-center w-full">
          <jet-checkbox
            name="onlyTrashed"
            id="onlyTrashed"
            v-model:checked="filters.onlyTrashed"
            @change="refresh"
          />
          <div class="ml-2">Show Banned</div>
        </div>
      </jet-label>
      <jet-input
        name="name"
        id="name"
        type="text"
        class="m-2 mt-1 block w-full"
        placeholder="Name..."
        v-model="filters.name"
      />
      <jet-input
        name="email"
        id="email"
        type="text"
        class="m-2 mt-1 block w-full"
        placeholder="Email..."
        v-model="filters.email"
      />
      <button @click="refresh()" title="Go" class="hover:bg-red-100">
        <i class="p-2 text-blue-400 fas fa-search fa-2x"></i>
      </button>
      <button @click="clear()" title="Clear" class="hover:bg-red-100">
        <i class="p-2 text-red-400 fas fa-times"></i>
      </button>
    </div>

    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
      <table class="table-fixed w-full border">
        <thead>
          <tr class="border">
            <th class="w-1 p-3 text-left">#ID</th>
            <th class="w-4 text-left">Name</th>
            <th class="w-4 text-left">Email</th>
            <th class="w-2 text-left">Money</th>
            <th class="w-2 text-left"></th>
          </tr>
        </thead>
        <tbody>
          <tr
            class="border"
            v-for="item in $page.props.users.data"
            :key="item.id"
          >
            <td class="p-3">{{ item.id }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.email }}</td>
            <td>{{ formatMoney(item.money) }}</td>
            <td>
              <div v-if="filters.onlyTrashed">
                <button
                  v-if="filters.onlyTrashed"
                  @click="restore(item)"
                  title="Unban"
                  class="hover:bg-green-100"
                >
                  <i class="text-green-400 fas fa-user-check fa-2x"></i>
                </button>
              </div>
              <div v-else>
                <button
                  title="Money"
                  class="p-1 hover:bg-yellow-100"
                  @click="editMoney(item)"
                >
                  <i class="text-yellow-400 fas fa-money-bill-wave fa-2x"></i>
                </button>
                <button
                  @click="confirmBan(item)"
                  title="Ban"
                  class="p-1 hover:bg-red-100"
                >
                  <i class="text-red-400 fas fa-user-lock fa-2x"></i>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <pagination class="mt-6" :links="$page.props.users.links" />
    </div>

    <!-- Delete Token Confirmation Modal -->
    <jet-confirmation-modal :show="confirmingBan" @close="closeModal">
      <template #title> Ban User </template>

      <template #content>
        Are you sure you would like to ban user
        <strong>{{ item.name }} - {{ item.email }}</strong> ?
      </template>

      <template #footer>
        <jet-secondary-button @click="confirmingBan = false">
          Close
        </jet-secondary-button>

        <jet-danger-button
          class="ml-2"
          @click="destroy"
          :class="{ 'opacity-25': processing }"
          :disabled="processing"
        >
          Ban
        </jet-danger-button>
      </template>
    </jet-confirmation-modal>

    <!-- API Token Permissions Modal -->
    <jet-dialog-modal :show="editingUserMoney" @close="editingUserMoney = null">
      <template #title> Edit Money - {{ editingUserMoney.email }}</template>

      <template #content>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <jet-label for="amount" value="Amount" />
          <input
            type="number"
            ref="amount"
            class="mt-1 p-3 w-full"
            v-model="updateMoneyForm.amount"
          />
          <jet-label for="money" value="Current Money" />
          <span>
            {{formatMoney(editingUserMoney.money)}}
          </span>
          <jet-label for="estimated" value="Estimated Money" />
          <span>
            {{estimatedMoney}}
          </span>
        </div>
      </template>

      <template #footer>
        <jet-secondary-button @click="editingUserMoney = null">
          Cancel
        </jet-secondary-button>

        <jet-button
          class="ml-2"
          @click="updateMoney"
          :class="{ 'opacity-25': updateMoneyForm.processing }"
          :disabled="updateMoneyForm.processing"
        >
          Save
        </jet-button>
      </template>
    </jet-dialog-modal>
  </div>
</template>

<script>
import JetApplicationLogo from "@/Jetstream/ApplicationLogo";
import Pagination from "@/Jetstream/Pagination";
import JetButton from "@/Jetstream/Button";
import JetConfirmationModal from "@/Jetstream/ConfirmationModal";
import JetDialogModal from "@/Jetstream/DialogModal";
import JetDangerButton from "@/Jetstream/DangerButton";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import JetPrimaryButton from "@/Jetstream/PrimaryButton";
import JetCheckbox from "@/Jetstream/Checkbox";
import JetToggle from "@/Jetstream/Toggle";
import JetInput from "@/Jetstream/Input";
import JetLabel from "@/Jetstream/Label";
import { Inertia } from "@inertiajs/inertia";

export default {
  components: {
    JetApplicationLogo,
    Pagination,
    JetButton,
    JetDangerButton,
    JetSecondaryButton,
    JetPrimaryButton,
    JetConfirmationModal,
    JetDialogModal,
    JetCheckbox,
    JetToggle,
    JetLabel,
    JetInput,
  },

  data() {
    return {
      confirmingBan: false,
      editingUserMoney: null,
      processing: false,
      item: null,
      filters: {
        name: null,
        email: null,
        onlyTrashed: false,
      },
      updateMoneyForm: this.$inertia.form({
        amount: 0,
      }),
    };
  },

  computed: {
    estimatedMoney() {
        let amount = parseFloat(this.updateMoneyForm.amount);
        let money = parseFloat(this.editingUserMoney.money);
        let result = amount + money;
      return this.formatMoney(result);
    },
  },

  methods: {
    confirmBan(item) {
      this.item = item;
      this.confirmingBan = true;
    },

    refresh() {
      Inertia.reload({
        only: ["users"],
        data: {
          name: this.filters.name,
          email: this.filters.email,
          onlyTrashed: this.filters.onlyTrashed,
        },
      });
    },

    clear() {
      this.filters = {
        name: null,
        email: null,
        onlyTrashed: false,
      };
      this.refresh();
    },

    destroy() {
      this.processing = true;

      axios
        .get(
          route("manager.users.destroy", {
            user: this.item,
          })
        )
        .then((response) => {
          Inertia.reload({ only: ["users"] });
        })
        .catch((error) => {
          //
        })
        .finally(() => {
          this.processing = false;
          this.closeModal();
        });
    },

    restore(item) {
      this.processing = true;
      this.item = item;

      axios
        .get(
          route("manager.users.restore", {
            user: this.item,
          })
        )
        .then((response) => {
          Inertia.reload({ only: ["users"] });
        })
        .catch((error) => {
          //
        })
        .finally(() => {
          this.processing = false;
        });
    },

    closeModal() {
      this.confirmingBan = false;
      this.item = null;

      this.form.reset();
    },

    editMoney(item) {
      this.editingUserMoney = item;
    },

    updateMoney() {
      this.updateMoneyForm.put(
        route("manager.users.money.edit", this.editingUserMoney),
        {
          preserveScroll: true,
          preserveState: true,
          onSuccess: () => (this.editingUserMoney = null),
        }
      );
    },

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

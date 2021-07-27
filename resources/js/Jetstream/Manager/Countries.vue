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
          <div class="ml-2">Show Trashed</div>
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
            <th class="w-6 text-left">Name</th>
            <th class="w-4 text-left">A2 Code</th>
            <th class="w-4 text-left">A3 Code</th>
            <th class="w-1 text-left">Price</th>
            <th class="w-4 text-left"></th>
          </tr>
        </thead>
        <tbody>
          <tr
            class="border"
            v-for="item in $page.props.countries.data"
            :key="item.id"
          >
            <td class="p-3">{{ item.id }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.a2_code }}</td>
            <td>{{ item.a3_code }}</td>
            <td><jet-money :value="item.price"/></td>
            <td>
              <div v-if="filters.onlyTrashed">
                <button
                  v-if="filters.onlyTrashed"
                  @click="restore(item)"
                  title="Restore"
                  class="hover:bg-green-100"
                >
                  <i class="text-green-400 fas fa-trash-restore fa-2x"></i>
                </button>
              </div>
              <div v-else>
                <button
                  title="Price"
                  class="p-1 hover:bg-yellow-100"
                  @click="editPrice(item)"
                >
                  <i class="text-yellow-400 fas fa-money-bill-wave fa-2x"></i>
                </button>
                <button
                  @click="confirmTrash(item)"
                  title="Trash"
                  class="p-1 hover:bg-red-100"
                >
                  <i class="text-red-400 fas fa-trash fa-2x"></i>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <pagination class="mt-6" :links="$page.props.countries.links" />
    </div>

    <!-- Delete Token Confirmation Modal -->
    <jet-confirmation-modal :show="confirmingTrash" @close="closeModal">
      <template #title> Trash Country </template>

      <template #content>
        Are you sure you would like to trash item
        <strong>{{ item.name }}</strong> ?
      </template>

      <template #footer>
        <jet-secondary-button @click="confirmingTrash = false">
          Close
        </jet-secondary-button>

        <jet-danger-button
          class="ml-2"
          @click="destroy"
          :class="{ 'opacity-25': processing }"
          :disabled="processing"
        >
          Trash
        </jet-danger-button>
      </template>
    </jet-confirmation-modal>

    <!-- Update price Permissions Modal -->
    <jet-dialog-modal :show="editingCountryPrice" @close="editingCountryPrice = null">
      <template #title> Edit Price - {{ editingCountryPrice.name }}</template>

      <template #content>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <jet-label for="price" value="New Price" />
          <input
            type="number"
            ref="price"
            class="mt-1 p-3 w-full"
            v-model="updatePriceForm.price"
          />
          <jet-label for="price" value="Current Price" />
          <jet-money :value="editingCountryPrice.price"/>
        </div>
      </template>

      <template #footer>
        <jet-secondary-button @click="editingCountryPrice = null">
          Cancel
        </jet-secondary-button>

        <jet-button
          class="ml-2"
          @click="updatePrice"
          :class="{ 'opacity-25': updatePriceForm.processing }"
          :disabled="updatePriceForm.processing"
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
import JetMoney from "@/Jetstream/Money";
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
    JetMoney,
    JetInput,
  },

  data() {
    return {
      confirmingTrash: false,
      editingCountryPrice: null,
      processing: false,
      item: null,
      filters: {
        name: null,
        onlyTrashed: false,
      },
      updatePriceForm: this.$inertia.form({
        price: 0,
      }),
    };
  },

  methods: {
    confirmTrash(item) {
      this.item = item;
      this.confirmingTrash = true;
    },

    refresh() {
      Inertia.reload({
        only: ["countries"],
        data: {
          name: this.filters.name,
          onlyTrashed: this.filters.onlyTrashed,
        },
      });
    },

    clear() {
      this.filters = {
        name: null,
        onlyTrashed: false,
      };
      this.refresh();
    },

    destroy() {
      this.processing = true;

      axios
        .get(
          route("manager.countries.destroy", {
            country: this.item,
          })
        )
        .then((response) => {
          Inertia.reload({ only: ["countries"] });
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
          route("manager.countries.restore", {
            country: this.item,
          })
        )
        .then((response) => {
          Inertia.reload({ only: ["countries"] });
        })
        .catch((error) => {
          //
        })
        .finally(() => {
          this.processing = false;
        });
    },

    closeModal() {
      this.confirmingTrash = false;
      this.item = null;

      this.updatePriceForm.reset();
    },

    editPrice(item) {
      this.editingCountryPrice = item;
    },

    updatePrice() {
      this.updatePriceForm.put(
        route("manager.countries.update", this.editingCountryPrice),
        {
          preserveScroll: true,
          preserveState: true,
          onSuccess: () => (this.editingCountryPrice = null),
        }
      );
    },

  },
};
</script>

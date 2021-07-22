<template>
  <div>
    <div class="mt-4 p-6">
      <jet-label for="terms">
        <div class="flex items-center">
          <jet-checkbox name="onlyTrashed" id="onlyTrashed"  v-model:checked="filters.onlyTrashed" @change="refresh"/>
          <div class="ml-2">Show Banned</div>
        </div>
      </jet-label>
    </div>

    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
      <table class="table-fixed w-full border">
        <thead>
          <tr class="border">
            <th class="w-1 p-3 text-left">#ID</th>
            <th class="w-5 text-left">Name</th>
            <th class="w-5 text-left">Email</th>
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
            <td>
              <button
                @click="confirmBan(item)"
                title="Ban"
                class="hover:bg-red-100"
              >
                <svg
                  aria-hidden="true"
                  focusable="false"
                  data-prefix="fas"
                  data-icon="ban"
                  class="w-8 h-8 text-red-400"
                  role="img"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 512 512"
                >
                  <path
                    fill="currentColor"
                    d="M256 8C119.034 8 8 119.033 8 256s111.034 248 248 248 248-111.034 248-248S392.967 8 256 8zm130.108 117.892c65.448 65.448 70 165.481 20.677 235.637L150.47 105.216c70.204-49.356 170.226-44.735 235.638 20.676zM125.892 386.108c-65.448-65.448-70-165.481-20.677-235.637L361.53 406.784c-70.203 49.356-170.226 44.736-235.638-20.676z"
                  ></path>
                </svg>
              </button>
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
          @click="ban"
          :class="{ 'opacity-25': processing }"
          :disabled="processing"
        >
          Ban
        </jet-danger-button>
      </template>
    </jet-confirmation-modal>
  </div>
</template>

<script>
import JetApplicationLogo from "@/Jetstream/ApplicationLogo";
import Pagination from "@/Jetstream/Pagination";
import JetButton from "@/Jetstream/Button";
import JetConfirmationModal from "@/Jetstream/ConfirmationModal";
import JetDangerButton from "@/Jetstream/DangerButton";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import JetCheckbox from "@/Jetstream/Checkbox";
import JetToggle from "@/Jetstream/Toggle";
import JetLabel from "@/Jetstream/Label";
import { Inertia } from "@inertiajs/inertia";

export default {
  components: {
    JetApplicationLogo,
    Pagination,
    JetButton,
    JetDangerButton,
    JetSecondaryButton,
    JetConfirmationModal,
    JetToggle, JetCheckbox,
    JetLabel,
  },

  data() {
    return {
      confirmingBan: false,
      processing: false,
      item: null,
      filters: {
        onlyTrashed: false,
      },
    };
  },

  methods: {
    confirmBan(item) {
      this.item = item;
      this.confirmingBan = true;
    },

    refresh() {
      Inertia.reload({
          only: ["users"],
          data: {onlyTrashed: this.filters.onlyTrashed},
          });
    },

    clear() {
      this.filters = {
        onlyTrashed: false,
      };
      this.load();
    },

    ban() {
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
          this.closeModal();
        });
    },

    closeModal() {
      this.confirmingBan = false;
      this.item = null;

      this.form.reset();
    },
  },
};
</script>

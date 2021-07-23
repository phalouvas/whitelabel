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
        <svg
          aria-hidden="true"
          focusable="false"
          data-prefix="fas"
          data-icon="search"
          class="w-10 h-10 p-2 text-blue-400"
          role="img"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 512 512"
        >
          <path
            fill="currentColor"
            d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"
          ></path>
        </svg>
      </button>
      <button @click="clear()" title="Clear" class="hover:bg-red-100">
        <svg
          aria-hidden="true"
          focusable="false"
          data-prefix="fas"
          data-icon="times"
          class="w-8 h-8 p-2 text-red-400"
          role="img"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 512 512"
        >
          <path
            fill="currentColor"
            d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"
          ></path>
        </svg>
      </button>
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
                v-if="filters.onlyTrashed"
                @click="restore(item)"
                title="Unban"
                class="hover:bg-red-100"
              >
                <svg
                  aria-hidden="true"
                  focusable="false"
                  data-prefix="fas"
                  data-icon="unban"
                  class="w-8 h-8 text-green-400"
                  role="img"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 640 512"
                >
                  <path
                    fill="currentColor"
                    d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4zm323-128.4l-27.8-28.1c-4.6-4.7-12.1-4.7-16.8-.1l-104.8 104-45.5-45.8c-4.6-4.7-12.1-4.7-16.8-.1l-28.1 27.9c-4.7 4.6-4.7 12.1-.1 16.8l81.7 82.3c4.6 4.7 12.1 4.7 16.8.1l141.3-140.2c4.6-4.7 4.7-12.2.1-16.8z"
                  ></path>
                </svg>
              </button>
              <button
                v-else
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
                  viewBox="0 0 640 512"
                >
                  <path
                    fill="currentColor"
                    d="M224 256A128 128 0 1 0 96 128a128 128 0 0 0 128 128zm96 64a63.08 63.08 0 0 1 8.1-30.5c-4.8-.5-9.5-1.5-14.5-1.5h-16.7a174.08 174.08 0 0 1-145.8 0h-16.7A134.43 134.43 0 0 0 0 422.4V464a48 48 0 0 0 48 48h280.9a63.54 63.54 0 0 1-8.9-32zm288-32h-32v-80a80 80 0 0 0-160 0v80h-32a32 32 0 0 0-32 32v160a32 32 0 0 0 32 32h224a32 32 0 0 0 32-32V320a32 32 0 0 0-32-32zM496 432a32 32 0 1 1 32-32 32 32 0 0 1-32 32zm32-144h-64v-80a32 32 0 0 1 64 0z"
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
          @click="destroy"
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
    JetCheckbox,
    JetToggle,
    JetLabel,
    JetInput,
  },

  data() {
    return {
      confirmingBan: false,
      processing: false,
      item: null,
      filters: {
        name: null,
        email: null,
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
  },
};
</script>

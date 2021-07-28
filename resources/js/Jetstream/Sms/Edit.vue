<template>
  <div class="p-0">
    <div class="grid grid-cols-3">
      <div class="col-span-2 p-3 m-3">
        <!-- Phone -->
        <jet-label for="to" value="Phone" />
        <vue-tel-input
          id="to"
          class="mt-1 p-3 w-full"
          v-model="to"
          @validate="onValidateChange"
          @change="estimateSms"
        />
        <jet-input-error :message="form.errors.to" class="mt-2" />

        <!-- Message -->
        <jet-label for="message" value="Message" />
        <textarea
          v-model="form.message"
          v-on:input="estimate"
          type="text"
          class="mt-1 p-3 w-full"
          id="message"
          placeholder="Your message here..."
          rows="6"
          @change="estimateSms"
        />
        <jet-input-error :message="form.errors.message" class="mt-2" />

        <!-- Sender ID -->
        <jet-label for="sender_id" value="Sender ID" />
        <input
          type="text"
          id="sender_id"
          class="mt-1 p-3 w-full"
          v-model="form.sender_id"
          placeholder="Sender ID..."
          @change="estimateSms"
        />
        <jet-input-error :message="form.errors.sender_id" class="mt-2" />
      </div>

      <div class="">
          <div class="p-3 m-3 bg-gray-200 rounded-md prose">
              <table class="table-auto">
                  <tbody>
                      <tr>
                          <td class="uppercase">Messages (parts):</td>
                          <td class="font-bold text-lg">{{$page.props.sms_estimation.sms_count}}</td>
                      </tr>
                     <tr>
                          <td class="uppercase">ESTIMATED COST:</td>
                          <td>
                              <jet-money class="font-bold text-lg" v-if="$page.props.sms_estimation.estimated_cost > 0" :value="$page.props.sms_estimation.estimated_cost"/>
                              <span v-else class="font-bold text-lg">0</span>
                          </td>
                      </tr>
                      <tr>
                          <td class="uppercase">YOUR BALANCE:</td>
                          <td>
                              <jet-money class="font-bold text-lg" v-if="$page.props.user.money > 0" :value="$page.props.user.money"/>
                              <span v-else class="font-bold text-lg">0</span>
                          </td>
                      </tr>
                  </tbody>
              </table>
          </div>
          <div class="p-3 m-3">
              <phone-preview :content="form.message"></phone-preview>
          </div>
      </div>
    </div>

    <jet-input-error :message="form.errors.smsto_error" class="mt-2" />

    <jet-action-message :on="form.recentlySuccessful" class="mr-3">
      Sent!
    </jet-action-message>

    <jet-success-button
      class="m-1"
      :class="{ 'opacity-25': processing }"
      :disabled="processing || form.hasErrors"
      @click="sendSms"
    >
      <i class="fas fa-paper-plane"></i> Send
    </jet-success-button>

    <jet-secondary-button
      class="m-1"
      :class="{ 'opacity-25': processing }"
      :disabled="processing"
      @click="estimateSms"
    >
      <i class="fas fa-calculator"></i> Estimate
    </jet-secondary-button>
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
import PhonePreview from "@/Jetstream/Sms/PhonePreview"
import { VueTelInput } from "vue-tel-input";
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
    JetLabel, JetMoney,
    JetEditor,
    JetCheckbox,
    VueTelInput,
    PhonePreview
  },

  data() {
    return {
      processing: false,
      form: this.$inertia.form({
        _method: "PUT",
        cost: 0,
        to: null,
        message: null,
        sender_id: null,
        sms_count: 0,
        estimated_cost: 0,
        contact_count: 0,
        invalid_count: 0
      }),
      to: null,
    };
  },

  mounted() {
    this.formReset();
    this.estimateSms();
  },

  methods: {
    estimateSms() {
      this.processing = true;
      this.form.post(route("sms.estimate"), {
        errorBag: "estimateSms",
        preserveScroll: true,
        onSuccess: () => (this.form.recentlySuccessful = false),
      });
      this.processing = false;
    },

    sendSms() {
      this.processing = true;
      this.form.post(route("sms.send"), {
        errorBag: "sendSms",
        preserveScroll: true,
        onSuccess: () => this.formReset(),
      });
      this.processing = false;
    },

    formReset() {
      this.to = null;
      this.form.cost = 0;
      this.form.to = null;
      this.form.message = null;
      this.form.sender_id = null;
      this.form.sms_count = 0;
      this.form.estimated_cost = 0;
      this.form.contact_count = 0;
      this.form.invalid_count = 0;
    },

    onValidateChange(to) {
      if (to.valid === true) {
        this.form.to = to.number;
        this.form.errors.to = null;
      } else {
        this.form.to = null;
        this.form.hasErrors = true;
        this.form.errors.to = "The Phone field is invalid";
      }
    },
  },
};
</script>

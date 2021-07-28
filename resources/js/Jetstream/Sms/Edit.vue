<template>
    <div class="p-6">

        <div class="p-6 m-6 border col-span-6 sm:col-span-12">

            <!-- Phone -->
            <jet-label for="phone" value="Phone" />
            <vue-tel-input id="phone" class="mt-1 p-3 w-full" v-model="phone" @validate="onValidateChange" @change="estimateSms"/>
            <jet-input-error :message="form.errors.phone" class="mt-2" />

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
            <input type="text" id="sender_id" class="mt-1 p-3 w-full" v-model="form.sender_id" placeholder="Sender ID..."  @change="estimateSms"/>
            <jet-input-error :message="form.errors.sender_id" class="mt-2" />

        </div>

        <jet-action-message :on="form.recentlySuccessful" class="mr-3">
            Sent!
        </jet-action-message>

        <jet-button :class="{ 'opacity-25': processing }" :disabled="processing || form.hasErrors" @click="sendSms">
            Send
        </jet-button>

        <jet-button :class="{ 'opacity-25': processing }" :disabled="processing" @click="estimateSms">
            Estimate
        </jet-button>
    </div>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetEditor from '@/Jetstream/Editor'
    import JetCheckbox from '@/Jetstream/Checkbox'
    import { VueTelInput } from 'vue-tel-input';
    import 'vue-tel-input/dist/vue-tel-input.css';

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
            JetEditor,
            JetCheckbox,
            VueTelInput
        },

        data() {
            return {
                processing: false,
                form: this.$inertia.form({
                    _method: 'PUT',
                    cost: 0,
                    phone: null,
                    message:null,
                    sender_id: null
                }),
                phone: null
            }
        },

        mounted() {
            console.log(this.$page.props.sms_estimation);
            console.log(this.$page.props.user);
        },

        methods: {
            estimateSms() {
                this.processing = true;
                this.form.post(route('sms.estimate'), {
                    errorBag: 'estimateSms',
                    preserveScroll: true,
                    onSuccess: () => (this.form.recentlySuccessful = false),
                });
                this.processing = false;
            },

            sendSms() {
                this.processing = true;
                this.form.post(route('sms.send'), {
                    errorBag: 'sendSms',
                    preserveScroll: true,
                    onSuccess: () => (this.formReset()),
                });
                this.processing = false;
            },

            formReset() {
                this.phone = null;
                this.form.cost = 0;
                this.form.phone = null;
                this.form.message = null;
                this.form.sender_id = null;
            },

            onValidateChange(phone) {
                if (phone.valid === true) {
                    this.form.phone = phone.number;
                    this.form.errors.phone = null;
                } else {
                    this.form.phone = null;
                    this.form.hasErrors = true;
                    this.form.errors.phone = "The Phone field is invalid";
                }
            }

        },
    }
</script>

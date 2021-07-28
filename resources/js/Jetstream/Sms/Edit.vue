<template>
    <div class="p-6">

        <!-- Phone -->
        <div class="p-6 m-6 border col-span-6 sm:col-span-12">
            <jet-label for="phone" value="Phone" />
            <vue-tel-input id="phone" class="mt-1 p-3 w-full" v-model="phone" @validate="onValidateChange"/>
            <jet-input-error :message="form.errors.phone" class="mt-2" />
        </div>

        <jet-action-message :on="form.recentlySuccessful" class="mr-3">
            Sent!
        </jet-action-message>

        <jet-button :class="{ 'opacity-25': processing }" :disabled="processing" @click="sendSms">
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
                });
                this.processing = false;
            },

            sendSms() {
                this.processing = true;
                this.form.post(route('sms.send'), {
                    errorBag: 'sendSms',
                    preserveScroll: true,
                    onSuccess: () => (this.form.reset()),
                });
                this.processing = false;
            },

            onValidateChange(phone) {
                if (phone.valid === true) {
                    this.form.phone = phone.number;
                    this.form.errors.phone = null;
                } else {
                    this.form.phone = null;
                    this.form.errors.phone = "The Phone field is invalid";
                }
            }

        },
    }
</script>

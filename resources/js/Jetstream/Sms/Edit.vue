<template>
    <div class="p-6">

        <!-- Api Key -->
        <div class="p-6 m-6 border col-span-6 sm:col-span-12">
            <jet-label for="phone" value="Phone" />
            <input type="text" ref="phone" class="mt-1 p-3 w-full" v-model="form.phone">
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
            JetCheckbox
        },

        data() {
            return {
                processing: false,
                form: this.$inertia.form({
                    _method: 'PUT',
                    cost: 0,
                    phone: null,
                }),
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

        },
    }
</script>

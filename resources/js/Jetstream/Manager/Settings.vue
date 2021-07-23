<template>
    <div class="p-6">

        <!-- Logo -->
        <div class="p-6 m-6 border col-span-6 sm:col-span-12">
            <jet-label for="logo" value="Logo" />
            <input type="file" ref="logo">
        </div>

        <!-- Welcome -->
        <div class="p-6 m-6 border col-span-6 sm:col-span-12">
            <jet-label for="welcome" value="Welcome Page" />
            <jet-editor id="welcome" class="mt-1 w-full" v-model="form.welcome"/>
        </div>

        <jet-action-message :on="recentlySuccessful" class="mr-3">
            Saved.
        </jet-action-message>

        <jet-button :class="{ 'opacity-25': processing }" :disabled="processing" @click="updateSettings">
            Save
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

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
            JetEditor
        },

        data() {
            return {
                processing: false,
                recentlySuccessful: false,
                form: this.$inertia.form({
                    _method: 'PUT',
                    welcome: null,
                    logo: null,
                }),
            }
        },

        mounted() {
            this.form.welcome = this.$page.props.settings.welcome;
        },

        methods: {
            updateSettings() {
                this.processing = true;
                if (this.$refs.logo) {
                    this.form.logo = this.$refs.logo.files[0];
                }
                this.form.post(route('manager.settings.update'), {
                    errorBag: 'updateSettings',
                    preserveScroll: true,
                    onSuccess: () => (this.recentlySuccessful = true),
                });
                this.processing = false;
            },

        },
    }
</script>

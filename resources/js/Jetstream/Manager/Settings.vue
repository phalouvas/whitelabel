<template>
    <div class="p-6">

        <!-- Api Key -->
        <div class="p-6 m-6 border col-span-6 sm:col-span-12">
            <jet-label for="api_key" value="SMSto - Api Key" />
            <input type="text" ref="api_key" class="mt-1 p-3 w-full" v-model="form.api_key">
        </div>

        <!-- Logo -->
        <div class="p-6 m-6 border col-span-6 sm:col-span-12">
            <jet-label for="logo" value="Logo" />
            <input type="file" ref="logo">
        </div>

        <!-- Welcome -->
        <div class="p-6 m-6 border col-span-6 sm:col-span-12">
            <jet-label for="welcome" value="Welcome Page" />
            <textarea v-if="is_html" class="mt-1 border p-3 overflow-y-scroll max-h-96 w-full" v-model="form.welcome" rows="96"/>
            <jet-editor v-else id="welcome" class="mt-1 w-full" v-model="form.welcome"/>
            <div class="flex items-center w-full">
            <jet-checkbox
                name="isHtml"
                id="isHtml"
                v-model:checked="is_html"
            />
            <div class="ml-2">
                <span v-if="is_html">Switch to editor</span>
                <span v-else>Switch to plain HTML</span>
            </div>
            </div>
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
                recentlySuccessful: false,
                is_html: false,
                form: this.$inertia.form({
                    _method: 'PUT',
                    welcome: null,
                    logo: null,
                    api_key: null
                }),
            }
        },

        mounted() {
            this.form.welcome = this.$page.props.settings.welcome;
            this.form.api_key = this.$page.props.settings.api_key;
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

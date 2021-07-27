<template>
    <div class="p-6">

        <!-- Api Key -->
        <div class="p-6 m-6 border col-span-6 sm:col-span-12">
            <jet-label for="token" value="SMSto - Api Key" />
            <input type="text" ref="token" class="mt-1 p-3 w-full" v-model="form.token">
        </div>

        <!-- Logo -->
        <div class="p-6 m-6 border col-span-6 sm:col-span-12">
            <jet-label for="logo" value="Logo" />
            <input type="file" ref="logo">
        </div>

        <!-- Phone -->
        <div class="p-6 m-6 border col-span-6 sm:col-span-12">
            <jet-label for="phone" value="Phone" />
            <input type="text" ref="phone" class="mt-1 p-3 w-full" v-model="form.phone">
        </div>

        <!-- Email -->
        <div class="p-6 m-6 border col-span-6 sm:col-span-12">
            <jet-label for="email" value="Email" />
            <input type="text" ref="email" class="mt-1 p-3 w-full" v-model="form.email">
        </div>

        <!-- Address -->
        <div class="p-6 m-6 border col-span-6 sm:col-span-12">
            <jet-label for="address" value="Address" />
            <textarea class="mt-1 border p-3 overflow-y-scroll max-h-96 w-full" v-model="form.address" rows="4"/>
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

        <!-- Terms Of Service -->
        <div class="p-6 m-6 border col-span-6 sm:col-span-12">
            <jet-label for="terms" value="Terms Of Service" />
            <textarea v-if="is_html" class="mt-1 border p-3 overflow-y-scroll max-h-96 w-full" v-model="form.terms" rows="96"/>
            <jet-editor v-else id="terms" class="mt-1 w-full" v-model="form.terms"/>
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

        <!-- Privacy Policy -->
        <div class="p-6 m-6 border col-span-6 sm:col-span-12">
            <jet-label for="privacy" value="Privacy Policy" />
            <textarea v-if="is_html" class="mt-1 border p-3 overflow-y-scroll max-h-96 w-full" v-model="form.privacy" rows="96"/>
            <jet-editor v-else id="privacy" class="mt-1 w-full" v-model="form.privacy"/>
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

        <jet-action-message :on="form.recentlySuccessful" class="mr-3">
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
                is_html: false,
                form: this.$inertia.form({
                    _method: 'PUT',
                    welcome: null,
                    logo: null,
                    token: null,
                    email: null,
                    phone: null,
                    address: null,
                    terms: null,
                    privacy: null
                }),
            }
        },

        mounted() {
            this.form.welcome = this.$page.props.settings.welcome;
            this.form.token = this.$page.props.settings.token;
            this.form.email = this.$page.props.settings.email;
            this.form.phone = this.$page.props.settings.phone;
            this.form.address = this.$page.props.settings.address;
            this.form.terms = this.$page.props.settings.terms;
            this.form.privacy = this.$page.props.settings.privacy;
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
                });
                this.processing = false;
            },

        },
    }
</script>

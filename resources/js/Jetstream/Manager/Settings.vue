<template>
    <jet-form-section class="p-6">

        <template #title>
            Site Information
        </template>

        <template #description>
            Update your site's settings and information.
        </template>

        <template #form>

            <!-- Welcome -->
            <div class="col-span-6 sm:col-span-12">
                <jet-label for="welcome" value="Welcome" />
                <jet-editor id="welcome" class="mt-1 w-full" v-model="form.welcome"/>
            </div>
                <jet-input-error :message="form.errors.welcome" class="mt-2" />

        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="updateSettings">
                Save
            </jet-button>
        </template>
    </jet-form-section>
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
                form: this.$inertia.form({
                    _method: 'PUT',
                    welcome: this.$page.props.settings.welcome,
                }),

            }
        },

        methods: {
            updateSettings() {
                return;
                this.form.post(route('manager.settings.update'), {
                    errorBag: 'updateSettings',
                    preserveScroll: true,
                    onSuccess: () => (this.clearPhotoFileInput()),
                });
            },

        },
    }
</script>

<template>
    <div class="p-6">

        <!-- Welcome -->
        <div class="col-span-6 sm:col-span-12">
            <jet-label for="welcome" value="Welcome Page" />
            <jet-editor id="welcome" class="mt-1 w-full" v-model="welcome"/>
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
                welcome: null,
            }
        },

        mounted() {
            this.welcome = this.$page.props.settings.welcome;
        },

        methods: {
            updateSettings() {
                this.processing = true;
                axios
                .put(
                    route("manager.settings.update", {
                        welcome: this.welcome,
                    })
                    )
                    .then((response) => {
                        this.recentlySuccessful = true;
                    })
                    .catch((error) => {
                    //
                    })
                    .finally(() => {
                        this.recentlySuccessful = false;
                        this.processing = false;
                    });
            },

        },
    }
</script>

<template>
    <guest-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Contact Us
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-3 prose prose-sm sm:prose lg:prose-lg xl:prose-2xl m-5 focus:outline-none">
                        <jet-form-contact-us @submitted="updateContactUs">
                            <template #title>
                                Direct Contact
                            </template>

                            <template #email>
                                {{$page.props.settings.email}}
                            </template>

                            <template #phone>
                                {{$page.props.settings.phone}}
                            </template>

                            <template #address>
                                {{$page.props.settings.address}}
                            </template>

                            <template #form>

                                <!-- Name -->
                                <div class="col-span-12 sm:col-span-12">
                                    <jet-label for="name" value="Name" />
                                    <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name"/>
                                    <jet-input-error :message="form.errors.name" class="mt-2" />
                                </div>

                                <!-- Email -->
                                <div class="col-span-12 sm:col-span-12">
                                    <jet-label for="email" value="Email" />
                                    <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email"/>
                                    <jet-input-error :message="form.errors.email" class="mt-2" />
                                </div>

                                <!-- Phone -->
                                <div class="col-span-12 sm:col-span-12">
                                    <jet-label for="phone" value="Phone" />
                                    <jet-input id="phone" type="text" class="mt-1 block w-full" v-model="form.phone"/>
                                    <span class="text-sm text-gray-400">*international phone number format</span>
                                    <jet-input-error :message="form.errors.phone" class="mt-2" />
                                </div>

                                <!-- Message -->
                                <div class="col-span-12 sm:col-span-12">
                                    <jet-label for="message" value="Message" />
                                    <textarea id="message" type="message" class="mt-1 block w-full" rows="12" v-model="form.message" />
                                    <jet-input-error :message="form.errors.message" class="mt-2" />
                                </div>
                            </template>

                            <template #actions>
                                <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                                    Your message is successfully sent!
                                </jet-action-message>

                                <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing || form.recentlySuccessful">
                                    Send
                                </jet-button>
                            </template>
                        </jet-form-contact-us>
                    </div>
                </div>
            </div>
        </div>
    </guest-layout>
</template>

<script>
    import GuestLayout from '@/Layouts/GuestLayout'
    import JetButton from '@/Jetstream/Button'
    import JetFormContactUs from '@/Jetstream/FormContactUs'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        components: {
            GuestLayout,
            JetActionMessage,
            JetButton,
            JetFormContactUs,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
        },

        data() {
            return {
                form: this.$inertia.form({
                    _method: 'PUT',
                    name: null,
                    email: null,
                    message: null,
                    phone: null
                }),
            }
        },

        methods: {
            updateContactUs() {
                this.form.post(route('contact-us.update'), {
                    errorBag: 'updateContactUs',
                    preserveScroll: true,
                    onSuccess: () => (this.clearForm()),
                });
            },

            clearForm() {
                this.form.name = null;
                this.form.email = null;
                this.form.message = null;
                this.form.phone = null;
            }

        },
    }

</script>

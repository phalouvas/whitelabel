<template>
    <guest-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-3 prose prose-sm sm:prose lg:prose-lg xl:prose-2xl m-5 focus:outline-none" v-html="this.$page.props.settings.welcome"></div>
                </div>
            </div>
        </div>
    </guest-layout>
</template>

<script>
    import GuestLayout from '@/Layouts/GuestLayout'
    import Welcome from '@/Jetstream/Welcome'

    export default {
        components: {
            GuestLayout,
            Welcome,
        },
    }
</script>

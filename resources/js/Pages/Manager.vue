<template>
    <manager-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <welcome />
                </div>
            </div>
        </div>
    </manager-layout>
</template>

<script>
    import ManagerLayout from '@/Layouts/ManagerLayout'
    import Welcome from '@/Jetstream/Manager/Welcome'

    export default {
        components: {
            ManagerLayout,
            Welcome,
        },
    }
</script>

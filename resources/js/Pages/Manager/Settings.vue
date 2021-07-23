<template>
    <manager-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Settings
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <settings />
                </div>
            </div>
        </div>
    </manager-layout>
</template>

<script>
    import ManagerLayout from '@/Layouts/ManagerLayout'
    import Settings from '@/Jetstream/Manager/Settings'

    export default {
        components: {
            ManagerLayout,
            Settings,
        },
    }
</script>

<template>
    <manager-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Countries
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <countries />
                </div>
            </div>
        </div>
    </manager-layout>
</template>

<script>
    import ManagerLayout from '@/Layouts/ManagerLayout'
    import Countries from '@/Jetstream/Manager/Countries'

    export default {
        components: {
            ManagerLayout,
            Countries,
        },
    }
</script>

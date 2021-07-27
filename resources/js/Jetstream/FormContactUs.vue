<template>
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1 flex justify-between">
        <div class="px-4 sm:px-0">
            <h4 class="text-lg font-medium text-gray-900">
                <slot name="title"></slot>
            </h4>

            <p class="mt-1 text-md text-gray-400">
                <i class="far fa-envelope p-2"></i>
                <slot name="email"></slot>
            </p>

            <p class="mt-1 text-md text-gray-400">
               <i class="fas fa-phone p-2"></i>
                <slot name="phone"></slot>
            </p>

            <p class="mt-1 text-sm text-gray-400">
                <i class="fas fa-map-marker-alt p-2"></i>
                <slot name="address"></slot>
            </p>
        </div>

        <div class="px-4 sm:px-0">
            <slot name="aside"></slot>
        </div>
    </div>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <form @submit.prevent="$emit('submitted')">
                <div class="px-4 py-5 bg-white sm:p-6 shadow"
                    :class="hasActions ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md'">
                    <div class="grid grid-cols-6 gap-6">
                        <slot name="form"></slot>
                    </div>
                </div>

                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md" v-if="hasActions">
                    <slot name="actions"></slot>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import JetSectionTitle from './SectionTitle'

    export default {
        emits: ['submitted'],

        components: {
            JetSectionTitle,
        },

        computed: {
            hasActions() {
                return !! this.$slots.actions
            }
        }
    }
</script>

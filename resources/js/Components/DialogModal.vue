<template>
    <div v-if="show" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
        <div :class="['bg-white rounded-lg w-96', maxWidthClass]">
            <div class="px-6 py-4">
                <div class="text-lg font-medium text-gray-900">
                    <slot name="title" />
                </div>

                <div class="mt-4 text-sm text-gray-600">
                    <slot name="content" />
                </div>
            </div>

            <div class="flex justify-end px-6 py-4 bg-gray-100 rounded-b-lg">
                <slot name="footer" />
            </div>
        </div>
    </div>
</template>

<script setup>
import Modal from './Modal.vue';

const emit = defineEmits(['close']);

defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});

const close = () => {
    emit('close');
};
</script>
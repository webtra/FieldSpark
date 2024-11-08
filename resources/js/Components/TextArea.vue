<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <textarea ref="input"
        class="text-black text-xs placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded-lg" rows="5"
        :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"></textarea>
</template>

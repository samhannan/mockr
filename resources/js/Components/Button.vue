<script setup>
    import { useButtonStyles } from '@/Composables/useButtonStyles.js'

    defineProps({
        variant: {
            type: String,
            default: 'primary',
        },
        disabled: {
            type: Boolean,
            default: false,
        },
    })
</script>

<template>
    <button
        :disabled="disabled"
        v-bind="$attrs"
        :class="useButtonStyles({ intent: variant, disabled })"
    >
        <slot />
    </button>
</template>

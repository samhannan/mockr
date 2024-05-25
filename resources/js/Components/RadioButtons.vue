<template>
    <div>
        <div class="flex items-center justify-between">
            <h2 class="text-sm font-medium leading-6 text-gray-900">{{ label }}</h2>
        </div>
        <RadioGroup v-model="model" class="mt-2">
            <RadioGroupLabel class="sr-only">{{ label }}</RadioGroupLabel>
            <div class="grid grid-cols-3 gap-2 sm:grid-cols-5">
                <RadioGroupOption as="template" v-for="option in options" :key="option.name" :value="option" :disabled="option.disabled" v-slot="{ active, checked }">
                    <div :class="[!option.disabled ? 'cursor-pointer focus:outline-none' : 'cursor-not-allowed opacity-25', active ? 'ring-2 ring-indigo-600 ring-offset-2' : '', checked ? 'bg-indigo-600 text-white hover:bg-indigo-500' : 'ring-1 ring-inset ring-gray-300 bg-white text-gray-900 hover:bg-gray-50', 'flex items-center justify-center rounded-md py-2 px-3 text-sm font-semibold uppercase sm:flex-1']">
                        <RadioGroupLabel as="span">{{ option.name }}</RadioGroupLabel>
                    </div>
                </RadioGroupOption>
            </div>
        </RadioGroup>
    </div>
</template>

<script setup>
import { RadioGroup, RadioGroupLabel, RadioGroupOption } from '@headlessui/vue'

const { options, label } = defineProps({
    options: Array,
    label: String,
})

const model = defineModel({ default: null })
</script>

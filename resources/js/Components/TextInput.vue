<template>
    <div>
        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">{{ label }}</label>
        <div class="mt-2">
            <input v-model="model" :name="name" :id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" v-bind="$attrs" />
        </div>
    </div>
</template>


<script setup>
    const { label, name, placeholder } = defineProps({
        label: String,
        name: {
            type: String,
            required: true,
        },
        type: {
            type: String,
            default: 'text',
        },
    });

    const model = defineModel({ default: null });
</script>

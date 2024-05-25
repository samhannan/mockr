<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import { Head, useForm } from '@inertiajs/vue3'
    import { computed, ref } from 'vue'
    import Slideover from '@/Components/Slideover.vue'
    import RadioButtons from '@/Components/RadioButtons.vue'
    import Toggle from '@/Components/Toggle.vue'
    import TextInput from '@/Components/TextInput.vue'
    import Combobox from '@/Components/Combobox.vue'
    import codes from '@/Config/status-codes.js'
    import Button from '@/Components/Button.vue'
    import { useClipboard } from '@vueuse/core'
    import { ClipboardDocumentIcon } from '@heroicons/vue/24/outline'

    const { endpoints } = defineProps({
        endpoints: {
            type: Array,
            required: true,
        },
    })

    const { text, copy, copied, isSupported } = useClipboard()

    const endpointPanelOpen = ref(false)

    const verbs = [
        { name: 'GET', value: 'get', disabled: false },
        { name: 'POST', value: 'post', disabled: false },
        { name: 'PUT', value: 'put', disabled: false },
        { name: 'PATCH', value: 'patch', disabled: false },
        { name: 'DELETE', value: 'delete', disabled: false },
    ]

    const statusCodes = Object.values(codes).map((code) => ({
        label: code.code.toString(),
        value: code.code,
        description: code.message,
    }))

    const delayToggle = ref(false)

    const form = useForm({
        method: '',
        statusCode: '',
        delay: null,
    })

    const canSaveEndpoint = computed(() => {
        return form.method.value && form.statusCode.value
    })
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #page-title>Dashboard</template>
        <template #actions>
            <button
                type="button"
                class="ml-3 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                @click="endpointPanelOpen = true"
            >
                Create Endpoint
            </button>
        </template>
        <kbd
            class="text-md block mb-5 border-b pb-5 flex justify-between"
            v-for="endpoint in endpoints.data"
        >
            <span>
                <span
                    class="font-semibold uppercase bg-slate-700 text-slate-100 p-1 mr-3 rounded-md text-sm text-center min-w-[50px] inline-block"
                >
                    {{ endpoint.method }}
                </span>
                <span>
                    {{ endpoint.url }}
                    <ClipboardDocumentIcon
                        v-if="isSupported"
                        class="w-5 inline cursor-pointer"
                        @click="copy(endpoint.url)"
                    />
                </span>
                <span v-if="copied && text === endpoint.url" class="text-xs">
                    Copied to clipboard
                </span>
            </span>
            <span class="block text-sm text-gray-900 font-semibold">
                <span>Status code: {{ endpoint.status_code }}</span>
                <span>&nbsp;| Delay: {{ endpoint.delay ?? 0 }}s</span>
            </span>
        </kbd>
        <Slideover v-model="endpointPanelOpen">
            <template #title>Generate Endpoint</template>
            <form
                @submit.prevent="
                    form.transform((data) => ({
                        method: data.method.value,
                        status_code: data.statusCode.value,
                        delay: data.delay,
                    })).post(route('endpoints.store'), {
                        onSuccess: () => {
                            endpointPanelOpen = false
                            form.reset()
                        },
                    })
                "
                class="form"
            >
                <RadioButtons
                    :options="verbs"
                    label="Method"
                    class="mb-5"
                    v-model="form.method"
                />
                <Combobox
                    :options="statusCodes"
                    label="Response Code"
                    placeholder="200"
                    class="mb-5"
                    autocomplete="false"
                    v-model="form.statusCode"
                />

                <Toggle
                    label="Add Delay"
                    helpText="Wait before returning a response"
                    class="mb-5"
                    v-model="delayToggle"
                />
                <TextInput
                    v-if="delayToggle"
                    label="Delay (seconds)"
                    name="delay"
                    v-model="form.delay"
                    type="number"
                    placeholder="3"
                    class="mb-7"
                />
                <Button :disabled="form.processing || !canSaveEndpoint">
                    Save
                </Button>
            </form>
        </Slideover>
    </AuthenticatedLayout>
</template>

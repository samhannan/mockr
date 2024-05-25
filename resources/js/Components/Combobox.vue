<template>
    <Combobox as="div" v-model="selected">
        <ComboboxLabel
            class="block text-sm font-medium leading-6 text-gray-900"
        >
            {{ label }}
        </ComboboxLabel>
        <div class="relative mt-2">
            <ComboboxInput
                class="w-full rounded-md border-0 bg-white py-1.5 pl-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                @change="onInputChange"
                :value="inputValue"
                :display-value="(option) => option?.label"
                :placeholder="placeholder"
            />
            <ComboboxButton
                class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none"
            >
                <ChevronUpDownIcon
                    class="h-5 w-5 text-gray-400"
                    aria-hidden="true"
                />
            </ComboboxButton>

            <ComboboxOptions
                v-if="filteredOptions.length > 0"
                class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
            >
                <ComboboxOption
                    v-for="option in filteredOptions"
                    :key="option.value"
                    :value="option"
                    as="template"
                    v-slot="{ active, selected }"
                >
                    <li
                        :class="[
                            'relative cursor-default select-none py-2 pl-3 pr-9 cursor-pointer',
                            active
                                ? 'bg-indigo-600 text-white'
                                : 'text-gray-900',
                        ]"
                    >
                        <div class="flex">
                            <span
                                :class="[
                                    'truncate',
                                    selected && 'font-semibold',
                                ]"
                            >
                                {{ option.label }}
                            </span>
                            <span
                                :class="[
                                    'ml-2 truncate text-gray-500',
                                    active
                                        ? 'text-indigo-200'
                                        : 'text-gray-500',
                                ]"
                            >
                                {{ option.description }}
                            </span>
                        </div>

                        <span
                            v-if="selected"
                            :class="[
                                'absolute inset-y-0 right-0 flex items-center pr-4',
                                active ? 'text-white' : 'text-indigo-600',
                            ]"
                        >
                            <CheckIcon class="h-5 w-5" aria-hidden="true" />
                        </span>
                    </li>
                </ComboboxOption>
            </ComboboxOptions>
        </div>
    </Combobox>
</template>

<script setup>
    import { computed, ref, watch } from 'vue'
    import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid'
    import {
        Combobox,
        ComboboxButton,
        ComboboxInput,
        ComboboxLabel,
        ComboboxOption,
        ComboboxOptions,
    } from '@headlessui/vue'

    const { options, label } = defineProps({
        options: {
            type: Array,
            required: true,
        },
        label: {
            type: String,
            default: 'Select',
        },
        placeholder: {
            type: String,
            default: 'Select an option',
        },
    })

    let selected = ref(options[0])
    let query = ref('')
    let inputValue = ref('')

    watch(selected, (value) => {
        query.value = ''
        inputValue.value = value.label
    })

    const onInputChange = (event) => {
        query.value = event.target.value
        inputValue.value = event.target.value
    }

    const filteredOptions = computed(() =>
        query.value === ''
            ? options
            : options.filter((option) => {
                  return `${option.label} ${option.description}`
                      .toString()
                      .toLowerCase()
                      .includes(query.value.toLowerCase())
              }),
    )
</script>

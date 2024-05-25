import { cva } from 'class-variance-authority'

export const useButtonStyles = cva(
    [
        'inline-flex items-center justify-center gap-x-2 rounded-md px-4 py-2 text-sm font-semibold shadow-sm transition duration-100 ease-in-out',
    ],
    {
        variants: {
            intent: {
                primary:
                    'bg-indigo-700 text-white border-transparent focus:ring-indigo-500 hover:bg-indigo-600',
                secondary:
                    'rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50',
                danger: 'bg-red-600 text-white border-transparent focus:ring-red-500',
                warning:
                    'bg-orange-600 text-white border-transparent focus:ring-amber-500 hover:bg-orange-500',
            },
            disabled: {
                true: 'opacity-50 cursor-not-allowed',
            },
        },
    },
)

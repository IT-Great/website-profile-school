```vue
<script setup>
const statistics = [
    {
        number: '500+',
        title: 'Students',
        icon: 'students',
    },
    {
        number: '25+',
        title: 'Teachers',
        icon: 'teachers',
    },
    {
        number: '15+',
        title: 'Years of Excellence',
        icon: 'excellence',
    },
    {
        number: '100%',
        title: 'Graduation Rate',
        icon: 'graduation',
    },
]
</script>

<template>
    <section
        class="relative z-10 -mt-10 px-4 sm:-mt-12 sm:px-6 md:-mt-14 md:px-8 lg:-mt-16 lg:px-10 xl:px-12 2xl:px-16"
    >
        <div
            class="mx-auto w-full max-w-6xl rounded-2xl bg-white px-5 py-6 shadow-xl sm:px-7 sm:py-7 md:px-8 md:py-8 lg:px-10 lg:py-9"
        >
            <div
                class="grid grid-cols-2 gap-x-4 gap-y-7 sm:gap-x-6 sm:gap-y-8 lg:grid-cols-4 lg:gap-6"
            >
                <!-- Students -->
                <div class="flex min-w-0 items-center gap-3 sm:gap-4">
                    <svg
                        class="h-7 w-7 shrink-0 text-orange-500 sm:h-8 sm:w-8"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M17 20v-1a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v1M9.5 11a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM19 20v-1a4 4 0 0 0-3-3.87M14.5 4.13a3.5 3.5 0 0 1 0 6.75"
                        />
                    </svg>

                    <div class="min-w-0">
                        <p
                            class="text-xl font-bold leading-tight text-gray-900 sm:text-2xl lg:text-3xl"
                        >
                            500+
                        </p>
                        <p class="mt-1 text-xs leading-5 text-gray-500 sm:text-sm">
                            Students
                        </p>
                    </div>
                </div>

                <!-- Teachers -->
                <div class="flex min-w-0 items-center gap-3 sm:gap-4">
                    <svg
                        class="h-7 w-7 shrink-0 text-orange-500 sm:h-8 sm:w-8"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M22 10L12 5 2 10l10 5 10-5z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 12v5c0 1.5 3 3 6 3s6-1.5 6-3v-5"
                        />
                    </svg>

                    <div class="min-w-0">
                        <p
                            class="text-xl font-bold leading-tight text-gray-900 sm:text-2xl lg:text-3xl"
                        >
                            25+
                        </p>
                        <p class="mt-1 text-xs leading-5 text-gray-500 sm:text-sm">
                            Teachers
                        </p>
                    </div>
                </div>

                <!-- Years of Excellence -->
                <div class="flex min-w-0 items-center gap-3 sm:gap-4">
                    <svg
                        class="h-7 w-7 shrink-0 text-orange-500 sm:h-8 sm:w-8"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8 21h8M12 17v4M7 4h10v4a5 5 0 0 1-10 0V4zM7 5H4a3 3 0 0 0 3 4M17 5h3a3 3 0 0 1-3 4"
                        />
                    </svg>

                    <div class="min-w-0">
                        <p
                            class="text-xl font-bold leading-tight text-gray-900 sm:text-2xl lg:text-3xl"
                        >
                            15+
                        </p>
                        <p class="mt-1 text-xs leading-5 text-gray-500 sm:text-sm">
                            Years of Excellence
                        </p>
                    </div>
                </div>

                <!-- Graduation Rate -->
                <div class="flex min-w-0 items-center gap-3 sm:gap-4">
                    <svg
                        class="h-7 w-7 shrink-0 text-orange-500 sm:h-8 sm:w-8"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 2l2.9 6.3 6.9.6-5.2 4.6 1.6 6.8L12 16.9 5.8 20.3l1.6-6.8L2.2 8.9l6.9-.6L12 2z"
                        />
                    </svg>

                    <div class="min-w-0">
                        <p
                            class="text-xl font-bold leading-tight text-gray-900 sm:text-2xl lg:text-3xl"
                        >
                            100%
                        </p>
                        <p class="mt-1 text-xs leading-5 text-gray-500 sm:text-sm">
                            Graduation Rate
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
```

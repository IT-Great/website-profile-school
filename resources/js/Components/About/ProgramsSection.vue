<script setup>
import { Link } from '@inertiajs/vue3'
import { ArrowRight } from 'lucide-vue-next'

const programs = [
    {
        title: 'Preschool',
        subtitle: '2 - 6 Years Old',
        description: 'A safe and joyful environment for early learners.',
        url: '/programs/preschool',
        bg: 'bg-pink-100',
        color: 'text-pink-500',
        icon: 'M12 3c-1.5 0-2.5 1-2.5 2.2 0 .5.2 1 .5 1.3C8.8 7 8 8.3 8 10c0 2.8 1.8 4.5 4 4.5s4-1.7 4-4.5c0-1.7-.8-3-2-3.5.3-.3.5-.8.5-1.3C14.5 4 13.5 3 12 3zM9 16.5c-2 0-3.5 1.2-3.5 3v1.5h13v-1.5c0-1.8-1.5-3-3.5-3',
    },
    {
        title: 'Primary',
        subtitle: '6 - 12 Years Old',
        description: 'Building strong foundations for lifelong learning.',
        url: '/programs/primary',
        bg: 'bg-amber-100',
        color: 'text-amber-500',
        icon: 'M4 5.5C4 5 4.5 4.5 5 4.5h6v14H5c-.5 0-1-.4-1-1V5.5zM20 5.5c0-.5-.5-1-1-1h-6v14h6c.5 0 1-.4 1-1V5.5z',
    },
    {
        title: 'Secondary',
        subtitle: '12 - 15 Years Old',
        description: 'Encouraging critical thinking and creativity.',
        url: '/programs/secondary',
        bg: 'bg-green-100',
        color: 'text-green-600',
        icon: 'M6 8h12v11a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V8zM9 8V6a3 3 0 0 1 6 0v2M9 12h6',
    },
]
</script>

<template>
    <section class="bg-gray-100 py-12 sm:py-14 lg:py-20">
        <div
            class="mx-auto w-full max-w-[1600px]
                   px-4 sm:px-6 md:px-8
                   lg:px-12 xl:px-16 2xl:px-20"
        >
            <!-- Section Heading -->
            <div class="mx-auto mb-8 max-w-3xl text-center sm:mb-10 lg:mb-12">
                <span
                    class="text-xs font-semibold uppercase tracking-[2px]
                           text-orange-500
                           sm:text-sm sm:tracking-[3px]"
                >
                    Our Programs
                </span>

                <h2
                    class="mt-3 text-2xl font-bold leading-tight text-gray-900
                           sm:text-3xl
                           lg:text-4xl
                           xl:text-5xl"
                >
                    A Path for Every Stage of Growth
                </h2>

                <p
                    class="mx-auto mt-4 max-w-2xl text-sm leading-6 text-gray-600
                           sm:text-base sm:leading-7"
                >
                    From early years to higher education, we provide programs
                    that support students in achieving their full potential.
                </p>
            </div>

            <!-- Programs Grid -->
            <div
                class="grid grid-cols-1 gap-4
                       sm:grid-cols-2 sm:gap-5
                       lg:grid-cols-3 lg:gap-6
                       xl:gap-7"
            >
                <div
                    v-for="program in programs"
                    :key="program.title"
                    class="group flex h-full flex-col items-center
                           rounded-2xl border border-gray-100 bg-white
                           px-5 py-7 text-center
                           transition-all duration-300
                           hover:-translate-y-1 hover:shadow-xl
                           sm:px-6 sm:py-8
                           lg:px-7 lg:py-9
                           xl:px-9"
                >
                    <!-- Program Icon -->
                    <div
                        class="flex h-14 w-14 shrink-0 items-center justify-center
                               rounded-full transition-transform duration-300
                               group-hover:scale-110
                               sm:h-16 sm:w-16"
                        :class="program.bg"
                    >
                        <svg
                            class="h-6 w-6 sm:h-7 sm:w-7"
                            :class="program.color"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                :d="program.icon"
                            />
                        </svg>
                    </div>

                    <!-- Program Information -->
                    <h3
                        class="mt-4 text-lg font-bold text-gray-900
                               sm:text-xl"
                    >
                        {{ program.title }}
                    </h3>

                    <p
                        class="mt-2 text-sm font-medium text-gray-500"
                    >
                        {{ program.subtitle }}
                    </p>

                    <p
                        class="mt-3 max-w-sm text-sm leading-6 text-gray-600
                               sm:text-base sm:leading-7"
                    >
                        {{ program.description }}
                    </p>

                    <!-- Learn More -->
                    <div class="mt-auto pt-5">
                        <Link
                            :href="program.url"
                            class="inline-flex items-center gap-2 rounded-full
                                   py-2 text-sm font-semibold text-orange-500
                                   transition-all duration-300
                                   hover:gap-3 hover:text-orange-600
                                   focus-visible:outline-none
                                   focus-visible:ring-2
                                   focus-visible:ring-orange-500
                                   focus-visible:ring-offset-2"
                        >
                            Learn More
                            <ArrowRight class="h-4 w-4 shrink-0" />
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
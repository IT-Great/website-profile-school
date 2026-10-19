
<script setup>
import { Link } from '@inertiajs/vue3'

const programs = [
    {
        name: 'Preschool',
        age: 'Ages 2 – 5 Years',
        description: 'Our preschool program provides a joyful, safe, and nurturing environment where children learn through play, exploration, and discovery.',
        points: [
            'Play-based learning',
            'Social & emotional development',
            'Language & communication',
            'Creativity & independence',
        ],
        image: '/storage/images/preschool.jpg',
        iconBg: 'bg-orange-100',
        iconColor: 'text-orange-500',
        accentColor: 'text-orange-500',
        checkColor: 'text-orange-500',
        linkColor: 'text-orange-500',
        url: '/programs/preschool',
    },
    {
        name: 'Primary School',
        age: 'Ages 6 – 11 Years',
        description: 'Our primary program builds strong academic foundations while developing critical thinking, character, and a love for learning.',
        points: [
            'Cambridge Primary Curriculum',
            'Character & Values Education',
            'STEM & Digital Literacy',
            'Critical Thinking & Problem Solving',
        ],
        image: '/storage/images/primary.jpeg',
        iconBg: 'bg-amber-100',
        iconColor: 'text-amber-500',
        accentColor: 'text-amber-500',
        checkColor: 'text-amber-500',
        linkColor: 'text-amber-500',
        url: '/programs/primary',
    },
    {
        name: 'Secondary School',
        age: 'Ages 12 – 18 Years',
        description: 'Our secondary program prepares students for global opportunities with academic excellence, leadership, and real-world skills.',
        points: [
            'Cambridge Lower Secondary & IGCSE',
            'Leadership & Global Citizenship',
            'Advanced Academic Subjects',
            'University & Career Preparation',
        ],
        image: '/storage/images/secondary.jpg',
        iconBg: 'bg-green-100',
        iconColor: 'text-green-600',
        accentColor: 'text-green-600',
        checkColor: 'text-green-600',
        linkColor: 'text-green-600',
        url: '/programs/secondary',
    },
]
</script>

<template>
    <section class="bg-white py-12 sm:py-14 lg:py-20">
        <div
            class="mx-auto w-full max-w-[1600px] px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-20"
        >
            <!-- Heading -->
            <div class="mx-auto mb-8 max-w-3xl text-center sm:mb-10 lg:mb-12">
                <span
                    class="text-xs font-semibold uppercase tracking-[2px] text-orange-500 sm:text-sm sm:tracking-[3px]"
                >
                    Our Programs
                </span>

                <h2
                    class="mt-3 text-2xl font-bold leading-tight text-gray-900 sm:text-3xl lg:text-4xl xl:text-5xl"
                >
                    Education for Every Stage of Life
                </h2>

                <p
                    class="mx-auto mt-4 max-w-2xl text-sm leading-6 text-gray-500 sm:text-base sm:leading-7"
                >
                    We provide world-class education programs designed to help
                    students grow academically, socially, and emotionally at
                    every stage.
                </p>
            </div>

            <!-- Program Cards -->
            <div class="flex flex-col gap-5 sm:gap-6 lg:gap-8">
                <article
                    v-for="(program, index) in programs"
                    :key="program.name"
                    class="overflow-hidden rounded-2xl border border-gray-100 bg-white p-4 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg sm:p-5 md:p-6 lg:p-7 xl:p-8"
                >
                    <div
                        class="grid grid-cols-1 items-center gap-5 sm:gap-6 lg:grid-cols-[minmax(0,0.9fr)_minmax(0,1.1fr)] lg:gap-8 xl:gap-10"
                    >
                        <!-- Image -->
                        <div
                            class="overflow-hidden rounded-xl sm:rounded-2xl"
                            :class="index % 2 === 1 ? 'lg:order-2' : ''"
                        >
                            <img
                                :src="program.image"
                                :alt="program.name"
                                loading="lazy"
                                class="aspect-[4/3] w-full object-cover transition duration-500 hover:scale-105 sm:aspect-[16/10] lg:aspect-[4/3]"
                            />
                        </div>

                        <!-- Content -->
                        <div
                            class="flex min-w-0 flex-col"
                            :class="index % 2 === 1 ? 'lg:order-1' : ''"
                        >
                            <!-- Program title -->
                            <div class="flex items-center gap-3 sm:gap-4">
                                <div
                                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full sm:h-14 sm:w-14"
                                    :class="program.iconBg"
                                >
                                    <svg
                                        class="h-5 w-5 sm:h-6 sm:w-6"
                                        :class="program.iconColor"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 3v18m-8-9h16"
                                        />
                                    </svg>
                                </div>

                                <div class="min-w-0">
                                    <h3
                                        class="text-lg font-bold leading-snug text-gray-900 sm:text-xl lg:text-2xl"
                                    >
                                        {{ program.name }}
                                    </h3>

                                    <p
                                        class="mt-1 text-xs font-medium sm:text-sm"
                                        :class="program.accentColor"
                                    >
                                        {{ program.age }}
                                    </p>
                                </div>
                            </div>

                            <!-- Description -->
                            <p
                                class="mt-4 text-sm leading-6 text-gray-500 sm:mt-5 sm:text-base sm:leading-7"
                            >
                                {{ program.description }}
                            </p>

                            <!-- Checklist -->
                            <div
                                class="mt-4 grid grid-cols-1 gap-x-4 gap-y-3 min-[420px]:grid-cols-2 sm:mt-5 sm:gap-y-3"
                            >
                                <div
                                    v-for="point in program.points"
                                    :key="point"
                                    class="flex min-w-0 items-start gap-2"
                                >
                                    <svg
                                        class="mt-0.5 h-4 w-4 shrink-0"
                                        :class="program.checkColor"
                                        viewBox="0 0 24 24"
                                        fill="currentColor"
                                        aria-hidden="true"
                                    >
                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="10"
                                            opacity="0.15"
                                        />
                                        <path
                                            d="M17 8.5L10.5 15 7 11.5"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            fill="none"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>

                                    <span
                                        class="break-words text-sm leading-5 text-gray-600"
                                    >
                                        {{ point }}
                                    </span>
                                </div>
                            </div>

                            <!-- Learn More -->
                            <div class="mt-5 sm:mt-6">
                                <Link
                                    :href="program.url"
                                    class="inline-flex min-h-10 items-center gap-2 text-sm font-semibold transition-all duration-300 hover:gap-3"
                                    :class="program.linkColor"
                                >
                                    Learn More

                                    <svg
                                        class="h-4 w-4 shrink-0"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3"
                                        />
                                    </svg>
                                </Link>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Bottom CTA -->
            <div
                class="mt-6 flex flex-col items-center gap-5 rounded-2xl bg-orange-50 p-5 sm:mt-8 sm:rounded-3xl sm:p-6 md:p-8 lg:flex-row lg:justify-between lg:gap-8"
            >
                <div
                    class="flex w-full flex-col items-center gap-4 text-center sm:flex-row sm:text-left lg:flex-1"
                >
                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-orange-100 sm:h-14 sm:w-14"
                    >
                        <svg
                            class="h-6 w-6 text-orange-500"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 17.75l-6.16 3.24 1.18-6.88L2 9.24l6.92-1L12 2l3.08 6.24 6.92 1-5.02 4.87 1.18 6.88z"
                            />
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p
                            class="text-base font-bold text-gray-900 sm:text-lg"
                        >
                            A Journey of Growth and Success
                        </p>

                        <p
                            class="mt-1 text-sm leading-6 text-gray-500 sm:text-base"
                        >
                            From early childhood to future leaders, we are
                            with our students every step of the way.
                        </p>
                    </div>
                </div>

                <Link
                    href="/about"
                    class="inline-flex min-h-12 w-full shrink-0 items-center justify-center gap-2 rounded-full bg-orange-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-orange-600 sm:w-auto sm:text-base"
                >
                    Why Choose Us

                    <svg
                        class="h-4 w-4 shrink-0"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"
                        />
                    </svg>
                </Link>
            </div>
        </div>
    </section>
</template>
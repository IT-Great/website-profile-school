<script setup>
import { Link } from '@inertiajs/vue3'

const curriculums = [
    {
        label: 'Preschool Curriculum',
        title: 'Learning Through Play',
        description: 'Our Preschool curriculum is designed for children aged 2-4 years, focusing on holistic development through play-based learning. We nurture curiosity, creativity, independence, and social skills in a safe and joyful environment.',
        points: [
            'Play-based & inquiry learning',
            'Social & emotional development',
            'Language & communication',
            'Motor skills & creativity',
        ],
        image: '/storage/images/preschool.jpg',
        imagePosition: 'left',
        bg: 'bg-white',
        iconBg: 'bg-orange-100',
        iconColor: 'text-orange-500',
        labelColor: 'text-orange-500',
        underline: 'bg-orange-500',
        checkColor: 'text-orange-500',
    },
    {
        label: 'Primary Curriculum',
        title: 'Building Strong Foundations',
        description: 'Our Primary curriculum (Ages 5-11) follows the Cambridge Primary Framework, combining a strong academic program with character education. Students are encouraged to think critically, communicate effectively, and develop a love for learning.',
        points: [
            'Cambridge Primary Curriculum',
            'Critical Thinking & Problem Solving',
            'STEM & Digital Literacy',
            'Character & Values Education',
        ],
        image: '/storage/images/primarycurriculum.jpeg',
        imagePosition: 'right',
        bg: 'bg-green-50/60',
        iconBg: 'bg-green-100',
        iconColor: 'text-green-600',
        labelColor: 'text-green-600',
        underline: 'bg-green-600',
        checkColor: 'text-green-600',
    },
    {
        label: 'Secondary Curriculum',
        title: 'Preparing for the Future',
        description: 'Our Secondary curriculum (Ages 12-18) follows the Cambridge Lower Secondary and IGCSE framework, preparing students for higher education and global opportunities. We focus on academic rigor, leadership, and real-world application.',
        points: [
            'Cambridge Lower Secondary & IGCSE',
            'Leadership & Global Citizenship',
            'Advanced Academic Subjects',
            'University & Career Preparation',
        ],
        image: '/storage/images/secondary.jpg',
        imagePosition: 'left',
        bg: 'bg-white',
        iconBg: 'bg-indigo-100',
        iconColor: 'text-indigo-500',
        labelColor: 'text-indigo-500',
        underline: 'bg-indigo-500',
        checkColor: 'text-indigo-500',
    },
]
</script>

<template>
    <section class="bg-white py-10 sm:py-12 lg:py-16">
        <div
            class="mx-auto w-full max-w-[1600px]
                   px-4 sm:px-6 md:px-8
                   lg:px-12 xl:px-16 2xl:px-20"
        >
            <!-- Heading -->
            <div
                class="mx-auto mb-8 max-w-3xl text-center
                       sm:mb-10 lg:mb-14"
            >
                <span
                    class="text-xs font-semibold uppercase tracking-[2px]
                           text-orange-500 sm:text-sm sm:tracking-[3px]"
                >
                    Our Commitment
                </span>

                <h2
                    class="mt-3 text-2xl font-bold leading-tight text-gray-900
                           sm:text-3xl lg:text-4xl"
                >
                    Curriculum That Nurtures Every Potential
                </h2>

                <p
                    class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-gray-500
                           sm:text-base sm:leading-8"
                >
                    At Great Crystal School, we provide internationally
                    recognized curricula that are developmentally appropriate
                    for each stage of learning. We focus on academic excellence,
                    character development, and future-ready skills.
                </p>
            </div>

            <!-- Curriculum Blocks -->
            <div class="flex flex-col gap-5 sm:gap-7 lg:gap-8">
                <article
                    v-for="item in curriculums"
                    :key="item.title"
                    class="min-w-0 rounded-2xl p-4
                           sm:rounded-3xl sm:p-6
                           lg:p-8 xl:p-10"
                    :class="item.bg"
                >
                    <div
                        class="grid grid-cols-1 items-center gap-6
                               md:gap-8
                               lg:grid-cols-2 lg:gap-10
                               xl:gap-14"
                    >
                        <!-- Image -->
                        <div
                            class="min-w-0 overflow-hidden rounded-xl
                                   sm:rounded-2xl"
                            :class="
                                item.imagePosition === 'right'
                                    ? 'lg:order-2'
                                    : 'lg:order-1'
                            "
                        >
                            <img
                                :src="item.image"
                                :alt="item.label"
                                loading="lazy"
                                class="aspect-[4/3] w-full object-cover
                                       transition duration-500
                                       hover:scale-[1.03]"
                            />
                        </div>

                        <!-- Content -->
                        <div
                            class="min-w-0"
                            :class="
                                item.imagePosition === 'right'
                                    ? 'lg:order-1'
                                    : 'lg:order-2'
                            "
                        >
                            <!-- Label and Icon -->
                            <div class="mb-4 flex items-center gap-3 sm:gap-4">
                                <div
                                    class="flex h-11 w-11 shrink-0 items-center
                                           justify-center rounded-full
                                           sm:h-14 sm:w-14"
                                    :class="item.iconBg"
                                >
                                    <svg
                                        class="h-5 w-5 sm:h-6 sm:w-6"
                                        :class="item.iconColor"
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
                                    <span
                                        class="text-[10px] font-semibold
                                               uppercase tracking-[1.5px]
                                               sm:text-xs sm:tracking-[2px]"
                                        :class="item.labelColor"
                                    >
                                        {{ item.label }}
                                    </span>

                                    <div
                                        class="mt-1 h-0.5 w-8"
                                        :class="item.underline"
                                    ></div>
                                </div>
                            </div>

                            <!-- Title -->
                            <h3
                                class="text-xl font-bold leading-snug
                                       text-gray-900
                                       sm:text-2xl
                                       xl:text-3xl"
                            >
                                {{ item.title }}
                            </h3>

                            <!-- Description -->
                            <p
                                class="mt-3 text-sm leading-7 text-gray-500
                                       sm:text-base sm:leading-8"
                            >
                                {{ item.description }}
                            </p>

                            <!-- Checklist -->
                            <div
                                class="mt-5 grid grid-cols-1 gap-x-4 gap-y-3
                                       sm:grid-cols-2 sm:gap-y-4"
                            >
                                <div
                                    v-for="point in item.points"
                                    :key="point"
                                    class="flex min-w-0 items-start gap-2"
                                >
                                    <svg
                                        class="mt-0.5 h-4 w-4 shrink-0"
                                        :class="item.checkColor"
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
                                        class="min-w-0 text-sm leading-6
                                               text-gray-600"
                                    >
                                        {{ point }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Bottom CTA -->
            <div
                class="mt-6 flex flex-col items-center gap-5
                       rounded-2xl bg-orange-50 p-5 text-center
                       sm:mt-8 sm:rounded-3xl sm:p-7
                       lg:flex-row lg:justify-between
                       lg:gap-8 lg:p-8 lg:text-left
                       xl:p-10"
            >
                <div
                    class="flex min-w-0 flex-col items-center gap-3
                           sm:flex-row sm:gap-4
                           lg:flex-1 lg:items-center"
                >
                    <div
                        class="flex h-12 w-12 shrink-0 items-center
                               justify-center rounded-full bg-orange-100
                               sm:h-14 sm:w-14"
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
                                d="M22 10L12 5 2 10l10 5 10-5z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 12v5c0 1.5 3 3 6 3s6-1.5 6-3v-5"
                            />
                        </svg>
                    </div>

                    <p
                        class="text-sm font-semibold leading-6 text-gray-900
                               sm:text-base sm:leading-7
                               lg:text-lg"
                    >
                        A curriculum that inspires today, prepares for
                        tomorrow, and empowers for life.
                    </p>
                </div>

                <Link
                    href="/contact"
                    class="inline-flex min-h-12 w-full shrink-0
                           items-center justify-center gap-2
                           rounded-full bg-orange-500 px-6 py-3
                           text-sm font-medium text-white
                           transition duration-300
                           hover:bg-orange-600
                           focus-visible:outline-none
                           focus-visible:ring-2
                           focus-visible:ring-orange-400
                           focus-visible:ring-offset-2
                           sm:w-auto sm:text-base"
                >
                    Get in Touch

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
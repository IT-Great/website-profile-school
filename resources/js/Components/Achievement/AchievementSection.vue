<script setup>
import {
    Trophy,
    Medal,
    Users,
    Star,
    Play,
} from 'lucide-vue-next'

const stats = [
    {
        icon: Trophy,
        number: '320+',
        label: 'Awards Won',
        sub: 'Academic & Non Academic',
    },
    {
        icon: Medal,
        number: '150+',
        label: 'Competitions',
        sub: 'Local, National & International',
    },
    {
        icon: Users,
        number: '98%',
        label: 'Students Participation',
        sub: 'Active in Various Events',
    },
    {
        icon: Star,
        number: '45+',
        label: 'Championships',
        sub: 'Team & Individual',
    },
]

const achievements = [
    { title: 'Silver Medal', description: 'Wushu Championship' },
    {
        title: 'Gold Medal',
        description: 'OSN (Mathematics) organized by Puspresnas',
    },
    {
        title: 'Gold Medal',
        description: 'OSN (English) organized by Puspresnas',
    },
    {
        title: '3rd Place',
        description: 'Student Science Competition 2025',
    },
    {
        title: 'Bronze Medal',
        description: 'CMLI Cup National Youth Championship 2025 (U-16)',
    },
    {
        title: 'Silver Medal',
        description: 'FOKSI English Olympiad Level 3 (Provincial Level)',
    },
    {
        title: 'Silver Medal',
        description: 'FOKSI Mathematics Olympiad Level 3 (Provincial Level)',
    },
    {
        title: 'Silver Medal',
        description: 'FOKSI Science Olympiad Level 3 (Provincial Level)',
    },
    {
        title: 'Silver Medal',
        description: 'IQAAE English Olympiad (Provincial Level)',
    },
    {
        title: 'Mandarin Proficiency Championship 2025',
        description: 'Level 1: Yayasan Achievement Award',
    },
    {
        title: '1st Place',
        description:
            'Ideagym (Fun Active Classes U11) in Mayor of Surabaya Cup East 2025',
    },
    {
        title: '3RD Place Winner',
        description: 'Fun Catic Jr. Under 13-E DMT',
    },
]
</script>

<template>
    <section class="overflow-hidden bg-white py-10 sm:py-14 lg:py-20">
        <div
            class="mx-auto w-full max-w-[1600px]
                   px-4 sm:px-6 md:px-8
                   lg:px-12 xl:px-16 2xl:px-20"
        >
            <!-- Student Achievements Heading -->
            <div class="mx-auto max-w-3xl text-center">
                <h2
                    class="text-2xl font-bold leading-tight text-gray-900
                           sm:text-3xl lg:text-4xl"
                >
                    Student Achievements
                </h2>

                <div
                    class="mx-auto mt-3 h-1 w-10 rounded-full bg-orange-500"
                ></div>

                <p
                    class="mt-4 text-sm leading-6 text-gray-500
                           sm:mt-5 sm:text-base sm:leading-7"
                >
                    Student achievement measures the strength of academic
                    excellence and the skills gained through various
                    competitions, activities, and programs at Great Crystal
                    School.
                </p>
            </div>

            <!-- Achievements in 2025 -->
            <div
                class="mt-8 grid grid-cols-1 items-stretch gap-5
                       sm:mt-10 sm:gap-6
                       lg:mt-14 lg:grid-cols-[minmax(0,0.85fr)_minmax(0,1.5fr)]
                       xl:gap-8"
            >
                <!-- Trophy Card -->
                <div
                    class="relative flex min-h-[250px] flex-col
                           justify-center overflow-hidden rounded-2xl
                           bg-orange-500 p-6
                           sm:min-h-[280px] sm:p-8
                           lg:min-h-[360px] lg:p-8
                           xl:p-10"
                >
                    <img
                        src="https://images.unsplash.com/photo-1567427017947-545c5f8d16ad?q=80&w=800"
                        alt="Trophy representing student achievements"
                        loading="lazy"
                        class="absolute inset-0 h-full w-full
                               object-cover opacity-40"
                    />

                    <div class="absolute inset-0 bg-orange-600/20"></div>

                    <div class="relative z-10">
                        <span
                            class="text-xs font-semibold uppercase
                                   tracking-[2px] text-orange-100"
                        >
                            School Achievements
                        </span>

                        <h3
                            class="mt-2 text-2xl font-bold leading-tight
                                   text-white sm:text-3xl"
                        >
                            Achievements in 2025
                        </h3>

                        <p
                            class="mt-4 max-w-sm text-sm leading-6
                                   text-orange-50 sm:text-base sm:leading-7"
                        >
                            Great Crystal School continues to achieve
                            excellence through dedication, innovation,
                            and a commitment to quality education.
                        </p>
                    </div>
                </div>

                <!-- Achievement List -->
                <div
                    class="min-w-0 rounded-2xl border border-gray-100
                           bg-white p-4 shadow-lg
                           sm:p-6 lg:p-7 xl:p-8"
                >
                    <div class="relative flex flex-col gap-4 pl-1 sm:gap-5">
                        <!-- Timeline line -->
                        <div
                            class="absolute bottom-2 left-[9px] top-2
                                   border-l border-dashed border-gray-200"
                            aria-hidden="true"
                        ></div>

                        <div
                            v-for="item in achievements"
                            :key="item.title + item.description"
                            class="relative flex min-w-0 items-start gap-3"
                        >
                            <div
                                class="z-10 mt-0.5 flex h-5 w-5 shrink-0
                                       items-center justify-center
                                       rounded-full bg-orange-500"
                            >
                                <svg
                                    class="h-3 w-3 text-white"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="3"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M20 6L9 17l-5-5"
                                    />
                                </svg>
                            </div>

                            <p
                                class="min-w-0 flex-1 break-words
                                       text-sm leading-6 text-gray-600"
                            >
                                <span class="font-semibold text-gray-900">
                                    {{ item.title }}
                                </span>
                                <span> – {{ item.description }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alumni Achievements Heading -->
            <div
                class="mx-auto mt-14 max-w-3xl text-center
                       sm:mt-16 lg:mt-20"
            >
                <h2
                    class="text-2xl font-bold leading-tight text-gray-900
                           sm:text-3xl lg:text-4xl"
                >
                    Alumni Achievements
                </h2>

                <div
                    class="mx-auto mt-3 h-1 w-10 rounded-full bg-orange-500"
                ></div>

                <p
                    class="mt-4 text-sm leading-6 text-gray-500
                           sm:mt-5 sm:text-base sm:leading-7"
                >
                    Our alumni continue to make their mark in various fields
                    and inspire the next generation of Great Crystal students.
                </p>
            </div>

            <!-- Alumni Video Banner -->
            <div
                class="group relative mt-8 flex flex-col overflow-hidden
                       rounded-2xl sm:mt-10 sm:rounded-3xl
                       lg:min-h-[300px] lg:flex-row lg:items-stretch"
                style="background: linear-gradient(135deg, #fbbf24, #f97316);"
            >
                <!-- Decorative Clouds -->
                <svg
                    class="pointer-events-none absolute left-4 top-5
                           h-7 w-14 text-white/30
                           sm:left-8 sm:top-7 sm:h-8 sm:w-16"
                    viewBox="0 0 100 50"
                    fill="currentColor"
                    aria-hidden="true"
                >
                    <ellipse cx="25" cy="30" rx="22" ry="16" />
                    <ellipse cx="55" cy="25" rx="28" ry="20" />
                    <ellipse cx="80" cy="32" rx="18" ry="13" />
                </svg>

                <svg
                    class="pointer-events-none absolute bottom-16
                           left-1/3 hidden h-10 w-20 text-white/25
                           sm:block"
                    viewBox="0 0 100 50"
                    fill="currentColor"
                    aria-hidden="true"
                >
                    <ellipse cx="25" cy="30" rx="22" ry="16" />
                    <ellipse cx="55" cy="25" rx="28" ry="20" />
                    <ellipse cx="80" cy="32" rx="18" ry="13" />
                </svg>

                <svg
                    class="pointer-events-none absolute right-4 top-8
                           h-7 w-14 text-white/20
                           sm:right-8 sm:top-10 sm:h-8 sm:w-16"
                    viewBox="0 0 100 50"
                    fill="currentColor"
                    aria-hidden="true"
                >
                    <ellipse cx="25" cy="30" rx="22" ry="16" />
                    <ellipse cx="55" cy="25" rx="28" ry="20" />
                    <ellipse cx="80" cy="32" rx="18" ry="13" />
                </svg>

                <!-- Text Side -->
                <div
                    class="relative z-10 flex min-w-0 flex-1
                           flex-col items-start justify-center
                           px-5 py-8
                           sm:px-8 sm:py-10
                           lg:px-10 lg:py-12
                           xl:px-14"
                >
                    <p
                        class="text-xs font-medium tracking-wide
                               text-white/90 sm:text-sm"
                    >
                        Great Crystal School &amp; Course Center
                    </p>

                    <h3
                        class="mt-2 text-3xl font-extrabold leading-tight
                               text-red-600
                               sm:text-4xl lg:text-5xl"
                        style="-webkit-text-stroke: 1px white; paint-order: stroke fill;"
                    >
                        Great Alumni Talks
                    </h3>

                    <button
                        type="button"
                        class="mt-5 inline-flex min-h-11
                               items-center justify-center gap-2
                               rounded-full bg-white px-5 py-3
                               text-sm font-semibold text-orange-600
                               transition duration-300
                               hover:bg-orange-50
                               focus-visible:outline-none
                               focus-visible:ring-2
                               focus-visible:ring-white
                               focus-visible:ring-offset-2
                               focus-visible:ring-offset-orange-500
                               sm:mt-6"
                    >
                        <span>Watch Now</span>
                        <Play
                            class="h-4 w-4"
                            fill="currentColor"
                            aria-hidden="true"
                        />
                    </button>
                </div>

                <!-- Photo Side -->
                <div
                    class="relative mx-3 mb-3 h-48 shrink-0
                           overflow-hidden rounded-xl
                           sm:mx-5 sm:mb-5 sm:h-64
                           lg:my-4 lg:ml-0 lg:mr-4 lg:h-auto
                           lg:w-[38%] lg:min-w-[260px]
                           xl:w-[35%] xl:min-w-[320px]"
                >
                    <img
                        src="https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=800"
                        alt="Alumni speaker"
                        loading="lazy"
                        class="h-full w-full object-cover"
                    />

                    <div
                        class="absolute inset-0 flex items-center
                               justify-center bg-black/10"
                    >
                        <div
                            class="flex h-14 w-14 items-center
                                   justify-center rounded-full
                                   bg-white/90 shadow-lg
                                   transition duration-300
                                   group-hover:scale-110
                                   sm:h-16 sm:w-16"
                        >
                            <Play
                                class="ml-1 h-6 w-6 text-orange-500
                                       sm:h-7 sm:w-7"
                                fill="currentColor"
                                aria-hidden="true"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
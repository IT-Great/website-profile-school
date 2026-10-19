<script setup>
import { Link } from '@inertiajs/vue3'
import {
    PlayCircle,
    UserRound,
    Building2,
    Award,
    GraduationCap,
    Users,
    Globe,
    Heart,
} from 'lucide-vue-next'

const milestones = [
    {
        year: '2004',
        title: 'Start History',
        description:
            'Great Crystal School was established with a vision to provide quality education and character building for children in Surabaya.',
        icon: PlayCircle,
        image: 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=800',
        side: 'image-left',
    },
    {
        year: '2005',
        title: 'Established in 2005 by Surabaya Mayor',
        description:
            'On March 5, 2005, Mr. Bambang D.H, the Mayor of Surabaya, officially cut the ribbon to inaugurate Great Crystal School.',
        icon: UserRound,
        image: 'https://images.unsplash.com/photo-1531482615713-2afd69097998?q=80&w=800',
        side: 'card-left',
    },
    {
        year: '2010',
        title: 'Become Cambridge School in 2010 with ID 076',
        description:
            'We reached a new milestone by becoming an official Cambridge School, bringing international standards to our students.',
        icon: Building2,
        image: 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=800',
        side: 'image-left',
    },
    {
        year: '2016',
        title: 'Become SPK School in 2016',
        description:
            'Great Crystal School was recognized as an SPK (Satuan Pendidikan Kerjasama) School by the government.',
        icon: Award,
        image: 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=800',
        side: 'card-left',
    },
]

const features = [
    {
        icon: GraduationCap,
        title: 'Strong Foundation',
        description: 'Built on trust and commitment since 2004',
    },
    {
        icon: Users,
        title: 'Academic Excellence',
        description: 'Continuously improving quality and achievement',
    },
    {
        icon: Globe,
        title: 'Global Perspective',
        description: 'International curriculum and global mindset',
    },
    {
        icon: Heart,
        title: 'Bright Future',
        description: 'Preparing generations for a better tomorrow',
    },
]
</script>

<template>
    <section class="overflow-hidden bg-white py-12 sm:py-16 lg:py-24">
        <div
            class="mx-auto w-full max-w-[1600px]
                   px-4 sm:px-6 md:px-8
                   lg:px-12 xl:px-16 2xl:px-20"
        >
            <!-- Our Story -->
            <div
                class="grid grid-cols-1 items-center
                       gap-8 sm:gap-10
                       lg:grid-cols-2 lg:gap-10
                       xl:gap-16"
            >
                <!-- Story Content -->
                <div class="min-w-0 py-2">
                    <span
                        class="text-xs font-semibold uppercase
                               tracking-[2px] text-orange-500
                               sm:text-sm sm:tracking-[3px]"
                    >
                        Our Story
                    </span>

                    <h2
                        class="mt-3 text-2xl font-bold
                               leading-tight text-gray-900
                               sm:text-3xl
                               lg:text-3xl
                               xl:text-4xl"
                    >
                        The Journey of Great Crystal School
                    </h2>

                    <p
                        class="mt-4 text-sm leading-6 text-gray-500
                               sm:mt-5 sm:text-base sm:leading-7"
                    >
                        Great Crystal School and Course Center was founded
                        in 2004 in an influential residential area in
                        Surabaya. The school aims to serve the community
                        by providing quality education and opportunities
                        for our students to achieve proficiency level in
                        English that will enable them to seek admission
                        to schools or universities.
                    </p>

                    <p
                        class="mt-4 text-sm leading-6 text-gray-500
                               sm:text-base sm:leading-7"
                    >
                        We were honored to have Mr. Bambang D.H, the Mayor
                        of Surabaya, officially "cut the ribbon" on
                        March 5, 2005. Recognized by and registered with
                        the Dinas Pendidikan Surabaya.
                    </p>

                    <Link
                        href="/about"
                        class="mt-6 inline-flex min-h-12 max-w-full
                               items-center justify-center gap-2
                               rounded-full border-2 border-orange-500
                               px-5 py-3 text-center
                               text-sm font-semibold text-orange-500
                               transition duration-300
                               hover:bg-orange-500 hover:text-white
                               focus-visible:outline-none
                               focus-visible:ring-2
                               focus-visible:ring-orange-400
                               focus-visible:ring-offset-2
                               sm:mt-8 sm:px-6 sm:text-base"
                    >
                        <span>Learn More About Us</span>

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

                <!-- Story Image -->
                <div
                    class="relative min-w-0 overflow-hidden
                           rounded-2xl sm:rounded-3xl"
                >
                    <img
                        src="/storage/images/field.png"
                        alt="Great Crystal School campus"
                        loading="lazy"
                        class="h-56 w-full object-cover
                               sm:h-72
                               md:h-80
                               lg:h-[400px]
                               xl:h-[460px]"
                    />
                </div>
            </div>

            <!-- Milestones Heading -->
            <div
                class="mx-auto mb-10 mt-16 max-w-3xl
                       text-center sm:mb-12 sm:mt-20
                       lg:mb-14 lg:mt-24"
            >
                <span
                    class="text-xs font-semibold uppercase
                           tracking-[2px] text-orange-500
                           sm:text-sm sm:tracking-[3px]"
                >
                    Our Milestones
                </span>

                <h2
                    class="mt-3 text-2xl font-bold
                           leading-tight text-gray-900
                           sm:text-3xl
                           lg:text-4xl"
                >
                    The History Process of Great Crystal School
                </h2>
            </div>

            <!-- Timeline -->
            <div class="relative">
                <!-- Center Line: Tablet/Desktop -->
                <div
                    class="absolute bottom-0 left-1/2 top-0
                           hidden w-px -translate-x-1/2
                           bg-gray-200 md:block"
                    aria-hidden="true"
                ></div>

                <div class="flex flex-col gap-8 sm:gap-10 lg:gap-12">
                    <div
                        v-for="(milestone, index) in milestones"
                        :key="milestone.year"
                        class="relative grid min-w-0 grid-cols-1
                               items-center gap-4
                               md:grid-cols-2 md:gap-8
                               lg:gap-10"
                    >
                        <!-- Number Marker -->
                        <div
                            class="absolute left-1/2 top-1/2 z-10
                                   hidden h-10 w-10
                                   -translate-x-1/2 -translate-y-1/2
                                   items-center justify-center
                                   rounded-full border-4 border-white
                                   bg-orange-500 text-sm font-bold
                                   text-white shadow-sm
                                   md:flex"
                        >
                            {{ index + 1 }}
                        </div>

                        <!-- Image -->
                        <div
                            class="h-48 min-w-0 overflow-hidden
                                   rounded-2xl sm:h-56
                                   md:h-56
                                   lg:h-64
                                   xl:h-72"
                            :class="
                                milestone.side === 'image-left'
                                    ? 'md:order-1'
                                    : 'md:order-2'
                            "
                        >
                            <img
                                :src="milestone.image"
                                :alt="milestone.title"
                                loading="lazy"
                                class="h-full w-full object-cover
                                       transition duration-500
                                       hover:scale-105"
                            />
                        </div>

                        <!-- Milestone Card -->
                        <div
                            class="flex min-w-0 items-start gap-3
                                   rounded-2xl border border-gray-100
                                   bg-white p-4
                                   transition duration-300
                                   hover:shadow-md
                                   sm:gap-4 sm:p-6
                                   lg:p-7"
                            :class="
                                milestone.side === 'image-left'
                                    ? 'md:order-2'
                                    : 'md:order-1'
                            "
                        >
                            <!-- Icon -->
                            <div
                                class="flex h-10 w-10 shrink-0
                                       items-center justify-center
                                       rounded-xl bg-orange-100
                                       sm:h-12 sm:w-12"
                            >
                                <component
                                    :is="milestone.icon"
                                    class="h-5 w-5 text-orange-500
                                           sm:h-6 sm:w-6"
                                    aria-hidden="true"
                                />
                            </div>

                            <!-- Text -->
                            <div class="min-w-0 flex-1">
                                <span
                                    class="text-sm font-semibold
                                           text-orange-500"
                                >
                                    {{ milestone.year }}
                                </span>

                                <h3
                                    class="mt-1 text-base font-bold
                                           leading-snug text-gray-900
                                           sm:text-lg"
                                >
                                    {{ milestone.title }}
                                </h3>

                                <p
                                    class="mt-2 text-sm leading-6
                                           text-gray-500"
                                >
                                    {{ milestone.description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Strip -->
            <div
                class="mt-12 rounded-2xl bg-orange-50
                       px-4 py-6
                       sm:mt-16 sm:rounded-3xl sm:px-6 sm:py-8
                       lg:mt-20 lg:px-8"
            >
                <div
                    class="grid grid-cols-1 gap-6
                           min-[420px]:grid-cols-2
                           lg:grid-cols-4 lg:gap-6
                           xl:gap-8"
                >
                    <div
                        v-for="feature in features"
                        :key="feature.title"
                        class="flex min-w-0 items-start gap-3"
                    >
                        <!-- Icon -->
                        <div
                            class="flex h-10 w-10 shrink-0
                                   items-center justify-center
                                   rounded-full bg-white
                                   sm:h-11 sm:w-11"
                        >
                            <component
                                :is="feature.icon"
                                class="h-5 w-5 text-orange-500"
                                aria-hidden="true"
                            />
                        </div>

                        <!-- Feature Text -->
                        <div class="min-w-0">
                            <p
                                class="text-sm font-semibold
                                       leading-5 text-gray-900
                                       sm:text-base"
                            >
                                {{ feature.title }}
                            </p>

                            <p
                                class="mt-1 text-xs leading-5
                                       text-gray-500 sm:text-sm"
                            >
                                {{ feature.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
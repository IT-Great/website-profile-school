<script setup>
import {
    LayoutGrid,
    FlaskConical,
    BookOpen,
    Monitor,
    Trophy,
    Music,
    Gamepad2,
    UtensilsCrossed,
} from 'lucide-vue-next'

const facilities = [
    {
        image: 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=800',
        icon: LayoutGrid,
        title: 'Smart Classrooms',
        description: 'Modern classrooms equipped with interactive boards and smart technology for engaging learning.',
    },
    {
        image: 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?q=80&w=800',
        icon: FlaskConical,
        title: 'Science Laboratory',
        description: 'Well-equipped labs for experiments and hands-on learning in a safe environment.',
    },
    {
        image: 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=800',
        icon: BookOpen,
        title: 'Library',
        description: 'A spacious library with a rich collection of books and digital resources to inspire young minds.',
    },
    {
        image: 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=800',
        icon: Monitor,
        title: 'Computer Lab',
        description: 'Up-to-date computers and software to build digital skills and creativity.',
    },
    {
        image: 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800',
        icon: Trophy,
        title: 'Sports Facilities',
        description: 'Indoor and outdoor sports areas to encourage fitness, teamwork, and healthy living.',
    },
    {
        image: 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?q=80&w=800',
        icon: Music,
        title: 'Art & Music Room',
        description: 'Creative spaces for students to explore art, music, and express their talents.',
    },
    {
        image: 'https://images.unsplash.com/photo-1594959416491-c6a1e0cc2b0b?q=80&w=800',
        icon: Gamepad2,
        title: 'Playground',
        description: 'Safe and fun playgrounds designed for play, movement, and social development.',
    },
    {
        image: 'https://images.unsplash.com/photo-1544148103-0773bf10d330?q=80&w=800',
        icon: UtensilsCrossed,
        title: 'Canteen',
        description: 'A clean and nutritious dining area offering healthy meals and snacks for students.',
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
            <div class="mx-auto mb-8 max-w-3xl text-center sm:mb-10 lg:mb-12">
                <span
                    class="text-xs font-semibold uppercase tracking-[2px]
                           text-orange-500 sm:text-sm sm:tracking-[3px]"
                >
                    Our Facilities
                </span>

                <h2
                    class="mt-3 text-2xl font-bold leading-tight text-gray-900
                           sm:text-3xl lg:text-4xl"
                >
                    Explore Our Facilities
                </h2>
            </div>

            <!-- Facilities Grid -->
            <div
                class="grid grid-cols-1 gap-4
                       min-[420px]:grid-cols-2
                       sm:gap-5
                       md:grid-cols-3 md:gap-6
                       lg:grid-cols-4
                       xl:gap-7"
            >
                <article
                    v-for="facility in facilities"
                    :key="facility.title"
                    class="group flex min-w-0 flex-col overflow-hidden
                           rounded-2xl border border-gray-100 bg-white
                           transition duration-300
                           hover:-translate-y-1 hover:shadow-lg"
                >
                    <!-- Image -->
                    <div
                        class="relative h-40 overflow-hidden
                               min-[420px]:h-32
                               sm:h-40
                               lg:h-44
                               xl:h-48"
                    >
                        <img
                            :src="facility.image"
                            :alt="facility.title"
                            loading="lazy"
                            class="h-full w-full object-cover
                                   transition duration-500
                                   group-hover:scale-105"
                        />
                    </div>

                    <!-- Content -->
                    <div class="flex flex-1 flex-col p-4 sm:p-5">
                        <!-- Icon and Title -->
                        <div class="flex items-start gap-2.5">
                            <div
                                class="flex h-8 w-8 shrink-0 items-center
                                       justify-center rounded-lg bg-orange-100"
                            >
                                <component
                                    :is="facility.icon"
                                    class="h-4 w-4 text-orange-500"
                                    aria-hidden="true"
                                />
                            </div>

                            <h3
                                class="min-w-0 pt-1 text-sm font-bold
                                       leading-5 text-gray-900
                                       sm:text-base sm:leading-6"
                            >
                                {{ facility.title }}
                            </h3>
                        </div>

                        <!-- Description -->
                        <p
                            class="mt-3 text-xs leading-5 text-gray-500
                                   sm:text-sm sm:leading-6"
                        >
                            {{ facility.description }}
                        </p>
                    </div>
                </article>
            </div>

            <!-- Button -->
            <div class="mt-8 text-center sm:mt-10 lg:mt-12">
                <a
                    href="/facilities"
                    class="inline-flex min-h-12 max-w-full items-center
                           justify-center gap-2 rounded-full
                           border border-orange-300 px-5 py-3
                           text-center text-sm font-medium text-orange-500
                           transition duration-300
                           hover:border-orange-500 hover:bg-orange-500
                           hover:text-white
                           focus-visible:outline-none
                           focus-visible:ring-2
                           focus-visible:ring-orange-400
                           focus-visible:ring-offset-2
                           sm:px-6 sm:text-base"
                >
                    <span>See More Facilities</span>

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
                </a>
            </div>
        </div>
    </section>
</template>
```vue
<script setup>
import { Link } from '@inertiajs/vue3'
import {
    CalendarDays,
    ArrowRight,
    Tag,
} from 'lucide-vue-next'

const posts = [
    {
        id: 1,
        type: 'News',
        title: 'Students Win National Robotics Competition',
        description:
            'Our students demonstrate creativity, innovation, and teamwork in a prestigious robotics competition.',
        date: '15 July 2026',
        image: 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=1200',
        url: '/news/detail',
    },
    {
        id: 2,
        type: 'Event',
        title: 'Open House 2026 Registration Now Open',
        description:
            'Discover our learning environment, meet our educators, and explore exciting opportunities for your child.',
        date: '10 August 2026',
        image: 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=1200',
        url: '/news/detail',
    },
    {
        id: 3,
        type: 'News',
        title: 'Inspiring Young Minds Through Creative Learning',
        description:
            'Explore how our students learn, collaborate, and develop essential skills through engaging activities.',
        date: '20 August 2026',
        image: 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=1200',
        url: '/news/detail',
    },
]
</script>

<template>
    <section
        class="bg-white py-12 sm:py-14 md:py-16 lg:py-20"
    >
        <div
            class="mx-auto w-full max-w-[1600px] px-5 sm:px-8 md:px-10 lg:px-12 xl:px-16 2xl:px-20"
        >
            <!-- Heading -->
            <div
                class="mb-8 flex flex-col items-start justify-between gap-5 sm:mb-10 sm:flex-row sm:items-end md:mb-12"
            >
                <div>
                    <span
                        class="text-xs font-semibold uppercase tracking-[2px] text-orange-500 sm:text-sm sm:tracking-[3px]"
                    >
                        Latest News & Events
                    </span>

                    <h2
                        class="mt-3 text-2xl font-bold leading-tight text-gray-900 sm:text-3xl md:text-4xl lg:text-5xl"
                    >
                        Stay Updated
                    </h2>

                    <p
                        class="mt-3 max-w-xl text-sm leading-6 text-gray-500 sm:text-base sm:leading-7"
                    >
                        Discover the latest stories, school activities,
                        and exciting achievements from our community.
                    </p>
                </div>

                <!-- View All Button -->
                <Link
                    href="/news"
                    class="inline-flex min-h-11 w-full shrink-0 items-center justify-center gap-2 rounded-full border border-orange-300 px-5 py-3 text-sm font-semibold text-orange-500 transition duration-300 hover:border-orange-500 hover:bg-orange-500 hover:text-white sm:w-auto sm:px-6"
                >
                    View All News

                    <ArrowRight class="h-4 w-4" />
                </Link>
            </div>

            <!-- News Cards -->
            <div
                class="grid grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3 lg:gap-7 xl:gap-8"
            >
                <article
                    v-for="post in posts"
                    :key="post.id"
                    class="group flex min-w-0 flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white transition duration-300 hover:-translate-y-1 hover:shadow-xl"
                >
                    <!-- Image -->
                    <Link
                        :href="post.url"
                        class="relative block aspect-[16/10] overflow-hidden bg-gray-100"
                    >
                        <img
                            :src="post.image"
                            :alt="post.title"
                            loading="lazy"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                        />

                        <!-- Category Badge -->
                        <span
                            class="absolute left-4 top-4 rounded-full bg-white/95 px-3 py-1.5 text-xs font-semibold text-orange-500 shadow-sm backdrop-blur"
                        >
                            {{ post.type }}
                        </span>
                    </Link>

                    <!-- Content -->
                    <div
                        class="flex flex-1 flex-col p-5 sm:p-5 md:p-6"
                    >
                        <!-- Metadata -->
                        <div
                            class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-gray-500 sm:text-sm"
                        >
                            <span class="inline-flex items-center gap-1.5">
                                <CalendarDays
                                    class="h-4 w-4 shrink-0 text-orange-500"
                                />
                                {{ post.date }}
                            </span>

                            <span class="inline-flex items-center gap-1.5">
                                <Tag
                                    class="h-4 w-4 shrink-0 text-orange-500"
                                />
                                {{ post.type }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h3
                            class="mt-4 text-base font-bold leading-snug text-gray-900 transition-colors duration-300 group-hover:text-orange-500 sm:text-lg"
                        >
                            <Link :href="post.url">
                                {{ post.title }}
                            </Link>
                        </h3>

                        <!-- Description -->
                        <p
                            v-if="post.description"
                            class="mt-3 line-clamp-3 text-sm leading-6 text-gray-500"
                        >
                            {{ post.description }}
                        </p>

                        <!-- Read More -->
                        <div class="mt-auto pt-5">
                            <Link
                                :href="post.url"
                                class="inline-flex items-center gap-2 text-sm font-semibold text-orange-500 transition-all duration-300 hover:gap-3"
                            >
                                Read More

                                <ArrowRight class="h-4 w-4" />
                            </Link>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>
```

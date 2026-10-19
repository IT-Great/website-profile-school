<script setup>
import { Link } from '@inertiajs/vue3'
import {
    Baby,
    Backpack,
    BookOpen,
    GraduationCap,
    Globe,
    ArrowRight,
} from 'lucide-vue-next'

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
    //{
      //  title: 'Junior College',
        //subtitle: '15 - 18 Years Old',
        //description: 'Preparing students for university and beyond.',
        //url: '/programs/junior-college',
        //bg: 'bg-indigo-100',
        //color: 'text-indigo-500',
        //icon: 'M12 4L2 9l10 5 8-4v6M6 11v5c0 1.5 2.7 3 6 3s6-1.5 6-3v-5',
    //},
]
</script>

<template>

<section class="py-12 bg-gray-100">

    <div class="mx-0 lg:mx-24 px-6">

        <div class="text-center mb-7">

            <span
                class="uppercase tracking-[3px] text-orange-500 font-semibold text-sm">

                Our Programs

            </span>

            <h2 class="text-3xl lg:text-4xl font-bold mt-3 text-gray-900">

                Programs for Every Stage of Growth

            </h2>

        </div>

        <div class="grid sm:grid-cols-3 lg:grid-cols-3 gap-2">

            <div
                v-for="program in programs"
                :key="program.title"
                class="rounded-2xl border border-gray-100 bg-white px-4 py-6 text-center hover:shadow-lg transition duration-300">

                <div
                    class="w-16 h-16 mx-auto rounded-full flex items-center justify-center"
                    :class="program.bg">

                    <svg
                        class="w-7 h-7"
                        :class="program.color"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            :d="program.icon" />

                    </svg>

                </div>

                <h3 class="text-lg font-bold mt-3 text-gray-900">

                    {{ program.title }}

                </h3>

                <p class="text-gray-500 text-sm mt-2">

                    {{ program.subtitle }}

                </p>

                <p class="text-gray-500 text-sm leading-6 mt-3">

                    {{ program.description }}

                </p>

                <Link
                    :href="program.url"
                    class="inline-flex items-center gap-1.5 mt-3 text-sm font-semibold text-orange-500 hover:gap-2.5 transition-all">

                    Learn More

                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>

                </Link>

            </div>

        </div>

    </div>

</section>
</template>
<script setup>
import { Link } from '@inertiajs/vue3'

const features = [
    'Quality Education',
    'Experienced Teachers',
    'Modern Facilities',
    'Character Building',
]
</script>

<template>

<section class="py-24 bg-white px-6 lg:px-32">

    <div class="mx-auto">

        <div class="grid lg:grid-cols-2 gap-12 items-center">

            <!-- Image -->

            <div>

                <img
                    src="/storage/images/program.png"
                    class="rounded-2xl shadow-md w-full object-cover aspect-[4/3]"
                >

            </div>

            <!-- Content -->

            <div>

                <span
                    class="uppercase text-orange-500 font-bold text-sm">

                    About Us

                </span>

                <h2
                    class="text-3xl lg:text-4xl font-bold text-gray-900 mt-3">

                    About Great Crystal School

                </h2>

                <p
                    class="text-gray-500 mt-2 leading-7 ">

                    We are committed to providing high-quality education
                    that empowers students academically, socially, and
                    emotionally. Our holistic approach ensures every
                    child reaches their full potential.

                </p>

                <!-- Feature -->

                <div class="flex flex-col gap-3 mt-3">

                    <div
                        v-for="item in features"
                        :key="item"
                        class="flex items-center gap-3">

                        <svg class="w-5 h-5 text-orange-500 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5" />
                        </svg>

                        <span class="text-gray-600">{{ item }}</span>

                    </div>

                </div>

                <Link
                    href="/about"
                    class="inline-flex items-center gap-6 mt-5 px-7 py-3 rounded-full border-2 border-orange-500 text-orange-500 font-medium hover:bg-orange-500 hover:text-white transition">

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
<script setup>
import {
    ShieldCheck,
    Building2,
    Leaf,
    Wifi,
} from 'lucide-vue-next'

const features = [
    {
        icon: ShieldCheck,
        title: 'Safe & <br> Secure',
        description: '24/7 security and child-friendly environment',
    },
    {
        icon: Building2,
        title: 'Modern & Complete',
        description: 'Facilities designed to support 21st-century learning',
    },
    {
        icon: Leaf,
        title: 'Green <br> Environment',
        description: 'Open spaces and green areas for a healthy school life',
    },
    {
        icon: Wifi,
        title: 'Smart <br> Technology',
        description: 'Integrated technology for interactive and effective learning',
    },
]
</script>

<template>
    <section class="overflow-hidden bg-orange-50/40 py-12 sm:py-14 md:py-16 lg:py-20">
        <div
            class="mx-auto w-full max-w-[1600px] px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-20"
        >
            <div
                class="grid grid-cols-1 items-center gap-8 sm:gap-10 lg:grid-cols-12 lg:gap-8 xl:gap-12"
            >
                <!-- Content -->
                <div class="text-center lg:col-span-5 lg:text-left">
                    <span
                        class="text-xs font-semibold uppercase tracking-[2px] text-orange-500 sm:text-sm sm:tracking-[3px]"
                    >
                        Learning Without Limits
                    </span>

                    <h2
                        class="mx-auto mt-3 max-w-xl text-2xl font-bold leading-tight text-gray-900 sm:text-3xl lg:mx-0 lg:text-4xl xl:text-5xl"
                    >
                        Spaces that Support Every Journey
                    </h2>

                    <p
                        class="mx-auto mt-4 max-w-xl text-sm leading-6 text-gray-500 sm:text-base sm:leading-7 lg:mx-0"
                    >
                        At Great Crystal School, every space is designed with
                        purpose. From modern classrooms to creative studios and
                        green open areas, our facilities encourage curiosity,
                        creativity, and collaboration.
                    </p>
                </div>

                <!-- Features -->
                <div
                    class="grid grid-cols-1 gap-x-5 gap-y-8 min-[400px]:grid-cols-2 sm:gap-x-8 sm:gap-y-10 lg:col-span-7 lg:grid-cols-2 xl:grid-cols-4 xl:gap-x-5"
                >
                    <div
                        v-for="feature in features"
                        :key="feature.title"
                        class="group flex flex-col items-center text-center"
                    >
                        <!-- Icon -->
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-orange-100 transition duration-300 group-hover:-translate-y-1 group-hover:bg-orange-200 sm:h-14 sm:w-14"
                        >
                            <component
                                :is="feature.icon"
                                class="h-6 w-6 text-orange-500 sm:h-7 sm:w-7"
                                :stroke-width="1.8"
                            />
                        </div>

                        <!-- Title -->
                        <h3
                            class="mt-3 text-sm font-semibold leading-snug text-gray-900 sm:mt-4 sm:text-base"
                            v-html="feature.title"
                        ></h3>

                        <!-- Description -->
                        <p
                            class="mt-2 max-w-[260px] text-xs leading-5 text-gray-500 sm:text-sm sm:leading-6"
                        >
                            {{ feature.description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
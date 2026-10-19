<script setup>
import { GraduationCap, Users, UserCircle, ShieldCheck, CheckCircle2 } from 'lucide-vue-next'

const stats = [
    { icon: GraduationCap, number: '2004', label: 'Established' },
    { icon: Users, number: '500+', label: 'Students' },
    { icon: UserCircle, number: '25+', label: 'Teachers' },
    { icon: ShieldCheck, number: '100%', label: 'Graduation Rate' },
]

const missionPoints = [
    'Internationally recognized curriculum',
    'Character building and values education',
    'Modern facilities and digital learning',
    'Experienced and caring teachers',
    'Safe, inclusive, and supportive environment',
]
</script>

<template>
    <!-- Section 1: Who We Are -->
    <section class="bg-white py-12 sm:py-16 lg:py-20">
        <div
            class="mx-auto w-full max-w-[1600px]
                   px-4 sm:px-6 md:px-8
                   lg:px-12 xl:px-16 2xl:px-20"
        >
            <div class="grid grid-cols-1 items-center gap-8 sm:gap-10 lg:grid-cols-2 lg:gap-12 xl:gap-16">

                <!-- Content -->
                <div class="min-w-0">
                    <span
                        class="text-xs font-bold uppercase tracking-[2px]
                               text-orange-500 sm:text-sm sm:tracking-[3px]"
                    >
                        Who We Are
                    </span>

                    <h2
                        class="mt-3 text-2xl font-bold leading-tight
                               text-gray-900 sm:text-3xl
                               lg:text-4xl xl:text-5xl"
                    >
                        Welcome to Great Crystal School &amp; Course Center
                    </h2>

                    <p
                        class="mt-4 text-sm leading-7 text-gray-500
                               sm:text-base sm:leading-8"
                    >
                        Great Crystal School and Course Center provides a
                        complete academic journey through internationally and
                        nationally recognized programs across Preschool,
                        Primary, and Secondary.
                    </p>

                    <p
                        class="mt-3 text-sm leading-7 text-gray-500
                               sm:text-base sm:leading-8"
                    >
                        We are committed to delivering high-quality education
                        that nurtures character, creativity, and critical
                        thinking in a safe and supportive environment.
                    </p>

                    <!-- Statistics -->
                    <div
                        class="mt-7 grid grid-cols-2 gap-x-3 gap-y-6
                               sm:mt-8 sm:grid-cols-4 sm:gap-4
                               lg:gap-3 xl:gap-5"
                    >
                        <div
                            v-for="stat in stats"
                            :key="stat.label"
                            class="flex min-w-0 flex-col items-center text-center"
                        >
                            <div
                                class="flex h-12 w-12 items-center
                                       justify-center rounded-full
                                       bg-orange-100 sm:h-14 sm:w-14"
                            >
                                <component
                                    :is="stat.icon"
                                    class="h-5 w-5 text-orange-500 sm:h-6 sm:w-6"
                                />
                            </div>

                            <p
                                class="mt-3 text-xl font-bold text-gray-900
                                       sm:text-2xl"
                            >
                                {{ stat.number }}
                            </p>

                            <p
                                class="mt-1 text-xs leading-5 text-gray-500
                                       sm:text-sm"
                            >
                                {{ stat.label }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- School Image -->
                <div
                    class="group relative min-w-0 overflow-hidden
                           rounded-2xl shadow-lg"
                >
                    <img
                        src="/storage/images/hero/hero1.png"
                        alt="Great Crystal School"
                        loading="lazy"
                        class="h-64 w-full object-cover
                               transition-transform duration-500
                               group-hover:scale-105
                               sm:h-80 md:h-96
                               lg:h-[420px] xl:h-[500px]"
                    />
                </div>

            </div>
        </div>
    </section>

    <!-- Section 2: Our Mission -->
    <section class="bg-gray-50 py-12 sm:py-16 lg:py-20">
        <div
            class="mx-auto w-full max-w-[1600px]
                   px-4 sm:px-6 md:px-8
                   lg:px-12 xl:px-16 2xl:px-20"
        >
            <div
                class="grid grid-cols-1 items-center gap-8
                       sm:gap-10 lg:grid-cols-2 lg:gap-12
                       xl:gap-16"
            >

                <!-- Mission Image -->
                <div
                    class="min-w-0 overflow-hidden rounded-2xl shadow-lg"
                >
                    <img
                        src="/storage/images/primary.jpeg"
                        alt="Students at Great Crystal School"
                        loading="lazy"
                        class="h-64 w-full object-cover
                               sm:h-80 md:h-96
                               lg:h-[420px] xl:h-[480px]"
                    />
                </div>

                <!-- Mission Content -->
                <div class="min-w-0">
                    <span
                        class="text-xs font-bold uppercase tracking-[2px]
                               text-orange-500 sm:text-sm sm:tracking-[3px]"
                    >
                        Our Mission
                    </span>

                    <h2
                        class="mt-3 text-2xl font-bold leading-tight
                               text-gray-900 sm:text-3xl
                               lg:text-4xl xl:text-5xl"
                    >
                        Education with Purpose and Passion
                    </h2>

                    <p
                        class="mt-4 text-sm leading-7 text-gray-500
                               sm:text-base sm:leading-8"
                    >
                        We aim to cultivate students who are confident,
                        compassionate, and capable of making a positive impact
                        in the world.
                    </p>

                    <!-- Mission Checklist -->
                    <div class="mt-6 flex flex-col gap-4 sm:mt-7 sm:gap-5">
                        <div
                            v-for="point in missionPoints"
                            :key="point"
                            class="flex items-start gap-3"
                        >
                            <CheckCircle2
                                class="mt-0.5 h-5 w-5 shrink-0
                                       text-orange-500 sm:h-6 sm:w-6"
                                fill="currentColor"
                                stroke="white"
                            />

                            <span
                                class="text-sm leading-6 text-gray-600
                                       sm:text-base sm:leading-7"
                            >
                                {{ point }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</template>
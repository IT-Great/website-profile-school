<script setup>
import { Link } from '@inertiajs/vue3'

import {
    Lightbulb,
    BookOpen,
    Users,
    Globe,
    CheckCircle2,
    ArrowRight,
    FlaskConical,
    Palette,
    Music,
    Calculator,
    Code,
    UserRound,
} from 'lucide-vue-next'
</script>

<template>
    <!-- HERO -->
    <section
        class="relative isolate w-full overflow-hidden
               min-h-[440px] sm:min-h-[480px] lg:min-h-[520px]
               h-[65svh] max-h-[760px]"
    >
        <img
            src="/storage/images/program.png"
            alt="Primary Program"
            class="absolute inset-0 h-full w-full object-cover object-center"
        />

        <div
            class="absolute inset-0 bg-gradient-to-r
                   from-black/85 via-black/60 to-black/20"
        ></div>

        <div
            class="relative z-10 mx-auto flex h-full min-h-[440px] w-full
                   max-w-[1600px] items-center
                   px-4 py-12 sm:min-h-[480px] sm:px-8
                   md:px-10 lg:min-h-[520px] lg:px-14
                   xl:px-20 2xl:px-24"
        >
            <div class="w-full max-w-3xl text-white">
                <!-- Breadcrumb -->
                <nav
                    aria-label="Breadcrumb"
                    class="mb-5 flex flex-wrap items-center gap-x-2 gap-y-1
                           text-xs sm:text-sm"
                >
                    <Link href="/" class="transition hover:text-orange-400">
                        Home
                    </Link>

                    <span class="text-orange-400">›</span>

                    <Link
                        href="/programs"
                        class="transition hover:text-orange-400"
                    >
                        Programs
                    </Link>

                    <span class="text-orange-400">›</span>

                    <span class="font-medium text-orange-400">Primary</span>
                </nav>

                <h1
                    class="text-4xl font-bold leading-tight tracking-tight
                           sm:text-5xl md:text-6xl lg:text-7xl"
                >
                    Primary Program
                </h1>

                <div class="mb-5 mt-5 h-1 w-12 rounded-full bg-orange-500 sm:mb-6 sm:mt-6"></div>

                <p
                    class="max-w-2xl text-sm leading-7 text-gray-200
                           sm:text-base sm:leading-8 md:text-lg"
                >
                    Building strong foundations, inspiring curiosity,
                    and preparing students to become confident,
                    creative, and compassionate learners.
                </p>
            </div>
        </div>
    </section>

    <!-- ABOUT PRIMARY -->
    <section class="w-full overflow-hidden bg-white py-12 sm:py-16 lg:py-20">
        <div
            class="mx-auto w-full max-w-[1600px]
                   px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-20"
        >
            <div class="grid grid-cols-1 items-center gap-8 sm:gap-10 lg:grid-cols-2 lg:gap-12 xl:gap-16">
                <!-- Image -->
                <div class="min-w-0">
                    <div class="overflow-hidden rounded-2xl">
                        <img
                            src="/storage/images/program.png"
                            alt="Primary students"
                            loading="lazy"
                            class="h-60 w-full object-cover sm:h-80 lg:h-[390px]"
                        />
                    </div>

                    <!-- Decorative slider indicators -->
                    <div class="mt-5 flex justify-center gap-2" aria-hidden="true">
                        <span class="h-2.5 w-2.5 rounded-full bg-orange-500"></span>
                        <span class="h-2.5 w-2.5 rounded-full bg-gray-300"></span>
                        <span class="h-2.5 w-2.5 rounded-full bg-gray-300"></span>
                        <span class="h-2.5 w-2.5 rounded-full bg-gray-300"></span>
                    </div>
                </div>

                <!-- Content -->
                <div class="min-w-0">
                    <span
                        class="text-xs font-semibold uppercase tracking-wider
                               text-orange-500 sm:text-sm"
                    >
                        About Primary Program
                    </span>

                    <h2
                        class="mt-3 text-3xl font-bold leading-tight text-gray-900
                               sm:text-4xl"
                    >
                        Developing Confident Lifelong Learners
                    </h2>

                    <div class="mb-6 mt-5 h-1 w-12 rounded-full bg-orange-500"></div>

                    <p class="text-sm leading-7 text-gray-600 sm:text-base sm:leading-8">
                        Our Primary Program provides a holistic and broad-based
                        education that nurtures academic excellence, character,
                        and life skills.
                    </p>

                    <p class="mt-4 text-sm leading-7 text-gray-600 sm:text-base sm:leading-8">
                        We encourage students to explore, think critically,
                        and work collaboratively in a supportive and joyful
                        environment.
                    </p>

                    <!-- Features -->
                    <div
                        class="mt-8 grid grid-cols-1 gap-x-5 gap-y-7
                               min-[420px]:grid-cols-2
                               lg:grid-cols-2 xl:grid-cols-4"
                    >
                        <div class="text-center">
                            <Lightbulb
                                class="mx-auto h-8 w-8 text-orange-500 sm:h-9 sm:w-9"
                                :stroke-width="1.8"
                            />

                            <h3 class="mt-3 text-sm font-semibold leading-5 text-gray-800">
                                Student-Centered
                            </h3>

                            <p class="mt-2 text-xs leading-5 text-gray-500 sm:text-sm sm:leading-6">
                                Encouraging active learning and critical thinking.
                            </p>
                        </div>

                        <div class="text-center">
                            <BookOpen
                                class="mx-auto h-8 w-8 text-orange-500 sm:h-9 sm:w-9"
                                :stroke-width="1.8"
                            />

                            <h3 class="mt-3 text-sm font-semibold leading-5 text-gray-800">
                                Strong Foundations
                            </h3>

                            <p class="mt-2 text-xs leading-5 text-gray-500 sm:text-sm sm:leading-6">
                                Building solid skills in literacy, numeracy,
                                and communication.
                            </p>
                        </div>

                        <div class="text-center">
                            <Users
                                class="mx-auto h-8 w-8 text-orange-500 sm:h-9 sm:w-9"
                                :stroke-width="1.8"
                            />

                            <h3 class="mt-3 text-sm font-semibold leading-5 text-gray-800">
                                Character Growth
                            </h3>

                            <p class="mt-2 text-xs leading-5 text-gray-500 sm:text-sm sm:leading-6">
                                Developing integrity, respect, responsibility,
                                and empathy.
                            </p>
                        </div>

                        <div class="text-center">
                            <Globe
                                class="mx-auto h-8 w-8 text-orange-500 sm:h-9 sm:w-9"
                                :stroke-width="1.8"
                            />

                            <h3 class="mt-3 text-sm font-semibold leading-5 text-gray-800">
                                Global Perspective
                            </h3>

                            <p class="mt-2 text-xs leading-5 text-gray-500 sm:text-sm sm:leading-6">
                                Preparing students to be open-minded and ready
                                for the future.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- OUR PRIMARY LEVELS -->
    <section class="w-full overflow-hidden bg-gray-50 py-12 sm:py-16">
        <div
            class="mx-auto w-full max-w-[1600px]
                   px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-20"
        >
            <div class="text-center">
                <span
                    class="text-xs font-semibold uppercase tracking-wider
                           text-orange-500 sm:text-sm"
                >
                    Primary Education
                </span>

                <h2 class="mt-3 text-3xl font-bold text-gray-900 sm:text-4xl">
                    Our Primary Levels
                </h2>

                <div class="mx-auto mt-4 h-1 w-12 rounded-full bg-orange-500"></div>
            </div>

            <!-- Levels -->
            <div class="mt-8 grid grid-cols-1 gap-6 xl:grid-cols-2 xl:gap-7 sm:mt-10">
                <!-- Lower Primary -->
                <div
                    class="min-w-0 rounded-2xl border border-gray-100
                           bg-white p-4 shadow-sm transition duration-300
                           hover:shadow-md sm:p-5"
                >
                    <div class="grid grid-cols-1 items-center gap-5 md:grid-cols-2">
                        <div class="relative min-w-0">
                            <img
                                src="/storage/images/program.png"
                                alt="Lower Primary"
                                loading="lazy"
                                class="h-56 w-full rounded-xl object-cover sm:h-64 md:h-60"
                            />

                            <div
                                class="absolute left-3 top-3 flex h-12 w-12
                                       items-center justify-center rounded-full
                                       border-4 border-white bg-orange-500
                                       text-white shadow sm:-left-2 sm:-top-2
                                       sm:h-14 sm:w-14"
                            >
                                <UserRound class="h-6 w-6 sm:h-7 sm:w-7" />
                            </div>
                        </div>

                        <div class="min-w-0 p-1 sm:p-2">
                            <h3 class="text-xl font-bold text-orange-500 sm:text-2xl">
                                Lower Primary
                            </h3>

                            <p class="mt-2 font-semibold text-gray-800">
                                Grades 1 – 3
                            </p>

                            <p class="mt-3 text-sm leading-6 text-gray-600">
                                Students build essential skills in reading,
                                writing, mathematics, and explore the world
                                around them through hands-on learning.
                            </p>

                            <ul class="mt-4 space-y-3">
                                <li class="flex items-start gap-2 text-sm leading-5 text-gray-600">
                                    <CheckCircle2 class="mt-0.5 h-4 w-4 shrink-0 text-orange-500" />
                                    <span>Building basic academic skills</span>
                                </li>

                                <li class="flex items-start gap-2 text-sm leading-5 text-gray-600">
                                    <CheckCircle2 class="mt-0.5 h-4 w-4 shrink-0 text-orange-500" />
                                    <span>Developing curiosity &amp; creativity</span>
                                </li>

                                <li class="flex items-start gap-2 text-sm leading-5 text-gray-600">
                                    <CheckCircle2 class="mt-0.5 h-4 w-4 shrink-0 text-orange-500" />
                                    <span>Social &amp; emotional growth</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Upper Primary -->
                <div
                    class="min-w-0 rounded-2xl border border-gray-100
                           bg-white p-4 shadow-sm transition duration-300
                           hover:shadow-md sm:p-5"
                >
                    <div class="grid grid-cols-1 items-center gap-5 md:grid-cols-2">
                        <div class="relative min-w-0">
                            <img
                                src="/storage/images/program.png"
                                alt="Upper Primary"
                                loading="lazy"
                                class="h-56 w-full rounded-xl object-cover sm:h-64 md:h-60"
                            />

                            <div
                                class="absolute left-3 top-3 flex h-12 w-12
                                       items-center justify-center rounded-full
                                       border-4 border-white bg-orange-500
                                       text-white shadow sm:-left-2 sm:-top-2
                                       sm:h-14 sm:w-14"
                            >
                                <UserRound class="h-6 w-6 sm:h-7 sm:w-7" />
                            </div>
                        </div>

                        <div class="min-w-0 p-1 sm:p-2">
                            <h3 class="text-xl font-bold text-orange-500 sm:text-2xl">
                                Upper Primary
                            </h3>

                            <p class="mt-2 font-semibold text-gray-800">
                                Grades 4 – 6
                            </p>

                            <p class="mt-3 text-sm leading-6 text-gray-600">
                                Students expand their knowledge, strengthen
                                independent learning, and develop problem-solving
                                and leadership skills.
                            </p>

                            <ul class="mt-4 space-y-3">
                                <li class="flex items-start gap-2 text-sm leading-5 text-gray-600">
                                    <CheckCircle2 class="mt-0.5 h-4 w-4 shrink-0 text-orange-500" />
                                    <span>Advanced academic skills</span>
                                </li>

                                <li class="flex items-start gap-2 text-sm leading-5 text-gray-600">
                                    <CheckCircle2 class="mt-0.5 h-4 w-4 shrink-0 text-orange-500" />
                                    <span>Critical thinking &amp; collaboration</span>
                                </li>

                                <li class="flex items-start gap-2 text-sm leading-5 text-gray-600">
                                    <CheckCircle2 class="mt-0.5 h-4 w-4 shrink-0 text-orange-500" />
                                    <span>Leadership &amp; global awareness</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CURRICULUM + EXTRACURRICULAR -->
    <section class="w-full overflow-hidden bg-white py-12 sm:py-16">
        <div
            class="mx-auto w-full max-w-[1600px]
                   px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-20"
        >
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-2 xl:gap-7">
                <!-- CURRICULUM -->
                <div class="min-w-0 rounded-2xl border border-gray-100 p-5 shadow-sm sm:p-7 lg:p-8">
                    <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                        Curriculum
                    </h2>

                    <div class="mb-5 mt-4 h-1 w-12 rounded-full bg-orange-500"></div>

                    <p class="text-sm leading-7 text-gray-600 sm:text-base">
                        We combine national standards with international best
                        practices to provide a balanced and future-ready education.
                    </p>

                    <div class="mt-7 grid grid-cols-3">
                        <!-- Cambridge -->
                        <div class="min-w-0 border-r border-gray-200 px-2 text-center sm:px-4">
                            <div class="flex h-16 items-center justify-center sm:h-20">
                                <span class="text-2xl font-bold text-gray-700 sm:text-3xl">
                                    CIE
                                </span>
                            </div>

                            <h3 class="break-words text-xs font-semibold text-gray-700 sm:text-base">
                                Cambridge
                            </h3>

                            <p class="mt-1 text-[11px] leading-4 text-gray-500 sm:text-sm sm:leading-5">
                                International Curriculum
                            </p>
                        </div>

                        <!-- Merdeka -->
                        <div class="min-w-0 border-r border-gray-200 px-2 text-center sm:px-4">
                            <div class="flex h-16 items-center justify-center sm:h-20">
                                <span class="text-3xl font-bold text-blue-500 sm:text-4xl">
                                    M
                                </span>
                            </div>

                            <h3 class="break-words text-xs font-semibold text-gray-700 sm:text-base">
                                Merdeka
                            </h3>

                            <p class="mt-1 text-[11px] leading-4 text-gray-500 sm:text-sm sm:leading-5">
                                Curriculum
                            </p>
                        </div>

                        <!-- 21st Century -->
                        <div class="min-w-0 px-2 text-center sm:px-4">
                            <div class="flex h-16 items-center justify-center sm:h-20">
                                <span class="text-2xl font-bold text-gray-700 sm:text-3xl">
                                    21<sup>st</sup>
                                </span>
                            </div>

                            <h3 class="break-words text-xs font-semibold leading-4 text-gray-700 sm:text-base sm:leading-5">
                                Character &amp; 21st Century
                            </h3>

                            <p class="mt-1 text-[11px] leading-4 text-gray-500 sm:text-sm sm:leading-5">
                                Learning
                            </p>
                        </div>
                    </div>
                </div>

                <!-- EXTRACURRICULAR -->
                <div class="min-w-0 rounded-2xl border border-gray-100 p-5 shadow-sm sm:p-7 lg:p-8">
                    <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                        Extracurricular Activities
                    </h2>

                    <div class="mb-5 mt-4 h-1 w-12 rounded-full bg-orange-500"></div>

                    <p class="text-sm leading-7 text-gray-600 sm:text-base">
                        We offer a variety of extracurricular activities to help
                        students discover their passions and develop their talents.
                    </p>

                    <div
                        class="mt-7 grid grid-cols-2 border-l border-t
                               border-gray-200 sm:grid-cols-4"
                    >
                        <div class="border-b border-r border-gray-200 p-3 text-center sm:p-4">
                            <BookOpen class="mx-auto h-6 w-6 text-orange-500 sm:h-7 sm:w-7" />
                            <p class="mt-2 text-xs font-medium leading-5 sm:text-sm">
                                English Club
                            </p>
                        </div>

                        <div class="border-b border-r border-gray-200 p-3 text-center sm:p-4">
                            <Code class="mx-auto h-6 w-6 text-orange-500 sm:h-7 sm:w-7" />
                            <p class="mt-2 text-xs font-medium leading-5 sm:text-sm">
                                Robotics Club
                            </p>
                        </div>

                        <div class="border-b border-r border-gray-200 p-3 text-center sm:p-4">
                            <Code class="mx-auto h-6 w-6 text-orange-500 sm:h-7 sm:w-7" />
                            <p class="mt-2 text-xs font-medium leading-5 sm:text-sm">
                                Coding Club
                            </p>
                        </div>

                        <div class="border-b border-r border-gray-200 p-3 text-center sm:p-4">
                            <Calculator class="mx-auto h-6 w-6 text-orange-500 sm:h-7 sm:w-7" />
                            <p class="mt-2 text-xs font-medium leading-5 sm:text-sm">
                                Math Club
                            </p>
                        </div>

                        <div class="border-b border-r border-gray-200 p-3 text-center sm:p-4">
                            <FlaskConical class="mx-auto h-6 w-6 text-orange-500 sm:h-7 sm:w-7" />
                            <p class="mt-2 text-xs font-medium leading-5 sm:text-sm">
                                Science Club
                            </p>
                        </div>

                        <div class="border-b border-r border-gray-200 p-3 text-center sm:p-4">
                            <Palette class="mx-auto h-6 w-6 text-orange-500 sm:h-7 sm:w-7" />
                            <p class="mt-2 text-xs font-medium leading-5 sm:text-sm">
                                Art Club
                            </p>
                        </div>

                        <div class="border-b border-r border-gray-200 p-3 text-center sm:p-4">
                            <Music class="mx-auto h-6 w-6 text-orange-500 sm:h-7 sm:w-7" />
                            <p class="mt-2 text-xs font-medium leading-5 sm:text-sm">
                                Music Club
                            </p>
                        </div>

                        <div class="border-b border-r border-gray-200 p-3 text-center sm:p-4">
                            <Users class="mx-auto h-6 w-6 text-orange-500 sm:h-7 sm:w-7" />
                            <p class="mt-2 text-xs font-medium leading-5 sm:text-sm">
                                Student Council
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- LEARNING BEYOND THE CLASSROOM -->
    <section class="w-full overflow-hidden bg-gray-50 py-12 sm:py-16">
        <div
            class="mx-auto w-full max-w-[1600px]
                   px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-20"
        >
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl lg:text-4xl">
                    Learning Beyond the Classroom
                </h2>

                <div class="mx-auto mt-4 h-1 w-12 rounded-full bg-orange-500"></div>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-6 sm:mt-10 md:grid-cols-2 xl:grid-cols-3 xl:gap-7">
                <!-- Field Trip -->
                <article
                    class="flex min-w-0 flex-col overflow-hidden rounded-2xl
                           border border-gray-100 bg-white shadow-sm
                           transition duration-300 hover:-translate-y-1 hover:shadow-md"
                >
                    <img
                        src="/storage/images/program.png"
                        alt="Field Trip"
                        loading="lazy"
                        class="h-48 w-full object-cover sm:h-56"
                    />

                    <div class="flex flex-1 flex-col p-5 sm:p-6">
                        <h3 class="text-xl font-bold text-orange-500">
                            Field Trip
                        </h3>

                        <p class="mt-3 text-sm leading-6 text-gray-600">
                            Our field trips provide real-world experiences that
                            enhance learning and broaden students' horizons.
                        </p>

                        <Link
                            href="/storage/images/program.png"
                            class="mt-auto inline-flex w-fit max-w-full items-center
                                   gap-2 rounded-full border border-orange-500
                                   px-4 py-2.5 mt-5 text-sm text-orange-500
                                   transition hover:bg-orange-500 hover:text-white
                                   sm:px-5"
                        >
                            <span>View All Field Trips</span>
                            <ArrowRight class="h-4 w-4 shrink-0" />
                        </Link>
                    </div>
                </article>

                <!-- School Activities -->
                <article
                    class="flex min-w-0 flex-col overflow-hidden rounded-2xl
                           border border-gray-100 bg-white shadow-sm
                           transition duration-300 hover:-translate-y-1 hover:shadow-md"
                >
                    <img
                        src="/storage/images/program.png"
                        alt="School Activities"
                        loading="lazy"
                        class="h-48 w-full object-cover sm:h-56"
                    />

                    <div class="flex flex-1 flex-col p-5 sm:p-6">
                        <h3 class="text-xl font-bold text-orange-500">
                            School Activities
                        </h3>

                        <p class="mt-3 text-sm leading-6 text-gray-600">
                            From competitions to special events, our activities
                            build confidence, teamwork, and unforgettable memories.
                        </p>

                        <Link
                            href="/storage/images/program.png"
                            class="mt-auto inline-flex w-fit max-w-full items-center
                                   gap-2 rounded-full border border-orange-500
                                   px-4 py-2.5 mt-5 text-sm text-orange-500
                                   transition hover:bg-orange-500 hover:text-white
                                   sm:px-5"
                        >
                            <span>View All Activities</span>
                            <ArrowRight class="h-4 w-4 shrink-0" />
                        </Link>
                    </div>
                </article>

                <!-- Class Projects -->
                <article
                    class="flex min-w-0 flex-col overflow-hidden rounded-2xl
                           border border-gray-100 bg-white shadow-sm
                           transition duration-300 hover:-translate-y-1 hover:shadow-md
                           md:col-span-2 xl:col-span-1"
                >
                    <img
                        src="/storage/images/program.png"
                        alt="Class Projects"
                        loading="lazy"
                        class="h-48 w-full object-cover sm:h-56"
                    />

                    <div class="flex flex-1 flex-col p-5 sm:p-6">
                        <h3 class="text-xl font-bold text-orange-500">
                            Class Projects
                        </h3>

                        <p class="mt-3 text-sm leading-6 text-gray-600">
                            Hands-on projects encourage creativity, collaboration,
                            and problem-solving in meaningful ways.
                        </p>

                        <Link
                            href="/storage/images/program.png"
                            class="mt-auto inline-flex w-fit max-w-full items-center
                                   gap-2 rounded-full border border-orange-500
                                   px-4 py-2.5 mt-5 text-sm text-orange-500
                                   transition hover:bg-orange-500 hover:text-white
                                   sm:px-5"
                        >
                            <span>View All Projects</span>
                            <ArrowRight class="h-4 w-4 shrink-0" />
                        </Link>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- MOMENTS OF LEARNING & FUN -->
    <section class="w-full overflow-hidden bg-white py-12 sm:py-16">
        <div
            class="mx-auto w-full max-w-[1600px]
                   px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-20"
        >
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl lg:text-4xl">
                    Moments of Learning &amp; Fun
                </h2>

                <div class="mx-auto mt-4 h-1 w-12 rounded-full bg-orange-500"></div>
            </div>

            <!-- Gallery -->
            <div class="mt-8 grid grid-cols-2 gap-3 sm:mt-10 sm:gap-4 md:grid-cols-3 lg:grid-cols-5">
                <img
                    src="/storage/images/program.png"
                    alt="Primary school activity"
                    loading="lazy"
                    class="aspect-[4/3] h-full w-full rounded-xl object-cover transition duration-300 hover:scale-[1.02]"
                />

                <img
                    src="/storage/images/program.png"
                    alt="Primary students reading"
                    loading="lazy"
                    class="aspect-[4/3] h-full w-full rounded-xl object-cover transition duration-300 hover:scale-[1.02]"
                />

                <img
                    src="/storage/images/program.png"
                    alt="Primary science activity"
                    loading="lazy"
                    class="aspect-[4/3] h-full w-full rounded-xl object-cover transition duration-300 hover:scale-[1.02]"
                />

                <img
                    src="/storage/images/program.png"
                    alt="Primary achievement"
                    loading="lazy"
                    class="aspect-[4/3] h-full w-full rounded-xl object-cover transition duration-300 hover:scale-[1.02]"
                />

                <img
                    src="/storage/images/program.png"
                    alt="Primary classroom activity"
                    loading="lazy"
                    class="aspect-[4/3] h-full w-full rounded-xl object-cover transition duration-300 hover:scale-[1.02]"
                />
            </div>

            <div class="mt-8 text-center">
                <Link
                    href="/gallery?program=primary"
                    class="inline-flex max-w-full items-center justify-center
                           gap-2 rounded-full border border-orange-500
                           px-5 py-3 text-sm font-medium text-orange-500
                           transition hover:bg-orange-500 hover:text-white
                           sm:px-7 sm:text-base"
                >
                    <span>View All Photos</span>
                    <ArrowRight class="h-4 w-4 shrink-0" />
                </Link>
            </div>
        </div>
    </section>
</template>
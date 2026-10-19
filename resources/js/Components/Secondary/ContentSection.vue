<script setup>
import { Link } from '@inertiajs/vue3'

import {
    GraduationCap,
    Users,
    Globe,
    Heart,
    BookOpen,
    Lightbulb,
    MessageCircle,
    Handshake,
    Palette,
    Monitor,
    Flag,
    ArrowRight,
    FlaskConical,
    Trophy,
    Music,
    Code,
    Dumbbell,
    Library,
    Microscope,
    ShieldCheck,
    UserRound,
    Target,
} from 'lucide-vue-next'
</script>

<template>

    <!-- ========================================================= -->
    <!-- HERO -->
    <!-- ========================================================= -->

    <section class="relative h-[430px] overflow-hidden">

        <img
            src="/storage/images/program.png"
            alt="Secondary Program"
            class="absolute inset-0 w-full h-full object-cover"
        />

        <div
            class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/55 to-black/10"
        ></div>

        <div
            class="relative z-10 max-w-7xl mx-auto px-6 h-full flex items-center"
        >

            <div class="max-w-2xl text-white">

                <!-- Breadcrumb -->

                <div class="flex items-center gap-2 text-sm mb-5">

                    <Link
                        href="/"
                        class="hover:text-orange-400 transition"
                    >
                        Home
                    </Link>

                    <span class="text-orange-400">
                        ›
                    </span>

                    <Link
                        href="/programs"
                        class="hover:text-orange-400 transition"
                    >
                        Programs
                    </Link>

                    <span class="text-orange-400">
                        ›
                    </span>

                    <span class="text-orange-400 font-medium">
                        Secondary School
                    </span>

                </div>


                <h1
                    class="text-5xl md:text-6xl font-bold leading-tight"
                >
                    Secondary Program
                </h1>


                <div
                    class="w-12 h-1 bg-orange-500 mt-6 mb-5"
                ></div>


                <p
                    class="text-lg md:text-xl text-gray-200 leading-relaxed max-w-xl"
                >
                    Empowering young learners to become confident,
                    responsible, and future-ready global citizens.
                </p>

            </div>

        </div>

    </section>


    <!-- ========================================================= -->
    <!-- ABOUT + CURRICULUM -->
    <!-- ========================================================= -->

    <section class="py-16 bg-white">

        <div class="max-w-7xl mx-auto px-6">

            <div class="grid lg:grid-cols-2 gap-10">


                <!-- ================================================= -->
                <!-- ABOUT -->
                <!-- ================================================= -->

                <div class="py-3">

                    <span
                        class="text-orange-500 font-semibold uppercase tracking-wider text-sm"
                    >
                        About Secondary
                    </span>

                    <h2
                        class="text-3xl md:text-4xl font-bold text-gray-900 mt-3"
                    >
                        About Secondary Program
                    </h2>

                    <div
                        class="w-12 h-1 bg-orange-500 mt-4 mb-6"
                    ></div>


                    <p
                        class="text-gray-600 leading-7"
                    >
                        Our Secondary Program (Grades 7–9) focuses on
                        academic excellence, character development,
                        and leadership. Students are encouraged to
                        explore their passions, think critically,
                        and develop the skills they need to succeed
                        in a rapidly changing world.
                    </p>


                    <!-- Features -->

                    <div
                        class="grid grid-cols-2 md:grid-cols-4 gap-5 mt-10"
                    >

                        <!-- Academic Excellence -->

                        <div class="text-center">

                            <GraduationCap
                                class="w-9 h-9 mx-auto text-orange-500"
                                stroke-width="1.7"
                            />

                            <h3
                                class="font-bold text-gray-800 mt-4 text-sm"
                            >
                                Academic
                                Excellence
                            </h3>

                            <p
                                class="text-xs text-gray-500 leading-6 mt-2"
                            >
                                Strong curriculum that builds
                                knowledge and critical thinking.
                            </p>

                        </div>


                        <!-- Character -->

                        <div class="text-center">

                            <UserRound
                                class="w-9 h-9 mx-auto text-orange-500"
                                stroke-width="1.7"
                            />

                            <h3
                                class="font-bold text-gray-800 mt-4 text-sm"
                            >
                                Character &
                                Leadership
                            </h3>

                            <p
                                class="text-xs text-gray-500 leading-6 mt-2"
                            >
                                Building integrity, confidence,
                                and responsibility.
                            </p>

                        </div>


                        <!-- Global -->

                        <div class="text-center">

                            <Globe
                                class="w-9 h-9 mx-auto text-orange-500"
                                stroke-width="1.7"
                            />

                            <h3
                                class="font-bold text-gray-800 mt-4 text-sm"
                            >
                                Global
                                Perspective
                            </h3>

                            <p
                                class="text-xs text-gray-500 leading-6 mt-2"
                            >
                                Preparing students to be open-minded
                                and globally aware.
                            </p>

                        </div>


                        <!-- Well Rounded -->

                        <div class="text-center">

                            <Heart
                                class="w-9 h-9 mx-auto text-orange-500"
                                stroke-width="1.7"
                            />

                            <h3
                                class="font-bold text-gray-800 mt-4 text-sm"
                            >
                                Well-rounded
                                Development
                            </h3>

                            <p
                                class="text-xs text-gray-500 leading-6 mt-2"
                            >
                                Supporting physical, emotional,
                                and social growth.
                            </p>

                        </div>

                    </div>

                </div>


                <!-- ================================================= -->
                <!-- CURRICULUM -->
                <!-- ================================================= -->

                <div
                    class="bg-orange-50/70 rounded-2xl p-7 md:p-8"
                >

                    <h2
                        class="text-3xl font-bold text-gray-900"
                    >
                        Curriculum We Use
                    </h2>

                    <div
                        class="w-12 h-1 bg-orange-500 mt-4 mb-5"
                    ></div>


                    <p
                        class="text-gray-600 leading-7"
                    >
                        We combine international standards with
                        national best practices to provide a balanced
                        and future-focused education.
                    </p>


                    <!-- Curriculum 1 -->

                    <div
                        class="bg-white rounded-xl p-5 mt-7 flex gap-5 items-center"
                    >

                        <div
                            class="w-16 h-16 shrink-0 rounded-lg bg-gray-50 flex items-center justify-center"
                        >
                            <span
                                class="font-bold text-red-700 text-xl"
                            >
                                CIE
                            </span>
                        </div>

                        <div>

                            <h3
                                class="font-bold text-gray-900"
                            >
                                Cambridge Curriculum
                            </h3>

                            <p
                                class="text-sm text-gray-600 leading-6 mt-2"
                            >
                                An internationally recognized
                                curriculum that develops confident,
                                independent learners with strong
                                academic foundation and critical
                                thinking skills.
                            </p>

                        </div>

                    </div>


                    <!-- Curriculum 2 -->

                    <div
                        class="bg-white rounded-xl p-5 mt-4 flex gap-5 items-center"
                    >

                        <div
                            class="w-16 h-16 shrink-0 rounded-lg bg-gray-50 flex items-center justify-center"
                        >
                            <GraduationCap
                                class="w-9 h-9 text-blue-600"
                            />
                        </div>

                        <div>

                            <h3
                                class="font-bold text-gray-900"
                            >
                                Kurikulum Merdeka (Indonesia)
                            </h3>

                            <p
                                class="text-sm text-gray-600 leading-6 mt-2"
                            >
                                Integrated to ensure students meet
                                national standards while fostering
                                creativity, character, and lifelong
                                learning.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- ========================================================= -->
    <!-- WHAT STUDENTS WILL LEARN -->
    <!-- ========================================================= -->

    <section class="py-12 bg-white">

        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center">

                <h2
                    class="text-3xl md:text-4xl font-bold text-gray-900"
                >
                    What Students Will Learn
                </h2>

                <div
                    class="w-12 h-1 bg-orange-500 mx-auto mt-4"
                ></div>

            </div>


            <div
                class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3 mt-8"
            >

                <!-- 1 -->

                <div
                    class="border border-orange-100 rounded-xl p-5 text-center hover:shadow-md hover:-translate-y-1 transition"
                >

                    <BookOpen
                        class="w-8 h-8 mx-auto text-orange-500"
                    />

                    <p
                        class="text-sm font-semibold text-gray-700 mt-4"
                    >
                        Advanced Academic Skills
                    </p>

                </div>


                <!-- 2 -->

                <div
                    class="border border-orange-100 rounded-xl p-5 text-center hover:shadow-md hover:-translate-y-1 transition"
                >

                    <Lightbulb
                        class="w-8 h-8 mx-auto text-orange-500"
                    />

                    <p
                        class="text-sm font-semibold text-gray-700 mt-4"
                    >
                        Critical Thinking &
                        Problem Solving
                    </p>

                </div>


                <!-- 3 -->

                <div
                    class="border border-orange-100 rounded-xl p-5 text-center hover:shadow-md hover:-translate-y-1 transition"
                >

                    <MessageCircle
                        class="w-8 h-8 mx-auto text-orange-500"
                    />

                    <p
                        class="text-sm font-semibold text-gray-700 mt-4"
                    >
                        Effective
                        Communication
                    </p>

                </div>


                <!-- 4 -->

                <div
                    class="border border-orange-100 rounded-xl p-5 text-center hover:shadow-md hover:-translate-y-1 transition"
                >

                    <Handshake
                        class="w-8 h-8 mx-auto text-orange-500"
                    />

                    <p
                        class="text-sm font-semibold text-gray-700 mt-4"
                    >
                        Collaboration &
                        Teamwork
                    </p>

                </div>


                <!-- 5 -->

                <div
                    class="border border-orange-100 rounded-xl p-5 text-center hover:shadow-md hover:-translate-y-1 transition"
                >

                    <Palette
                        class="w-8 h-8 mx-auto text-orange-500"
                    />

                    <p
                        class="text-sm font-semibold text-gray-700 mt-4"
                    >
                        Creativity &
                        Innovation
                    </p>

                </div>


                <!-- 6 -->

                <div
                    class="border border-orange-100 rounded-xl p-5 text-center hover:shadow-md hover:-translate-y-1 transition"
                >

                    <Monitor
                        class="w-8 h-8 mx-auto text-orange-500"
                    />

                    <p
                        class="text-sm font-semibold text-gray-700 mt-4"
                    >
                        Digital & Information
                        Literacy
                    </p>

                </div>


                <!-- 7 -->

                <div
                    class="border border-orange-100 rounded-xl p-5 text-center hover:shadow-md hover:-translate-y-1 transition"
                >

                    <Flag
                        class="w-8 h-8 mx-auto text-orange-500"
                    />

                    <p
                        class="text-sm font-semibold text-gray-700 mt-4"
                    >
                        Leadership &
                        Responsibility
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- ========================================================= -->
    <!-- FIELD TRIP / ACTIVITIES / EXTRACURRICULAR -->
    <!-- ========================================================= -->

    <section class="py-16 bg-white">

        <div class="max-w-7xl mx-auto px-6">

            <div
                class="grid lg:grid-cols-3 divide-y lg:divide-y-0 lg:divide-x divide-gray-200"
            >


                <!-- ================================================= -->
                <!-- FIELD TRIPS -->
                <!-- ================================================= -->

                <div class="px-6 pb-10 lg:pb-0">

                    <h2
                        class="text-2xl font-bold text-gray-900"
                    >
                        Field Trips
                    </h2>

                    <div
                        class="w-10 h-1 bg-orange-500 mt-3 mb-5"
                    ></div>

                    <p
                        class="text-sm text-gray-600 leading-6"
                    >
                        Field trips provide real-world experiences
                        that spark curiosity and broaden students'
                        understanding of the world.
                    </p>


                    <div
                        class="grid grid-cols-3 gap-3 mt-7"
                    >

                        <div class="text-center">

                            <img
                                src="/storage/images/program.png"
                                alt="Museum Visit"
                                class="w-full h-28 object-cover rounded-xl"
                            />

                            <p
                                class="text-xs font-semibold text-gray-700 mt-2"
                            >
                                Museum Visit
                            </p>

                        </div>


                        <div class="text-center">

                            <img
                                src="/storage/images/program.png"
                                alt="University Tour"
                                class="w-full h-28 object-cover rounded-xl"
                            />

                            <p
                                class="text-xs font-semibold text-gray-700 mt-2"
                            >
                                University Tour
                            </p>

                        </div>


                        <div class="text-center">

                            <img
                                src="/storage/images/program.png"
                                alt="Science Center"
                                class="w-full h-28 object-cover rounded-xl"
                            />

                            <p
                                class="text-xs font-semibold text-gray-700 mt-2"
                            >
                                Science Center
                            </p>

                        </div>

                    </div>


                    <div class="text-center mt-7">

                        <Link
                            href="/storage/images/program.png"
                            class="inline-flex items-center gap-2 border border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white px-6 py-2.5 rounded-full text-sm transition"
                        >
                            View All Field Trips
                            <ArrowRight class="w-4 h-4" />
                        </Link>

                    </div>

                </div>


                <!-- ================================================= -->
                <!-- ACTIVITIES -->
                <!-- ================================================= -->

                <div class="px-6 py-10 lg:py-0">

                    <h2
                        class="text-2xl font-bold text-gray-900"
                    >
                        Activities at School
                    </h2>

                    <div
                        class="w-10 h-1 bg-orange-500 mt-3 mb-5"
                    ></div>

                    <p
                        class="text-sm text-gray-600 leading-6"
                    >
                        Engaging activities that help students
                        discover their interests, build skills,
                        and create lasting memories.
                    </p>


                    <div
                        class="grid grid-cols-3 gap-3 mt-7"
                    >

                        <div class="text-center">

                            <img
                                src="/storage/images/program.png"
                                alt="Science Experiment"
                                class="w-full h-28 object-cover rounded-xl"
                            />

                            <p
                                class="text-xs font-semibold text-gray-700 mt-2"
                            >
                                Science Experiment
                            </p>

                        </div>


                        <div class="text-center">

                            <img
                                src="/storage/images/program.png"
                                alt="Debate Club"
                                class="w-full h-28 object-cover rounded-xl"
                            />

                            <p
                                class="text-xs font-semibold text-gray-700 mt-2"
                            >
                                Debate Club
                            </p>

                        </div>


                        <div class="text-center">

                            <img
                                src="/storage/images/program.png"
                                alt="Student Project"
                                class="w-full h-28 object-cover rounded-xl"
                            />

                            <p
                                class="text-xs font-semibold text-gray-700 mt-2"
                            >
                                Student Project
                            </p>

                        </div>

                    </div>


                    <div class="text-center mt-7">

                        <Link
                            href="/storage/images/program.png"
                            class="inline-flex items-center gap-2 border border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white px-6 py-2.5 rounded-full text-sm transition"
                        >
                            View All Activities
                            <ArrowRight class="w-4 h-4" />
                        </Link>

                    </div>

                </div>


                <!-- ================================================= -->
                <!-- EXTRACURRICULAR -->
                <!-- ================================================= -->

                <div class="px-6 pt-10 lg:pt-0">

                    <h2
                        class="text-2xl font-bold text-gray-900"
                    >
                        Extracurricular Programs
                    </h2>

                    <div
                        class="w-10 h-1 bg-orange-500 mt-3 mb-5"
                    ></div>

                    <p
                        class="text-sm text-gray-600 leading-6"
                    >
                        A wide range of extracurricular activities
                        to develop talents, interests, and leadership
                        skills.
                    </p>


                    <div
                        class="grid grid-cols-4 gap-y-5 mt-7"
                    >

                        <!-- English -->

                        <div class="text-center">

                            <div
                                class="w-12 h-12 mx-auto rounded-full bg-orange-100 flex items-center justify-center"
                            >
                                <MessageCircle
                                    class="w-6 h-6 text-orange-500"
                                />
                            </div>

                            <p class="text-xs font-medium mt-2">
                                English Club
                            </p>

                        </div>


                        <!-- Robotics -->

                        <div class="text-center">

                            <div
                                class="w-12 h-12 mx-auto rounded-full bg-blue-100 flex items-center justify-center"
                            >
                                <Code
                                    class="w-6 h-6 text-blue-500"
                                />
                            </div>

                            <p class="text-xs font-medium mt-2">
                                Robotics
                            </p>

                        </div>


                        <!-- Basketball -->

                        <div class="text-center">

                            <div
                                class="w-12 h-12 mx-auto rounded-full bg-orange-100 flex items-center justify-center"
                            >
                                <Trophy
                                    class="w-6 h-6 text-orange-500"
                                />
                            </div>

                            <p class="text-xs font-medium mt-2">
                                Basketball
                            </p>

                        </div>


                        <!-- Badminton -->

                        <div class="text-center">

                            <div
                                class="w-12 h-12 mx-auto rounded-full bg-blue-100 flex items-center justify-center"
                            >
                                <Target
                                    class="w-6 h-6 text-blue-500"
                                />
                            </div>

                            <p class="text-xs font-medium mt-2">
                                Badminton
                            </p>

                        </div>


                        <!-- Choir -->

                        <div class="text-center">

                            <div
                                class="w-12 h-12 mx-auto rounded-full bg-purple-100 flex items-center justify-center"
                            >
                                <Music
                                    class="w-6 h-6 text-purple-500"
                                />
                            </div>

                            <p class="text-xs font-medium mt-2">
                                Choir
                            </p>

                        </div>


                        <!-- Coding -->

                        <div class="text-center">

                            <div
                                class="w-12 h-12 mx-auto rounded-full bg-blue-100 flex items-center justify-center"
                            >
                                <Monitor
                                    class="w-6 h-6 text-blue-500"
                                />
                            </div>

                            <p class="text-xs font-medium mt-2">
                                Coding Club
                            </p>

                        </div>


                        <!-- Taekwondo -->

                        <div class="text-center">

                            <div
                                class="w-12 h-12 mx-auto rounded-full bg-orange-100 flex items-center justify-center"
                            >
                                <Dumbbell
                                    class="w-6 h-6 text-orange-500"
                                />
                            </div>

                            <p class="text-xs font-medium mt-2">
                                Taekwondo
                            </p>

                        </div>


                        <!-- Art -->

                        <div class="text-center">

                            <div
                                class="w-12 h-12 mx-auto rounded-full bg-red-100 flex items-center justify-center"
                            >
                                <Palette
                                    class="w-6 h-6 text-red-500"
                                />
                            </div>

                            <p class="text-xs font-medium mt-2">
                                Art Club
                            </p>

                        </div>

                    </div>


                    <div class="text-center mt-7">

                        <Link
                            href="/programs/secondary/extracurricular"
                            class="inline-flex items-center gap-2 border border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white px-6 py-2.5 rounded-full text-sm transition"
                        >
                            View All Extracurriculars
                            <ArrowRight class="w-4 h-4" />
                        </Link>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- ========================================================= -->
    <!-- WHY GREAT CRYSTAL -->
    <!-- ========================================================= -->

    <section class="py-16 bg-white">

        <div class="max-w-7xl mx-auto px-6">

            <div
                class="relative overflow-hidden rounded-2xl bg-orange-50"
            >

                <!-- Background image -->

                <div
                    class="absolute right-0 top-0 bottom-0 w-full lg:w-[35%]"
                >

                    <img
                        src="/storage/images/program.png"
                        alt="Great Crystal students"
                        class="w-full h-full object-cover"
                    />

                    <div
                        class="absolute inset-0 bg-gradient-to-r from-orange-50 via-orange-50/50 to-transparent"
                    ></div>

                </div>


                <div
                    class="relative z-10 p-8 md:p-10 lg:p-12 lg:pr-[38%]"
                >

                    <h2
                        class="text-3xl font-bold text-gray-900"
                    >
                        Why Great Crystal?
                    </h2>

                    <div
                        class="w-12 h-1 bg-orange-500 mt-4 mb-5"
                    ></div>

                    <p
                        class="text-gray-600 leading-7 max-w-xl"
                    >
                        We nurture students to achieve academic
                        success while becoming confident,
                        compassionate, and future-ready individuals
                        who make a positive impact in the world.
                    </p>


                    <!-- Benefits -->

                    <div
                        class="grid grid-cols-2 md:grid-cols-4 bg-white rounded-xl shadow-sm mt-8"
                    >

                        <!-- Experienced -->

                        <div
                            class="p-5 text-center border-r border-gray-100"
                        >

                            <Users
                                class="w-8 h-8 mx-auto text-orange-500"
                            />

                            <h3
                                class="text-xs font-semibold text-gray-700 mt-3"
                            >
                                Experienced
                                Teachers
                            </h3>

                        </div>


                        <!-- Student Centered -->

                        <div
                            class="p-5 text-center md:border-r border-gray-100"
                        >

                            <UserRound
                                class="w-8 h-8 mx-auto text-orange-500"
                            />

                            <h3
                                class="text-xs font-semibold text-gray-700 mt-3"
                            >
                                Student-Centered
                                Learning
                            </h3>

                        </div>


                        <!-- Safe -->

                        <div
                            class="p-5 text-center border-r border-gray-100"
                        >

                            <ShieldCheck
                                class="w-8 h-8 mx-auto text-orange-500"
                            />

                            <h3
                                class="text-xs font-semibold text-gray-700 mt-3"
                            >
                                Safe & Supportive
                                Environment
                            </h3>

                        </div>


                        <!-- Global -->

                        <div
                            class="p-5 text-center"
                        >

                            <Globe
                                class="w-8 h-8 mx-auto text-orange-500"
                            />

                            <h3
                                class="text-xs font-semibold text-gray-700 mt-3"
                            >
                                Global
                                Opportunities
                            </h3>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</template>
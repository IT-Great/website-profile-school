<script setup>
import { Link } from '@inertiajs/vue3'
import {
    Heart,
    BookOpen,
    Users,
    Star,
    UserRound,
    CheckCircle2,
    ArrowRight,
} from 'lucide-vue-next'
import { ref, onMounted, onUnmounted } from 'vue'

const offsetY = ref(0)
let ticking = false

const handleScroll = () => {
    if (!ticking) {
        window.requestAnimationFrame(() => {
            // Batasi parallax supaya tidak terlalu jauh pada mobile
            offsetY.value = Math.min(window.scrollY * 0.18, 100)
            ticking = false
        })

        ticking = true
    }
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll, {
        passive: true,
    })
})

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll)
})
</script>

<template>

    <!-- ========================================================= -->
    <!-- HERO -->
    <!-- ========================================================= -->

    <section
        class="relative min-h-[430px] overflow-hidden sm:min-h-[500px] lg:min-h-[560px]"
    >

        <!-- Background -->
        <img
            :style="{
                transform: `translate3d(0, ${offsetY}px, 0) scale(1.08)`
            }"
            src="/storage/images/program.png"
            alt="Preschool Program"
            class="absolute inset-0 h-full w-full object-cover will-change-transform"
        />

        <!-- Overlay -->
        <div
            class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/55 to-black/20"
        ></div>

        <!-- Content -->
        <div
            class="relative z-10 mx-auto flex min-h-[430px] w-full max-w-7xl items-center px-4 pt-20 sm:min-h-[500px] sm:px-6 sm:pt-24 lg:min-h-[560px] lg:px-8 lg:pt-20 xl:px-10"
        >

            <div class="w-full max-w-3xl text-white">

                <!-- Breadcrumb -->
                <div
                    class="mb-4 flex flex-wrap items-center gap-1.5 text-xs sm:mb-5 sm:gap-2 sm:text-sm"
                >

                    <Link
                        href="/"
                        class="transition hover:text-orange-400"
                    >
                        Home
                    </Link>

                    <span class="text-orange-400">
                        ›
                    </span>

                    <Link
                        href="/programs"
                        class="transition hover:text-orange-400"
                    >
                        Programs
                    </Link>

                    <span class="text-orange-400">
                        ›
                    </span>

                    <span class="font-medium text-orange-400">
                        Preschool
                    </span>

                </div>

                <h1
                    class="text-4xl font-bold leading-tight sm:text-5xl lg:text-6xl"
                >
                    Preschool Program
                </h1>

                <div
                    class="mb-4 mt-5 h-1 w-10 rounded-full bg-orange-500 sm:mb-5 sm:mt-6 sm:w-12"
                ></div>

                <p
                    class="max-w-2xl text-sm leading-6 text-gray-200 sm:text-base sm:leading-7 lg:text-xl lg:leading-8"
                >
                    A joyful start to learning, growing,
                    and discovering the world.
                </p>

            </div>

        </div>

    </section>


    <!-- ========================================================= -->
    <!-- ABOUT PRESCHOOL -->
    <!-- ========================================================= -->

    <section class="bg-white py-14 sm:py-16 lg:py-20">

        <div
            class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 xl:px-10"
        >

            <div
                class="grid grid-cols-1 items-center gap-10 lg:grid-cols-2 lg:gap-14 xl:gap-16"
            >

                <!-- Images -->
                <div class="w-full">

                    <div class="overflow-hidden rounded-2xl">

                        <img
                            src="/storage/images/preschool.jpg"
                            alt="Preschool students"
                            class="aspect-[4/3] w-full object-cover sm:aspect-[16/10] lg:aspect-[4/3]"
                        />

                    </div>

                    <!-- Slider Indicator -->
                    <div
                        class="mt-5 flex justify-center gap-2"
                    >

                        <span
                            class="h-2.5 w-2.5 rounded-full bg-orange-500"
                        ></span>

                        <span
                            class="h-2.5 w-2.5 rounded-full bg-gray-300"
                        ></span>

                        <span
                            class="h-2.5 w-2.5 rounded-full bg-gray-300"
                        ></span>

                        <span
                            class="h-2.5 w-2.5 rounded-full bg-gray-300"
                        ></span>

                    </div>

                </div>


                <!-- Content -->
                <div class="w-full">

                    <span
                        class="text-xs font-semibold uppercase tracking-[0.2em] text-orange-500 sm:text-sm"
                    >
                        About Preschool
                    </span>

                    <h2
                        class="mt-3 text-3xl font-bold leading-tight text-gray-900 sm:text-4xl"
                    >
                        A Joyful Beginning to Learning
                    </h2>

                    <div
                        class="mb-6 mt-5 h-1 w-12 rounded-full bg-orange-500"
                    ></div>

                    <div class="space-y-4">

                        <p
                            class="text-sm leading-7 text-gray-600 sm:text-base"
                        >
                            Our Preschool Program provides a safe,
                            nurturing, and engaging environment where
                            children build confidence, develop essential
                            skills, and love learning.
                        </p>

                        <p
                            class="text-sm leading-7 text-gray-600 sm:text-base"
                        >
                            Through play-based and student-centered
                            activities, we nurture each child's curiosity,
                            creativity, and character.
                        </p>

                    </div>


                    <!-- Features -->
                    <div
                        class="mt-8 grid grid-cols-2 gap-x-5 gap-y-8 sm:mt-10 sm:grid-cols-4 sm:gap-6"
                    >

                        <!-- Feature -->
                        <div class="text-center">

                            <Heart
                                class="mx-auto h-8 w-8 text-orange-500 sm:h-9 sm:w-9"
                                stroke-width="1.8"
                            />

                            <h3
                                class="mt-3 text-sm font-semibold leading-5 text-gray-800"
                            >
                                Safe & Caring
                            </h3>

                            <p
                                class="mt-2 text-xs leading-5 text-gray-500 sm:text-sm"
                            >
                                A warm, secure environment
                                for every child.
                            </p>

                        </div>


                        <!-- Feature -->
                        <div class="text-center">

                            <BookOpen
                                class="mx-auto h-8 w-8 text-orange-500 sm:h-9 sm:w-9"
                                stroke-width="1.8"
                            />

                            <h3
                                class="mt-3 text-sm font-semibold leading-5 text-gray-800"
                            >
                                Play-Based Learning
                            </h3>

                            <p
                                class="mt-2 text-xs leading-5 text-gray-500 sm:text-sm"
                            >
                                Learning through play,
                                exploration, and discovery.
                            </p>

                        </div>


                        <!-- Feature -->
                        <div class="text-center">

                            <Users
                                class="mx-auto h-8 w-8 text-orange-500 sm:h-9 sm:w-9"
                                stroke-width="1.8"
                            />

                            <h3
                                class="mt-3 text-sm font-semibold leading-5 text-gray-800"
                            >
                                Holistic Development
                            </h3>

                            <p
                                class="mt-2 text-xs leading-5 text-gray-500 sm:text-sm"
                            >
                                Supporting cognitive,
                                social, emotional, and physical growth.
                            </p>

                        </div>


                        <!-- Feature -->
                        <div class="text-center">

                            <Star
                                class="mx-auto h-8 w-8 text-orange-500 sm:h-9 sm:w-9"
                                stroke-width="1.8"
                            />

                            <h3
                                class="mt-3 text-sm font-semibold leading-5 text-gray-800"
                            >
                                Character Building
                            </h3>

                            <p
                                class="mt-2 text-xs leading-5 text-gray-500 sm:text-sm"
                            >
                                Cultivating kindness,
                                respect, and responsibility.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- ========================================================= -->
    <!-- OUR CLASSES -->
    <!-- ========================================================= -->

    <section class="bg-gray-50 py-14 sm:py-16 lg:py-20">

        <div
            class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8"
        >

            <!-- Heading -->
            <div
                class="mx-auto max-w-3xl text-center"
            >

                <span
                    class="text-xs font-semibold uppercase tracking-[0.2em] text-orange-500 sm:text-sm"
                >
                    Preschool Program
                </span>

                <h2
                    class="mt-3 text-3xl font-bold leading-tight text-gray-900 sm:text-4xl"
                >
                    Our Classes
                </h2>

                <p
                    class="mx-auto mt-4 max-w-2xl text-sm leading-6 text-gray-600 sm:text-base sm:leading-7"
                >
                    We offer age-appropriate classes designed
                    to support every stage of early childhood development.
                </p>

            </div>


            <!-- Classes -->
            <div
                class="mt-10 space-y-5 sm:mt-12 sm:space-y-6"
            >

                <!-- Nursery -->
                <div
                    class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-5 lg:p-6"
                >

                    <div
                        class="grid grid-cols-1 items-center gap-6 md:grid-cols-[280px_1fr] lg:grid-cols-[340px_1fr] lg:gap-8"
                    >

                        <img
                            src="/storage/images/preschool.jpg"
                            alt="Nursery"
                            class="aspect-[4/3] w-full rounded-xl object-cover"
                        />

                        <div>

                            <h3
                                class="text-2xl font-bold text-orange-500"
                            >
                                Nursery
                            </h3>

                            <div
                                class="mt-2 flex items-center gap-2 text-sm text-gray-600"
                            >

                                <UserRound
                                    class="h-4 w-4 shrink-0 text-orange-500"
                                />

                                Ages 1 – 2 Years

                            </div>

                            <p
                                class="mt-4 text-sm leading-7 text-gray-600 sm:text-base"
                            >
                                A gentle introduction to learning
                                through sensory play, music, movement,
                                and social interaction.
                            </p>

                            <ul class="mt-5 space-y-2">

                                <li class="flex gap-2 text-sm text-gray-600">
                                    <CheckCircle2
                                        class="mt-0.5 h-4 w-4 shrink-0 text-orange-500"
                                    />
                                    <span>
                                        Building early language skills
                                    </span>
                                </li>

                                <li class="flex gap-2 text-sm text-gray-600">
                                    <CheckCircle2
                                        class="mt-0.5 h-4 w-4 shrink-0 text-orange-500"
                                    />
                                    <span>
                                        Developing motor skills
                                    </span>
                                </li>

                                <li class="flex gap-2 text-sm text-gray-600">
                                    <CheckCircle2
                                        class="mt-0.5 h-4 w-4 shrink-0 text-orange-500"
                                    />
                                    <span>
                                        Encouraging independence
                                    </span>
                                </li>

                                <li class="flex gap-2 text-sm text-gray-600">
                                    <CheckCircle2
                                        class="mt-0.5 h-4 w-4 shrink-0 text-orange-500"
                                    />
                                    <span>
                                        Social & emotional growth
                                    </span>
                                </li>

                            </ul>

                            <Link
                                href="/programs/preschool"
                                class="mt-6 inline-flex items-center gap-2 rounded-full bg-orange-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-orange-600 sm:px-6 sm:py-3"
                            >
                                Learn More
                                <ArrowRight class="h-4 w-4" />
                            </Link>

                        </div>

                    </div>

                </div>


                <!-- Kindergarten -->
                <div
                    class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-5 lg:p-6"
                >

                    <div
                        class="grid grid-cols-1 items-center gap-6 md:grid-cols-[280px_1fr] lg:grid-cols-[340px_1fr] lg:gap-8"
                    >

                        <img
                            src="/storage/images/preschool.jpg"
                            alt="Kindergarten"
                            class="aspect-[4/3] w-full rounded-xl object-cover"
                        />

                        <div>

                            <h3
                                class="text-2xl font-bold text-orange-500"
                            >
                                Kindergarten A-B
                            </h3>

                            <div
                                class="mt-2 flex items-center gap-2 text-sm text-gray-600"
                            >

                                <UserRound
                                    class="h-4 w-4 shrink-0 text-orange-500"
                                />

                                Ages 3 – 5 Years

                            </div>

                            <p
                                class="mt-4 text-sm leading-7 text-gray-600 sm:text-base"
                            >
                                Preparing children for primary
                                education with hands-on learning
                                and creative exploration.
                            </p>

                            <ul class="mt-5 space-y-2">

                                <li class="flex gap-2 text-sm text-gray-600">
                                    <CheckCircle2
                                        class="mt-0.5 h-4 w-4 shrink-0 text-orange-500"
                                    />
                                    <span>
                                        Early literacy & numeracy
                                    </span>
                                </li>

                                <li class="flex gap-2 text-sm text-gray-600">
                                    <CheckCircle2
                                        class="mt-0.5 h-4 w-4 shrink-0 text-orange-500"
                                    />
                                    <span>
                                        Critical thinking & problem solving
                                    </span>
                                </li>

                                <li class="flex gap-2 text-sm text-gray-600">
                                    <CheckCircle2
                                        class="mt-0.5 h-4 w-4 shrink-0 text-orange-500"
                                    />
                                    <span>
                                        Creativity & self-expression
                                    </span>
                                </li>

                                <li class="flex gap-2 text-sm text-gray-600">
                                    <CheckCircle2
                                        class="mt-0.5 h-4 w-4 shrink-0 text-orange-500"
                                    />
                                    <span>
                                        Positive habits & character
                                    </span>
                                </li>

                            </ul>

                            <Link
                                href="/programs/preschool/kindergarten"
                                class="mt-6 inline-flex items-center gap-2 rounded-full bg-orange-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-orange-600 sm:px-6 sm:py-3"
                            >
                                Learn More
                                <ArrowRight class="h-4 w-4" />
                            </Link>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- ========================================================= -->
    <!-- FIELD TRIP + ACTIVITIES -->
    <!-- ========================================================= -->

    <section class="bg-white py-14 sm:py-16 lg:py-20">

        <div
            class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 xl:px-10"
        >

            <div
                class="grid grid-cols-1 gap-12 lg:grid-cols-2 lg:gap-16"
            >

                <!-- FIELD TRIP -->

                <div>

                    <h2
                        class="text-2xl font-bold text-gray-900 sm:text-3xl"
                    >
                        Field Trip
                    </h2>

                    <div
                        class="mb-5 mt-4 h-1 w-12 rounded-full bg-orange-500"
                    ></div>

                    <p
                        class="max-w-xl text-sm leading-7 text-gray-600 sm:text-base"
                    >
                        Field trips provide real-world experiences
                        that spark curiosity and broaden children's
                        understanding of the world.
                    </p>


                    <div
                        class="mt-8 grid grid-cols-3 gap-3 sm:gap-4"
                    >

                        <!-- Zoo -->
                        <div class="min-w-0">

                            <img
                                src="/storage/images/program.png"
                                class="aspect-[4/3] w-full rounded-xl object-cover"
                                alt="Surabaya Zoo"
                            />

                            <h4
                                class="mt-3 text-center text-xs font-semibold text-gray-700 sm:text-sm"
                            >
                                Surabaya Zoo
                            </h4>

                        </div>


                        <!-- Kids City -->
                        <div class="min-w-0">

                            <img
                                src="/storage/images/program.png"
                                class="aspect-[4/3] w-full rounded-xl object-cover"
                                alt="Kids City"
                            />

                            <h4
                                class="mt-3 text-center text-xs font-semibold text-gray-700 sm:text-sm"
                            >
                                Kids City
                            </h4>

                        </div>


                        <!-- Eco Green -->
                        <div class="min-w-0">

                            <img
                                src="/storage/images/program.png"
                                class="aspect-[4/3] w-full rounded-xl object-cover"
                                alt="Eco Green Park"
                            />

                            <h4
                                class="mt-3 text-center text-xs font-semibold text-gray-700 sm:text-sm"
                            >
                                Eco Green Park
                            </h4>

                        </div>

                    </div>


                    <div class="mt-8 text-center sm:text-left">

                        <Link
                            href="/programs/preschool/field-trips"
                            class="inline-flex items-center gap-2 rounded-full border border-orange-500 px-5 py-2.5 text-sm text-orange-500 transition hover:bg-orange-500 hover:text-white sm:px-6 sm:py-3"
                        >

                            View All Field Trips

                            <ArrowRight class="h-4 w-4" />

                        </Link>

                    </div>

                </div>


                <!-- ACTIVITIES -->

                <div>

                    <h2
                        class="text-2xl font-bold text-gray-900 sm:text-3xl"
                    >
                        Activities at School
                    </h2>

                    <div
                        class="mb-5 mt-4 h-1 w-12 rounded-full bg-orange-500"
                    ></div>

                    <p
                        class="max-w-xl text-sm leading-7 text-gray-600 sm:text-base"
                    >
                        Fun and meaningful activities that help
                        children learn, grow, and build wonderful
                        memories every day.
                    </p>


                    <div
                        class="mt-8 grid grid-cols-3 gap-3 sm:gap-4"
                    >

                        <!-- Art -->
                        <div class="min-w-0">

                            <img
                                src="/storage/images/program.png"
                                class="aspect-[4/3] w-full rounded-xl object-cover"
                                alt="Art and Craft"
                            />

                            <h4
                                class="mt-3 text-center text-xs font-semibold text-gray-700 sm:text-sm"
                            >
                                Art & Craft
                            </h4>

                        </div>


                        <!-- Music -->
                        <div class="min-w-0">

                            <img
                                src="/storage/images/program.png"
                                class="aspect-[4/3] w-full rounded-xl object-cover"
                                alt="Music and Movement"
                            />

                            <h4
                                class="mt-3 text-center text-xs font-semibold text-gray-700 sm:text-sm"
                            >
                                Music & Movement
                            </h4>

                        </div>


                        <!-- Story -->
                        <div class="min-w-0">

                            <img
                                src="/storage/images/program.png"
                                class="aspect-[4/3] w-full rounded-xl object-cover"
                                alt="Story Time"
                            />

                            <h4
                                class="mt-3 text-center text-xs font-semibold text-gray-700 sm:text-sm"
                            >
                                Story Time
                            </h4>

                        </div>

                    </div>


                    <div class="mt-8 text-center sm:text-left">

                        <Link
                            href="/programs/preschool/activities"
                            class="inline-flex items-center gap-2 rounded-full border border-orange-500 px-5 py-2.5 text-sm text-orange-500 transition hover:bg-orange-500 hover:text-white sm:px-6 sm:py-3"
                        >

                            View All Activities

                            <ArrowRight class="h-4 w-4" />

                        </Link>

                    </div>

                </div>

            </div>

        </div>

    </section>

</template>
<script setup>
import { Link } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue'

const images = [
    '/storage/images/field.png',
]

const offsetY = ref(0)

let ticking = false
let animationFrameId = null

const handleScroll = () => {
    if (ticking) return

    ticking = true

    animationFrameId = window.requestAnimationFrame(() => {
        offsetY.value = window.scrollY * 0.3
        ticking = false
    })
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll, { passive: true })
})

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll)

    if (animationFrameId !== null) {
        window.cancelAnimationFrame(animationFrameId)
    }
})
</script>

<template>
    <section
        class="relative isolate w-full
               h-[75svh] min-h-[520px] max-h-[850px]
               overflow-hidden
               sm:h-[80svh] sm:min-h-[580px]
               lg:h-[85vh] lg:min-h-[650px]
               2xl:max-h-[1000px]"
    >
        <!-- Background Image -->
        <div class="absolute inset-0 overflow-hidden">
            <img
                :src="images[0]"
                alt="Great Crystal School facilities"
                fetchpriority="high"
                :style="{
                    transform: `translate3d(0, ${offsetY}px, 0)`
                }"
                class="absolute -top-[15%] left-0
                       h-[130%] w-full
                       object-cover object-center
                       will-change-transform"
            />
        </div>

        <!-- Dark Overlay -->
        <div
            class="absolute inset-0 bg-black/55
                   sm:bg-black/60"
        ></div>

        <!-- Optional Gradient for Better Readability -->
        <div
            class="absolute inset-0
                   bg-gradient-to-r
                   from-black/40 via-black/20 to-transparent"
        ></div>

        <!-- Content -->
        <div
            class="relative z-10 mx-auto flex h-full w-full
                   max-w-[1600px] items-center
                   px-5 py-12
                   sm:px-8 sm:py-14
                   md:px-10
                   lg:px-12 lg:py-16
                   xl:px-16
                   2xl:px-20"
        >
            <div class="w-full max-w-4xl">
                <!-- Heading -->
                <h1
                    class="text-4xl font-black leading-[1.1]
                           tracking-tight text-white
                           sm:text-5xl
                           md:text-6xl
                           lg:mt-0 lg:text-7xl
                           xl:text-8xl"
                >
                    Our Facilities
                </h1>

                <!-- Description -->
                <p
                    class="mt-5 max-w-3xl
                           text-sm leading-6 text-gray-200
                           sm:mt-6 sm:text-base sm:leading-7
                           md:text-lg md:leading-8
                           lg:mt-7"
                >
                    Great Crystal School and Course Center provides a
                    complete academic journey through internationally
                    and nationally recognized programs across Preschool,
                    Primary, and Secondary.
                </p>

                <!-- Buttons -->
                <div
                    class="mt-7 flex w-full flex-col gap-3
                           sm:mt-8 sm:w-auto sm:flex-row sm:flex-wrap
                           sm:gap-4"
                >
                    <Link
                        href="/about"
                        class="inline-flex min-h-12 w-full
                               items-center justify-center gap-3
                               rounded-full bg-orange-500
                               px-6 py-3.5
                               text-center text-sm font-semibold text-white
                               transition duration-300
                               hover:bg-orange-600
                               focus-visible:outline-none
                               focus-visible:ring-2
                               focus-visible:ring-orange-300
                               focus-visible:ring-offset-2
                               focus-visible:ring-offset-black
                               sm:w-auto sm:px-7 sm:py-4
                               md:text-base"
                    >
                        <span>Explore Our School</span>

                        <svg
                            class="h-4 w-4 shrink-0 transition-transform
                                   duration-300 group-hover:translate-x-1"
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

                    <Link
                        href="/contact"
                        class="inline-flex min-h-12 w-full
                               items-center justify-center
                               rounded-full border border-white/80
                               px-6 py-3.5
                               text-center text-sm font-semibold text-white
                               transition duration-300
                               hover:bg-white hover:text-gray-900
                               focus-visible:outline-none
                               focus-visible:ring-2
                               focus-visible:ring-white
                               focus-visible:ring-offset-2
                               focus-visible:ring-offset-black
                               sm:w-auto sm:px-8 sm:py-4
                               md:text-base"
                    >
                        Contact Us
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
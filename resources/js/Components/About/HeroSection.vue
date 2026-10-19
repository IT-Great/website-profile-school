<script setup>
import { Link } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue'
import { ArrowRight } from 'lucide-vue-next'

const images = [
    '/storage/images/hero/hero1.png',
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
    window.addEventListener('scroll', handleScroll, {
        passive: true,
    })
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
        class="relative isolate flex h-[80svh] min-h-[540px] max-h-[950px]
               w-full items-center overflow-hidden
               sm:min-h-[600px]
               lg:h-[85vh] lg:min-h-[650px]
               xl:min-h-[700px]"
    >
        <!-- Background Image -->
        <div class="absolute inset-0 -z-20 overflow-hidden">
            <img
                :src="images[0]"
                alt="About Great Crystal School"
                fetchpriority="high"
                :style="{
                    transform: `translate3d(0, ${offsetY}px, 0)`
                }"
                class="absolute -top-[10%] left-0 h-[120%] w-full
                       object-cover object-center will-change-transform"
            />
        </div>

        <!-- Dark Overlay -->
        <div
            class="absolute inset-0 -z-10
                   bg-gradient-to-r from-black/75
                   via-black/55 to-black/30"
        ></div>

        <div
            class="absolute inset-0 -z-10
                   bg-gradient-to-t from-black/25
                   via-transparent to-black/10"
        ></div>

        <!-- Content Container -->
        <div
            class="mx-auto w-full max-w-[1600px]
                   px-5 py-14
                   sm:px-8 sm:py-16
                   md:px-10
                   lg:px-16 lg:py-20
                   xl:px-24
                   2xl:px-28"
        >
            <div class="w-full max-w-5xl">

                <!-- Heading -->
                <h1
                    class="text-4xl font-black leading-[1.12]
                           tracking-tight text-white
                           sm:text-5xl
                           md:text-6xl
                           lg:mt-4 lg:text-7xl
                           xl:text-8xl"
                >
                    About Us
                </h1>

                <!-- Description -->
                <p
                    class="mt-5 max-w-3xl text-sm leading-7 text-gray-200
                           sm:mt-6 sm:text-base sm:leading-8
                           md:text-lg
                           lg:text-xl"
                >
                    Great Crystal School and Course Center provides a
                    complete academic journey through internationally
                    and nationally recognized programs across Preschool,
                    Primary, and Secondary.
                </p>

                <!-- Action Buttons -->
                <div
                    class="mt-7 flex w-full flex-col gap-3
                           sm:mt-9 sm:w-auto sm:flex-row
                           sm:flex-wrap sm:gap-4"
                >
                    <Link
                        href="/about"
                        class="inline-flex min-h-12 w-full items-center
                               justify-center gap-3 rounded-full
                               bg-orange-500 px-7 py-3.5
                               text-sm font-semibold text-white
                               transition duration-300
                               hover:bg-orange-600
                               sm:w-auto sm:px-8
                               md:min-h-14 md:px-9 md:text-base"
                    >
                        Explore Our School

                        <ArrowRight class="h-5 w-5 shrink-0" />
                    </Link>

                    <Link
                        href="/contact"
                        class="inline-flex min-h-12 w-full items-center
                               justify-center rounded-full
                               border border-white/80
                               px-7 py-3.5 text-sm font-semibold text-white
                               transition duration-300
                               hover:border-white hover:bg-white
                               hover:text-gray-900
                               sm:w-auto sm:px-8
                               md:min-h-14 md:px-9 md:text-base"
                    >
                        Contact
                    </Link>
                </div>

            </div>
        </div>
    </section>
</template>
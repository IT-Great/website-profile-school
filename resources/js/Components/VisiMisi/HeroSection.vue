<script setup>
import { Link } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue'

const images = [
    '/storage/images/visimisi.png',
]

const offsetY = ref(0)

let ticking = false
let animationFrame = null

const handleScroll = () => {
    if (ticking) return

    ticking = true

    animationFrame = window.requestAnimationFrame(() => {
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

    if (animationFrame !== null) {
        window.cancelAnimationFrame(animationFrame)
    }
})
</script>

<template>
    <section
        class="relative isolate w-full overflow-hidden
               h-[75svh] min-h-[520px] max-h-[850px]
               sm:h-[80svh] sm:min-h-[580px]
               lg:h-[85vh] lg:min-h-[650px]
               2xl:max-h-[1000px]"
    >
        <!-- Background Image -->
        <div class="absolute inset-0 overflow-hidden">
            <img
                :src="images[0]"
                alt="Great Crystal School - Vision and Mission"
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
        <div class="absolute inset-0 bg-black/60"></div>

        <!-- Gradient Overlay -->
        <div
            class="absolute inset-0
                   bg-gradient-to-r
                   from-black/50 via-black/25 to-transparent"
        ></div>

        <!-- Content -->
        <div
            class="relative z-10 mx-auto flex h-full w-full
                   max-w-[1600px] items-center
                   px-5 py-12
                   sm:px-8
                   md:px-10
                   lg:px-14
                   xl:px-20
                   2xl:px-24"
        >
            <div class="w-full max-w-4xl">
                <!-- Heading -->
                <h1
                    class="text-4xl font-black leading-[1.15]
                           tracking-tight text-white
                           sm:text-5xl
                           md:text-6xl
                           lg:text-7xl
                           xl:text-8xl
                           2xl:text-9xl"
                >
                    Shining Today,
                    <br />
                    Leading Tomorrow
                </h1>

                <!-- Description -->
                <p
                    class="mt-5 max-w-2xl
                           text-sm leading-7 text-gray-200
                           sm:mt-6 sm:text-base sm:leading-8
                           md:text-lg
                           lg:max-w-3xl"
                >
                    Great Crystal School and Course Center provides a
                    complete academic journey through internationally
                    and nationally recognized programs across Preschool,
                    Primary, and Secondary.
                </p>

                <!-- Buttons -->
                <div
                    class="mt-7 flex w-full flex-col gap-3
                           min-[420px]:flex-row min-[420px]:flex-wrap
                           sm:mt-9 sm:gap-4"
                >
                    <Link
                        href="/about"
                        class="inline-flex min-h-12 w-full items-center
                               justify-center gap-3 rounded-full
                               bg-orange-500 px-6 py-3
                               text-sm font-semibold text-white
                               transition duration-300
                               hover:bg-orange-600
                               focus-visible:outline-none
                               focus-visible:ring-2
                               focus-visible:ring-orange-300
                               min-[420px]:w-auto
                               sm:min-h-14 sm:px-8 sm:py-4
                               sm:text-base"
                    >
                        Get to Know

                        <svg
                            class="h-4 w-4 shrink-0"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
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
                        class="inline-flex min-h-12 w-full items-center
                               justify-center rounded-full
                               border border-white/80 px-6 py-3
                               text-sm font-semibold text-white
                               transition duration-300
                               hover:bg-white hover:text-black
                               focus-visible:outline-none
                               focus-visible:ring-2
                               focus-visible:ring-white
                               min-[420px]:w-auto
                               sm:min-h-14 sm:px-8 sm:py-4
                               sm:text-base"
                    >
                        Contact
                    </Link>
                </div>
            </div>
        </div>

        <!-- Bottom Gradient -->
        <div
            class="pointer-events-none absolute inset-x-0 bottom-0
                   h-20 bg-gradient-to-t
                   from-black/20 to-transparent"
        ></div>
    </section>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 1s ease-in-out;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.fade-enter-to,
.fade-leave-from {
    opacity: 1;
}
</style>
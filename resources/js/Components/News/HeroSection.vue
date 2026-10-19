<script setup>
import { Link } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue'
import { ArrowRight } from 'lucide-vue-next'

const images = [
    '/storage/images/eventsnews.jpeg',
]

const offsetY = ref(0)

let ticking = false

const handleScroll = () => {
    if (!ticking) {
        window.requestAnimationFrame(() => {
            offsetY.value = window.scrollY * 0.3
            ticking = false
        })

        ticking = true
    }
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll, { passive: true })
})

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll)
})
</script>

<template>
    <section
        class="relative isolate flex min-h-[600px] h-[85svh] max-h-[1000px] w-full items-center overflow-hidden sm:min-h-[650px] sm:h-[85svh] lg:min-h-[700px] lg:h-screen"
    >
        <!-- Background Image -->
        <div class="absolute inset-0 -z-20 overflow-hidden">
            <img
                :src="images[0]"
                alt="Great Crystal School News"
                fetchpriority="high"
                :style="{
                    transform: `translate3d(0, ${offsetY}px, 0)`,
                }"
                class="absolute -top-[10%] left-0 h-[120%] w-full object-cover object-center will-change-transform"
            />
        </div>

        <!-- Dark Overlay -->
        <div
            class="absolute inset-0 -z-10 bg-gradient-to-r from-black/80 via-black/60 to-black/30"
        ></div>

        <!-- Additional Bottom Overlay -->
        <div
            class="absolute inset-0 -z-10 bg-gradient-to-t from-black/30 via-transparent to-black/10"
        ></div>

        <!-- Content Container -->
        <div
            class="mx-auto w-full max-w-[1600px] px-5 py-20 sm:px-8 md:px-10 lg:px-16 xl:px-24 2xl:px-28"
        >
            <div class="max-w-4xl">
                <!-- Eyebrow -->
                <p
                    class="text-xs font-semibold uppercase tracking-[3px] text-orange-400 sm:text-sm sm:tracking-[5px] md:tracking-[6px]"
                >
                    Great Crystal School
                </p>

                <!-- Heading -->
                <h1
                    class="mt-4 text-4xl font-black leading-[1.1] tracking-tight text-white sm:text-5xl md:text-6xl lg:mt-6 lg:text-7xl xl:text-8xl"
                >
                    News
                </h1>

                <!-- Description -->
                <p
                    class="mt-5 max-w-3xl text-sm leading-7 text-gray-200 sm:mt-6 sm:text-base sm:leading-8 md:text-lg lg:text-xl"
                >
                    Great Crystal School and Course Center provides a complete
                    academic journey through internationally and nationally
                    recognized programs across Preschool, Primary, and Secondary.
                </p>

                <!-- CTA Buttons -->
                <div
                    class="mt-7 flex w-full flex-col gap-3 sm:mt-9 sm:w-auto sm:flex-row sm:flex-wrap sm:gap-4"
                >
                    <Link
                        href="/about"
                        class="inline-flex min-h-12 w-full items-center justify-center gap-3 rounded-full bg-orange-500 px-7 py-3.5 text-sm font-semibold text-white transition duration-300 hover:bg-orange-600 sm:w-auto sm:px-8 md:min-h-14 md:px-9 md:text-base"
                    >
                        Get to Know
                        <ArrowRight class="h-5 w-5 shrink-0" />
                    </Link>

                    <Link
                        href="/contact"
                        class="inline-flex min-h-12 w-full items-center justify-center rounded-full border border-white/80 px-7 py-3.5 text-sm font-semibold text-white transition duration-300 hover:border-white hover:bg-white hover:text-gray-900 sm:w-auto sm:px-8 md:min-h-14 md:px-9 md:text-base"
                    >
                        Contact
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
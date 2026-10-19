```vue
<script setup>
import { Link } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue'

const images = [
    '/storage/images/hero/hero1.png',
    '/storage/images/hero/hero2.png',
    '/storage/images/hero/hero3.png',
    '/storage/images/hero/hero4.png',
]

const currentImage = ref(0)

let interval = null

onMounted(() => {
    interval = setInterval(() => {
        currentImage.value =
            (currentImage.value + 1) % images.length
    }, 5000)
})

onUnmounted(() => {
    if (interval) {
        clearInterval(interval)
    }
})
</script>

<template>
    <section
        class="relative min-h-[650px] h-[100svh] max-h-[1100px] overflow-hidden bg-gray-900"
    >
        <!-- Background Slideshow -->
        <div class="absolute inset-0">
            <transition name="fade">
                <img
                    :key="images[currentImage]"
                    :src="images[currentImage]"
                    alt="Great Crystal School"
                    fetchpriority="high"
                    class="absolute inset-0 h-full w-full object-cover object-center hero-image"
                />
            </transition>
        </div>

        <!-- Dark Overlay -->
        <div
            class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/55 to-black/20"
        ></div>

        <!-- Additional Overlay for Mobile Readability -->
        <div
            class="absolute inset-0 bg-black/15 md:bg-transparent"
        ></div>

        <!-- Hero Content -->
        <div
            class="relative z-10 mx-auto flex h-full w-full max-w-[1600px] items-center px-5 py-24 sm:px-8 md:px-12 lg:px-16 xl:px-20 2xl:px-24"
        >
            <div class="w-full max-w-4xl text-left">

                <!-- Heading -->
                <h1
                    class="mt-4 text-4xl font-black leading-[1.12] tracking-tight text-white sm:text-5xl md:text-6xl lg:text-7xl xl:text-8xl 2xl:text-9xl"
                >
                    Building Future
                    <br />
                    Global Leaders
                </h1>

                <!-- Description -->
                <p
                    class="mt-5 max-w-2xl text-sm leading-7 text-gray-200 sm:text-base sm:leading-8 md:mt-6 md:text-lg lg:text-xl"
                >
                    Great Crystal School provides a nurturing environment
                    for students to learn, grow, and achieve their dreams
                    through quality education and character building.
                </p>

                <!-- Action Buttons -->
                <div
                    class="mt-7 flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:gap-4 md:mt-9"
                >
                    <Link
                        href="/about"
                        class="inline-flex min-h-12 w-full items-center justify-center gap-3 rounded-full bg-orange-500 px-6 py-3 text-sm font-semibold text-white transition duration-300 hover:bg-orange-600 sm:w-auto sm:px-7 sm:py-4 md:min-h-14 md:px-8 md:text-base"
                    >
                        Explore Our School

                        <svg
                            class="h-4 w-4 shrink-0 transition-transform duration-300 group-hover:translate-x-1"
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
                        class="inline-flex min-h-12 w-full items-center justify-center rounded-full border border-white/80 px-6 py-3 text-sm font-semibold text-white transition duration-300 hover:bg-white hover:text-black sm:w-auto sm:px-7 sm:py-4 md:min-h-14 md:px-8 md:text-base"
                    >
                        Contact Us
                    </Link>
                </div>

            </div>
        </div>
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

.hero-image {
    animation: heroZoom 8s ease-in-out infinite alternate;
}

@keyframes heroZoom {
    from {
        transform: scale(1);
    }

    to {
        transform: scale(1.06);
    }
}

@media (prefers-reduced-motion: reduce) {
    .fade-enter-active,
    .fade-leave-active {
        transition: none;
    }

    .hero-image {
        animation: none;
    }
}
</style>
```

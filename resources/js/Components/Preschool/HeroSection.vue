<script setup>
import { Link } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue'

const images = [
    '/storage/images/eventsnews.jpeg',
]

const offsetY = ref(0)

const handleScroll = () => {
    if (!ticking) {
        window.requestAnimationFrame(() => {
            offsetY.value = window.scrollY * 0.5
            ticking = false
        })
        ticking = true
    }
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll)
})

let ticking = false


</script>

<template>

<section class="relative h-screen overflow-hidden px-16">

    <!-- Background -->

    <div class="absolute inset-0 overflow-hidden">

        <img
            :src="images[0]"
            :style="{ transform: `translateY(${offsetY}px)` }"
            class="absolute inset-0 w-full h-[120%] object-cover will-change-transform"
        >

    </div>

    <!-- Overlay -->

    <div class="absolute inset-0 bg-black/60"></div>

    <!-- Content -->

    <div
        class="relative z-10 max-w-7xl mx-auto h-full flex items-center px-24">

        <div class="w-full">

            <!-- <span
                class="uppercase tracking-[6px] text-orange-400 font-semibold">

                Welcome To

            </span>  -->

            <h1
                class="text-6xl lg:text-7xl font-black text-white mt-6 leading-tight">

                Preschool Programs at Great Crystal School and Course Center

            </h1>

            <p
                class="text-gray-200 mt-4 leading-8 text-lg">

               Great Crystal School and Course Center provides a complete academic journey through internationally and nationally recognized programs across Preschool, Primary, and Secondary.

            </p>

            <div class="flex gap-5 mt-4">

                <Link
                    href="/about"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-6 rounded-full lg:flex items-center gap-3">

                    Get to Know

                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </Link>

                <Link
                    href="/contact"
                    class="border border-white text-white px-8 py-6 rounded-full hover:bg-white hover:text-black">

                    Contact

                </Link>

            </div>

        </div>

    </div>

</section>

</template>

<style scoped>

.fade-enter-active,
.fade-leave-active{
    transition: opacity 1s ease-in-out;
}

.fade-enter-from,
.fade-leave-to{
    opacity:0;
}

.fade-enter-to,
.fade-leave-from{
    opacity:1;
}

</style>
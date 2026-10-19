```vue
<script setup>
import {
    ref,
    computed,
    onMounted,
    onUnmounted,
    nextTick,
} from 'vue'

const galleries = [
    { id: 1, image: 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800', alt: 'School sports activities' },
    { id: 2, image: 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=800', alt: 'Students learning in class' },
    { id: 3, image: 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=800', alt: 'School campus activities' },
    { id: 4, image: 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=800', alt: 'Reading and learning' },
    { id: 5, image: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=800', alt: 'Digital learning activities' },
    { id: 6, image: 'https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=800', alt: 'School events' },
    { id: 7, image: 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=800', alt: 'Classroom learning' },
    { id: 8, image: 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=800', alt: 'Students working together' },
]

// Jumlah gambar per grup
const groupSize = 5

const totalDots = computed(() =>
    Math.ceil(galleries.length / groupSize)
)

const scrollContainer = ref(null)
const slideRefs = ref([])
const activeDot = ref(0)

let observer = null

// Klik dot untuk menuju gambar pertama dalam grup
const goToDot = (dotIndex) => {
    const targetIndex = dotIndex * groupSize
    const el = slideRefs.value[targetIndex]

    if (!el) return

    el.scrollIntoView({
        behavior: 'smooth',
        inline: 'start',
        block: 'nearest',
    })

    activeDot.value = dotIndex
}

// Update pagination ketika galeri di-scroll
const setupObserver = () => {
    if (!scrollContainer.value) return

    observer = new IntersectionObserver(
        (entries) => {
            const visibleSlides = entries
                .filter(entry => entry.isIntersecting)
                .sort(
                    (a, b) =>
                        b.intersectionRatio - a.intersectionRatio
                )

            if (visibleSlides.length) {
                const index = Number(
                    visibleSlides[0].target.dataset.index
                )

                activeDot.value = Math.floor(index / groupSize)
            }
        },
        {
            root: scrollContainer.value,
            threshold: [0.3, 0.6, 0.9],
        }
    )

    slideRefs.value.forEach((el) => {
        if (el) observer.observe(el)
    })
}

onMounted(async () => {
    await nextTick()
    setupObserver()
})

onUnmounted(() => {
    if (observer) {
        observer.disconnect()
    }
})
</script>

<template>
    <section
        class="overflow-hidden bg-white py-12 sm:py-14 md:py-16 lg:py-20"
    >
        <div
            class="mx-auto w-full max-w-[1600px] px-5 sm:px-8 md:px-10 lg:px-12 xl:px-16 2xl:px-20"
        >
            <!-- Heading -->
            <div class="mb-7 sm:mb-8 md:mb-10">
                <span
                    class="text-xs font-semibold uppercase tracking-[2px] text-orange-500 sm:text-sm sm:tracking-[3px]"
                >
                    Gallery
                </span>

                <h2
                    class="mt-3 text-2xl font-bold leading-tight text-gray-900 sm:text-3xl md:text-4xl lg:text-5xl"
                >
                    Moments That Matter
                </h2>

                <p
                    class="mt-3 max-w-xl text-sm leading-6 text-gray-500 sm:text-base sm:leading-7"
                >
                    Explore memorable moments, inspiring activities,
                    and everyday experiences at Great Crystal School.
                </p>
            </div>

            <!-- Horizontal Gallery -->
            <div
                ref="scrollContainer"
                class="no-scrollbar flex snap-x snap-mandatory gap-3 overflow-x-auto scroll-smooth pb-2 sm:gap-4 md:gap-5"
            >
                <div
                    v-for="(gallery, index) in galleries"
                    :key="gallery.id"
                    :ref="el => slideRefs[index] = el"
                    :data-index="index"
                    class="group relative aspect-[4/3] w-[72%] shrink-0 snap-start overflow-hidden rounded-xl bg-gray-100 sm:w-[44%] sm:rounded-2xl md:w-[31%] lg:w-[24%] xl:w-[22%]"
                >
                    <img
                        :src="gallery.image"
                        :alt="gallery.alt"
                        loading="lazy"
                        class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                    />

                    <!-- Subtle Image Overlay -->
                    <div
                        class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-60 transition duration-300 group-hover:opacity-100"
                    ></div>
                </div>
            </div>

            <!-- Pagination Dots -->
            <div
                class="mt-6 flex items-center justify-center gap-2 sm:mt-8"
                aria-label="Gallery pagination"
            >
                <button
                    v-for="dot in totalDots"
                    :key="dot"
                    type="button"
                    @click="goToDot(dot - 1)"
                    class="flex min-h-8 min-w-8 items-center justify-center rounded-full"
                    :aria-label="`Go to gallery group ${dot}`"
                    :aria-current="activeDot === dot - 1 ? 'true' : undefined"
                >
                    <span
                        class="h-2 rounded-full transition-all duration-300"
                        :class="
                            activeDot === dot - 1
                                ? 'w-6 bg-orange-500'
                                : 'w-2 bg-gray-300 hover:bg-gray-400'
                        "
                    ></span>
                </button>
            </div>
        </div>
    </section>
</template>

<style scoped>
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

.no-scrollbar::-webkit-scrollbar {
    display: none;
}

@media (prefers-reduced-motion: reduce) {
    .no-scrollbar {
        scroll-behavior: auto;
    }

    .group img {
        transition: none;
    }
}
</style>
```

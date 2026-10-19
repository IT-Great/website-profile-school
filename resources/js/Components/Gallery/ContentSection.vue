<script setup>
import { ref, computed } from 'vue'
import {
    LayoutGrid,
    BookOpen,
    PartyPopper,
    Trophy,
    Palette,
    Bus,
    ChevronDown,
} from 'lucide-vue-next'

const categories = [
    { key: 'All', label: 'All Photos', icon: LayoutGrid },
    { key: 'Academic', label: 'Academic Activities', icon: BookOpen },
    { key: 'Events', label: 'Events & Celebrations', icon: PartyPopper },
    { key: 'Sports', label: 'Sports & Competitions', icon: Trophy },
    { key: 'Arts', label: 'Arts & Creativity', icon: Palette },
    { key: 'Field Trips', label: 'Field Trips', icon: Bus },
]

const activeCategory = ref('All')
const visibleCount = ref(12)

const photos = [
    {
        id: 1,
        category: 'Academic',
        image: 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?q=80&w=800',
        span: 'lg:col-span-4',
    },
    {
        id: 2,
        category: 'Events',
        image: 'https://images.unsplash.com/photo-1548438294-1ac2ef6cbea6?q=80&w=800',
        span: 'lg:col-span-4',
    },
    {
        id: 3,
        category: 'Academic',
        image: 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=800',
        span: 'lg:col-span-4',
    },
    {
        id: 4,
        category: 'Arts',
        image: 'https://images.unsplash.com/photo-1587616211892-b8a1b9a91b1a?q=80&w=800',
        span: 'lg:col-span-3',
    },
    {
        id: 5,
        category: 'Events',
        image: 'https://images.unsplash.com/photo-1509099836639-18ba1795216d?q=80&w=800',
        span: 'lg:col-span-6',
    },
    {
        id: 6,
        category: 'Sports',
        image: 'https://images.unsplash.com/photo-1551958219-acbc608c6377?q=80&w=800',
        span: 'lg:col-span-3',
    },
    {
        id: 7,
        category: 'Events',
        image: 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?q=80&w=800',
        span: 'lg:col-span-4',
    },
    {
        id: 8,
        category: 'Academic',
        image: 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=800',
        span: 'lg:col-span-4',
    },
    {
        id: 9,
        category: 'Arts',
        image: 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?q=80&w=800',
        span: 'lg:col-span-4',
    },
    {
        id: 10,
        category: 'Field Trips',
        image: 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800',
        span: 'lg:col-span-4',
    },
    {
        id: 11,
        category: 'Arts',
        image: 'https://images.unsplash.com/photo-1472162072942-cd5147eb3902?q=80&w=800',
        span: 'lg:col-span-4',
    },
    {
        id: 12,
        category: 'Academic',
        image: 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=800',
        span: 'lg:col-span-4',
    },
]

const filteredPhotos = computed(() => {
    if (activeCategory.value === 'All') return photos

    return photos.filter(
        photo => photo.category === activeCategory.value
    )
})

const visiblePhotos = computed(() =>
    filteredPhotos.value.slice(0, visibleCount.value)
)

const hasMore = computed(() =>
    visibleCount.value < filteredPhotos.value.length
)

const setCategory = (key) => {
    activeCategory.value = key
    visibleCount.value = 12
}

const loadMore = () => {
    visibleCount.value += 6
}
</script>

<template>
    <section class="bg-white py-10 sm:py-12 lg:py-16">
        <div
            class="mx-auto w-full max-w-[1600px] px-4
                   sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-20"
        >
            <!-- Filter Categories -->
            <div
                class="mb-6 rounded-2xl bg-orange-50 p-2
                       sm:mb-8 sm:p-3 lg:mb-10"
            >
                <div
                    class="flex items-center gap-2 overflow-x-auto
                           overscroll-x-contain pb-1
                           sm:flex-wrap sm:overflow-visible sm:pb-0
                           [scrollbar-width:none] [&::-webkit-scrollbar]:hidden"
                >
                    <button
                        v-for="cat in categories"
                        :key="cat.key"
                        type="button"
                        @click="setCategory(cat.key)"
                        :aria-pressed="activeCategory === cat.key"
                        class="inline-flex min-h-10 shrink-0 items-center
                               justify-center gap-2 rounded-xl px-3 py-2
                               text-xs font-medium transition duration-300
                               focus-visible:outline-none focus-visible:ring-2
                               focus-visible:ring-orange-500
                               sm:px-4 sm:text-sm"
                        :class="activeCategory === cat.key
                            ? 'bg-orange-500 text-white shadow-sm'
                            : 'text-gray-600 hover:bg-orange-100 hover:text-orange-600'"
                    >
                        <component
                            :is="cat.icon"
                            class="h-4 w-4 shrink-0"
                        />

                        <span>{{ cat.label }}</span>
                    </button>
                </div>
            </div>

            <!-- Photo Count -->
            <div
                v-if="filteredPhotos.length > 0"
                class="mb-4 flex items-center justify-between sm:mb-5"
            >
                <p class="text-sm text-gray-500">
                    Showing
                    <span class="font-semibold text-gray-800">
                        {{ visiblePhotos.length }}
                    </span>
                    of
                    <span class="font-semibold text-gray-800">
                        {{ filteredPhotos.length }}
                    </span>
                    photos
                </p>
            </div>

            <!-- Empty State -->
            <div
                v-if="filteredPhotos.length === 0"
                class="rounded-2xl bg-gray-50 px-4 py-16 text-center
                       text-sm text-gray-400 sm:py-20"
            >
                No photos in this category yet.
            </div>

            <!-- Responsive Gallery -->
            <div
                v-else
                class="grid grid-cols-2 gap-3
                       sm:grid-cols-6 sm:gap-4
                       lg:grid-cols-12 lg:gap-4
                       xl:gap-5"
            >
                <div
                    v-for="(photo, index) in visiblePhotos"
                    :key="photo.id"
                    class="group relative col-span-1 aspect-[4/3]
                           overflow-hidden rounded-xl bg-gray-100
                           sm:col-span-3 sm:rounded-2xl
                           lg:aspect-auto lg:h-56"
                    :class="[
                        photo.span,
                        index === 0 || index === 5
                            ? 'sm:col-span-6'
                            : '',
                        index === 4
                            ? 'lg:h-64'
                            : '',
                    ]"
                >
                    <img
                        :src="photo.image"
                        :alt="`${photo.category} photo ${photo.id}`"
                        loading="lazy"
                        class="h-full w-full object-cover
                               transition-transform duration-500
                               ease-out group-hover:scale-105"
                    />

                    <!-- Hover Overlay -->
                    <div
                        class="pointer-events-none absolute inset-0
                               bg-gradient-to-t from-black/35 via-transparent
                               to-transparent opacity-0 transition-opacity
                               duration-300 group-hover:opacity-100"
                    />

                    <!-- Category Label -->
                    <div
                        class="absolute bottom-0 left-0 right-0
                               translate-y-2 p-3 opacity-0
                               transition-all duration-300
                               group-hover:translate-y-0
                               group-hover:opacity-100
                               sm:p-4"
                    >
                        <span
                            class="inline-block rounded-full bg-white/90
                                   px-3 py-1 text-[10px] font-semibold
                                   text-gray-800 backdrop-blur-sm sm:text-xs"
                        >
                            {{ photo.category }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Load More -->
            <div
                v-if="hasMore"
                class="mt-8 flex justify-center sm:mt-10 lg:mt-12"
            >
                <button
                    type="button"
                    @click="loadMore"
                    class="inline-flex min-h-11 items-center justify-center
                           gap-2 rounded-full border border-orange-300
                           px-6 py-3 text-sm font-semibold text-orange-500
                           transition duration-300
                           hover:border-orange-500 hover:bg-orange-500
                           hover:text-white
                           focus-visible:outline-none focus-visible:ring-2
                           focus-visible:ring-orange-500
                           focus-visible:ring-offset-2
                           sm:min-h-12 sm:px-8 sm:text-base"
                >
                    Load More Photos

                    <ChevronDown class="h-4 w-4 shrink-0" />
                </button>
            </div>
        </div>
    </section>
</template>
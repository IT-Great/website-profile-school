<script setup>
import { ref, computed } from 'vue'
import {
    Search,
    CalendarDays,
    ArrowRight,
    ChevronLeft,
    ChevronRight,
} from 'lucide-vue-next'

const filters = ['All', 'News', 'Events', 'Activities', 'Achievements']
const activeFilter = ref('All')
const searchQuery = ref('')
const currentPage = ref(1)
const perPage = 9

const posts = [
    {
        id: 1,
        category: 'Events',
        badge: 'EVENT',
        date: 'May 20, 2024',
        title: 'Learning Carnival 2024',
        description: 'A fun and educational day filled with games, performances, and exciting competitions for all students.',
        image: 'https://images.unsplash.com/photo-1472162072942-cd5147eb3902?q=80&w=600',
        url: '/news/detail',
    },
    {
        id: 2,
        category: 'News',
        badge: 'NEWS',
        date: 'May 15, 2024',
        title: 'GCS Students Win Top Awards',
        description: 'Our students achieved excellent results in the National Science Competition 2024.',
        image: 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=600',
        url: '/news/detail',
    },
    {
        id: 3,
        category: 'Activities',
        badge: 'ACTIVITY',
        date: 'May 10, 2024',
        title: 'Science Experiment Day',
        description: 'Hands-on learning experiences that spark curiosity and creativity in our young scientists.',
        image: 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?q=80&w=600',
        url: '/news/detail',
    },
    {
        id: 4,
        category: 'Events',
        badge: 'EVENT',
        date: 'May 01, 2024',
        title: 'Baby Crawl Competition',
        description: 'An exciting event for our little ones to explore, move, and have fun in a safe environment.',
        image: 'https://images.unsplash.com/photo-1587616211892-b8a1b9a91b1a?q=80&w=600',
        url: '/news/detail',
    },
    {
        id: 5,
        category: 'News',
        badge: 'NEWS',
        date: 'Apr 28, 2024',
        title: 'GCS CSR: Sharing & Caring',
        description: 'Our students and teachers visited an orphanage to share love and bring happiness.',
        image: 'https://images.unsplash.com/photo-1509099836639-18ba1795216d?q=80&w=600',
        url: '/news/detail',
    },
    {
        id: 6,
        category: 'Activities',
        badge: 'ACTIVITY',
        date: 'Apr 25, 2024',
        title: 'Reading Week',
        description: 'A week full of reading activities, storytelling, and book discussions to build a reading habit.',
        image: 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=600',
        url: '/news/detail',
    },
    {
        id: 7,
        category: 'Achievements',
        badge: 'ACHIEVEMENT',
        date: 'Apr 20, 2024',
        title: 'Outstanding Achievement',
        description: 'Congratulations to our student for winning Gold Medal in Mathematics Olympiad.',
        image: 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?q=80&w=600',
        url: '/news/detail',
    },
    {
        id: 8,
        category: 'Events',
        badge: 'EVENT',
        date: 'Apr 18, 2024',
        title: 'Student Showcase: Joy of Playland',
        description: 'A spectacular performance by our students showcasing their talents and creativity.',
        image: 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?q=80&w=600',
        url: '/news/detail',
    },
    {
        id: 9,
        category: 'News',
        badge: 'NEWS',
        date: 'Apr 12, 2024',
        title: 'Digital Learning Workshop',
        description: 'Teachers joined a workshop to enhance digital learning strategies in the classroom.',
        image: 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=600',
        url: '/news/detail',
    },
]

const filteredPosts = computed(() => {
    let result = posts

    if (activeFilter.value !== 'All') {
        result = result.filter(
            post => post.category === activeFilter.value
        )
    }

    const query = searchQuery.value.trim().toLowerCase()

    if (query) {
        result = result.filter(post =>
            post.title.toLowerCase().includes(query) ||
            post.description.toLowerCase().includes(query) ||
            post.category.toLowerCase().includes(query)
        )
    }

    return result
})

const totalPages = computed(() =>
    Math.max(1, Math.ceil(filteredPosts.value.length / perPage))
)

const paginatedPosts = computed(() => {
    const start = (currentPage.value - 1) * perPage
    return filteredPosts.value.slice(start, start + perPage)
})

const setFilter = (filter) => {
    activeFilter.value = filter
    currentPage.value = 1
}

const goToPage = (page) => {
    if (page < 1 || page > totalPages.value) return
    currentPage.value = page
}

const visiblePages = computed(() => {
    const total = totalPages.value
    const current = currentPage.value
    const pages = []

    if (total <= 5) {
        for (let i = 1; i <= total; i++) {
            pages.push(i)
        }
    } else {
        pages.push(1)

        if (current > 3) pages.push('...')

        const start = Math.max(2, current - 1)
        const end = Math.min(total - 1, current + 1)

        for (let i = start; i <= end; i++) {
            pages.push(i)
        }

        if (current < total - 2) pages.push('...')

        pages.push(total)
    }

    return pages
})

const badgeColor = {
    EVENT: 'bg-white/95 text-gray-900',
    NEWS: 'bg-white/95 text-gray-900',
    ACTIVITY: 'bg-white/95 text-gray-900',
    ACHIEVEMENT: 'bg-white/95 text-gray-900',
}
</script>

<template>
    <section class="bg-white py-8 sm:py-10 lg:py-14">
        <!-- Responsive Container -->
        <div
            class="mx-auto w-full max-w-[1600px] px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-20"
        >
            <!-- Filter & Search -->
            <div
                class="mb-7 flex flex-col gap-5 sm:mb-9 lg:mb-10 lg:flex-row lg:items-center lg:justify-between"
            >
                <!-- Category Filters -->
                <div class="flex flex-wrap items-center gap-2">
                    <button
                        v-for="filter in filters"
                        :key="filter"
                        type="button"
                        @click="setFilter(filter)"
                        class="rounded-full px-4 py-2.5 text-xs font-semibold transition duration-200 sm:px-5 sm:text-sm"
                        :class="
                            activeFilter === filter
                                ? 'bg-orange-500 text-white shadow-sm'
                                : 'bg-orange-50 text-gray-600 hover:bg-orange-100 hover:text-orange-600'
                        "
                    >
                        {{ filter }}
                    </button>
                </div>

                <!-- Search -->
                <form
                    class="flex w-full items-center gap-2 sm:max-w-md lg:w-72 lg:shrink-0"
                    @submit.prevent="currentPage = 1"
                >
                    <div class="relative min-w-0 flex-1">
                        <Search
                            class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"
                        />

                        <input
                            v-model="searchQuery"
                            @input="currentPage = 1"
                            type="search"
                            placeholder="Search events, news..."
                            aria-label="Search news and events"
                            class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-10 pr-4 text-sm text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        />
                    </div>

                    <button
                        type="submit"
                        aria-label="Search"
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-orange-500 text-white transition hover:bg-orange-600"
                    >
                        <Search class="h-4 w-4" />
                    </button>
                </form>
            </div>

            <!-- Result Count -->
            <div
                class="mb-5 flex flex-wrap items-center justify-between gap-2 sm:mb-6"
            >
                <p class="text-xs text-gray-500 sm:text-sm">
                    Showing
                    <span class="font-semibold text-gray-900">
                        {{ paginatedPosts.length }}
                    </span>
                    of
                    <span class="font-semibold text-gray-900">
                        {{ filteredPosts.length }}
                    </span>
                    articles
                </p>

                <p
                    v-if="activeFilter !== 'All'"
                    class="rounded-full bg-orange-50 px-3 py-1 text-xs font-medium text-orange-600"
                >
                    {{ activeFilter }}
                </p>
            </div>

            <!-- Empty State -->
            <div
                v-if="paginatedPosts.length === 0"
                class="rounded-2xl border border-dashed border-gray-200 px-5 py-16 text-center sm:py-20"
            >
                <div
                    class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-orange-50"
                >
                    <Search class="h-6 w-6 text-orange-500" />
                </div>

                <h3 class="mt-4 text-lg font-bold text-gray-900">
                    No results found
                </h3>

                <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                    Try another keyword or select a different category.
                </p>

                <button
                    type="button"
                    @click="
                        searchQuery = '';
                        setFilter('All')
                    "
                    class="mt-5 rounded-full bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-600"
                >
                    Clear Filters
                </button>
            </div>

            <!-- News Cards -->
            <div
                v-else
                class="grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3 lg:gap-6 xl:gap-7"
            >
                <article
                    v-for="post in paginatedPosts"
                    :key="post.id"
                    class="group flex min-w-0 flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white transition duration-300 hover:-translate-y-1 hover:shadow-xl"
                >
                    <!-- Image -->
                    <div
                        class="relative aspect-[16/10] w-full overflow-hidden bg-gray-100 sm:aspect-[4/3] lg:aspect-[16/10]"
                    >
                        <img
                            :src="post.image"
                            :alt="post.title"
                            loading="lazy"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                        />

                        <span
                            class="absolute left-3 top-3 rounded-md px-3 py-1.5 text-[10px] font-bold tracking-wider shadow-sm sm:left-4 sm:top-4 sm:text-xs"
                            :class="badgeColor[post.badge]"
                        >
                            {{ post.badge }}
                        </span>
                    </div>

                    <!-- Card Content -->
                    <div class="flex flex-1 flex-col p-4 sm:p-5 lg:p-6">
                        <!-- Date -->
                        <div
                            class="flex items-center gap-2 text-xs text-gray-500 sm:text-sm"
                        >
                            <CalendarDays
                                class="h-4 w-4 shrink-0 text-orange-500"
                            />

                            <span>{{ post.date }}</span>
                        </div>

                        <!-- Title -->
                        <h3
                            class="mt-3 text-base font-bold leading-snug text-gray-900 transition group-hover:text-orange-600 sm:text-lg"
                        >
                            {{ post.title }}
                        </h3>

                        <!-- Description -->
                        <p
                            class="mt-2 line-clamp-3 text-sm leading-6 text-gray-500"
                        >
                            {{ post.description }}
                        </p>

                        <!-- Read More -->
                        <div class="mt-auto pt-5">
                            <a
                                :href="post.url"
                                class="inline-flex items-center gap-2 text-sm font-semibold text-orange-500 transition-all hover:gap-3 hover:text-orange-600"
                            >
                                Read More
                                <ArrowRight class="h-4 w-4" />
                            </a>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Pagination -->
            <nav
                v-if="totalPages > 1"
                aria-label="News pagination"
                class="mt-10 flex flex-wrap items-center justify-center gap-1.5 sm:mt-14 sm:gap-2"
            >
                <!-- Previous -->
                <button
                    type="button"
                    @click="goToPage(currentPage - 1)"
                    :disabled="currentPage === 1"
                    aria-label="Previous page"
                    class="flex h-9 w-9 items-center justify-center rounded-full border border-gray-200 text-gray-500 transition hover:bg-orange-50 hover:text-orange-600 disabled:cursor-not-allowed disabled:opacity-40 sm:h-10 sm:w-10"
                >
                    <ChevronLeft class="h-4 w-4" />
                </button>

                <!-- Page Numbers -->
                <template
                    v-for="(page, index) in visiblePages"
                    :key="`${page}-${index}`"
                >
                    <span
                        v-if="page === '...'"
                        class="flex h-9 w-7 items-center justify-center text-sm text-gray-400 sm:h-10 sm:w-8"
                    >
                        ...
                    </span>

                    <button
                        v-else
                        type="button"
                        @click="goToPage(page)"
                        :aria-label="`Go to page ${page}`"
                        :aria-current="currentPage === page ? 'page' : undefined"
                        class="flex h-9 w-9 items-center justify-center rounded-full text-xs font-semibold transition sm:h-10 sm:w-10 sm:text-sm"
                        :class="
                            currentPage === page
                                ? 'bg-orange-500 text-white shadow-sm'
                                : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600'
                        "
                    >
                        {{ page }}
                    </button>
                </template>

                <!-- Next -->
                <button
                    type="button"
                    @click="goToPage(currentPage + 1)"
                    :disabled="currentPage === totalPages"
                    aria-label="Next page"
                    class="flex h-9 w-9 items-center justify-center rounded-full border border-gray-200 text-gray-500 transition hover:bg-orange-50 hover:text-orange-600 disabled:cursor-not-allowed disabled:opacity-40 sm:h-10 sm:w-10"
                >
                    <ChevronRight class="h-4 w-4" />
                </button>
            </nav>
        </div>
    </section>
</template>
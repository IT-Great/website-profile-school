<script setup>
import { ref, computed, onMounted } from 'vue'
import {
    Trophy,
    Medal,
    Users,
    Star,
    Play,
    Award,
    Camera,
    Sparkles,
    ChevronDown,
} from 'lucide-vue-next'

const stats = [
    {
        icon: Trophy,
        number: '320+',
        label: 'Awards Won',
        sub: 'Academic & Non Academic',
    },
    {
        icon: Medal,
        number: '150+',
        label: 'Competitions',
        sub: 'Local, National & International',
    },
    {
        icon: Users,
        number: '98%',
        label: 'Student Participation',
        sub: 'Active in Various Events',
    },
    {
        icon: Star,
        number: '45+',
        label: 'Championships',
        sub: 'Team & Individual',
    },
]

// medal: gold | silver | bronze | award
const achievements = [
    {
        medal: 'silver',
        id: 1,
        image: '/images/achievements/01-wushu.jpg',
        title: 'Silver Medal',
        description: 'Wushu Championship',
    },
    {
        medal: 'gold',
        id: 2,
        image: '/images/achievements/02-osn-math.jpg',
        title: 'Gold Medal',
        description: 'OSN (Mathematics) organized by Puspresnas',
    },
    {
        medal: 'gold',
        id: 3,
        image: '/images/achievements/03-osn-english.jpg',
        title: 'Gold Medal',
        description: 'OSN (English) organized by Puspresnas',
    },
    {
        medal: 'bronze',
        id: 4,
        image: '/images/achievements/04-science-2025.jpg',
        title: '3rd Place',
        description: 'Student Science Competition 2025',
    },
    {
        medal: 'bronze',
        id: 5,
        image: '/images/achievements/05-cmli-cup.jpg',
        title: 'Bronze Medal',
        description: 'CMLI Cup National Youth Championship 2025 (U-16)',
    },
    {
        medal: 'silver',
        id: 6,
        image: '/images/achievements/06-foksi-english.jpg',
        title: 'Silver Medal',
        description: 'FOKSI English Olympiad Level 3 (Provincial Level)',
    },
    {
        medal: 'silver',
        id: 7,
        image: '/images/achievements/07-foksi-math.jpg',
        title: 'Silver Medal',
        description: 'FOKSI Mathematics Olympiad Level 3 (Provincial Level)',
    },
    {
        medal: 'silver',
        id: 8,
        image: '/images/achievements/08-foksi-science.jpg',
        title: 'Silver Medal',
        description: 'FOKSI Science Olympiad Level 3 (Provincial Level)',
    },
    {
        medal: 'silver',
        id: 9,
        image: '/images/achievements/09-iqaae-english.jpg',
        title: 'Silver Medal',
        description: 'IQAAE English Olympiad (Provincial Level)',
    },
    {
        medal: 'award',
        id: 10,
        image: '/images/achievements/10-mandarin.jpg',
        title: 'Mandarin Proficiency Championship 2025',
        description: 'Level 1: Yayasan Achievement Award',
    },
    {
        medal: 'gold',
        id: 11,
        image: '/images/achievements/11-ideagym.jpg',
        title: '1st Place',
        description:
            'Ideagym (Fun Active Classes U11) in Mayor of Surabaya Cup East 2025',
    },
    {
        medal: 'bronze',
        id: 12,
        image: '/images/achievements/12-fun-catic.jpg',
        title: '3rd Place Winner',
        description: 'Fun Catic Jr. Under 13-E DMT',
    },
]

const medalStyles = {
    gold: {
        label: 'Gold',
        badge: 'bg-amber-100 text-amber-800 ring-amber-200',
        icon: 'bg-gradient-to-br from-amber-300 to-amber-500 text-white',
    },
    silver: {
        label: 'Silver',
        badge: 'bg-slate-100 text-slate-700 ring-slate-200',
        icon: 'bg-gradient-to-br from-slate-300 to-slate-500 text-white',
    },
    bronze: {
        label: 'Bronze',
        badge: 'bg-orange-100 text-orange-800 ring-orange-200',
        icon: 'bg-gradient-to-br from-orange-400 to-orange-700 text-white',
    },
    award: {
        label: 'Award',
        badge: 'bg-rose-100 text-rose-800 ring-rose-200',
        icon: 'bg-gradient-to-br from-rose-400 to-rose-600 text-white',
    },
}

const filters = [
    { value: 'all', label: 'All' },
    { value: 'gold', label: 'Gold' },
    { value: 'silver', label: 'Silver' },
    { value: 'bronze', label: 'Bronze' },
    { value: 'award', label: 'Award' },
]

const activeFilter = ref('all')
const showAll = ref(false)
const INITIAL_COUNT = 6

// ---- Dokumentasi per penghargaan (hover di daftar -> tampil di kartu kiri) ----
const DEFAULT_IMAGE =
    'https://images.unsplash.com/photo-1567427017947-545c5f8d16ad?q=80&w=800'

const activeId = ref(null)
const failedImages = ref(new Set())

const activeItem = computed(
    () => achievements.find((item) => item.id === activeId.value) ?? null,
)

function hasImage(item) {
    return Boolean(item.image) && !failedImages.value.has(item.id)
}

const heroImage = computed(() =>
    activeItem.value && hasImage(activeItem.value)
        ? activeItem.value.image
        : DEFAULT_IMAGE,
)

function markFailed(id) {
    failedImages.value.add(id)
}

function onHeroError() {
    if (activeItem.value && heroImage.value === activeItem.value.image) {
        markFailed(activeItem.value.id)
    }
}

function onListFocusOut(event) {
    if (!event.currentTarget.contains(event.relatedTarget)) {
        activeId.value = null
    }
}

// Preload di layar besar supaya pergantian gambar saat hover terasa mulus,
// sekaligus mendeteksi file dokumentasi yang belum tersedia.
onMounted(() => {
    if (!window.matchMedia('(min-width: 1024px)').matches) return

    achievements.forEach((item) => {
        if (!item.image) return
        const img = new Image()
        img.onerror = () => markFailed(item.id)
        img.src = item.image
    })
})

const filtered = computed(() =>
    activeFilter.value === 'all'
        ? achievements
        : achievements.filter((item) => item.medal === activeFilter.value),
)

const visible = computed(() =>
    showAll.value ? filtered.value : filtered.value.slice(0, INITIAL_COUNT),
)

function countFor(value) {
    return value === 'all'
        ? achievements.length
        : achievements.filter((item) => item.medal === value).length
}

function setFilter(value) {
    activeFilter.value = value
    showAll.value = false
    activeId.value = null
}
</script>

<template>
    <section class="overflow-hidden bg-gradient-to-b from-orange-50/60 via-white to-white">
        <!-- ============ HERO + STATS ============ -->
        <div class="relative">
            <div
                class="pointer-events-none absolute -right-24 -top-24 h-72 w-72
                       rounded-full bg-orange-200/40 blur-3xl"
                aria-hidden="true"
            ></div>
            <div
                class="pointer-events-none absolute -left-24 top-40 h-64 w-64
                       rounded-full bg-amber-200/40 blur-3xl"
                aria-hidden="true"
            ></div>

            <div
                class="relative mx-auto w-full max-w-[1400px]
                       px-4 pb-10 pt-12 sm:px-6 sm:pt-16 lg:px-12 lg:pt-20"
            >
                <div class="mx-auto max-w-3xl text-center">
                    <span
                        class="inline-flex items-center gap-2 rounded-full
                               bg-orange-100 px-3 py-1 text-xs font-semibold
                               uppercase tracking-widest text-orange-700"
                    >
                        <Sparkles class="h-3.5 w-3.5" aria-hidden="true" />
                        Great Crystal School
                    </span>

                    <h1
                        class="mt-4 text-3xl font-extrabold leading-tight
                               tracking-tight text-gray-900
                               sm:text-4xl lg:text-5xl"
                    >
                        Student
                        <span
                            class="bg-gradient-to-r from-orange-500 to-amber-500
                                   bg-clip-text text-transparent"
                        >
                            Achievements
                        </span>
                    </h1>

                    <p
                        class="mt-4 text-sm leading-6 text-gray-600
                               sm:text-base sm:leading-7"
                    >
                        Student achievement measures the strength of academic
                        excellence and the skills gained through various
                        competitions, activities, and programs at Great
                        Crystal School.
                    </p>
                </div>

                <!-- Stats -->
                <dl
                    class="mt-10 grid grid-cols-2 gap-3 sm:gap-4
                           lg:mt-14 lg:grid-cols-4 lg:gap-6"
                >
                    <div
                        v-for="stat in stats"
                        :key="stat.label"
                        class="group relative overflow-hidden rounded-2xl
                               border border-orange-100 bg-white p-4 shadow-sm
                               transition duration-300
                               hover:-translate-y-1 hover:shadow-lg
                               sm:p-6"
                    >
                        <div
                            class="flex h-10 w-10 items-center justify-center
                                   rounded-xl bg-orange-100 text-orange-600
                                   transition duration-300
                                   group-hover:bg-orange-500
                                   group-hover:text-white sm:h-12 sm:w-12"
                        >
                            <component
                                :is="stat.icon"
                                class="h-5 w-5 sm:h-6 sm:w-6"
                                aria-hidden="true"
                            />
                        </div>

                        <dd
                            class="mt-4 text-3xl font-extrabold tracking-tight
                                   text-gray-900 sm:text-4xl"
                        >
                            {{ stat.number }}
                        </dd>
                        <dt class="mt-1 text-sm font-semibold text-gray-800">
                            {{ stat.label }}
                        </dt>
                        <p class="mt-0.5 text-xs leading-5 text-gray-500 sm:text-sm">
                            {{ stat.sub }}
                        </p>
                    </div>
                </dl>
            </div>
        </div>

        <!-- ============ ACHIEVEMENTS 2025 ============ -->
        <div
            class="mx-auto w-full max-w-[1400px]
                   px-4 py-10 sm:px-6 lg:px-12 lg:py-16"
        >
            <div
                class="grid grid-cols-1 items-start gap-6
                       lg:grid-cols-[minmax(0,0.8fr)_minmax(0,1.6fr)] xl:gap-10"
            >
                <!-- Highlight card: berubah mengikuti penghargaan yang di-hover -->
                <div
                    class="relative flex min-h-[260px] flex-col justify-end
                           overflow-hidden rounded-3xl bg-orange-600 p-6
                           sm:min-h-[300px] sm:p-8
                           lg:sticky lg:top-6 lg:min-h-[480px]"
                >
                    <Transition name="doc-fade">
                        <img
                            :key="heroImage"
                            :src="heroImage"
                            :alt="
                                activeItem
                                    ? `Documentation: ${activeItem.description}`
                                    : 'Trophy representing student achievements'
                            "
                            class="absolute inset-0 h-full w-full object-cover"
                            :class="
                                activeItem && hasImage(activeItem)
                                    ? 'opacity-100'
                                    : 'opacity-50'
                            "
                            @error="onHeroError"
                        />
                    </Transition>

                    <div
                        class="absolute inset-0 bg-gradient-to-t transition-colors duration-500"
                        :class="
                            activeItem && hasImage(activeItem)
                                ? 'from-orange-900/90 via-orange-800/30 to-transparent'
                                : 'from-orange-700 via-orange-600/60 to-orange-500/10'
                        "
                    ></div>

                    <div class="relative z-10">
                        <Transition name="doc-text" mode="out-in">
                            <!-- Detail penghargaan yang di-hover -->
                            <div v-if="activeItem" :key="activeItem.id">
                                <span
                                    class="inline-flex items-center gap-1.5
                                           rounded-full bg-white/20 px-3 py-1
                                           text-xs font-semibold uppercase
                                           tracking-widest text-white
                                           backdrop-blur"
                                >
                                    <Camera class="h-3.5 w-3.5" aria-hidden="true" />
                                    Documentation
                                </span>

                                <h2
                                    class="mt-4 text-2xl font-extrabold
                                           leading-tight text-white sm:text-3xl"
                                >
                                    {{ activeItem.title }}
                                </h2>

                                <p
                                    class="mt-2 max-w-sm text-sm leading-6
                                           text-orange-50 sm:text-base"
                                >
                                    {{ activeItem.description }}
                                </p>

                                <p
                                    v-if="!hasImage(activeItem)"
                                    class="mt-3 text-xs text-orange-100"
                                >
                                    Photo documentation is not available yet.
                                </p>
                            </div>

                            <!-- Tampilan awal -->
                            <div v-else key="default">
                                <span
                                    class="inline-flex items-center gap-1.5
                                           rounded-full bg-white/20 px-3 py-1
                                           text-xs font-semibold uppercase
                                           tracking-widest text-white
                                           backdrop-blur"
                                >
                                    <Award class="h-3.5 w-3.5" aria-hidden="true" />
                                    School Achievements
                                </span>

                                <h2
                                    class="mt-4 text-3xl font-extrabold
                                           leading-tight text-white sm:text-4xl"
                                >
                                    Achievements in 2025
                                </h2>

                                <p
                                    class="mt-3 max-w-sm text-sm leading-6
                                           text-orange-50 sm:text-base sm:leading-7"
                                >
                                    Great Crystal School continues to achieve
                                    excellence through dedication, innovation,
                                    and a commitment to quality education.
                                </p>

                                <p class="mt-5 text-sm font-semibold text-white">
                                    {{ achievements.length }} highlighted wins
                                </p>
                                <p class="mt-1 text-xs text-orange-100">
                                    Hover or tap an achievement to see its
                                    documentation.
                                </p>
                            </div>
                        </Transition>
                    </div>
                </div>

                <!-- List -->
                <div class="min-w-0">
                    <!-- Filter chips -->
                    <div
                        class="-mx-4 flex gap-2 overflow-x-auto px-4 pb-1
                               sm:mx-0 sm:flex-wrap sm:overflow-visible sm:px-0"
                        role="group"
                        aria-label="Filter achievements by medal"
                    >
                        <button
                            v-for="filter in filters"
                            :key="filter.value"
                            type="button"
                            :aria-pressed="activeFilter === filter.value"
                            class="inline-flex shrink-0 items-center gap-2
                                   rounded-full border px-4 py-2 text-sm
                                   font-medium transition
                                   focus-visible:outline-none
                                   focus-visible:ring-2
                                   focus-visible:ring-orange-500
                                   focus-visible:ring-offset-2"
                            :class="
                                activeFilter === filter.value
                                    ? 'border-orange-500 bg-orange-500 text-white shadow'
                                    : 'border-gray-200 bg-white text-gray-600 hover:border-orange-300 hover:text-orange-600'
                            "
                            @click="setFilter(filter.value)"
                        >
                            {{ filter.label }}
                            <span
                                class="rounded-full px-1.5 text-xs"
                                :class="
                                    activeFilter === filter.value
                                        ? 'bg-white/25'
                                        : 'bg-gray-100 text-gray-500'
                                "
                            >
                                {{ countFor(filter.value) }}
                            </span>
                        </button>
                    </div>

                    <!-- Cards -->
                    <ul
                        class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4"
                        @mouseleave="activeId = null"
                        @focusout="onListFocusOut"
                    >
                        <li
                            v-for="item in visible"
                            :key="item.id"
                            tabindex="0"
                            class="group flex min-w-0 cursor-pointer gap-4
                                   rounded-2xl border bg-white p-4 shadow-sm
                                   transition duration-300
                                   hover:-translate-y-0.5 hover:border-orange-200
                                   hover:shadow-md
                                   focus-visible:outline-none
                                   focus-visible:ring-2
                                   focus-visible:ring-orange-500 sm:p-5"
                            :class="
                                activeId === item.id
                                    ? 'border-orange-300 shadow-md'
                                    : 'border-gray-100'
                            "
                            @mouseenter="activeId = item.id"
                            @focus="activeId = item.id"
                            @click="activeId = item.id"
                        >
                            <div
                                class="flex h-11 w-11 shrink-0 items-center
                                       justify-center rounded-xl shadow-sm"
                                :class="medalStyles[item.medal].icon"
                            >
                                <Medal class="h-5 w-5" aria-hidden="true" />
                            </div>

                            <div class="min-w-0 flex-1">
                                <span
                                    class="inline-block rounded-full px-2 py-0.5
                                           text-[11px] font-semibold uppercase
                                           tracking-wide ring-1 ring-inset"
                                    :class="medalStyles[item.medal].badge"
                                >
                                    {{ medalStyles[item.medal].label }}
                                </span>

                                <h3
                                    class="mt-2 break-words text-sm font-bold
                                           leading-snug text-gray-900 sm:text-base"
                                >
                                    {{ item.title }}
                                </h3>
                                <p
                                    class="mt-1 break-words text-sm leading-6
                                           text-gray-600"
                                >
                                    {{ item.description }}
                                </p>
                            </div>

                            <!-- Thumbnail dokumentasi (mobile/tablet; di desktop tampil di kartu kiri) -->
                            <img
                                v-if="hasImage(item)"
                                :src="item.image"
                                :alt="`Documentation: ${item.description}`"
                                loading="lazy"
                                class="h-16 w-16 shrink-0 self-center
                                       rounded-lg object-cover lg:hidden"
                                @error="markFailed(item.id)"
                            />
                        </li>
                    </ul>

                    <p
                        v-if="!filtered.length"
                        class="mt-5 rounded-2xl border border-dashed
                               border-gray-200 p-8 text-center text-sm
                               text-gray-500"
                    >
                        No achievements in this category yet.
                    </p>

                    <div
                        v-if="filtered.length > INITIAL_COUNT"
                        class="mt-6 flex justify-center"
                    >
                        <button
                            type="button"
                            class="inline-flex min-h-11 items-center gap-2
                                   rounded-full border border-orange-200
                                   bg-white px-5 py-2.5 text-sm font-semibold
                                   text-orange-600 transition
                                   hover:bg-orange-50
                                   focus-visible:outline-none
                                   focus-visible:ring-2
                                   focus-visible:ring-orange-500
                                   focus-visible:ring-offset-2"
                            :aria-expanded="showAll"
                            @click="showAll = !showAll"
                        >
                            {{ showAll ? 'Show less' : `Show all ${filtered.length}` }}
                            <ChevronDown
                                class="h-4 w-4 transition-transform"
                                :class="{ 'rotate-180': showAll }"
                                aria-hidden="true"
                            />
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============ ALUMNI ============ -->
        <div
            class="mx-auto w-full max-w-[1400px]
                   px-4 pb-14 sm:px-6 lg:px-12 lg:pb-24"
        >
            <div class="mx-auto max-w-3xl text-center">
                <span
                    class="inline-flex items-center gap-2 rounded-full
                           bg-orange-100 px-3 py-1 text-xs font-semibold
                           uppercase tracking-widest text-orange-700"
                >
                    Alumni
                </span>

                <h2
                    class="mt-4 text-2xl font-extrabold tracking-tight
                           text-gray-900 sm:text-3xl lg:text-4xl"
                >
                    Alumni
                    <span
                        class="bg-gradient-to-r from-orange-500 to-amber-500
                               bg-clip-text text-transparent"
                    >
                        Achievements
                    </span>
                </h2>

                <p class="mt-4 text-sm leading-6 text-gray-600 sm:text-base sm:leading-7">
                    Our alumni continue to make their mark in various fields
                    and inspire the next generation of Great Crystal students.
                </p>
            </div>

            <!-- Video banner -->
            <div
                class="group relative mt-8 flex flex-col overflow-hidden
                       rounded-3xl bg-gradient-to-br from-amber-400
                       via-orange-500 to-orange-600 shadow-xl sm:mt-10
                       lg:min-h-[340px] lg:flex-row lg:items-stretch"
            >
                <!-- Decorative shapes -->
                <div
                    class="pointer-events-none absolute -left-16 -top-16 h-56
                           w-56 rounded-full bg-white/10"
                    aria-hidden="true"
                ></div>
                <div
                    class="pointer-events-none absolute -bottom-20 left-1/3
                           h-64 w-64 rounded-full bg-white/10"
                    aria-hidden="true"
                ></div>

                <!-- Text -->
                <div
                    class="relative z-10 flex min-w-0 flex-1 flex-col
                           items-start justify-center px-6 py-8 sm:px-10
                           sm:py-12 lg:px-14"
                >
                    <p class="text-xs font-semibold uppercase tracking-widest text-white/90 sm:text-sm">
                        Great Crystal School &amp; Course Center
                    </p>

                    <h3
                        class="mt-3 text-4xl font-extrabold leading-[1.05]
                               text-white drop-shadow sm:text-5xl lg:text-6xl"
                    >
                        Great Alumni
                        <span class="block text-orange-50/90">Talks</span>
                    </h3>

                    <p class="mt-4 max-w-md text-sm leading-6 text-white/90 sm:text-base">
                        Hear real stories from graduates about their journey
                        after Great Crystal.
                    </p>

                    <button
                        type="button"
                        class="mt-6 inline-flex min-h-11 items-center
                               justify-center gap-2 rounded-full bg-white
                               px-6 py-3 text-sm font-semibold text-orange-600
                               shadow-lg transition duration-300
                               hover:scale-105 hover:bg-orange-50
                               focus-visible:outline-none
                               focus-visible:ring-2 focus-visible:ring-white
                               focus-visible:ring-offset-2
                               focus-visible:ring-offset-orange-500"
                    >
                        <span>Watch Now</span>
                        <Play class="h-4 w-4" fill="currentColor" aria-hidden="true" />
                    </button>
                </div>

                <!-- Photo -->
                <div
                    class="relative mx-4 mb-4 h-52 shrink-0 overflow-hidden
                           rounded-2xl sm:mx-6 sm:mb-6 sm:h-72
                           lg:m-4 lg:ml-0 lg:h-auto lg:w-[40%] lg:min-w-[300px]"
                >
                    <img
                        src="https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=800"
                        alt="Alumni speaker"
                        loading="lazy"
                        class="h-full w-full object-cover transition
                               duration-700 group-hover:scale-105"
                    />
                    <div
                        class="absolute inset-0 flex items-center
                               justify-center bg-black/15"
                    >
                        <span
                            class="flex h-16 w-16 items-center justify-center
                                   rounded-full bg-white/95 shadow-xl
                                   transition duration-300
                                   group-hover:scale-110 sm:h-20 sm:w-20"
                        >
                            <Play
                                class="ml-1 h-7 w-7 text-orange-500 sm:h-8 sm:w-8"
                                fill="currentColor"
                                aria-hidden="true"
                            />
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.doc-fade-enter-active,
.doc-fade-leave-active {
    transition: opacity 0.5s ease;
}

.doc-fade-enter-from,
.doc-fade-leave-to {
    opacity: 0;
}

.doc-text-enter-active,
.doc-text-leave-active {
    transition:
        opacity 0.2s ease,
        transform 0.2s ease;
}

.doc-text-enter-from,
.doc-text-leave-to {
    opacity: 0;
    transform: translateY(6px);
}

@media (prefers-reduced-motion: reduce) {
    .doc-fade-enter-active,
    .doc-fade-leave-active,
    .doc-text-enter-active,
    .doc-text-leave-active {
        transition: none;
    }
}
</style>
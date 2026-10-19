<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import {
    CalendarDays,
    UserRound,
    Clock3,
    ArrowLeft,
    ArrowRight,
    BookOpen,
    Search,
    Share2,
    Facebook,
    Instagram,
} from 'lucide-vue-next'
import { ref, computed } from 'vue'

const searchQuery = ref('')
const copied = ref(false)

const article = {
    category: 'School Activities',
    title: 'Student Showcase: Celebrating Creativity and Learning at Great Crystal School',
    excerpt:
        'Discover how our students develop confidence, creativity, and character through meaningful school activities and memorable learning experiences.',
    author: 'Great Crystal School',
    publishedAt: 'October 14, 2026',
    readTime: '5 min read',
    image: '/storage/images/news/student-showcase.jpg',
}

const relatedNews = [
    {
        category: 'Events',
        title: 'Learning Carnival: A Day of Discovery and Fun',
        date: 'October 8, 2026',
        image: '/storage/images/news/learning-carnival.jpg',
        href: '/news/learning-carnival',
    },
    {
        category: 'Achievements',
        title: 'Our Students Shine in Academic Competitions',
        date: 'September 28, 2026',
        image: '/storage/images/news/student-achievement.jpg',
        href: '/news/student-achievements',
    },
    {
        category: 'Activities',
        title: 'Exploring Science Through Hands-on Experiments',
        date: 'September 20, 2026',
        image: '/storage/images/news/science-experiment.jpg',
        href: '/news/science-experiment',
    },
]

const filteredNews = computed(() => {
    const query = searchQuery.value.trim().toLowerCase()

    if (!query) return relatedNews

    return relatedNews.filter((item) =>
        item.title.toLowerCase().includes(query) ||
        item.category.toLowerCase().includes(query)
    )
})

const shareArticle = async () => {
    const shareData = {
        title: article.title,
        text: article.excerpt,
        url: window.location.href,
    }

    try {
        if (navigator.share) {
            await navigator.share(shareData)
        } else {
            await navigator.clipboard.writeText(window.location.href)
            copied.value = true
            window.setTimeout(() => {
                copied.value = false
            }, 2000)
        }
    } catch (error) {
        if (error.name !== 'AbortError') {
            console.error('Unable to share article:', error)
        }
    }
}
</script>

<template>
    
<GuestLayout>
    <Head :title="`${article.title} | Great Crystal School`">
        <meta name="description" :content="article.excerpt" />
    </Head>

    <main class="min-h-screen bg-white pt-24 sm:pt-28 lg:pt-32">
        <div class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8 lg:pb-24">
            <!-- Breadcrumb -->
            <nav
                aria-label="Breadcrumb"
                class="mb-6 flex flex-wrap items-center gap-2 text-xs text-gray-500 sm:text-sm"
            >
                <Link href="/" class="transition hover:text-orange-500">
                    Home
                </Link>

                <span>/</span>

                <Link href="/news" class="transition hover:text-orange-500">
                    News
                </Link>

                <span>/</span>

                <span class="max-w-[220px] truncate font-medium text-orange-600 sm:max-w-sm">
                    {{ article.category }}
                </span>
            </nav>

            <!-- Main layout -->
            <div class="grid grid-cols-1 items-start gap-10 lg:grid-cols-12 lg:gap-12">
                <!-- Article -->
                <article class="min-w-0 lg:col-span-8">
                    <!-- Category -->
                    <div class="mb-4">
                        <span
                            class="inline-flex items-center rounded-full bg-orange-50 px-3 py-1.5 text-xs font-semibold text-orange-600"
                        >
                            {{ article.category }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h1
                        class="text-3xl font-bold leading-tight tracking-tight text-gray-900 sm:text-4xl lg:text-5xl"
                    >
                        {{ article.title }}
                    </h1>

                    <!-- Excerpt -->
                    <p class="mt-5 text-base leading-7 text-gray-600 sm:text-lg sm:leading-8">
                        {{ article.excerpt }}
                    </p>

                    <!-- Author / Date -->
                    <div
                        class="mt-6 flex flex-wrap items-center justify-between gap-4 border-b border-gray-100 pb-6"
                    >
                        <div class="flex min-w-0 items-center gap-3">
                            <div
                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-orange-100 text-orange-600"
                            >
                                <UserRound class="h-5 w-5" />
                            </div>

                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-gray-900">
                                    {{ article.author }}
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    Great Crystal School and Course Center
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-gray-500 sm:text-sm">
                            <span class="flex items-center gap-1.5">
                                <CalendarDays class="h-4 w-4 text-orange-500" />
                                {{ article.publishedAt }}
                            </span>

                            <span class="flex items-center gap-1.5">
                                <Clock3 class="h-4 w-4 text-orange-500" />
                                {{ article.readTime }}
                            </span>
                        </div>
                    </div>

                    <!-- Featured image -->
                    <figure class="mt-7 overflow-hidden rounded-2xl bg-gray-100">
                        <img
                            :src="article.image"
                            :alt="article.title"
                            class="aspect-[16/9] w-full object-cover"
                            @error="$event.target.style.display = 'none'"
                        />

                        <figcaption class="px-4 py-3 text-xs leading-5 text-gray-500 sm:px-5">
                            Learning, creativity, and memorable experiences at Great Crystal School.
                        </figcaption>
                    </figure>

                    <!-- Article body -->
                    <div
                        class="article-content mt-8 break-words text-base leading-8 text-gray-600 sm:mt-10 sm:text-[17px] sm:leading-9"
                    >
                        <p>
                            At Great Crystal School and Course Center, we believe that
                            every learning experience is an opportunity for students to
                            explore their potential. Through engaging activities and
                            meaningful experiences, students are encouraged to discover
                            their interests and express their creativity.
                        </p>

                        <p>
                            Our school provides a supportive environment where students
                            can learn, collaborate, and develop essential skills. Beyond
                            academic achievement, we focus on building confidence,
                            responsibility, communication, and respect for others.
                        </p>

                        <h2>
                            Learning Beyond the Classroom
                        </h2>

                        <p>
                            Learning becomes more meaningful when students can connect
                            their knowledge with real experiences. Classroom projects,
                            creative activities, experiments, and collaborative tasks
                            allow students to ask questions, solve problems, and learn
                            from one another.
                        </p>

                        <!-- Supporting image -->
                        <figure class="my-8 overflow-hidden rounded-2xl bg-gray-100">
                            <img
                                src="/storage/images/news/student-showcase-detail.jpg"
                                alt="Students participating in a school activity"
                                class="max-h-[520px] w-full object-cover"
                                @error="$event.target.style.display = 'none'"
                            />

                            <figcaption class="px-4 py-3 text-sm text-gray-500">
                                Students develop new skills through hands-on learning
                                and collaborative activities.
                            </figcaption>
                        </figure>

                        <h2>
                            Growing Together
                        </h2>

                        <p>
                            Every student has unique strengths, talents, and ways of
                            learning. By providing opportunities to participate, create,
                            and share ideas, we help students build a strong foundation
                            for their future.
                        </p>

                        <p>
                            We are grateful to our teachers, parents, and school
                            community for supporting these experiences. Together, we
                            continue to create a learning environment where every child
                            can grow, thrive, and feel proud of their achievements.
                        </p>

                        <blockquote>
                            Every learning experience is a chance to discover something
                            new, build confidence, and create a brighter future.
                        </blockquote>

                        <p>
                            Stay connected with Great Crystal School for more news,
                            student activities, school events, and stories from our
                            learning community.
                        </p>
                    </div>

                    <!-- Share -->
                    <div
                        class="mt-10 flex flex-wrap items-center justify-between gap-4 border-y border-gray-100 py-5"
                    >
                        <div>
                            <p class="text-sm font-semibold text-gray-900">
                                Share this article
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                Let others discover this story.
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                aria-label="Share article"
                                @click="shareArticle"
                                class="flex h-10 items-center gap-2 rounded-full border border-gray-200 px-4 text-sm text-gray-600 transition hover:border-orange-500 hover:bg-orange-50 hover:text-orange-600"
                            >
                                <Share2 class="h-4 w-4" />
                                {{ copied ? 'Link copied' : 'Share' }}
                            </button>

                            <a
                                :href="`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(typeof window !== 'undefined' ? window.location.href : '')}`"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Share on Facebook"
                                class="flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 text-gray-600 transition hover:border-orange-500 hover:bg-orange-50 hover:text-orange-600"
                            >
                                <Facebook class="h-4 w-4" />
                            </a>

                            <a
                                href="https://www.instagram.com/greatsch.id/"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Visit Great Crystal on Instagram"
                                class="flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 text-gray-600 transition hover:border-orange-500 hover:bg-orange-50 hover:text-orange-600"
                            >
                                <Instagram class="h-4 w-4" />
                            </a>
                        </div>
                    </div>

                    <!-- Back to news -->
                    <div class="mt-8">
                        <Link
                            href="/news"
                            class="inline-flex items-center gap-2 rounded-full border border-orange-200 px-5 py-3 text-sm font-semibold text-orange-600 transition hover:bg-orange-500 hover:text-white"
                        >
                            <ArrowLeft class="h-4 w-4" />
                            Back to News
                        </Link>
                    </div>
                </article>

                <!-- Sidebar -->
                <aside class="min-w-0 lg:col-span-4">
                    <div class="lg:sticky lg:top-28">
                        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                            <!-- Sidebar heading -->
                            <div class="border-b border-gray-100 p-5 sm:p-6">
                                <div class="flex items-center gap-2">
                                    <BookOpen class="h-5 w-5 text-orange-500" />

                                    <h2 class="text-lg font-bold text-gray-900">
                                        Related News
                                    </h2>
                                </div>

                                <p class="mt-2 text-sm leading-6 text-gray-500">
                                    Discover more stories from our school community.
                                </p>

                                <!-- Search -->
                                <div class="relative mt-4">
                                    <Search
                                        class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"
                                    />

                                    <input
                                        v-model="searchQuery"
                                        type="search"
                                        placeholder="Search news..."
                                        aria-label="Search related news"
                                        class="w-full rounded-xl border border-gray-200 py-2.5 pl-9 pr-3 text-sm outline-none transition placeholder:text-gray-400 focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                    />
                                </div>
                            </div>

                            <!-- Related news list -->
                            <div class="space-y-0">
                                <Link
                                    v-for="item in filteredNews"
                                    :key="item.title"
                                    :href="item.href"
                                    class="group flex gap-4 border-b border-gray-100 p-4 transition last:border-b-0 hover:bg-orange-50/50 sm:p-5"
                                >
                                    <div class="h-24 w-24 shrink-0 overflow-hidden rounded-xl bg-gray-100 sm:h-28 sm:w-28">
                                        <img
                                            :src="item.image"
                                            :alt="item.title"
                                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                            @error="$event.target.style.display = 'none'"
                                        />
                                    </div>

                                    <div class="flex min-w-0 flex-1 flex-col">
                                        <span class="text-[11px] font-semibold uppercase tracking-wide text-orange-500">
                                            {{ item.category }}
                                        </span>

                                        <h3 class="mt-1 line-clamp-3 text-sm font-semibold leading-5 text-gray-800 transition group-hover:text-orange-600">
                                            {{ item.title }}
                                        </h3>

                                        <span class="mt-auto pt-2 text-xs text-gray-400">
                                            {{ item.date }}
                                        </span>
                                    </div>
                                </Link>

                                <div
                                    v-if="filteredNews.length === 0"
                                    class="p-6 text-center"
                                >
                                    <p class="text-sm text-gray-500">
                                        No related news found.
                                    </p>
                                </div>
                            </div>

                            <!-- View all -->
                            <div class="border-t border-gray-100 p-5">
                                <Link
                                    href="/news"
                                    class="flex w-full items-center justify-center gap-2 rounded-full bg-orange-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-orange-600"
                                >
                                    View All News
                                    <ArrowRight class="h-4 w-4" />
                                </Link>
                            </div>
                        </div>

                        <!-- CTA -->
                        <div class="mt-6 rounded-2xl bg-orange-50 p-6">
                            <span class="text-xs font-semibold uppercase tracking-widest text-orange-500">
                                Great Crystal School
                            </span>

                            <h3 class="mt-2 text-xl font-bold leading-snug text-gray-900">
                                Discover a place to learn and grow.
                            </h3>

                            <p class="mt-3 text-sm leading-6 text-gray-600">
                                Explore our programs and discover learning opportunities
                                for every stage of your child's journey.
                            </p>

                            <Link
                                href="/programs"
                                class="mt-5 inline-flex items-center gap-2 font-semibold text-orange-600 transition hover:text-orange-700"
                            >
                                Explore Our Programs
                                <ArrowRight class="h-4 w-4" />
                            </Link>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </main>
</GuestLayout>  
</template>

<style scoped>
.article-content :deep(p) {
    margin-top: 1.25rem;
    margin-bottom: 1.25rem;
}

.article-content :deep(h2) {
    margin-top: 2.5rem;
    margin-bottom: 1rem;
    color: #111827;
    font-size: clamp(1.35rem, 2.5vw, 1.75rem);
    font-weight: 700;
    line-height: 1.35;
}

.article-content :deep(blockquote) {
    margin: 2rem 0;
    border-left: 4px solid #f97316;
    border-radius: 0 0.75rem 0.75rem 0;
    background: #fff7ed;
    padding: 1.25rem 1.5rem;
    color: #374151;
    font-size: 1.05rem;
    font-style: italic;
    line-height: 1.8;
}

.article-content :deep(img) {
    max-width: 100%;
    height: auto;
}

.article-content :deep(figure img[style*="display: none"]) {
    display: none;
}
</style>
```
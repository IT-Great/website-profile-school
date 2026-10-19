<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'

const props = defineProps({
    article: {
        type: Object,
        required: true,
    },
});

const formatDate = (date) => {
    if (!date) return '';

    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};
</script>

<template>
    <AdminLayout>
        <Head>
            <title>{{ article.title }}</title>

            <meta
                name="description"
                :content="article.excerpt || article.title"
            />
        </Head>

        <!-- Article Header -->
        <section class="bg-slate-50 py-16">
            <div class="mx-auto max-w-5xl px-6 lg:px-8">

                <!-- Back -->
                <Link
                    :href="route('admin.posts.index')"
                    class="mb-6 inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-blue-600"
                >
                    ← Back to News
                </Link>

                <!-- Category -->
                <div
                    v-if="article.category"
                    class="mb-4"
                >
                    <span
                        class="inline-flex rounded-full bg-blue-100 px-4 py-1.5 text-sm font-semibold text-blue-700"
                    >
                        {{ article.category.name }}
                    </span>
                </div>

                <!-- Title -->
                <h1
                    class="max-w-4xl text-3xl font-bold leading-tight text-slate-900 sm:text-4xl lg:text-5xl"
                >
                    {{ article.title }}
                </h1>

                <!-- Meta -->
                <div
                    class="mt-6 flex flex-wrap items-center gap-4 text-sm text-slate-500"
                >
                    <span v-if="article.published_at">
                        {{ formatDate(article.published_at) }}
                    </span>

                    <span v-if="article.author">
                        • {{ article.author.name }}
                    </span>
                </div>

            </div>
        </section>


        <!-- Featured Image -->
        <section
            v-if="article.featured_image"
            class="bg-white"
        >
            <div class="mx-auto max-w-5xl px-6 lg:px-8">

                <img
                    :src="`/storage/${article.featured_image}`"
                    :alt="article.title"
                    class="h-auto w-full rounded-2xl object-cover shadow-lg"
                />

            </div>
        </section>


        <!-- Article Content -->
        <section class="bg-white py-12">
            <div class="mx-auto max-w-4xl px-6 lg:px-8">

                <!-- Excerpt -->
                <div
                    v-if="article.excerpt"
                    class="mb-10 border-l-4 border-blue-500 pl-5 text-lg leading-relaxed text-slate-600"
                >
                    {{ article.excerpt }}
                </div>

                <!-- Summernote Content -->
                <article
                    class="article-content"
                    v-html="article.content"
                ></article>

            </div>
        </section>


        <!-- Back to News -->
        <section class="border-t bg-slate-50 py-10">
            <div class="mx-auto max-w-4xl px-6 text-center">

                <Link
                    :href="route('admin.posts.index')"
                    class="inline-flex items-center rounded-lg bg-blue-600 px-6 py-3 font-semibold text-white transition hover:bg-blue-700"
                >
                    ← Back to News
                </Link>

            </div>
        </section>

    </AdminLayout>
</template>


<style scoped>
.article-content {
    color: #334155;
    font-size: 17px;
    line-height: 1.8;
}

/* Paragraph */
.article-content :deep(p) {
    margin-bottom: 1.25rem;
}

/* Headings */
.article-content :deep(h1) {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-size: 2rem;
    font-weight: 700;
    line-height: 1.3;
    color: #0f172a;
}

.article-content :deep(h2) {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-size: 1.6rem;
    font-weight: 700;
    line-height: 1.4;
    color: #0f172a;
}

.article-content :deep(h3) {
    margin-top: 1.75rem;
    margin-bottom: 0.75rem;
    font-size: 1.3rem;
    font-weight: 700;
    color: #0f172a;
}

/* Links */
.article-content :deep(a) {
    color: #2563eb;
    text-decoration: underline;
}

.article-content :deep(a:hover) {
    color: #1d4ed8;
}

/* Images from Summernote */
.article-content :deep(img) {
    display: block;
    max-width: 100%;
    height: auto;
    margin: 2rem auto;
    border-radius: 0.75rem;
}

/* Lists */
.article-content :deep(ul) {
    margin-bottom: 1.25rem;
    padding-left: 1.75rem;
    list-style-type: disc;
}

.article-content :deep(ol) {
    margin-bottom: 1.25rem;
    padding-left: 1.75rem;
    list-style-type: decimal;
}

.article-content :deep(li) {
    margin-bottom: 0.5rem;
}

/* Blockquote */
.article-content :deep(blockquote) {
    margin: 2rem 0;
    padding: 1rem 1.5rem;
    border-left: 4px solid #3b82f6;
    background: #f8fafc;
    color: #475569;
    font-style: italic;
}

/* Tables */
.article-content :deep(table) {
    width: 100%;
    margin: 2rem 0;
    border-collapse: collapse;
    overflow: hidden;
}

.article-content :deep(th),
.article-content :deep(td) {
    padding: 0.75rem 1rem;
    border: 1px solid #e2e8f0;
}

.article-content :deep(th) {
    background: #f8fafc;
    font-weight: 600;
}

/* Horizontal line */
.article-content :deep(hr) {
    margin: 2rem 0;
    border: 0;
    border-top: 1px solid #e2e8f0;
}

/* Video */
.article-content :deep(iframe) {
    display: block;
    width: 100%;
    max-width: 100%;
    min-height: 400px;
    margin: 2rem auto;
    border: 0;
    border-radius: 0.75rem;
}
</style>

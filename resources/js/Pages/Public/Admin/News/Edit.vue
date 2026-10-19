<script setup>
import { computed, ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
});

const thumbnailInput = ref(null);

const form = useForm({
    category: props.post.category ?? 'news',
    title: props.post.title ?? '',
    excerpt: props.post.excerpt ?? '',
    content: props.post.content ?? '',
    thumbnail: null,
    published_at: props.post.published_at
        ? props.post.published_at.substring(0, 10)
        : '',
    is_featured: Boolean(props.post.is_featured),
    is_active: Boolean(props.post.is_active),
});

const previewImage = ref(
    props.post.thumbnail
        ? `/storage/${props.post.thumbnail}`
        : null
);

const categoryLabel = computed(() => {
    const categories = {
        news: 'NEWS',
        event: 'EVENT',
        activity: 'ACTIVITY',
        achievement: 'ACHIEVEMENT',
    };

    return categories[form.category] || 'NEWS';
});

const handleThumbnail = (event) => {
    const file = event.target.files[0];

    if (!file) {
        return;
    }

    form.thumbnail = file;

    previewImage.value = URL.createObjectURL(file);
};

const removeThumbnail = () => {
    form.thumbnail = null;

    previewImage.value = props.post.thumbnail
        ? `/storage/${props.post.thumbnail}`
        : null;

    if (thumbnailInput.value) {
        thumbnailInput.value.value = '';
    }
};

const submit = () => {
    form
        .transform((data) => ({
            ...data,
            _method: 'PUT',
        }))
        .post(
            route('admin.posts.update', props.post.id),
            {
                forceFormData: true,
                preserveScroll: true,

                onSuccess: () => {
                    // redirect dilakukan oleh controller
                },
            }
        );
};
</script>

<template>
    <Head :title="`Edit - ${post.title}`" />

    <AdminLayout>

        <div class="min-h-screen bg-slate-50">

            <!-- Header -->
            <div class="border-b border-slate-200 bg-white">
                <div class="px-6 py-5">

                    <div class="flex items-center justify-between gap-4">

                        <div>
                            <div class="flex items-center gap-3">

                                <Link
                                    :href="route('admin.posts.index')"
                                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:bg-slate-50 hover:text-slate-700"
                                >
                                    ←
                                </Link>

                                <div>
                                    <h1 class="text-xl font-bold text-slate-900">
                                        Edit Post
                                    </h1>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Update your news, event, activity, or achievement.
                                    </p>
                                </div>

                            </div>
                        </div>

                        <div class="flex items-center gap-3">

                            <Link
                                :href="route('admin.posts.index')"
                                class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                            >
                                Cancel
                            </Link>

                            <button
                                type="button"
                                @click="submit"
                                :disabled="form.processing"
                                class="rounded-lg bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600 disabled:cursor-not-allowed disabled:opacity-60"
                            >
                                <span v-if="form.processing">
                                    Saving...
                                </span>

                                <span v-else>
                                    Update Post
                                </span>
                            </button>

                        </div>

                    </div>

                </div>
            </div>


            <!-- Content -->
            <div class="px-6 py-6">

                <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

                    <!-- LEFT -->
                    <div class="space-y-6 xl:col-span-2">

                        <!-- Basic Information -->
                        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                            <div class="border-b border-slate-200 px-6 py-5">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-50 text-orange-500">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M12 20h9"
                                            />
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"
                                            />
                                        </svg>
                                    </div>

                                    <div>
                                        <h2 class="font-semibold text-slate-900">
                                            Basic Information
                                        </h2>

                                        <p class="text-sm text-slate-500">
                                            Update the basic information of this post.
                                        </p>
                                    </div>

                                </div>

                            </div>


                            <div class="space-y-5 p-6">

                                <!-- Category -->
                                <div>

                                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                                        Category
                                    </label>

                                    <select
                                        v-model="form.category"
                                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                    >
                                        <option value="news">
                                            News
                                        </option>

                                        <option value="event">
                                            Event
                                        </option>

                                        <option value="activity">
                                            Activity
                                        </option>

                                        <option value="achievement">
                                            Achievement
                                        </option>
                                    </select>

                                    <p
                                        v-if="form.errors.category"
                                        class="mt-1 text-sm text-red-500"
                                    >
                                        {{ form.errors.category }}
                                    </p>

                                </div>


                                <!-- Title -->
                                <div>

                                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                                        Title
                                    </label>

                                    <input
                                        v-model="form.title"
                                        type="text"
                                        placeholder="Enter post title..."
                                        class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                    />

                                    <p
                                        v-if="form.errors.title"
                                        class="mt-1 text-sm text-red-500"
                                    >
                                        {{ form.errors.title }}
                                    </p>

                                </div>


                                <!-- Excerpt -->
                                <div>

                                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                                        Excerpt
                                    </label>

                                    <textarea
                                        v-model="form.excerpt"
                                        rows="4"
                                        placeholder="Short description displayed on the news card..."
                                        class="w-full resize-none rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                    ></textarea>

                                    <div class="mt-1 flex justify-between">

                                        <p
                                            v-if="form.errors.excerpt"
                                            class="text-sm text-red-500"
                                        >
                                            {{ form.errors.excerpt }}
                                        </p>

                                        <span class="ml-auto text-xs text-slate-400">
                                            {{ form.excerpt?.length || 0 }} characters
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- Article Content -->
                        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                            <div class="border-b border-slate-200 px-6 py-5">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-50 text-orange-500">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h6l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2z"
                                            />
                                        </svg>
                                    </div>

                                    <div>
                                        <h2 class="font-semibold text-slate-900">
                                            Article Content
                                        </h2>

                                        <p class="text-sm text-slate-500">
                                            Write the complete content displayed on the detail page.
                                        </p>
                                    </div>

                                </div>

                            </div>

                            <div class="p-6">

                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Content
                                </label>

                                <textarea
                                    v-model="form.content"
                                    :height="500"
                                    placeholder="Write your article content here..."
                                />

                                <p
                                    v-if="form.errors.content"
                                    class="mt-2 text-sm text-red-500"
                                >
                                    {{ form.errors.content }}
                                </p>

                            </div>

                        </div>

                    </div>


                    <!-- RIGHT -->
                    <div class="space-y-6">

                        <!-- Publish Settings -->
                        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                            <div class="border-b border-slate-200 px-5 py-5">

                                <h2 class="font-semibold text-slate-900">
                                    Publish Settings
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Control when and how this post is displayed.
                                </p>

                            </div>

                            <div class="space-y-5 p-5">

                                <!-- Date -->
                                <div>

                                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                                        Published Date
                                    </label>

                                    <input
                                        v-model="form.published_at"
                                        type="date"
                                        class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-700 outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                    />

                                    <p
                                        v-if="form.errors.published_at"
                                        class="mt-1 text-sm text-red-500"
                                    >
                                        {{ form.errors.published_at }}
                                    </p>

                                </div>


                                <!-- Featured -->
                                <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-slate-200 p-4 hover:bg-slate-50">

                                    <input
                                        v-model="form.is_featured"
                                        type="checkbox"
                                        class="mt-0.5 h-4 w-4 rounded border-slate-300 text-orange-500 focus:ring-orange-500"
                                    />

                                    <div>
                                        <p class="text-sm font-semibold text-slate-800">
                                            Featured Post
                                        </p>

                                        <p class="mt-1 text-xs leading-5 text-slate-500">
                                            Highlight this post on the website.
                                        </p>
                                    </div>

                                </label>


                                <!-- Active -->
                                <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-slate-200 p-4 hover:bg-slate-50">

                                    <input
                                        v-model="form.is_active"
                                        type="checkbox"
                                        class="mt-0.5 h-4 w-4 rounded border-slate-300 text-orange-500 focus:ring-orange-500"
                                    />

                                    <div>
                                        <p class="text-sm font-semibold text-slate-800">
                                            Published / Active
                                        </p>

                                        <p class="mt-1 text-xs leading-5 text-slate-500">
                                            Make this post visible on the website.
                                        </p>
                                    </div>

                                </label>

                            </div>

                        </div>


                        <!-- Featured Image -->
                        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                            <div class="border-b border-slate-200 px-5 py-5">

                                <h2 class="font-semibold text-slate-900">
                                    Featured Image
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Image displayed on the news card.
                                </p>

                            </div>

                            <div class="p-5">

                                <input
                                    ref="thumbnailInput"
                                    type="file"
                                    accept="image/png,image/jpeg,image/webp"
                                    class="hidden"
                                    @change="handleThumbnail"
                                />

                                <!-- Preview -->
                                <div
                                    v-if="previewImage"
                                    class="relative overflow-hidden rounded-xl border border-slate-200"
                                >

                                    <img
                                        :src="previewImage"
                                        alt="Featured image"
                                        class="aspect-video w-full object-cover"
                                    />

                                    <div class="absolute inset-x-0 bottom-0 flex justify-between gap-2 bg-gradient-to-t from-black/70 to-transparent p-4 pt-10">

                                        <button
                                            type="button"
                                            @click="thumbnailInput?.click()"
                                            class="rounded-lg bg-white px-3 py-2 text-xs font-semibold text-slate-700 shadow hover:bg-slate-50"
                                        >
                                            Change Image
                                        </button>

                                        <button
                                            type="button"
                                            @click="removeThumbnail"
                                            class="rounded-lg bg-red-500 px-3 py-2 text-xs font-semibold text-white shadow hover:bg-red-600"
                                        >
                                            Remove
                                        </button>

                                    </div>

                                </div>


                                <!-- Upload -->
                                <button
                                    v-else
                                    type="button"
                                    @click="thumbnailInput?.click()"
                                    class="flex aspect-video w-full flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 transition hover:border-orange-300 hover:bg-orange-50/30"
                                >

                                    <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-white text-orange-500 shadow-sm">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-6 w-6"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M12 16V4m0 0l-4 4m4-4l4 4"
                                            />
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2"
                                            />
                                        </svg>
                                    </div>

                                    <span class="text-sm font-semibold text-slate-700">
                                        Upload Thumbnail
                                    </span>

                                    <span class="mt-1 text-xs text-slate-400">
                                        PNG, JPG or WEBP
                                    </span>

                                </button>

                                <p class="mt-3 text-xs text-slate-400">
                                    Recommended ratio 16:10. Maximum file size 5 MB.
                                </p>

                                <p
                                    v-if="form.errors.thumbnail"
                                    class="mt-2 text-sm text-red-500"
                                >
                                    {{ form.errors.thumbnail }}
                                </p>

                            </div>

                        </div>


                        <!-- Preview -->
                        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                            <div class="border-b border-slate-200 px-5 py-5">

                                <h2 class="font-semibold text-slate-900">
                                    Card Preview
                                </h2>

                            </div>

                            <div class="p-5">

                                <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

                                    <div class="relative">

                                        <img
                                            v-if="previewImage"
                                            :src="previewImage"
                                            alt="Preview"
                                            class="aspect-[16/10] w-full object-cover"
                                        />

                                        <div
                                            v-else
                                            class="flex aspect-[16/10] items-center justify-center bg-slate-100 text-slate-300"
                                        >
                                            No image
                                        </div>

                                        <span class="absolute left-3 top-3 rounded-md bg-white px-2 py-1 text-[10px] font-bold uppercase tracking-wide text-slate-700 shadow-sm">
                                            {{ categoryLabel }}
                                        </span>

                                    </div>

                                    <div class="p-4">

                                        <p class="text-xs font-medium text-orange-500">
                                            {{ form.published_at || 'Publication date' }}
                                        </p>

                                        <h3 class="mt-2 line-clamp-2 text-base font-bold text-slate-900">
                                            {{ form.title || 'Post title' }}
                                        </h3>

                                        <p class="mt-2 line-clamp-3 text-sm leading-6 text-slate-500">
                                            {{ form.excerpt || 'Post excerpt will appear here.' }}
                                        </p>

                                        <div class="mt-4 text-sm font-semibold text-orange-500">
                                            Read More →
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </AdminLayout>
</template>
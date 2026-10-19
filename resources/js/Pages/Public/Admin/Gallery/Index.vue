<script setup>
import { ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import {
    Pencil,
    Plus,
    Image as ImageIcon,
    Calendar,
    Trophy,
    Palette,
    Bus,
    BookOpen,
} from 'lucide-vue-next';

import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';

const props = defineProps({
    galleries: Object,

    filters: {
        type: Object,
        default: () => ({
            search: '',
            category: '',
            status: '',
        }),
    },
});

const search = ref(props.filters.search ?? '');
const category = ref(props.filters.category ?? '');
const status = ref(props.filters.status ?? '');

let timeout = null;

const applyFilter = () => {
    clearTimeout(timeout);

    timeout = setTimeout(() => {
        router.get(
            route('admin.galleries.index'),
            {
                search: search.value,
                category: category.value,
                status: status.value,
            },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
            }
        );
    }, 300);
};

watch(search, applyFilter);
watch(category, applyFilter);
watch(status, applyFilter);

const deleteGallery = (gallery) => {
    if (!confirm(`Delete gallery item "${gallery.title}"?`)) {
        return;
    }

    router.delete(
        route('admin.galleries.destroy', gallery.id),
        {
            preserveScroll: true,
        }
    );
};

// Helper format nama kategori
const formatCategory = (cat) => {
    const map = {
        academic: 'Academic Activities',
        events: 'Events & Celebrations',
        sports: 'Sports & Competitions',
        arts: 'Arts & Creativity',
        field_trips: 'Field Trips',
    };
    return map[cat] || cat;
};
</script>

<template>
    <Head title="Student Galleries" />

    <AdminLayout>
        <div class="min-h-screen bg-slate-50">
            <!-- HEADER -->
            <div class="border-b border-slate-200 bg-white">
                <div class="flex items-center justify-between px-6 py-5">
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">
                            Student Galleries
                        </h1>
                        <p class="mt-1 text-sm text-slate-500">
                            Manage student activities and event photos displayed on the website.
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <Link
                            :href="route('admin.edit.galleries.header')"
                            class="inline-flex items-center gap-2 rounded-xl bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-600"
                        >
                            <Pencil class="h-4 w-4" />
                            Edit Header
                        </Link>

                        <Link
                            :href="route('admin.galleries.create')"
                            class="inline-flex items-center gap-2 rounded-xl bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-600"
                        >
                            <Plus class="h-4 w-4" />
                            Add Gallery Item
                        </Link>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="mx-auto max-w-7xl">
                    <!-- FILTER -->
                    <div class="mb-6 rounded-xl border border-slate-200 bg-white p-4">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                            <!-- Search -->
                            <div class="md:col-span-2">
                                <input
                                    v-model="search"
                                    type="text"
                                    placeholder="Search gallery by title..."
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                />
                            </div>

                            <!-- Filter Category -->
                            <div>
                                <select
                                    v-model="category"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                >
                                    <option value="">All Categories</option>
                                    <option value="academic">Academic Activities</option>
                                    <option value="events">Events & Celebrations</option>
                                    <option value="sports">Sports & Competitions</option>
                                    <option value="arts">Arts & Creativity</option>
                                    <option value="field_trips">Field Trips</option>
                                </select>
                            </div>

                            <!-- Filter Status -->
                            <div>
                                <select
                                    v-model="status"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                >
                                    <option value="">All Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- CARDS -->
                    <div
                        v-if="galleries.data.length"
                        class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3"
                    >
                        <div
                            v-for="galleries in galleries.data"
                            :key="galleries.id"
                            class="group overflow-hidden rounded-xl border border-slate-200 bg-white transition hover:-translate-y-0.5 hover:shadow-md"
                        >
                            <!-- IMAGE -->
                            <div class="relative aspect-[16/9] overflow-hidden bg-slate-100">
                                 <img
                                    v-if="galleries.image_path"
                                    :src="`/storage/${galleries.image_path}`"
                                    :alt="galleries.title"
                                    class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                />

                                <div
                                    v-else
                                    class="flex h-full items-center justify-center text-slate-300"
                                >
                                    No Image
                                </div>

                                <!-- CATEGORY BADGE -->
                                <span class="absolute left-3 top-3 rounded-full bg-slate-900/60 px-3 py-1 text-xs font-medium text-white backdrop-blur-sm">
                                    {{ formatCategory(galleries.category) }}
                                </span>

                                <!-- STATUS BADGE -->
                                <span
                                    class="absolute right-3 top-3 rounded-full px-2.5 py-1 text-xs font-semibold"
                                    :class="
                                        galleries.status
                                            ? 'bg-green-100 text-green-700'
                                            : 'bg-slate-100 text-slate-500'
                                    "
                                >
                                    {{ galleries.status ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            <!-- CONTENT -->
                            <div class="p-5">
                                <h2 class="font-semibold text-slate-900 line-clamp-1">
                                    {{ galleries.title }}
                                </h2>

                                <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-500 min-h-[48px]">
                                    {{ galleries.description || 'No description provided.' }}
                                </p>

                                <!-- ACTIONS -->
                                <div class="mt-5 flex items-center justify-between border-t border-slate-100 pt-4">
                                    <span class="text-xs text-slate-400">
                                        Order: {{ galleries.sort_order }}
                                    </span>

                                    <div class="flex items-center gap-2">
                                        <Link
                                            :href="route('admin.galleries.edit', galleries.id)"
                                            class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50"
                                        >
                                            Edit
                                        </Link>

                                        <button
                                            type="button"
                                            @click="deleteGallery(item)"
                                            class="rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-100"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- EMPTY -->
                    <div
                        v-else
                        class="rounded-xl border border-dashed border-slate-300 bg-white py-20 text-center"
                    >
                        <div class="text-4xl">📸</div>

                        <h3 class="mt-4 font-semibold text-slate-800">
                            No gallery items found
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Start by adding your first student gallery activity.
                        </p>

                        <Link
                            :href="route('admin.galleries.create')"
                            class="mt-5 inline-block rounded-lg bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-600"
                        >
                            Add Gallery Item
                        </Link>
                    </div>

                    <!-- PAGINATION -->
                    <div
                        v-if="galleries.links?.length > 3"
                        class="mt-6 flex justify-center gap-1"
                    >
                        <template
                            v-for="(link, index) in galleries.links"
                            :key="index"
                        >
                            <Link
                                v-if="link.url"
                                :href="link.url"
                                preserve-scroll
                                class="rounded-lg px-3 py-2 text-sm"
                                :class="
                                    link.active
                                        ? 'bg-orange-500 text-white'
                                        : 'bg-white text-slate-600 hover:bg-slate-100'
                                "
                                v-html="link.label"
                            />
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
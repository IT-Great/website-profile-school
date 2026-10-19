<script setup>
import { ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import {
    Pencil,
    Plus,
    Trash2,
    BookOpen,
    AlignLeft,
    AlignRight,
    CheckCircle2,
} from 'lucide-vue-next';

import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';

const props = defineProps({
    curricula: Object,

    filters: {
        type: Object,
        default: () => ({
            search: '',
            status: '',
        }),
    },
});

const search = ref(props.filters.search ?? '');
const status = ref(props.filters.status ?? '');

let timeout = null;

const applyFilter = () => {
    clearTimeout(timeout);

    timeout = setTimeout(() => {
        router.get(
            route('admin.curriculum.index'),
            {
                search: search.value,
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
watch(status, applyFilter);

const deleteCurriculum = (item) => {
    if (!confirm(`Are you sure you want to delete "${item.title}"?`)) {
        return;
    }

    router.delete(route('admin.curriculum.destroy', item.id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Curriculum Management" />

    <AdminLayout>
        <div class="min-h-screen bg-slate-50">
            <!-- HEADER -->
            <div class="border-b border-slate-200 bg-white">
                <div class="flex items-center justify-between px-6 py-5">
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">
                            Curriculum Management
                        </h1>
                        <p class="mt-1 text-sm text-slate-500">
                            Manage curriculum blocks (Preschool, Primary, Secondary) displayed on the website.
                        </p>
                    </div>

                    <Link
                        :href="
                            route(
                                'admin.edit.curriculum.header'
                            )
                        "
                        class="inline-flex
                            items-center gap-2
                            rounded-xl
                            bg-orange-500
                            px-5 py-3
                            text-sm
                            font-semibold
                            text-white
                            hover:bg-orange-600"
                    >

                        <Pencil class="h-4 w-4" />

                        Edit Header
                    </Link>

                    <Link
                        :href="route('admin.curriculum.create')"
                        class="inline-flex items-center gap-2 rounded-xl bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-600 shadow-sm shadow-orange-500/20"
                    >
                        <Plus class="h-4 w-4" />
                        Add Curriculum Section
                    </Link>
                </div>
            </div>

            <div class="p-6">
                <div class="mx-auto max-w-7xl">
                    <!-- FILTER BAR -->
                    <div class="mb-6 rounded-xl border border-slate-200 bg-white p-4">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <div class="md:col-span-2">
                                <input
                                    v-model="search"
                                    type="text"
                                    placeholder="Search by title or badge subtitle..."
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                />
                            </div>

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

                    <!-- CARDS LIST -->
                    <div
                        v-if="curricula.data.length"
                        class="space-y-6"
                    >
                        <div
                            v-for="item in curricula.data"
                            :key="item.id"
                            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md"
                        >
                            <div class="grid grid-cols-1 md:grid-cols-12">
                                <!-- IMAGE THUMBNAIL (5 COLS) -->
                                <div class="relative aspect-[16/10] bg-slate-100 md:col-span-5 md:aspect-auto">
                                    <img
                                        v-if="item.image_url || item.image_path"
                                        :src="item.image_url ? item.image_url : `/storage/${item.image_path}`"
                                        :alt="item.title"
                                        class="h-full w-full object-cover"
                                    />
                                    <div
                                        v-else
                                        class="flex h-full items-center justify-center text-xs font-semibold text-slate-400"
                                    >
                                        No Image Attached
                                    </div>

                                    <!-- POSITION BADGE -->
                                    <span class="absolute left-3 top-3 inline-flex items-center gap-1.5 rounded-full bg-slate-900/70 px-3 py-1 text-[11px] font-semibold text-white backdrop-blur-sm">
                                        <AlignLeft v-if="item.image_position === 'left'" class="h-3 w-3" />
                                        <AlignRight v-else class="h-3 w-3" />
                                        Image: {{ item.image_position === 'left' ? 'Left' : 'Right' }}
                                    </span>
                                </div>

                                <!-- CONTENT DETAILS (7 COLS) -->
                                <div class="flex flex-col justify-between p-6 md:col-span-7">
                                    <div>
                                        <!-- BADGE & STATUS -->
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="text-xs font-bold uppercase tracking-wider text-orange-600">
                                                {{ item.badge_title }}
                                            </span>

                                            <span
                                                class="rounded-full px-2.5 py-0.5 text-xs font-semibold"
                                                :class="
                                                    item.status
                                                        ? 'bg-green-100 text-green-700'
                                                        : 'bg-slate-100 text-slate-500'
                                                "
                                            >
                                                {{ item.status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>

                                        <!-- TITLE -->
                                        <h2 class="mt-2 text-lg font-bold text-slate-900">
                                            {{ item.title }}
                                        </h2>

                                        <!-- DESCRIPTION -->
                                        <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-slate-500">
                                            {{ item.description }}
                                        </p>

                                        <!-- FEATURES LIST PREVIEW -->
                                        <div
                                            v-if="item.features && item.features.length"
                                            class="mt-4 grid grid-cols-1 gap-2 sm:grid-cols-2"
                                        >
                                            <div
                                                v-for="(feat, idx) in item.features"
                                                :key="idx"
                                                class="flex items-center gap-2 text-xs text-slate-600"
                                            >
                                                <CheckCircle2 class="h-3.5 w-3.5 shrink-0 text-orange-500" />
                                                <span class="truncate">{{ feat }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ACTIONS & ORDER FOOTER -->
                                    <div class="mt-6 flex items-center justify-between border-t border-slate-100 pt-4">
                                        <span class="text-xs font-medium text-slate-400">
                                            Sort Order: <strong class="text-slate-700">{{ item.sort_order }}</strong>
                                        </span>

                                        <div class="flex items-center gap-2">
                                            <Link
                                                :href="route('admin.curriculum.edit', item.id)"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-50"
                                            >
                                                <Pencil class="h-3.5 w-3.5" />
                                                Edit
                                            </Link>

                                            <button
                                                type="button"
                                                @click="deleteCurriculum(item)"
                                                class="inline-flex items-center gap-1.5 rounded-lg bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-100"
                                            >
                                                <Trash2 class="h-3.5 w-3.5" />
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- EMPTY STATE -->
                    <div
                        v-else
                        class="rounded-xl border border-dashed border-slate-300 bg-white py-20 text-center"
                    >
                        <BookOpen class="mx-auto h-12 w-12 text-slate-300" />

                        <h3 class="mt-4 font-semibold text-slate-800">
                            No curriculum items found
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Start by creating your first curriculum section.
                        </p>

                        <Link
                            :href="route('admin.curriculum.create')"
                            class="mt-5 inline-block rounded-lg bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-600"
                        >
                            Add Curriculum Item
                        </Link>
                    </div>

                    <!-- PAGINATION -->
                    <div
                        v-if="curricula.links?.length > 3"
                        class="mt-6 flex justify-center gap-1"
                    >
                        <template
                            v-for="(link, index) in curricula.links"
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
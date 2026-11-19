
<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import {
    Pencil, Search, Globe, Image as ImageIcon,
    Eye, EyeOff, LayoutDashboard,
} from 'lucide-vue-next'
import { computed, ref } from 'vue'

const props = defineProps({
    pages: {
        type: Array,
        default: () => [],
    },
})

const search = ref('')

const filteredPages = computed(() => {
    return props.pages.filter(page =>
        page.title.toLowerCase().includes(search.value.toLowerCase()) ||
        page.page_key.toLowerCase().includes(search.value.toLowerCase())
    )
})

const activeCount = computed(() =>
    props.pages.filter(page => page.is_active).length
)

function imageUrl(image) {
    if (!image) return null

    if (image.startsWith('http')) return image

    return `/storage/${image.replace(/^\/+/, '')}`
}

function toggleStatus(page) {
    router.patch(
        route('admin.header-pages.toggle-status', page.id),
        {},
        { preserveScroll: true }
    )
}
</script>

<template>
    <Head title="Header Pages" />

    <AdminLayout>
        <div class="min-h-screen bg-slate-50 px-4 py-6 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl space-y-6">

                <!-- Header -->
                <div>
                    <div class="mb-2 flex items-center gap-2 text-sm text-slate-500">
                        <span>Website Content</span>
                        <span>/</span>
                        <span class="text-orange-600">Header Pages</span>
                    </div>

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">
                                Header Pages
                            </h1>
                            <p class="mt-2 text-sm text-slate-500">
                                Manage hero sections and header content across your website.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-slate-200 bg-white p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-500">Total Pages</p>
                                <p class="mt-2 text-3xl font-bold text-slate-900">
                                    {{ pages.length }}
                                </p>
                            </div>
                            <div class="rounded-xl bg-orange-50 p-3 text-orange-600">
                                <Globe class="h-6 w-6" />
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-500">Active Headers</p>
                                <p class="mt-2 text-3xl font-bold text-slate-900">
                                    {{ activeCount }}
                                </p>
                            </div>
                            <div class="rounded-xl bg-emerald-50 p-3 text-emerald-600">
                                <Eye class="h-6 w-6" />
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-500">Inactive Headers</p>
                                <p class="mt-2 text-3xl font-bold text-slate-900">
                                    {{ pages.length - activeCount }}
                                </p>
                            </div>
                            <div class="rounded-xl bg-slate-100 p-3 text-slate-500">
                                <EyeOff class="h-6 w-6" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search and List -->
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="flex flex-col gap-4 border-b border-slate-100 p-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="font-bold text-slate-900">
                                Website Page Headers
                            </h2>
                            <p class="mt-1 text-sm text-slate-500">
                                Select a page to edit its header content.
                            </p>
                        </div>

                        <div class="relative">
                            <Search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
                            <input
                                v-model="search"
                                type="search"
                                placeholder="Search page..."
                                class="w-full rounded-xl border border-slate-200 py-2.5 pl-10 pr-4 text-sm outline-none focus:border-orange-400 sm:w-64"
                            />
                        </div>
                    </div>

                    <div class="divide-y divide-slate-100">
                        <div
                            v-for="page in filteredPages"
                            :key="page.id"
                            class="flex flex-col gap-4 p-5 transition hover:bg-slate-50 sm:flex-row sm:items-center"
                        >
                            <!-- Thumbnail -->
                            <div class="h-20 w-full shrink-0 overflow-hidden rounded-xl bg-slate-100 sm:w-32">
                                <img
                                    v-if="imageUrl(page.background_image)"
                                    :src="imageUrl(page.background_image)"
                                    :alt="page.title"
                                    class="h-full w-full object-cover"
                                />
                                <div
                                    v-else
                                    class="flex h-full items-center justify-center text-slate-400"
                                >
                                    <ImageIcon class="h-7 w-7" />
                                </div>
                            </div>

                            <!-- Page Info -->
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="font-semibold text-slate-900">
                                        {{ page.title }}
                                    </h3>

                                    <span
                                        :class="page.is_active
                                            ? 'bg-emerald-50 text-emerald-700'
                                            : 'bg-slate-100 text-slate-500'"
                                        class="rounded-full px-2.5 py-1 text-xs font-medium"
                                    >
                                        {{ page.is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>

                                <p class="mt-1 text-xs text-slate-400">
                                    Page key: {{ page.page_key }}
                                </p>

                                <p class="mt-2 line-clamp-1 text-sm text-slate-500">
                                    {{ page.description || 'No description configured yet.' }}
                                </p>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-2">
                                <button
                                    type="button"
                                    @click="toggleStatus(page)"
                                    class="inline-flex h-10 items-center gap-2 rounded-lg border border-slate-200 px-3 text-sm text-slate-600 hover:border-orange-300 hover:text-orange-600"
                                >
                                    <component
                                        :is="page.is_active ? EyeOff : Eye"
                                        class="h-4 w-4"
                                    />
                                    <span class="hidden md:inline">
                                        {{ page.is_active ? 'Deactivate' : 'Activate' }}
                                    </span>
                                </button>

                                <Link
                                    :href="route('admin.header-pages.edit', page.id)"
                                    class="inline-flex h-10 items-center gap-2 rounded-lg bg-orange-50 px-4 text-sm font-semibold text-orange-600 hover:bg-orange-100"
                                >
                                    <Pencil class="h-4 w-4" />
                                    Edit
                                </Link>
                            </div>
                        </div>

                        <div
                            v-if="filteredPages.length === 0"
                            class="p-12 text-center text-sm text-slate-500"
                        >
                            No pages found.
                        </div>
                    </div>

                    <div class="border-t border-slate-100 bg-slate-50 px-5 py-4 text-xs text-slate-500">
                        Showing {{ filteredPages.length }} of {{ pages.length }} pages
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import {
    Award,
    Plus,
    Search,
    Pencil,
    Trash2,
    Eye,
    Trophy,
    Users,
    CheckCircle2,
    FileText,
    CalendarDays,
    X,
} from 'lucide-vue-next'
import { ref, watch } from 'vue'
import { debounce } from 'lodash'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'

const props = defineProps({
    achievements: {
        type: Object,
        default: () => ({
            data: [],
            links: [],
            current_page: 1,
            last_page: 1,
            total: 0,
        }),
    },
    filters: {
        type: Object,
        default: () => ({
            search: '',
            category: '',
            status: '',
        }),
    },
    categories: {
        type: Array,
        default: () => ['Academic', 'Sports', 'Arts', 'Technology', 'Other'],
    },
    statistics: {
        type: Object,
        default: () => ({
            total: 0,
            published: 0,
            draft: 0,
        }),
    },
})

const search = ref(props.filters.search ?? '')
const category = ref(props.filters.category ?? '')
const status = ref(props.filters.status ?? '')
const showDeleteModal = ref(false)
const selectedAchievement = ref(null)

const applyFilters = debounce(() => {
    router.get(
        route('admin.achievements.index'),
        {
            search: search.value || undefined,
            category: category.value || undefined,
            status: status.value || undefined,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        },
    )
}, 350)

watch([search, category, status], applyFilters)

const hasFilters = computed(() => {
    return search.value || category.value || status.value
})

function resetFilters() {
    search.value = ''
    category.value = ''
    status.value = ''
}

function confirmDelete(achievement) {
    selectedAchievement.value = achievement
    showDeleteModal.value = true
}

function deleteAchievement() {
    if (!selectedAchievement.value) return

    router.delete(
        route(
            'admin.achievements.destroy',
            selectedAchievement.value.id,
        ),
        {
            preserveScroll: true,
            onSuccess: () => {
                showDeleteModal.value = false
                selectedAchievement.value = null
            },
        },
    )
}

function formatDate(date) {
    if (!date) return '-'

    return new Date(`${date}T00:00:00`).toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    })
}

function categoryClass(value) {
    const classes = {
        Academic: 'bg-blue-50 text-blue-700 ring-blue-600/20',
        Sports: 'bg-green-50 text-green-700 ring-green-600/20',
        Arts: 'bg-purple-50 text-purple-700 ring-purple-600/20',
        Technology: 'bg-cyan-50 text-cyan-700 ring-cyan-600/20',
        Other: 'bg-gray-100 text-gray-700 ring-gray-500/20',
    }

    return classes[value] ?? classes.Other
}

function levelClass(value) {
    const classes = {
        School: 'bg-gray-100 text-gray-700',
        City: 'bg-blue-50 text-blue-700',
        Regional: 'bg-indigo-50 text-indigo-700',
        National: 'bg-orange-50 text-orange-700',
        International: 'bg-amber-50 text-amber-800',
    }

    return classes[value] ?? classes.School
}
</script>

<template>
    <Head title="Student Achievements" />

    <AdminLayout>
        <div class="min-h-screen space-y-6 bg-gray-50/70 p-4 sm:p-6 lg:p-8">
            <!-- Page Header -->
            <div
                class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
            >
                <div>
                    <div class="mb-2 flex items-center gap-2 text-sm text-gray-500">
                        <Award class="h-4 w-4 text-orange-500" />
                        <span>Content Management</span>
                        <span>/</span>
                        <span class="text-gray-700">Student Achievements</span>
                    </div>
    
                    <h1 class="text-2xl font-bold tracking-tight text-gray-900">
                        Student Achievements
                    </h1>
    
                    <p class="mt-1 text-sm text-gray-500">
                        Kelola dan publikasikan prestasi siswa Great Crystal School.
                    </p>
                </div>

                <Link
                        :href="
                            route(
                                'admin.edit.achievements.header'
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
                    :href="route('admin.achievements.create')"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-orange-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2"
                >
                    <Plus class="h-4 w-4" />
                    Tambah Prestasi
                </Link>
            </div>
    
            <!-- Statistics -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm"
                >
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Total Prestasi
                            </p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">
                                {{ statistics.total ?? 0 }}
                            </p>
                            <p class="mt-1 text-xs text-gray-500">
                                Semua data prestasi siswa
                            </p>
                        </div>
    
                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-50 text-orange-600"
                        >
                            <Trophy class="h-5 w-5" />
                        </div>
                    </div>
                </div>
    
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm"
                >
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Dipublikasikan
                            </p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">
                                {{ statistics.published ?? 0 }}
                            </p>
                            <p class="mt-1 text-xs text-gray-500">
                                Tampil di halaman publik
                            </p>
                        </div>
    
                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-50 text-green-600"
                        >
                            <CheckCircle2 class="h-5 w-5" />
                        </div>
                    </div>
                </div>
    
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm"
                >
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Draft
                            </p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">
                                {{ statistics.draft ?? 0 }}
                            </p>
                            <p class="mt-1 text-xs text-gray-500">
                                Belum dipublikasikan
                            </p>
                        </div>
    
                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 text-gray-600"
                        >
                            <FileText class="h-5 w-5" />
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Main Content -->
            <div
                class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm"
            >
                <!-- Table Header -->
                <div
                    class="flex flex-col gap-4 border-b border-gray-200 p-5 lg:flex-row lg:items-center lg:justify-between"
                >
                    <div>
                        <h2 class="font-semibold text-gray-900">
                            Daftar Prestasi
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ achievements.total ?? 0 }} data ditemukan
                        </p>
                    </div>
    
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <!-- Search -->
                        <div class="relative">
                            <Search
                                class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"
                            />
                            <input
                                v-model="search"
                                type="search"
                                placeholder="Cari prestasi atau siswa..."
                                class="w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-9 pr-3 text-sm outline-none transition placeholder:text-gray-400 focus:border-orange-400 focus:ring-2 focus:ring-orange-100 sm:w-64"
                            />
                        </div>
    
                        <!-- Category Filter -->
                        <select
                            v-model="category"
                            class="rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-700 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >
                            <option value="">Semua Kategori</option>
                            <option
                                v-for="item in categories"
                                :key="item"
                                :value="item"
                            >
                                {{ item }}
                            </option>
                        </select>
    
                        <!-- Status Filter -->
                        <select
                            v-model="status"
                            class="rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-700 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >
                            <option value="">Semua Status</option>
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                        </select>
    
                        <button
                            v-if="hasFilters"
                            type="button"
                            @click="resetFilters"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 px-3 py-2.5 text-sm text-gray-600 transition hover:bg-gray-50"
                        >
                            <X class="h-4 w-4" />
                            Reset
                        </button>
                    </div>
                </div>
    
                <!-- Desktop Table -->
                <div class="hidden overflow-x-auto md:block">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50/80 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-5 py-4 font-semibold">Prestasi</th>
                                <th class="px-5 py-4 font-semibold">Siswa</th>
                                <th class="px-5 py-4 font-semibold">Kategori</th>
                                <th class="px-5 py-4 font-semibold">Penghargaan</th>
                                <th class="px-5 py-4 font-semibold">Tanggal</th>
                                <th class="px-5 py-4 font-semibold">Status</th>
                                <th class="px-5 py-4 text-right font-semibold">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
    
                        <tbody class="divide-y divide-gray-100">
                            <tr
                                v-for="item in achievements.data"
                                :key="item.id"
                                class="transition hover:bg-orange-50/30"
                            >
                                <td class="px-5 py-4">
                                    <div class="flex min-w-56 items-center gap-3">
                                        <div
                                            class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-xl border border-gray-100 bg-gray-50"
                                        >
                                            <img
                                                v-if="item.image"
                                                :src="`/storage/${item.image}`"
                                                :alt="item.title"
                                                class="h-full w-full object-cover"
                                            />
                                            <Award
                                                v-else
                                                class="h-5 w-5 text-orange-400"
                                            />
                                        </div>
    
                                        <div class="min-w-0">
                                            <p
                                                class="line-clamp-2 font-semibold text-gray-900"
                                            >
                                                {{ item.title }}
                                            </p>
                                            <p
                                                class="mt-1 line-clamp-1 text-xs text-gray-500"
                                            >
                                                {{ item.competition_name }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
    
                                <td class="px-5 py-4">
                                    <p class="font-medium text-gray-800">
                                        {{ item.student_name }}
                                    </p>
                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ item.student_class || 'Kelas tidak diisi' }}
                                    </p>
                                </td>
    
                                <td class="px-5 py-4">
                                    <span
                                        class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset"
                                        :class="categoryClass(item.category)"
                                    >
                                        {{ item.category }}
                                    </span>
                                    <p
                                        class="mt-2 text-xs"
                                        :class="levelClass(item.achievement_level)"
                                    >
                                        {{ item.achievement_level }}
                                    </p>
                                </td>
    
                                <td class="px-5 py-4">
                                    <span
                                        class="inline-flex items-center gap-1.5 font-medium text-gray-800"
                                    >
                                        <Trophy
                                            class="h-4 w-4 text-amber-500"
                                        />
                                        {{ item.award }}
                                    </span>
                                </td>
    
                                <td class="whitespace-nowrap px-5 py-4 text-gray-600">
                                    <span class="inline-flex items-center gap-2">
                                        <CalendarDays
                                            class="h-4 w-4 text-gray-400"
                                        />
                                        {{ formatDate(item.achievement_date) }}
                                    </span>
                                </td>
    
                                <td class="px-5 py-4">
                                    <span
                                        v-if="item.is_active"
                                        class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700"
                                    >
                                        <span
                                            class="h-1.5 w-1.5 rounded-full bg-green-500"
                                        ></span>
                                        Published
                                    </span>
                                    <span
                                        v-else
                                        class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600"
                                    >
                                        <span
                                            class="h-1.5 w-1.5 rounded-full bg-gray-400"
                                        ></span>
                                        Draft
                                    </span>
                                </td>
    
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <Link
                                            :href="route('admin.achievements.edit', item.id)"
                                            title="Edit prestasi"
                                            class="rounded-lg p-2 text-gray-500 transition hover:bg-orange-50 hover:text-orange-600"
                                        >
                                            <Pencil class="h-4 w-4" />
                                        </Link>
    
                                        <button
                                            type="button"
                                            title="Hapus prestasi"
                                            @click="confirmDelete(item)"
                                            class="rounded-lg p-2 text-gray-500 transition hover:bg-red-50 hover:text-red-600"
                                        >
                                            <Trash2 class="h-4 w-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
    
                            <tr v-if="!achievements.data?.length">
                                <td colspan="7" class="px-5 py-16 text-center">
                                    <div
                                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-orange-50 text-orange-500"
                                    >
                                        <Award class="h-7 w-7" />
                                    </div>
                                    <h3 class="mt-4 font-semibold text-gray-900">
                                        Belum ada data prestasi
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Tambahkan prestasi siswa untuk mulai mengisi halaman ini.
                                    </p>
                                    <Link
                                        :href="route('admin.achievements.create')"
                                        class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-orange-600 hover:text-orange-700"
                                    >
                                        <Plus class="h-4 w-4" />
                                        Tambah prestasi pertama
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
    
                <!-- Mobile Cards -->
                <div class="space-y-3 p-4 md:hidden">
                    <div
                        v-for="item in achievements.data"
                        :key="item.id"
                        class="rounded-xl border border-gray-200 p-4"
                    >
                        <div class="flex gap-3">
                            <div
                                class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-gray-50"
                            >
                                <img
                                    v-if="item.image"
                                    :src="`/storage/${item.image}`"
                                    :alt="item.title"
                                    class="h-full w-full object-cover"
                                />
                                <Award v-else class="h-6 w-6 text-orange-400" />
                            </div>
    
                            <div class="min-w-0 flex-1">
                                <h3 class="font-semibold text-gray-900">
                                    {{ item.title }}
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ item.student_name }}
                                    <span v-if="item.student_class">
                                        · {{ item.student_class }}
                                    </span>
                                </p>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    <span
                                        class="rounded-full px-2.5 py-1 text-xs font-medium"
                                        :class="categoryClass(item.category)"
                                    >
                                        {{ item.category }}
                                    </span>
                                    <span
                                        class="rounded-full px-2.5 py-1 text-xs font-medium"
                                        :class="
                                            item.is_active
                                                ? 'bg-green-50 text-green-700'
                                                : 'bg-gray-100 text-gray-600'
                                        "
                                    >
                                        {{ item.is_active ? 'Published' : 'Draft' }}
                                    </span>
                                </div>
                            </div>
                        </div>
    
                        <div
                            class="mt-3 flex items-center justify-between border-t border-gray-100 pt-3"
                        >
                            <div class="text-xs text-gray-500">
                                {{ item.award }} · {{ formatDate(item.achievement_date) }}
                            </div>
                            <div class="flex gap-1">
                                <Link
                                    :href="route('admin.achievements.edit', item.id)"
                                    class="rounded-lg p-2 text-gray-500 hover:bg-orange-50 hover:text-orange-600"
                                >
                                    <Pencil class="h-4 w-4" />
                                </Link>
                                <button
                                    type="button"
                                    @click="confirmDelete(item)"
                                    class="rounded-lg p-2 text-gray-500 hover:bg-red-50 hover:text-red-600"
                                >
                                    <Trash2 class="h-4 w-4" />
                                </button>
                            </div>
                        </div>
                    </div>
    
                    <div
                        v-if="!achievements.data?.length"
                        class="px-4 py-10 text-center"
                    >
                        <Award class="mx-auto h-9 w-9 text-orange-400" />
                        <p class="mt-3 font-medium text-gray-900">
                            Belum ada data prestasi
                        </p>
                        <p class="mt-1 text-sm text-gray-500">
                            Silakan tambahkan data prestasi siswa.
                        </p>
                    </div>
                </div>
    
                <!-- Pagination -->
                <div
                    v-if="achievements.links?.length > 3"
                    class="flex flex-col gap-3 border-t border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between"
                >
                    <p class="text-sm text-gray-500">
                        Halaman {{ achievements.current_page }} dari
                        {{ achievements.last_page }}
                    </p>
    
                    <div class="flex flex-wrap gap-1">
                        <template
                            v-for="(link, index) in achievements.links"
                            :key="index"
                        >
                            <Link
                                v-if="link.url"
                                :href="link.url"
                                preserve-scroll
                                class="rounded-lg border px-3 py-2 text-sm transition"
                                :class="
                                    link.active
                                        ? 'border-orange-500 bg-orange-500 text-white'
                                        : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50'
                                "
                            >
                                <span v-html="link.label"></span>
                            </Link>
                            <span
                                v-else
                                class="cursor-not-allowed rounded-lg border border-gray-100 px-3 py-2 text-sm text-gray-300"
                            >
                                <span v-html="link.label"></span>
                            </span>
                        </template>
                    </div>
                </div>
            </div>
    
            <!-- Delete Confirmation Modal -->
            <Teleport to="body">
                <div
                    v-if="showDeleteModal"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/40 p-4 backdrop-blur-sm"
                    @click.self="showDeleteModal = false"
                    @keydown.esc="showDeleteModal = false"
                >
                    <div
                        class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl"
                        role="dialog"
                        aria-modal="true"
                        aria-labelledby="delete-title"
                    >
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-red-600"
                        >
                            <Trash2 class="h-6 w-6" />
                        </div>
    
                        <h2
                            id="delete-title"
                            class="mt-4 text-lg font-bold text-gray-900"
                        >
                            Hapus prestasi?
                        </h2>
    
                        <p class="mt-2 text-sm leading-6 text-gray-500">
                            Data
                            <strong class="text-gray-800">
                                {{ selectedAchievement?.title }}
                            </strong>
                            akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.
                        </p>
    
                        <div class="mt-6 flex justify-end gap-3">
                            <button
                                type="button"
                                @click="showDeleteModal = false"
                                class="rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                            >
                                Batal
                            </button>
    
                            <button
                                type="button"
                                @click="deleteAchievement"
                                class="rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700"
                            >
                                Ya, hapus
                            </button>
                        </div>
                    </div>
                </div>
            </Teleport>
        </div>
    </AdminLayout>
</template>
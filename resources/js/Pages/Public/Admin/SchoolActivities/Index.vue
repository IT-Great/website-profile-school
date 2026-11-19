
<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import {
    Plus,
    Search,
    Pencil,
    Trash2,
    MapPin,
    CalendarDays,
    Image as ImageIcon,
    Eye,
    Filter,
    BookOpen,
    X,
} from 'lucide-vue-next'
import { computed, ref } from 'vue'

const props = defineProps({
    activities: {
        type: Object,
        default: () => ({
            data: [],
            links: [],
            meta: {},
        }),
    },
})

const search = ref('')
const selectedCategory = ref('')
const selectedClass = ref('')

const classes = [
    'preschool',
    'kindergarten-A',
    'kindergarten-B',
    'primary',
    'lower primary',
    'upper primary',
    'secondary',
    'all class',
    'upper class',
]

const categories = [
    { value: 'event', label: 'Event' },
    { value: 'fieldtrip', label: 'Field Trip' },
    { value: 'school-activities', label: 'School Activities' },
]

const filteredActivities = computed(() => {
    const keyword = search.value.toLowerCase().trim()

    return (props.activities.data ?? []).filter((activity) => {
        const matchSearch =
            !keyword ||
            activity.name?.toLowerCase().includes(keyword) ||
            activity.location?.toLowerCase().includes(keyword) ||
            activity.academic_year?.toLowerCase().includes(keyword)

        const matchCategory =
            !selectedCategory.value ||
            activity.category === selectedCategory.value

        const matchClass =
            !selectedClass.value ||
            activity.class_level === selectedClass.value

        return matchSearch && matchCategory && matchClass
    })
})

const categoryLabel = (category) => {
    return categories.find(item => item.value === category)?.label ?? category
}

const formatClass = (value) => {
    if (!value) return '-'

    return value
        .split(' ')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' ')
}

const deleteActivity = (activity) => {
    if (!confirm(`Are you sure you want to delete "${activity.name}"?`)) {
        return
    }

    router.delete(route('admin.school-activities.destroy', activity.id), {
        preserveScroll: true,
    })
}

const resetFilters = () => {
    search.value = ''
    selectedCategory.value = ''
    selectedClass.value = ''
}
</script>

<template>
    <Head title="School Activities" />

    <AdminLayout>
        <div class="space-y-6">

            <!-- Header -->
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        School Activities
                    </h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Manage school activity documentation and photos.
                    </p>
                </div>

                <Link
                    :href="route('admin.school-activities.create')"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-orange-500 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600"
                >
                    <Plus class="h-5 w-5" />
                    Add Activity
                </Link>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Activities</p>
                            <h2 class="mt-2 text-3xl font-bold text-gray-800">
                                {{ activities.total ?? activities.data?.length ?? 0 }}
                            </h2>
                        </div>

                        <div class="rounded-xl bg-orange-50 p-3 text-orange-500">
                            <CalendarDays class="h-6 w-6" />
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Active Activities</p>
                            <h2 class="mt-2 text-3xl font-bold text-gray-800">
                                {{ activities.data?.filter(item => item.is_active).length ?? 0 }}
                            </h2>
                        </div>

                        <div class="rounded-xl bg-green-50 p-3 text-green-600">
                            <Eye class="h-6 w-6" />
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Photos</p>
                            <h2 class="mt-2 text-3xl font-bold text-gray-800">
                                {{ activities.data?.reduce((total, item) => total + (item.photos?.length ?? 0), 0) ?? 0 }}
                            </h2>
                        </div>

                        <div class="rounded-xl bg-blue-50 p-3 text-blue-600">
                            <ImageIcon class="h-6 w-6" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center gap-2">
                    <Filter class="h-5 w-5 text-gray-500" />
                    <h3 class="font-semibold text-gray-800">Filter Activities</h3>
                </div>

                <div class="grid grid-cols-1 gap-3 md:grid-cols-4">
                    <div class="relative md:col-span-2">
                        <Search class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                        <input
                            v-model="search"
                            type="text"
                            placeholder="Search activity name, location..."
                            class="w-full rounded-xl border border-gray-200 py-3 pl-10 pr-4 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        />
                    </div>

                    <select
                        v-model="selectedCategory"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                    >
                        <option value="">All Categories</option>
                        <option
                            v-for="category in categories"
                            :key="category.value"
                            :value="category.value"
                        >
                            {{ category.label }}
                        </option>
                    </select>

                    <select
                        v-model="selectedClass"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                    >
                        <option value="">All Classes</option>
                        <option v-for="item in classes" :key="item" :value="item">
                            {{ formatClass(item) }}
                        </option>
                    </select>
                </div>

                <div
                    v-if="search || selectedCategory || selectedClass"
                    class="mt-3 flex justify-end"
                >
                    <button
                        @click="resetFilters"
                        class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 transition hover:text-orange-600"
                    >
                        <X class="h-4 w-4" />
                        Reset filters
                    </button>
                </div>
            </div>

            <!-- Activity List -->
            <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
                    <div>
                        <h3 class="font-semibold text-gray-800">Activity List</h3>
                        <p class="mt-1 text-xs text-gray-500">
                            {{ filteredActivities.length }} activities displayed
                        </p>
                    </div>
                </div>

                <div
                    v-if="filteredActivities.length"
                    class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 xl:grid-cols-3"
                >
                    <div
                        v-for="activity in filteredActivities"
                        :key="activity.id"
                        class="group overflow-hidden rounded-2xl border border-gray-200 transition hover:-translate-y-1 hover:border-orange-200 hover:shadow-lg"
                    >
                        <!-- Photo -->
                        <div class="relative h-52 overflow-hidden bg-gray-100">
                            <img
                                v-if="activity.photos?.length"
                                :src="`/storage/${activity.photos[0].image}`"
                                :alt="activity.name"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                            />

                            <div
                                v-else
                                class="flex h-full items-center justify-center text-gray-400"
                            >
                                <ImageIcon class="h-12 w-12" />
                            </div>

                            <div class="absolute left-3 top-3">
                                <span class="rounded-lg bg-white/95 px-3 py-1.5 text-xs font-semibold text-gray-700 shadow-sm">
                                    {{ categoryLabel(activity.category) }}
                                </span>
                            </div>

                            <div class="absolute right-3 top-3">
                                <span
                                    :class="activity.is_active
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-gray-100 text-gray-600'"
                                    class="rounded-lg px-3 py-1.5 text-xs font-semibold"
                                >
                                    {{ activity.is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            <div class="absolute bottom-3 right-3 rounded-lg bg-black/60 px-2.5 py-1 text-xs font-medium text-white">
                                <span class="inline-flex items-center gap-1">
                                    <ImageIcon class="h-3.5 w-3.5" />
                                    {{ activity.photos?.length ?? 0 }} Photos
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="space-y-4 p-4">
                            <div>
                                <h4 class="line-clamp-1 text-lg font-bold text-gray-800">
                                    {{ activity.name }}
                                </h4>

                                <div class="mt-2 flex items-center gap-2 text-sm text-gray-500">
                                    <BookOpen class="h-4 w-4 shrink-0" />
                                    <span>{{ formatClass(activity.class_level) }}</span>
                                </div>

                                <div
                                    v-if="activity.location"
                                    class="mt-1 flex items-center gap-2 text-sm text-gray-500"
                                >
                                    <MapPin class="h-4 w-4 shrink-0" />
                                    <span class="line-clamp-1">{{ activity.location }}</span>
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <span class="rounded-lg bg-orange-50 px-3 py-1.5 text-xs font-medium text-orange-700">
                                    Semester {{ activity.semester }}
                                </span>

                                <span class="rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700">
                                    {{ activity.academic_year }}
                                </span>
                            </div>

                            <div class="flex items-center gap-2 border-t border-gray-100 pt-4">
                                <Link
                                    :href="route('admin.school-activities.show', activity.id)"
                                    class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl border border-gray-200 px-3 py-2.5 text-sm font-semibold text-gray-600 transition hover:bg-gray-50"
                                >
                                    <Eye class="h-4 w-4" />
                                    View
                                </Link>

                                <Link
                                    :href="route('admin.school-activities.edit', activity.id)"
                                    class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl border border-orange-200 px-3 py-2.5 text-sm font-semibold text-orange-600 transition hover:bg-orange-50"
                                >
                                    <Pencil class="h-4 w-4" />
                                    Edit
                                </Link>

                                <button
                                    @click="deleteActivity(activity)"
                                    class="inline-flex items-center justify-center rounded-xl border border-red-200 px-3 py-2.5 text-red-600 transition hover:bg-red-50"
                                    title="Delete activity"
                                >
                                    <Trash2 class="h-4 w-4" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="px-5 py-16 text-center">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
                        <ImageIcon class="h-8 w-8" />
                    </div>

                    <h3 class="mt-4 text-lg font-semibold text-gray-800">
                        No activities found
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Try changing your filters or add a new school activity.
                    </p>

                    <Link
                        :href="route('admin.school-activities.create')"
                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-orange-500 px-5 py-3 text-sm font-semibold text-white hover:bg-orange-600"
                    >
                        <Plus class="h-4 w-4" />
                        Add Activity
                    </Link>
                </div>
            </div>

        </div>
    </AdminLayout>
</template>

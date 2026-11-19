
<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import {
    ArrowLeft,
    Pencil,
    MapPin,
    CalendarDays,
    BookOpen,
    Image as ImageIcon,
    X,
} from 'lucide-vue-next'
import { ref } from 'vue'

const props = defineProps({
    activity: {
        type: Object,
        required: true,
    },
})

const selectedPhoto = ref(null)

const categories = {
    event: 'Event',
    fieldtrip: 'Field Trip',
    'school-activities': 'School Activities',
}

const formatClass = (value) => {
    if (!value) return '-'

    return value
        .split(' ')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' ')
}

const photoUrl = (photo) => `/storage/${photo.image}`
</script>

<template>
    <Head :title="activity.name" />

    <AdminLayout>
        <div class="space-y-6">

            <!-- Header -->
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <Link
                        :href="route('admin.school-activities.index')"
                        class="mb-3 inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-orange-600"
                    >
                        <ArrowLeft class="h-4 w-4" />
                        Back to Activities
                    </Link>

                    <h1 class="text-2xl font-bold text-gray-800">
                        Activity Details
                    </h1>
                    <p class="mt-1 text-sm text-gray-500">
                        View school activity information and documentation.
                    </p>
                </div>

                <Link
                    :href="route('admin.school-activities.edit', activity.id)"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-orange-500 px-5 py-3 text-sm font-semibold text-white hover:bg-orange-600"
                >
                    <Pencil class="h-4 w-4" />
                    Edit Activity
                </Link>
            </div>

            <!-- Activity Information -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

                <div class="space-y-6 lg:col-span-2">

                    <!-- Main Information -->
                    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="rounded-lg bg-orange-50 px-3 py-1.5 text-xs font-semibold text-orange-700">
                                {{ categories[activity.category] ?? activity.category }}
                            </span>

                            <span
                                :class="activity.is_active
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-gray-100 text-gray-600'"
                                class="rounded-lg px-3 py-1.5 text-xs font-semibold"
                            >
                                {{ activity.is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <h2 class="mt-4 text-2xl font-bold text-gray-800">
                            {{ activity.name }}
                        </h2>

                        <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div class="flex gap-3">
                                <div class="rounded-xl bg-orange-50 p-3 text-orange-500">
                                    <BookOpen class="h-5 w-5" />
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Class</p>
                                    <p class="mt-1 font-semibold text-gray-800">
                                        {{ formatClass(activity.class_level) }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <div class="rounded-xl bg-blue-50 p-3 text-blue-600">
                                    <MapPin class="h-5 w-5" />
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Location</p>
                                    <p class="mt-1 font-semibold text-gray-800">
                                        {{ activity.location || 'Not specified' }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <div class="rounded-xl bg-purple-50 p-3 text-purple-600">
                                    <CalendarDays class="h-5 w-5" />
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Semester</p>
                                    <p class="mt-1 font-semibold text-gray-800">
                                        Semester {{ activity.semester }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <div class="rounded-xl bg-green-50 p-3 text-green-600">
                                    <CalendarDays class="h-5 w-5" />
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Academic Year</p>
                                    <p class="mt-1 font-semibold text-gray-800">
                                        {{ activity.academic_year }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Photo Gallery -->
                    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                        <div class="mb-5 flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">
                                    Photo Documentation
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ activity.photos?.length ?? 0 }} photos uploaded
                                </p>
                            </div>

                            <ImageIcon class="h-6 w-6 text-orange-500" />
                        </div>

                        <div
                            v-if="activity.photos?.length"
                            class="grid grid-cols-2 gap-3 sm:grid-cols-3"
                        >
                            <button
                                v-for="(photo, index) in activity.photos"
                                :key="photo.id"
                                type="button"
                                @click="selectedPhoto = photo"
                                class="group relative aspect-square overflow-hidden rounded-xl bg-gray-100"
                            >
                                <img
                                    :src="photoUrl(photo)"
                                    :alt="`${activity.name} - ${index + 1}`"
                                    class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                />

                                <div class="absolute inset-0 flex items-center justify-center bg-black/0 transition group-hover:bg-black/20">
                                    <span class="rounded-lg bg-black/60 px-3 py-1 text-xs font-medium text-white opacity-0 transition group-hover:opacity-100">
                                        View Photo
                                    </span>
                                </div>
                            </button>
                        </div>

                        <div v-else class="py-12 text-center text-gray-400">
                            <ImageIcon class="mx-auto h-10 w-10" />
                            <p class="mt-3 text-sm">No photos available.</p>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-5">
                    <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                        <h3 class="font-bold text-gray-800">Activity Summary</h3>

                        <div class="mt-5 space-y-4 text-sm">
                            <div class="flex justify-between gap-3">
                                <span class="text-gray-500">Activity ID</span>
                                <span class="font-semibold text-gray-800">#{{ activity.id }}</span>
                            </div>

                            <div class="flex justify-between gap-3">
                                <span class="text-gray-500">Category</span>
                                <span class="font-semibold text-gray-800">
                                    {{ categories[activity.category] ?? activity.category }}
                                </span>
                            </div>

                            <div class="flex justify-between gap-3">
                                <span class="text-gray-500">Class</span>
                                <span class="text-right font-semibold text-gray-800">
                                    {{ formatClass(activity.class_level) }}
                                </span>
                            </div>

                            <div class="flex justify-between gap-3">
                                <span class="text-gray-500">Photos</span>
                                <span class="font-semibold text-gray-800">
                                    {{ activity.photos?.length ?? 0 }}
                                </span>
                            </div>

                            <div class="flex justify-between gap-3">
                                <span class="text-gray-500">Status</span>
                                <span :class="activity.is_active ? 'text-green-600' : 'text-gray-500'" class="font-semibold">
                                    {{ activity.is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>

                        <Link
                            :href="route('admin.school-activities.edit', activity.id)"
                            class="mt-6 flex w-full items-center justify-center gap-2 rounded-xl border border-orange-200 px-4 py-3 text-sm font-semibold text-orange-600 hover:bg-orange-50"
                        >
                            <Pencil class="h-4 w-4" />
                            Edit Activity
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Photo Preview Modal -->
        <div
            v-if="selectedPhoto"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4"
            @click.self="selectedPhoto = null"
        >
            <button
                type="button"
                @click="selectedPhoto = null"
                class="absolute right-5 top-5 rounded-full bg-white/10 p-2 text-white hover:bg-white/20"
            >
                <X class="h-6 w-6" />
            </button>

            <img
                :src="photoUrl(selectedPhoto)"
                :alt="activity.name"
                class="max-h-[85vh] max-w-full rounded-lg object-contain"
            />
        </div>
    </AdminLayout>
</template>

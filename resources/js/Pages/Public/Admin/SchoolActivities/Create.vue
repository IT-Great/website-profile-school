
<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import {
    ArrowLeft, Upload, ImagePlus, X, Save,
    MapPin, CalendarDays, GraduationCap, Images,
} from 'lucide-vue-next'
import { computed, onBeforeUnmount, ref } from 'vue'

const props = defineProps({
    classes: Array,
    categories: Array,
})

const form = useForm({
    name: '',
    class_level: '',
    location: '',
    semester: '',
    academic_year: '2026-2027',
    category: '',
    photos: [],
    is_active: true,
})

const previews = ref([])
const fileInput = ref(null)

const photoCount = computed(() => form.photos.length)

const categoryLabels = {
    event: 'Event',
    fieldtrip: 'Field Trip',
    'school-activities': 'School Activities',
}

function selectPhotos(event) {
    const selected = Array.from(event.target.files || [])
    const remaining = 10 - form.photos.length

    if (selected.length > remaining) {
        alert(`You can only upload ${remaining} more photo(s). Maximum is 10.`)
    }

    const accepted = selected.slice(0, remaining).filter(file => {
        const validType = ['image/jpeg', 'image/png', 'image/webp'].includes(file.type)
        const validSize = file.size <= 5 * 1024 * 1024

        if (!validType) {
            alert(`${file.name}: Only JPG, PNG and WEBP are allowed.`)
        } else if (!validSize) {
            alert(`${file.name}: Maximum file size is 5 MB.`)
        }

        return validType && validSize
    })

    accepted.forEach(file => {
        form.photos.push(file)
        previews.value.push(URL.createObjectURL(file))
    })

    event.target.value = ''
}

function removePhoto(index) {
    URL.revokeObjectURL(previews.value[index])

    form.photos.splice(index, 1)
    previews.value.splice(index, 1)
}

function submit() {
    if (form.photos.length < 3 || form.photos.length > 10) {
        alert('Please select between 3 and 10 photos.')
        return
    }

    form.post(route('admin.school-activities.store'), {
        forceFormData: true,
        preserveScroll: true,
    })
}

onBeforeUnmount(() => {
    previews.value.forEach(url => URL.revokeObjectURL(url))
})
</script>

<template>
    <Head title="Upload School Activity" />

    <AdminLayout>
        <div class="min-h-screen bg-slate-50 px-4 py-6 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl space-y-6">

                <!-- Header -->
                <div>
                    <div class="mb-2 flex items-center gap-2 text-sm text-slate-500">
                        <span>Website Content</span>
                        <span>/</span>
                        <Link
                            :href="route('admin.school-activities.index')"
                            class="hover:text-orange-600"
                        >
                            School Activities
                        </Link>
                        <span>/</span>
                        <span class="text-orange-600">Create</span>
                    </div>

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">
                                Upload School Activity
                            </h1>
                            <p class="mt-2 text-sm text-slate-500">
                                Add school activity information and upload its photo documentation.
                            </p>
                        </div>

                        <Link
                            :href="route('admin.school-activities.index')"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50"
                        >
                            <ArrowLeft class="h-4 w-4" />
                            Back to Activities
                        </Link>
                    </div>
                </div>

                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 items-start gap-6 xl:grid-cols-3">

                        <!-- Main Form -->
                        <div class="space-y-6 xl:col-span-2">

                            <!-- Activity Information -->
                            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                                <div class="flex items-center gap-3 border-b border-slate-100 p-5">
                                    <div class="rounded-xl bg-orange-50 p-2.5 text-orange-600">
                                        <GraduationCap class="h-5 w-5" />
                                    </div>
                                    <div>
                                        <h2 class="font-semibold text-slate-900">
                                            Activity Information
                                        </h2>
                                        <p class="text-xs text-slate-500">
                                            Basic information about the school activity.
                                        </p>
                                    </div>
                                </div>

                                <div class="space-y-5 p-5 sm:p-6">

                                    <!-- Name -->
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-slate-700">
                                            Activity Name <span class="text-red-500">*</span>
                                        </label>

                                        <input
                                            v-model="form.name"
                                            type="text"
                                            placeholder="e.g. Science Museum Field Trip"
                                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                            :class="{ 'border-red-400': form.errors.name }"
                                        />

                                        <p v-if="form.errors.name" class="mt-1 text-xs text-red-500">
                                            {{ form.errors.name }}
                                        </p>
                                    </div>

                                    <!-- Class -->
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-slate-700">
                                            Class <span class="text-red-500">*</span>
                                        </label>

                                        <select
                                            v-model="form.class_level"
                                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400"
                                        >
                                            <option value="" disabled>Select class</option>
                                            <option
                                                v-for="item in classes"
                                                :key="item"
                                                :value="item"
                                            >
                                                {{ item }}
                                            </option>
                                        </select>

                                        <p v-if="form.errors.class_level" class="mt-1 text-xs text-red-500">
                                            {{ form.errors.class_level }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            Select the class or group participating in this activity.
                                        </p>
                                    </div>

                                    <!-- Location -->
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-slate-700">
                                            Location
                                        </label>

                                        <div class="relative">
                                            <MapPin class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />

                                            <input
                                                v-model="form.location"
                                                type="text"
                                                placeholder="e.g. Surabaya Zoo, School Hall..."
                                                class="w-full rounded-xl border border-slate-200 py-3 pl-10 pr-4 text-sm outline-none focus:border-orange-400"
                                            />
                                        </div>

                                        <p v-if="form.errors.location" class="mt-1 text-xs text-red-500">
                                            {{ form.errors.location }}
                                        </p>
                                    </div>

                                    <!-- Semester and Academic Year -->
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <div>
                                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                                Semester <span class="text-red-500">*</span>
                                            </label>

                                            <select
                                                v-model="form.semester"
                                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400"
                                            >
                                                <option value="" disabled>Select semester</option>
                                                <option value="1">Semester 1</option>
                                                <option value="2">Semester 2</option>
                                            </select>

                                            <p v-if="form.errors.semester" class="mt-1 text-xs text-red-500">
                                                {{ form.errors.semester }}
                                            </p>
                                        </div>

                                        <div>
                                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                                Academic Year <span class="text-red-500">*</span>
                                            </label>

                                            <input
                                                v-model="form.academic_year"
                                                type="text"
                                                placeholder="2026-2027"
                                                pattern="[0-9]{4}-[0-9]{4}"
                                                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400"
                                            />

                                            <p v-if="form.errors.academic_year" class="mt-1 text-xs text-red-500">
                                                {{ form.errors.academic_year }}
                                            </p>
                                            <p class="mt-1 text-xs text-slate-400">
                                                Example: 2026-2027
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Category -->
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-slate-700">
                                            Category <span class="text-red-500">*</span>
                                        </label>

                                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                                            <button
                                                v-for="category in categories"
                                                :key="category"
                                                type="button"
                                                @click="form.category = category"
                                                :class="form.category === category
                                                    ? 'border-orange-400 bg-orange-50 text-orange-700 ring-2 ring-orange-100'
                                                    : 'border-slate-200 bg-white text-slate-600 hover:border-orange-200'"
                                                class="rounded-xl border p-4 text-left transition"
                                            >
                                                <span class="block text-sm font-semibold">
                                                    {{ categoryLabels[category] || category }}
                                                </span>
                                                <span class="mt-1 block text-xs opacity-70">
                                                    {{ category === 'event'
                                                        ? 'School celebrations'
                                                        : category === 'fieldtrip'
                                                        ? 'Educational visits'
                                                        : 'Learning activities'
                                                    }}
                                                </span>
                                            </button>
                                        </div>

                                        <p v-if="form.errors.category" class="mt-1 text-xs text-red-500">
                                            {{ form.errors.category }}
                                        </p>
                                    </div>
                                </div>
                            </section>

                            <!-- Photo Documentation -->
                            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                                <div class="flex flex-col gap-3 border-b border-slate-100 p-5 sm:flex-row sm:items-center sm:justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="rounded-xl bg-orange-50 p-2.5 text-orange-600">
                                            <Images class="h-5 w-5" />
                                        </div>
                                        <div>
                                            <h2 class="font-semibold text-slate-900">
                                                Photo Documentation
                                            </h2>
                                            <p class="text-xs text-slate-500">
                                                Upload photos of this activity.
                                            </p>
                                        </div>
                                    </div>

                                    <span
                                        class="rounded-full px-3 py-1.5 text-xs font-semibold"
                                        :class="photoCount >= 3
                                            ? 'bg-emerald-50 text-emerald-700'
                                            : 'bg-amber-50 text-amber-700'"
                                    >
                                        {{ photoCount }} / 10 Photos
                                    </span>
                                </div>

                                <div class="space-y-4 p-5 sm:p-6">

                                    <!-- Upload Area -->
                                    <label
                                        v-if="photoCount < 10"
                                        class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 px-4 py-10 text-center transition hover:border-orange-300 hover:bg-orange-50/40"
                                    >
                                        <div class="mb-3 rounded-xl bg-white p-3 text-orange-500 shadow-sm">
                                            <Upload class="h-7 w-7" />
                                        </div>

                                        <span class="text-sm font-semibold text-slate-700">
                                            Click to upload photos
                                        </span>

                                        <span class="mt-1 text-xs text-slate-400">
                                            JPG, PNG or WEBP · Maximum 5 MB each
                                        </span>

                                        <span class="mt-2 text-xs font-medium text-orange-600">
                                            Minimum 3 photos · Maximum 10 photos
                                        </span>

                                        <input
                                            ref="fileInput"
                                            type="file"
                                            multiple
                                            accept="image/jpeg,image/png,image/webp"
                                            class="hidden"
                                            @change="selectPhotos"
                                        />
                                    </label>

                                    <!-- Preview Grid -->
                                    <div v-if="previews.length" class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                                        <div
                                            v-for="(preview, index) in previews"
                                            :key="preview"
                                            class="group relative aspect-square overflow-hidden rounded-xl bg-slate-100"
                                        >
                                            <img
                                                :src="preview"
                                                class="h-full w-full object-cover"
                                                :alt="`Activity photo ${index + 1}`"
                                            />

                                            <span class="absolute bottom-2 left-2 rounded-md bg-black/60 px-2 py-1 text-xs font-medium text-white">
                                                Photo {{ index + 1 }}
                                            </span>

                                            <button
                                                type="button"
                                                @click="removePhoto(index)"
                                                class="absolute right-2 top-2 flex h-8 w-8 items-center justify-center rounded-full bg-white text-red-500 shadow transition hover:bg-red-50"
                                            >
                                                <X class="h-4 w-4" />
                                            </button>
                                        </div>
                                    </div>

                                    <div
                                        v-else
                                        class="rounded-xl bg-slate-50 px-4 py-6 text-center text-sm text-slate-400"
                                    >
                                        No photos selected yet.
                                    </div>

                                    <p v-if="form.errors.photos" class="text-xs text-red-500">
                                        {{ form.errors.photos }}
                                    </p>

                                    <div
                                        v-for="(photo, index) in form.photos"
                                        :key="`error-${index}`"
                                    >
                                        <p
                                            v-if="form.errors[`photos.${index}`]"
                                            class="text-xs text-red-500"
                                        >
                                            {{ form.errors[`photos.${index}`] }}
                                        </p>
                                    </div>

                                    <p class="text-xs leading-5 text-slate-400">
                                        Select at least 3 photos to create an activity album.
                                        You can select multiple images at once.
                                    </p>
                                </div>
                            </section>
                        </div>

                        <!-- Sidebar -->
                        <div class="space-y-6">

                            <!-- Publishing -->
                            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                                <h2 class="font-semibold text-slate-900">
                                    Publishing
                                </h2>

                                <label class="mt-5 flex cursor-pointer items-center justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-medium text-slate-800">
                                            Publish Activity
                                        </p>
                                        <p class="mt-1 text-xs text-slate-400">
                                            Display this album on the website.
                                        </p>
                                    </div>

                                    <input
                                        v-model="form.is_active"
                                        type="checkbox"
                                        class="peer sr-only"
                                    />

                                    <span class="relative h-6 w-11 shrink-0 rounded-full bg-slate-300 transition peer-checked:bg-orange-500 after:absolute after:left-1 after:top-1 after:h-4 after:w-4 after:rounded-full after:bg-white after:transition peer-checked:after:translate-x-5" />
                                </label>
                            </section>

                            <!-- Upload Summary -->
                            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                                <h2 class="font-semibold text-slate-900">
                                    Activity Summary
                                </h2>

                                <div class="mt-4 space-y-4 text-sm">
                                    <div class="flex items-center justify-between gap-3">
                                        <span class="text-slate-500">Category</span>
                                        <span class="font-medium text-slate-800">
                                            {{ categoryLabels[form.category] || 'Not selected' }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between gap-3">
                                        <span class="text-slate-500">Class</span>
                                        <span class="text-right font-medium text-slate-800">
                                            {{ form.class_level || 'Not selected' }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between gap-3">
                                        <span class="text-slate-500">Semester</span>
                                        <span class="font-medium text-slate-800">
                                            {{ form.semester ? `Semester ${form.semester}` : 'Not selected' }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between gap-3">
                                        <span class="text-slate-500">Academic Year</span>
                                        <span class="font-medium text-slate-800">
                                            {{ form.academic_year || '-' }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between gap-3">
                                        <span class="text-slate-500">Documentation</span>
                                        <span class="font-semibold text-slate-800">
                                            {{ photoCount }} / 10
                                        </span>
                                    </div>
                                </div>
                            </section>

                            <!-- Information -->
                            <section class="rounded-2xl border border-orange-100 bg-orange-50/70 p-5">
                                <h3 class="text-sm font-semibold text-slate-800">
                                    Upload Guidelines
                                </h3>

                                <ul class="mt-3 space-y-2 text-xs leading-5 text-slate-600">
                                    <li>• Minimum 3 photos per activity.</li>
                                    <li>• Maximum 10 photos per activity.</li>
                                    <li>• Maximum 5 MB per photo.</li>
                                    <li>• Supported formats: JPG, PNG, WEBP.</li>
                                    <li>• Choose clear photos for the school gallery.</li>
                                </ul>
                            </section>
                        </div>
                    </div>

                    <!-- Bottom Actions -->
                    <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                        <Link
                            :href="route('admin.school-activities.index')"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50"
                        >
                            Cancel
                        </Link>

                        <button
                            type="submit"
                            :disabled="form.processing || photoCount < 3"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-orange-500 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600 disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            <Save class="h-4 w-4" />
                            {{ form.processing ? 'Uploading...' : 'Save Activity' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

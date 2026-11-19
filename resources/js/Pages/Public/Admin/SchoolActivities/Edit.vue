
<script setup>
import { Head, Link, useForm, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import {
    ArrowLeft,
    Save,
    Upload,
    Image as ImageIcon,
    X,
    MapPin,
    CalendarDays,
    BookOpen,
} from 'lucide-vue-next'
import { computed, onBeforeUnmount } from 'vue'

const props = defineProps({
    activity: {
        type: Object,
        required: true,
    },
    classes: {
        type: Array,
        default: () => [
            'preschool',
            'kindergarten-A',
            'kindergarten-B',
            'primary',
            'lower primary',
            'upper primary',
            'secondary',
            'all class',
            'upper class',
        ],
    },
    categories: {
        type: Array,
        default: () => [
            'event',
            'fieldtrip',
            'school-activities',
        ],
    },
})

const form = useForm({
    name: props.activity.name ?? '',
    class_level: props.activity.class_level ?? '',
    location: props.activity.location ?? '',
    semester: String(props.activity.semester ?? 1),
    academic_year: props.activity.academic_year ?? '',
    category: props.activity.category ?? 'event',
    is_active: Boolean(props.activity.is_active),
    photos: [],
    remove_photos: [],
})

const existingPhotos = computed(() => {
    return (props.activity.photos ?? []).filter(
        photo => !form.remove_photos.includes(photo.id)
    )
})

const totalPhotos = computed(() => {
    return existingPhotos.value.length + form.photos.length
})

const canSubmit = computed(() => {
    return totalPhotos.value >= 3 && totalPhotos.value <= 10
})

const newPhotoPreviews = computed(() => {
    return form.photos.map((file, index) => ({
        file,
        index,
        url: URL.createObjectURL(file),
    }))
})

// Revoke preview URLs when component is destroyed.
onBeforeUnmount(() => {
    newPhotoPreviews.value.forEach(photo => URL.revokeObjectURL(photo.url))
})

const photoUrl = (photo) => `/storage/${photo.image}`

const addPhotos = (event) => {
    const selected = Array.from(event.target.files ?? [])
    const available = 10 - totalPhotos.value

    if (available <= 0) {
        alert('Maximum 10 photos are allowed.')
        event.target.value = ''
        return
    }

    const allowed = selected.slice(0, available)

    if (selected.length > available) {
        alert(`You can only add ${available} more photo(s).`)
    }

    form.photos.push(...allowed)
    event.target.value = ''
}

const removeExistingPhoto = (photo) => {
    form.remove_photos.push(photo.id)
}

const restoreExistingPhoto = (photo) => {
    form.remove_photos = form.remove_photos.filter(
        id => id !== photo.id
    )
}

const removeNewPhoto = (index) => {
    form.photos.splice(index, 1)
}


const submit = () => {
    if (!canSubmit.value) {
        alert('The activity must have between 3 and 10 photos.')
        return
    }

    const data = new FormData()

    data.append('_method', 'PUT')
    data.append('name', form.name)
    data.append('class_level', form.class_level)
    data.append('location', form.location ?? '')
    data.append('semester', String(form.semester))
    data.append('academic_year', form.academic_year)
    data.append('category', form.category)
    data.append('is_active', form.is_active ? '1' : '0')

    form.remove_photos.forEach((id, index) => {
        data.append(`remove_photos[${index}]`, String(id))
    })

    form.photos.forEach((photo, index) => {
        data.append(`photos[${index}]`, photo)
    })

    console.log('FormData entries:')
    for (const [key, value] of data.entries()) {
        console.log(key, value)
    }

    router.post(
        route('admin.school-activities.update', props.activity.id),
        data,
        {
            forceFormData: true,
            preserveScroll: true,
        }
    )
}

</script>

<template>
    <Head title="Edit School Activity" />

    <AdminLayout>
        <div class="space-y-6">

            <!-- Header -->
            <div>
                <Link
                    :href="route('admin.school-activities.show', activity.id)"
                    class="mb-3 inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-orange-600"
                >
                    <ArrowLeft class="h-4 w-4" />
                    Back to Activity
                </Link>

                <h1 class="text-2xl font-bold text-gray-800">
                    Edit Activity
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Update activity information and photo documentation.
                </p>
            </div>

            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

                    <!-- Main Form -->
                    <div class="space-y-6 xl:col-span-2">

                        <!-- Activity Information -->
                        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                            <div class="mb-6 flex items-center gap-3">
                                <div class="rounded-xl bg-orange-50 p-3 text-orange-500">
                                    <BookOpen class="h-5 w-5" />
                                </div>
                                <div>
                                    <h2 class="font-bold text-gray-800">
                                        Activity Information
                                    </h2>
                                    <p class="text-sm text-gray-500">
                                        Basic information about the activity.
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-5">
                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                                        Activity Name <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        v-model="form.name"
                                        type="text"
                                        placeholder="Example: Science Project Exhibition"
                                        class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                    />
                                    <p v-if="form.errors.name" class="mt-1 text-sm text-red-500">
                                        {{ form.errors.name }}
                                    </p>
                                </div>

                                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                                    <div>
                                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                                            Class <span class="text-red-500">*</span>
                                        </label>
                                        <select
                                            v-model="form.class_level"
                                            class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
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
                                        <p v-if="form.errors.class_level" class="mt-1 text-sm text-red-500">
                                            {{ form.errors.class_level }}
                                        </p>
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                                            Category <span class="text-red-500">*</span>
                                        </label>
                                        <select
                                            v-model="form.category"
                                            class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                        >
                                            <option
                                                v-for="item in categories"
                                                :key="item"
                                                :value="item"
                                            >
                                                {{ item === 'fieldtrip'
                                                    ? 'Field Trip'
                                                    : item === 'school-activities'
                                                        ? 'School Activities'
                                                        : 'Event' }}
                                            </option>
                                        </select>
                                        <p v-if="form.errors.category" class="mt-1 text-sm text-red-500">
                                            {{ form.errors.category }}
                                        </p>
                                    </div>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                                        Location
                                    </label>
                                    <div class="relative">
                                        <MapPin class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                                        <input
                                            v-model="form.location"
                                            type="text"
                                            placeholder="Example: Surabaya Zoo"
                                            class="w-full rounded-xl border border-gray-200 py-3 pl-10 pr-4 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                        />
                                    </div>
                                    <p v-if="form.errors.location" class="mt-1 text-sm text-red-500">
                                        {{ form.errors.location }}
                                    </p>
                                </div>

                                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                                    <div>
                                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                                            Semester <span class="text-red-500">*</span>
                                        </label>
                                        <select
                                            v-model="form.semester"
                                            class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                        >
                                            <option value="1">Semester 1</option>
                                            <option value="2">Semester 2</option>
                                        </select>
                                        <p v-if="form.errors.semester" class="mt-1 text-sm text-red-500">
                                            {{ form.errors.semester }}
                                        </p>
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                                            Academic Year <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <CalendarDays class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                                            <input
                                                v-model="form.academic_year"
                                                type="text"
                                                placeholder="2026-2027"
                                                class="w-full rounded-xl border border-gray-200 py-3 pl-10 pr-4 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                            />
                                        </div>
                                        <p v-if="form.errors.academic_year" class="mt-1 text-sm text-red-500">
                                            {{ form.errors.academic_year }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Photo Documentation -->
                        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                            <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h2 class="font-bold text-gray-800">
                                        Photo Documentation
                                    </h2>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Manage existing photos and upload new ones.
                                    </p>
                                </div>

                                <span class="w-fit rounded-lg bg-orange-50 px-3 py-1.5 text-sm font-semibold text-orange-700">
                                    {{ totalPhotos }} / 10 Photos
                                </span>
                            </div>

                            <!-- Existing Photos -->
                            <div>
                                <h3 class="mb-3 text-sm font-semibold text-gray-700">
                                    Existing Photos
                                </h3>

                                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                                    <div
                                        v-for="photo in existingPhotos"
                                        :key="photo.id"
                                        class="group relative aspect-square overflow-hidden rounded-xl bg-gray-100"
                                    >
                                        <img
                                            :src="photoUrl(photo)"
                                            class="h-full w-full object-cover"
                                            alt="Activity photo"
                                        />

                                        <button
                                            type="button"
                                            @click="removeExistingPhoto(photo)"
                                            class="absolute right-2 top-2 rounded-full bg-red-500 p-2 text-white shadow hover:bg-red-600"
                                            title="Remove photo"
                                        >
                                            <X class="h-4 w-4" />
                                        </button>

                                        <span class="absolute bottom-2 left-2 rounded-md bg-black/60 px-2 py-1 text-xs text-white">
                                            Saved
                                        </span>
                                    </div>
                                </div>

                                <p v-if="!existingPhotos.length" class="py-5 text-center text-sm text-gray-400">
                                    All existing photos have been selected for removal.
                                </p>
                            </div>

                            <!-- Removed Photos -->
                            <div
                                v-if="form.remove_photos.length"
                                class="mt-5 rounded-xl border border-red-100 bg-red-50 p-4"
                            >
                                <p class="text-sm font-semibold text-red-700">
                                    {{ form.remove_photos.length }} photo(s) marked for removal
                                </p>
                                <p class="mt-1 text-xs text-red-600">
                                    These photos will be deleted when you save the changes.
                                </p>
                                <button
                                    v-for="photo in activity.photos.filter(item => form.remove_photos.includes(item.id))"
                                    :key="photo.id"
                                    type="button"
                                    @click="restoreExistingPhoto(photo)"
                                    class="mt-2 mr-2 text-xs font-semibold text-red-700 underline"
                                >
                                    Undo
                                </button>
                            </div>

                            <!-- New Photos -->
                            <div class="mt-6">
                                <h3 class="mb-3 text-sm font-semibold text-gray-700">
                                    Add New Photos
                                </h3>

                                <label
                                    class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 px-5 py-8 text-center transition hover:border-orange-300 hover:bg-orange-50/50"
                                >
                                    <Upload class="h-8 w-8 text-orange-500" />
                                    <span class="mt-3 text-sm font-semibold text-gray-700">
                                        Click to upload photos
                                    </span>
                                    <span class="mt-1 text-xs text-gray-500">
                                        JPG, JPEG, PNG, WEBP · Maximum 5 MB each
                                    </span>
                                    <input
                                        type="file"
                                        accept="image/jpeg,image/png,image/webp"
                                        multiple
                                        class="hidden"
                                        @change="addPhotos"
                                    />
                                </label>

                                <div
                                    v-if="form.photos.length"
                                    class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3"
                                >
                                    <div
                                        v-for="(file, index) in form.photos"
                                        :key="`${file.name}-${index}`"
                                        class="relative aspect-square overflow-hidden rounded-xl bg-gray-100"
                                    >
                                        <img
                                            :src="newPhotoPreviews[index]?.url"
                                            class="h-full w-full object-cover"
                                            alt="New photo preview"
                                        />

                                        <button
                                            type="button"
                                            @click="removeNewPhoto(index)"
                                            class="absolute right-2 top-2 rounded-full bg-red-500 p-2 text-white hover:bg-red-600"
                                        >
                                            <X class="h-4 w-4" />
                                        </button>

                                        <span class="absolute bottom-2 left-2 rounded-md bg-black/60 px-2 py-1 text-xs text-white">
                                            New
                                        </span>
                                    </div>
                                </div>

                                <p v-if="form.errors.photos" class="mt-2 text-sm text-red-500">
                                    {{ form.errors.photos }}
                                </p>
                                <p
                                    v-for="(file, index) in form.photos"
                                    :key="`error-${index}`"
                                    v-if="form.errors[`photos.${index}`]"
                                    class="mt-1 text-sm text-red-500"
                                >
                                    {{ form.errors[`photos.${index}`] }}
                                </p>
                            </div>

                            <div class="mt-4 rounded-xl bg-blue-50 p-4">
                                <p class="text-sm text-blue-800">
                                    <strong>Photo requirement:</strong>
                                    Minimum 3 and maximum 10 photos in total.
                                </p>
                                <p
                                    :class="canSubmit ? 'text-green-700' : 'text-red-600'"
                                    class="mt-1 text-sm font-semibold"
                                >
                                    Current total: {{ totalPhotos }} photos
                                    <span v-if="!canSubmit">
                                        — Please adjust the number of photos.
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-5">
                        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                            <h3 class="font-bold text-gray-800">
                                Publishing Status
                            </h3>

                            <label class="mt-5 flex cursor-pointer items-center justify-between gap-3">
                                <div>
                                    <p class="text-sm font-semibold text-gray-700">
                                        Active
                                    </p>
                                    <p class="mt-1 text-xs text-gray-500">
                                        Show this activity on the website.
                                    </p>
                                </div>

                                <input
                                    v-model="form.is_active"
                                    type="checkbox"
                                    class="h-5 w-5 rounded border-gray-300 text-orange-500 focus:ring-orange-400"
                                />
                            </label>

                            <div class="mt-6 border-t border-gray-100 pt-5">
                                <button
                                    type="submit"
                                    :disabled="form.processing || !canSubmit"
                                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-orange-500 px-5 py-3 font-semibold text-white transition hover:bg-orange-600 disabled:cursor-not-allowed disabled:opacity-50"
                                >
                                    <Save class="h-5 w-5" />
                                    {{ form.processing ? 'Saving...' : 'Save Changes' }}
                                </button>

                                <Link
                                    :href="route('admin.school-activities.show', activity.id)"
                                    class="mt-3 flex w-full items-center justify-center rounded-xl border border-gray-200 px-5 py-3 text-sm font-semibold text-gray-600 hover:bg-gray-50"
                                >
                                    Cancel
                                </Link>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-orange-100 bg-orange-50 p-5">
                            <div class="flex items-center gap-2 text-orange-700">
                                <ImageIcon class="h-5 w-5" />
                                <h3 class="font-semibold">Photo Guidelines</h3>
                            </div>
                            <ul class="mt-3 list-inside list-disc space-y-2 text-sm text-orange-800">
                                <li>Minimum 3 photos.</li>
                                <li>Maximum 10 photos.</li>
                                <li>Maximum file size 5 MB each.</li>
                                <li>Use JPG, JPEG, PNG, or WEBP.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

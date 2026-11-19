
<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import {
    ArrowLeft,
    Plus,
    Trash2,
    Save,
    ImagePlus,
    X,
    GraduationCap,
    GripVertical,
} from 'lucide-vue-next'

const props = defineProps({
    section: {
        type: Object,
        required: true,
    },
})

const form = useForm({
    _method: 'PUT',
    title: props.section.title ?? '',
    description: props.section.description ?? '',
    button_text: props.section.button_text ?? '',
    button_url: props.section.button_url ?? '',
    is_active: Boolean(props.section.is_active),

    items: (props.section.items ?? []).map(item => ({
        id: item.id,
        name: item.name ?? '',
        description: item.description ?? '',
        icon: item.icon ?? '',
        color: item.color ?? 'orange',
        is_active: Boolean(item.is_active),

        existing_photos: (item.photos ?? []).map(photo => ({
            id: photo.id,
            image: photo.image,
        })),

        remove_photos: [],
        new_photos: [],
    })),
})

const colorOptions = [
    { value: 'orange', label: 'Orange' },
    { value: 'blue', label: 'Blue' },
    { value: 'green', label: 'Green' },
    { value: 'purple', label: 'Purple' },
    { value: 'pink', label: 'Pink' },
    { value: 'yellow', label: 'Yellow' },
    { value: 'red', label: 'Red' },
]

const addItem = () => {
    form.items.push({
        id: null,
        name: '',
        description: '',
        icon: 'GraduationCap',
        color: 'orange',
        is_active: true,
        existing_photos: [],
        remove_photos: [],
        new_photos: [],
    })
}

const removeItem = (index) => {
    if (confirm('Apakah Anda yakin ingin menghapus program ini?')) {
        form.items.splice(index, 1)
    }
}

const addPhotos = (event, item) => {
    const files = Array.from(event.target.files ?? [])
    item.new_photos.push(...files)
    event.target.value = ''
}

const removeNewPhoto = (item, index) => {
    item.new_photos.splice(index, 1)
}

const removeExistingPhoto = (item, index) => {
    const photo = item.existing_photos[index]

    if (photo?.id) {
        item.remove_photos.push(photo.id)
    }

    item.existing_photos.splice(index, 1)
}

const photoUrl = (path) => {
    if (!path) return ''
    return `/storage/${path}`
}

const submit = () => {
    form.post(route('admin.secondary-program.extracurriculars.update'), {
        forceFormData: true,
        preserveScroll: true,
    })
}
</script>

<template>
    <Head title="Manage Extracurricular Programs" />

    <AdminLayout>
        <div class="space-y-6 pb-10">

            <!-- Header -->
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <Link
                        :href="route('admin.secondary-program.index')"
                        class="mb-3 inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-orange-600"
                    >
                        <ArrowLeft class="h-4 w-4" />
                        Back to Secondary Program
                    </Link>

                    <h1 class="text-2xl font-bold text-gray-800">
                        Extracurricular Programs
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Manage extracurricular activities and their photo galleries.
                    </p>
                </div>

                <button
                    type="button"
                    @click="submit"
                    :disabled="form.processing"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-orange-500 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <Save class="h-4 w-4" />
                    {{ form.processing ? 'Saving...' : 'Save Changes' }}
                </button>
            </div>

            <!-- Success -->
            <div
                v-if="$page.props.flash?.success"
                class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700"
            >
                {{ $page.props.flash.success }}
            </div>

            <!-- Section Information -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="mb-5 flex items-center gap-3">
                    <div class="rounded-xl bg-orange-100 p-3 text-orange-600">
                        <GraduationCap class="h-6 w-6" />
                    </div>
                    <div>
                        <h2 class="font-bold text-gray-800">Section Information</h2>
                        <p class="text-sm text-gray-500">
                            Main heading displayed on the public page.
                        </p>
                    </div>
                </div>

                <div class="grid gap-5">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            Section Title
                        </label>
                        <input
                            v-model="form.title"
                            type="text"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                        />
                        <p v-if="form.errors.title" class="mt-1 text-sm text-red-500">
                            {{ form.errors.title }}
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            Description
                        </label>
                        <textarea
                            v-model="form.description"
                            rows="3"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                        ></textarea>
                        <p v-if="form.errors.description" class="mt-1 text-sm text-red-500">
                            {{ form.errors.description }}
                        </p>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Button Text
                            </label>
                            <input
                                v-model="form.button_text"
                                type="text"
                                placeholder="Explore More"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-orange-500"
                            />
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Button URL
                            </label>
                            <input
                                v-model="form.button_url"
                                type="text"
                                placeholder="/contact"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-orange-500"
                            />
                        </div>
                    </div>

                    <label class="flex items-center gap-3">
                        <input
                            v-model="form.is_active"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500"
                        />
                        <span class="text-sm font-medium text-gray-700">
                            Display this section on the public website
                        </span>
                    </label>
                </div>
            </div>

            <!-- Items Header -->
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">
                        Extracurricular List
                    </h2>
                    <p class="text-sm text-gray-500">
                        Add activities and manage their gallery photos.
                    </p>
                </div>

                <button
                    type="button"
                    @click="addItem"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-orange-200 bg-orange-50 px-4 py-2.5 text-sm font-semibold text-orange-600 hover:bg-orange-100"
                >
                    <Plus class="h-4 w-4" />
                    Add Program
                </button>
            </div>

            <!-- Empty State -->
            <div
                v-if="form.items.length === 0"
                class="rounded-2xl border-2 border-dashed border-gray-300 bg-white p-10 text-center"
            >
                <GraduationCap class="mx-auto mb-3 h-10 w-10 text-gray-300" />
                <h3 class="font-semibold text-gray-700">No programs yet</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Click Add Program to create your first extracurricular activity.
                </p>
            </div>

            <!-- Program Cards -->
            <div
                v-for="(item, index) in form.items"
                :key="item.id ?? `new-${index}`"
                class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6"
            >
                <div class="mb-5 flex items-center justify-between border-b border-gray-100 pb-4">
                    <div class="flex items-center gap-3">
                        <GripVertical class="h-5 w-5 text-gray-300" />
                        <div>
                            <h3 class="font-bold text-gray-800">
                                Program {{ index + 1 }}
                            </h3>
                            <p class="text-xs text-gray-400">
                                {{ item.id ? `ID: ${item.id}` : 'New program' }}
                            </p>
                        </div>
                    </div>

                    <button
                        type="button"
                        @click="removeItem(index)"
                        class="rounded-lg p-2 text-red-500 hover:bg-red-50"
                        title="Remove program"
                    >
                        <Trash2 class="h-5 w-5" />
                    </button>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <!-- Name -->
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            Program Name
                        </label>
                        <input
                            v-model="item.name"
                            type="text"
                            placeholder="Example: Robotics Club"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-orange-500"
                        />
                        <p
                            v-if="form.errors[`items.${index}.name`]"
                            class="mt-1 text-sm text-red-500"
                        >
                            {{ form.errors[`items.${index}.name`] }}
                        </p>
                    </div>

                    <!-- Icon -->
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            Lucide Icon Name
                        </label>
                        <input
                            v-model="item.icon"
                            type="text"
                            placeholder="Example: Cpu"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-orange-500"
                        />
                        <p class="mt-1 text-xs text-gray-400">
                            Use a Lucide icon name, for example: Cpu, Music, Trophy, or Code.
                        </p>
                    </div>

                    <!-- Color -->
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            Program Color
                        </label>
                        <select
                            v-model="item.color"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-orange-500"
                        >
                            <option
                                v-for="color in colorOptions"
                                :key="color.value"
                                :value="color.value"
                            >
                                {{ color.label }}
                            </option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="flex items-center">
                        <label class="flex items-center gap-3">
                            <input
                                v-model="item.is_active"
                                type="checkbox"
                                class="h-4 w-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500"
                            />
                            <span class="text-sm font-medium text-gray-700">
                                Active / Visible
                            </span>
                        </label>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            Description
                        </label>
                        <textarea
                            v-model="item.description"
                            rows="3"
                            placeholder="Describe this extracurricular program..."
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-orange-500"
                        ></textarea>
                    </div>
                </div>

                <!-- Gallery -->
                <div class="mt-6 border-t border-gray-100 pt-5">
                    <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h4 class="font-bold text-gray-800">Program Gallery</h4>
                            <p class="text-xs text-gray-500">
                                Upload multiple photos. Maximum 5 MB per image.
                            </p>
                        </div>

                        <label
                            class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-xl border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-50"
                        >
                            <ImagePlus class="h-4 w-4" />
                            Add Photos
                            <input
                                type="file"
                                accept="image/jpeg,image/png,image/webp"
                                multiple
                                class="hidden"
                                @change="addPhotos($event, item)"
                            />
                        </label>
                    </div>

                    <div
                        v-if="item.existing_photos.length || item.new_photos.length"
                        class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4"
                    >
                        <!-- Existing Photos -->
                        <div
                            v-for="(photo, photoIndex) in item.existing_photos"
                            :key="`existing-${photo.id}`"
                            class="group relative aspect-square overflow-hidden rounded-xl border border-gray-200"
                        >
                            <img
                                :src="photoUrl(photo.image)"
                                alt="Program gallery"
                                class="h-full w-full object-cover"
                            />

                            <button
                                type="button"
                                @click="removeExistingPhoto(item, photoIndex)"
                                class="absolute right-2 top-2 rounded-full bg-white/90 p-1.5 text-red-500 shadow hover:bg-white"
                                title="Remove photo"
                            >
                                <X class="h-4 w-4" />
                            </button>
                        </div>

                        <!-- New Photos -->
                        <div
                            v-for="(file, fileIndex) in item.new_photos"
                            :key="`new-photo-${fileIndex}`"
                            class="group relative aspect-square overflow-hidden rounded-xl border border-orange-200"
                        >
                            <img
                                :src="URL.createObjectURL(file)"
                                alt="New photo preview"
                                class="h-full w-full object-cover"
                            />

                            <span class="absolute bottom-0 left-0 right-0 bg-orange-500/90 px-2 py-1 text-center text-xs font-medium text-white">
                                New Photo
                            </span>

                            <button
                                type="button"
                                @click="removeNewPhoto(item, fileIndex)"
                                class="absolute right-2 top-2 rounded-full bg-white/90 p-1.5 text-red-500 shadow hover:bg-white"
                                title="Remove photo"
                            >
                                <X class="h-4 w-4" />
                            </button>
                        </div>
                    </div>

                    <div
                        v-else
                        class="rounded-xl border-2 border-dashed border-gray-200 px-4 py-8 text-center"
                    >
                        <ImagePlus class="mx-auto mb-2 h-8 w-8 text-gray-300" />
                        <p class="text-sm text-gray-400">
                            No photos uploaded for this program.
                        </p>
                    </div>

                    <p
                        v-if="form.errors[`items.${index}.new_photos`]"
                        class="mt-2 text-sm text-red-500"
                    >
                        {{ form.errors[`items.${index}.new_photos`] }}
                    </p>
                </div>
            </div>

            <!-- Bottom Save -->
            <div class="flex justify-end">
                <button
                    type="button"
                    @click="submit"
                    :disabled="form.processing"
                    class="inline-flex items-center gap-2 rounded-xl bg-orange-500 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-orange-600 disabled:opacity-60"
                >
                    <Save class="h-4 w-4" />
                    {{ form.processing ? 'Saving...' : 'Save All Changes' }}
                </button>
            </div>

        </div>
    </AdminLayout>
</template>

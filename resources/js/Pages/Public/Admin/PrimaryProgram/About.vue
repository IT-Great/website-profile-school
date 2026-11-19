
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
    Lightbulb,
    ArrowUp,
    ArrowDown,
    GripVertical,
} from 'lucide-vue-next'

const props = defineProps({
    page: {
        type: Object,
        required: true,
    },
})

const form = useForm({
    _method: 'PUT',

    badge: props.page.badge ?? '',
    title: props.page.title ?? '',
    description: props.page.description ?? '',
    second_description: props.page.second_description ?? '',
    is_active: Boolean(props.page.is_active),

    features: (props.page.features ?? []).map(feature => ({
        id: feature.id,
        icon: feature.icon ?? '',
        title: feature.title ?? '',
        description: feature.description ?? '',
        is_active: Boolean(feature.is_active),
    })),

    existing_photos: (props.page.photos ?? []).map(photo => ({
        id: photo.id,
        image: photo.image,
        caption: photo.caption ?? '',
    })),

    remove_photos: [],
    new_photos: [],
})

const addFeature = () => {
    form.features.push({
        id: null,
        icon: 'Lightbulb',
        title: '',
        description: '',
        is_active: true,
    })
}

const removeFeature = (index) => {
    if (confirm('Hapus fitur ini?')) {
        form.features.splice(index, 1)
    }
}

const moveFeature = (index, direction) => {
    const targetIndex = index + direction

    if (targetIndex < 0 || targetIndex >= form.features.length) {
        return
    }

    const feature = form.features.splice(index, 1)[0]
    form.features.splice(targetIndex, 0, feature)
}

const addPhotos = (event) => {
    const files = Array.from(event.target.files ?? [])
    form.new_photos.push(...files)
    event.target.value = ''
}

const removeNewPhoto = (index) => {
    form.new_photos.splice(index, 1)
}

const removeExistingPhoto = (index) => {
    const photo = form.existing_photos[index]

    if (photo?.id) {
        form.remove_photos.push(photo.id)
    }

    form.existing_photos.splice(index, 1)
}

const photoUrl = (path) => {
    return path ? `/storage/${path}` : ''
}

const submit = () => {
    form.post(route('admin.primary-program.about.update'), {
        forceFormData: true,
        preserveScroll: true,
    })
}
</script>

<template>
    <Head title="Manage About Primary Program" />

    <AdminLayout>
        <div class="space-y-6 pb-10">

            <!-- Header -->
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <Link
                        :href="route('admin.primary-program.index')"
                        class="mb-3 inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-orange-600"
                    >
                        <ArrowLeft class="h-4 w-4" />
                        Back to Primary Program
                    </Link>

                    <h1 class="text-2xl font-bold text-gray-800">
                        About Primary Program
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Manage the introduction, carousel photos, and program features.
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

            <!-- Main Information -->
            <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-lg font-bold text-gray-800">
                        Main Information
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Content displayed on the About Primary Program section.
                    </p>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            Badge / Eyebrow Text
                        </label>
                        <input
                            v-model="form.badge"
                            type="text"
                            placeholder="ABOUT PRIMARY PROGRAM"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                        />
                        <p v-if="form.errors.badge" class="mt-1 text-sm text-red-500">
                            {{ form.errors.badge }}
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            Main Title
                        </label>
                        <input
                            v-model="form.title"
                            type="text"
                            placeholder="Developing Confident Lifelong Learners"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                        />
                        <p v-if="form.errors.title" class="mt-1 text-sm text-red-500">
                            {{ form.errors.title }}
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            First Description
                        </label>
                        <textarea
                            v-model="form.description"
                            rows="3"
                            placeholder="Write the first paragraph..."
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                        ></textarea>
                        <p v-if="form.errors.description" class="mt-1 text-sm text-red-500">
                            {{ form.errors.description }}
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            Second Description
                        </label>
                        <textarea
                            v-model="form.second_description"
                            rows="3"
                            placeholder="Write the second paragraph..."
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                        ></textarea>
                        <p v-if="form.errors.second_description" class="mt-1 text-sm text-red-500">
                            {{ form.errors.second_description }}
                        </p>
                    </div>

                    <label class="flex items-center gap-3 border-t border-gray-100 pt-5">
                        <input
                            v-model="form.is_active"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500"
                        />
                        <span class="text-sm font-medium text-gray-700">
                            Display About section on the public website
                        </span>
                    </label>
                </div>
            </section>

            <!-- Carousel Photos -->
            <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">
                            Carousel Photos
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Upload multiple photos for the About section carousel.
                        </p>
                    </div>

                    <label
                        class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-xl border border-orange-200 bg-orange-50 px-4 py-2.5 text-sm font-semibold text-orange-600 hover:bg-orange-100"
                    >
                        <ImagePlus class="h-4 w-4" />
                        Add Photos
                        <input
                            type="file"
                            accept="image/jpeg,image/png,image/webp"
                            multiple
                            class="hidden"
                            @change="addPhotos"
                        />
                    </label>
                </div>

                <div
                    v-if="form.existing_photos.length || form.new_photos.length"
                    class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4"
                >
                    <!-- Existing photos -->
                    <div
                        v-for="(photo, index) in form.existing_photos"
                        :key="`existing-${photo.id}`"
                        class="group relative aspect-[4/3] overflow-hidden rounded-xl border border-gray-200"
                    >
                        <img
                            :src="photoUrl(photo.image)"
                            alt="About carousel"
                            class="h-full w-full object-cover"
                        />

                        <span class="absolute bottom-2 left-2 rounded-md bg-black/60 px-2 py-1 text-xs text-white">
                            Saved
                        </span>

                        <button
                            type="button"
                            @click="removeExistingPhoto(index)"
                            class="absolute right-2 top-2 rounded-full bg-white/90 p-1.5 text-red-500 shadow hover:bg-white"
                            title="Remove photo"
                        >
                            <X class="h-4 w-4" />
                        </button>
                    </div>

                    <!-- New photos -->
                    <div
                        v-for="(file, index) in form.new_photos"
                        :key="`new-${index}`"
                        class="relative aspect-[4/3] overflow-hidden rounded-xl border border-orange-200"
                    >
                        <img
                            :src="URL.createObjectURL(file)"
                            alt="New carousel preview"
                            class="h-full w-full object-cover"
                        />

                        <span class="absolute bottom-2 left-2 rounded-md bg-orange-500 px-2 py-1 text-xs text-white">
                            New Photo
                        </span>

                        <button
                            type="button"
                            @click="removeNewPhoto(index)"
                            class="absolute right-2 top-2 rounded-full bg-white/90 p-1.5 text-red-500 shadow hover:bg-white"
                            title="Remove photo"
                        >
                            <X class="h-4 w-4" />
                        </button>
                    </div>
                </div>

                <div
                    v-else
                    class="rounded-xl border-2 border-dashed border-gray-200 px-4 py-10 text-center"
                >
                    <ImagePlus class="mx-auto mb-2 h-9 w-9 text-gray-300" />
                    <p class="text-sm text-gray-400">
                        No carousel photos uploaded yet.
                    </p>
                </div>

                <p class="mt-3 text-xs text-gray-400">
                    Supported formats: JPG, JPEG, PNG, WEBP. Maximum 5 MB per photo.
                </p>

                <p v-if="form.errors.new_photos" class="mt-2 text-sm text-red-500">
                    {{ form.errors.new_photos }}
                </p>
            </section>

            <!-- Features -->
            <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">
                            Program Features
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Manage the four key features displayed beside the carousel.
                        </p>
                    </div>

                    <button
                        type="button"
                        @click="addFeature"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-orange-200 bg-orange-50 px-4 py-2.5 text-sm font-semibold text-orange-600 hover:bg-orange-100"
                    >
                        <Plus class="h-4 w-4" />
                        Add Feature
                    </button>
                </div>

                <div
                    v-if="form.features.length === 0"
                    class="rounded-xl border-2 border-dashed border-gray-200 p-8 text-center"
                >
                    <Lightbulb class="mx-auto mb-2 h-8 w-8 text-gray-300" />
                    <p class="text-sm text-gray-500">
                        No features added. Add at least one feature.
                    </p>
                </div>

                <div class="space-y-5">
                    <div
                        v-for="(feature, index) in form.features"
                        :key="feature.id ?? `new-${index}`"
                        class="rounded-xl border border-gray-200 p-5"
                    >
                        <div class="mb-5 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <GripVertical class="h-5 w-5 text-gray-300" />
                                <span class="text-sm font-bold text-gray-700">
                                    Feature {{ index + 1 }}
                                </span>

                                <button
                                    type="button"
                                    @click="moveFeature(index, -1)"
                                    :disabled="index === 0"
                                    class="rounded-md p-1.5 text-gray-500 hover:bg-gray-100 disabled:opacity-30"
                                    title="Move up"
                                >
                                    <ArrowUp class="h-4 w-4" />
                                </button>

                                <button
                                    type="button"
                                    @click="moveFeature(index, 1)"
                                    :disabled="index === form.features.length - 1"
                                    class="rounded-md p-1.5 text-gray-500 hover:bg-gray-100 disabled:opacity-30"
                                    title="Move down"
                                >
                                    <ArrowDown class="h-4 w-4" />
                                </button>
                            </div>

                            <button
                                type="button"
                                @click="removeFeature(index)"
                                class="rounded-lg p-2 text-red-500 hover:bg-red-50"
                                title="Remove feature"
                            >
                                <Trash2 class="h-4 w-4" />
                            </button>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700">
                                    Feature Title
                                </label>
                                <input
                                    v-model="feature.title"
                                    type="text"
                                    placeholder="Student-Centered"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-orange-500"
                                />
                                <p
                                    v-if="form.errors[`features.${index}.title`]"
                                    class="mt-1 text-sm text-red-500"
                                >
                                    {{ form.errors[`features.${index}.title`] }}
                                </p>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700">
                                    Lucide Icon Name
                                </label>
                                <input
                                    v-model="feature.icon"
                                    type="text"
                                    placeholder="Lightbulb"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-orange-500"
                                />
                                <p class="mt-1 text-xs text-gray-400">
                                    Example: Lightbulb, BookOpen, Users, Globe.
                                </p>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="mb-2 block text-sm font-semibold text-gray-700">
                                    Description
                                </label>
                                <textarea
                                    v-model="feature.description"
                                    rows="2"
                                    placeholder="Write a short feature description..."
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-orange-500"
                                ></textarea>
                            </div>
                        </div>

                        <label class="mt-4 flex items-center gap-3 border-t border-gray-100 pt-4">
                            <input
                                v-model="feature.is_active"
                                type="checkbox"
                                class="h-4 w-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500"
                            />
                            <span class="text-sm font-medium text-gray-700">
                                Active / Visible
                            </span>
                        </label>
                    </div>
                </div>

                <p v-if="form.errors.features" class="mt-3 text-sm text-red-500">
                    {{ form.errors.features }}
                </p>
            </section>

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

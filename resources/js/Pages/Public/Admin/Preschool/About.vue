
<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import {
    ArrowLeft,
    ArrowUp,
    ArrowDown,
    Plus,
    Trash2,
    Save,
    ImagePlus,
    Heart,
    X,
} from 'lucide-vue-next'

const props = defineProps({
    page: {
        type: Object,
        required: true,
    },
})

const form = useForm({
    _method: 'PUT',

    about_badge: props.page.about_badge ?? '',
    about_title: props.page.about_title ?? '',
    about_description: props.page.about_description ?? '',
    about_second_description: props.page.about_second_description ?? '',

    features: (props.page.features ?? []).map(item => ({
        id: item.id,
        icon: item.icon ?? '',
        title: item.title ?? '',
        description: item.description ?? '',
        is_active: Boolean(item.is_active),
    })),

    remove_photos: [],
    new_photos: [],
})

const newPhotoPreviews = ref([])

const isPhotoRemoved = (id) => {
    return form.remove_photos.includes(id)
}

const toggleRemovePhoto = (id) => {
    if (isPhotoRemoved(id)) {
        form.remove_photos = form.remove_photos.filter(item => item !== id)
    } else {
        form.remove_photos.push(id)
    }
}

const selectPhotos = (event) => {
    const files = Array.from(event.target.files ?? [])

    files.forEach(file => {
        form.new_photos.push(file)
        newPhotoPreviews.value.push({
            name: file.name,
            url: URL.createObjectURL(file),
        })
    })

    event.target.value = ''
}

const removeNewPhoto = (index) => {
    const preview = newPhotoPreviews.value[index]

    if (preview?.url) {
        URL.revokeObjectURL(preview.url)
    }

    form.new_photos.splice(index, 1)
    newPhotoPreviews.value.splice(index, 1)
}

const addFeature = () => {
    form.features.push({
        id: null,
        icon: 'Star',
        title: '',
        description: '',
        is_active: true,
    })
}

const removeFeature = (index) => {
    if (!confirm('Remove this feature?')) return

    form.features.splice(index, 1)
}

const moveFeature = (index, direction) => {
    const target = index + direction

    if (target < 0 || target >= form.features.length) return

    const items = [...form.features]
    const current = items[index]

    items[index] = items[target]
    items[target] = current

    form.features = items
}

const submit = () => {
    form.post(route('admin.preschool.about.update'), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            newPhotoPreviews.value.forEach(photo => {
                URL.revokeObjectURL(photo.url)
            })

            newPhotoPreviews.value = []
        },
    })
}
</script>

<template>
    <Head title="Manage About Preschool" />

    <AdminLayout>
        <div class="space-y-6">

            <!-- Header -->
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <Link
                        :href="route('admin.preschool.index')"
                        class="mb-3 inline-flex items-center gap-2 text-sm text-gray-500 hover:text-orange-600"
                    >
                        <ArrowLeft class="h-4 w-4" />
                        Back to Preschool
                    </Link>

                    <h1 class="text-2xl font-bold text-gray-800">
                        Manage About Preschool
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Manage the introduction, photo carousel, and preschool features.
                    </p>
                </div>

                <button
                    type="button"
                    @click="submit"
                    :disabled="form.processing"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-orange-600 disabled:opacity-50"
                >
                    <Save class="h-4 w-4" />
                    {{ form.processing ? 'Saving...' : 'Save Changes' }}
                </button>
            </div>

            <!-- Success -->
            <div
                v-if="$page.props.flash?.success"
                class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700"
            >
                {{ $page.props.flash.success }}
            </div>

            <!-- About Information -->
            <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-5 py-4">
                    <h2 class="font-semibold text-gray-800">
                        About Information
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Edit the introduction displayed at the top of the Preschool page.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-5 p-5">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Badge / Small Heading
                        </label>
                        <input
                            v-model="form.about_badge"
                            type="text"
                            placeholder="ABOUT PRESCHOOL"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-100"
                        />
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Main Title
                        </label>
                        <input
                            v-model="form.about_title"
                            type="text"
                            placeholder="A Joyful Beginning to Learning"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-100"
                        />
                        <p v-if="form.errors.about_title" class="mt-1 text-xs text-red-500">
                            {{ form.errors.about_title }}
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Description
                        </label>
                        <textarea
                            v-model="form.about_description"
                            rows="3"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-100"
                        ></textarea>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Second Description
                        </label>
                        <textarea
                            v-model="form.about_second_description"
                            rows="3"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-100"
                        ></textarea>
                    </div>
                </div>
            </section>

            <!-- Photo Carousel -->
            <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-5 py-4">
                    <h2 class="font-semibold text-gray-800">
                        Preschool Photo Carousel
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Manage photos displayed on the left side of the About section.
                    </p>
                </div>

                <div class="space-y-5 p-5">
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                        <div
                            v-for="photo in page.photos ?? []"
                            :key="photo.id"
                            class="relative overflow-hidden rounded-xl border"
                            :class="isPhotoRemoved(photo.id) ? 'border-red-300 opacity-40' : 'border-gray-200'"
                        >
                            <img
                                :src="`/storage/${photo.image}`"
                                class="h-36 w-full object-cover"
                                alt="Preschool photo"
                            />

                            <button
                                type="button"
                                @click="toggleRemovePhoto(photo.id)"
                                class="absolute right-2 top-2 rounded-full p-1.5 text-white shadow"
                                :class="isPhotoRemoved(photo.id) ? 'bg-green-500' : 'bg-red-500'"
                                :title="isPhotoRemoved(photo.id) ? 'Restore photo' : 'Remove photo'"
                            >
                                <X v-if="!isPhotoRemoved(photo.id)" class="h-4 w-4" />
                                <span v-else class="px-1 text-xs font-bold">Undo</span>
                            </button>

                            <div class="bg-white px-3 py-2 text-xs text-gray-500">
                                {{ isPhotoRemoved(photo.id) ? 'Will be removed' : 'Existing photo' }}
                            </div>
                        </div>

                        <!-- New Photo Preview -->
                        <div
                            v-for="(photo, index) in newPhotoPreviews"
                            :key="`new-${index}`"
                            class="relative overflow-hidden rounded-xl border border-green-200"
                        >
                            <img
                                :src="photo.url"
                                class="h-36 w-full object-cover"
                                alt="New preschool photo"
                            />

                            <button
                                type="button"
                                @click="removeNewPhoto(index)"
                                class="absolute right-2 top-2 rounded-full bg-red-500 p-1.5 text-white"
                            >
                                <X class="h-4 w-4" />
                            </button>

                            <div class="bg-green-50 px-3 py-2 text-xs text-green-700">
                                New photo
                            </div>
                        </div>
                    </div>

                    <label
                        class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 px-5 py-8 text-center transition hover:border-orange-400 hover:bg-orange-50"
                    >
                        <ImagePlus class="h-9 w-9 text-orange-500" />

                        <span class="mt-3 text-sm font-semibold text-gray-700">
                            Add Preschool Photos
                        </span>

                        <span class="mt-1 text-xs text-gray-500">
                            JPG, PNG, WEBP · Maximum 5 MB per image
                        </span>

                        <input
                            type="file"
                            accept="image/jpeg,image/png,image/webp"
                            multiple
                            class="hidden"
                            @change="selectPhotos"
                        />
                    </label>

                    <div v-if="form.errors.new_photos" class="text-sm text-red-500">
                        {{ form.errors.new_photos }}
                    </div>
                </div>
            </section>

            <!-- Features -->
            <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="flex flex-col gap-3 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="font-semibold text-gray-800">
                            Preschool Features
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Manage the four key features displayed below the introduction.
                        </p>
                    </div>

                    <button
                        type="button"
                        @click="addFeature"
                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-orange-300 bg-orange-50 px-4 py-2 text-sm font-semibold text-orange-600 hover:bg-orange-100"
                    >
                        <Plus class="h-4 w-4" />
                        Add Feature
                    </button>
                </div>

                <div class="space-y-4 p-5">
                    <div
                        v-for="(feature, index) in form.features"
                        :key="feature.id ?? `new-${index}`"
                        class="overflow-hidden rounded-xl border border-gray-200"
                    >
                        <div class="flex items-center justify-between bg-gray-50 px-4 py-3">
                            <div class="flex items-center gap-2">
                                <Heart class="h-4 w-4 text-orange-500" />
                                <span class="text-sm font-semibold text-gray-700">
                                    Feature {{ index + 1 }}
                                </span>
                            </div>

                            <div class="flex items-center gap-1">
                                <button
                                    type="button"
                                    @click="moveFeature(index, -1)"
                                    :disabled="index === 0"
                                    class="rounded p-2 text-gray-500 hover:bg-gray-200 disabled:opacity-30"
                                >
                                    <ArrowUp class="h-4 w-4" />
                                </button>

                                <button
                                    type="button"
                                    @click="moveFeature(index, 1)"
                                    :disabled="index === form.features.length - 1"
                                    class="rounded p-2 text-gray-500 hover:bg-gray-200 disabled:opacity-30"
                                >
                                    <ArrowDown class="h-4 w-4" />
                                </button>

                                <button
                                    type="button"
                                    @click="removeFeature(index)"
                                    class="rounded p-2 text-red-500 hover:bg-red-50"
                                >
                                    <Trash2 class="h-4 w-4" />
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 p-4 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">
                                    Feature Title
                                </label>
                                <input
                                    v-model="feature.title"
                                    type="text"
                                    placeholder="Safe & Caring"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-orange-500 focus:outline-none"
                                />
                                <p
                                    v-if="form.errors[`features.${index}.title`]"
                                    class="mt-1 text-xs text-red-500"
                                >
                                    {{ form.errors[`features.${index}.title`] }}
                                </p>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">
                                    Lucide Icon Name
                                </label>
                                <input
                                    v-model="feature.icon"
                                    type="text"
                                    placeholder="Heart"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-orange-500 focus:outline-none"
                                />
                            </div>

                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-medium text-gray-700">
                                    Description
                                </label>
                                <textarea
                                    v-model="feature.description"
                                    rows="2"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-orange-500 focus:outline-none"
                                ></textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label class="flex cursor-pointer items-center gap-2">
                                    <input
                                        v-model="feature.is_active"
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500"
                                    />
                                    <span class="text-sm text-gray-700">
                                        Active – Display this feature on the website
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div
                        v-if="form.features.length === 0"
                        class="rounded-xl border-2 border-dashed border-gray-300 px-5 py-10 text-center"
                    >
                        <Heart class="mx-auto h-8 w-8 text-gray-300" />
                        <p class="mt-2 text-sm text-gray-500">
                            No features added yet.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Bottom Save -->
            <div class="flex justify-end border-t border-gray-200 pt-5">
                <button
                    type="button"
                    @click="submit"
                    :disabled="form.processing"
                    class="inline-flex items-center gap-2 rounded-lg bg-orange-500 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-600 disabled:opacity-50"
                >
                    <Save class="h-4 w-4" />
                    {{ form.processing ? 'Saving...' : 'Save Changes' }}
                </button>
            </div>

        </div>
    </AdminLayout>
</template>

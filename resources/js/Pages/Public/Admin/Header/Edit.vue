
<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import {
    ArrowLeft, ImagePlus, Save, Globe, Eye,
    Type, Link as LinkIcon, Trash2,
} from 'lucide-vue-next'
import { computed, onBeforeUnmount, ref, watch } from 'vue'

const props = defineProps({
    page: {
        type: Object,
        required: true,
    },
})

const form = useForm({
    title: props.page.title || '',
    description: props.page.description || '',
    background_image: null,
    primary_button_text: props.page.primary_button_text || '',
    primary_button_url: props.page.primary_button_url || '',
    secondary_button_text: props.page.secondary_button_text || '',
    secondary_button_url: props.page.secondary_button_url || '',
    is_active: Boolean(props.page.is_active),
})

const imagePreview = ref(null)
const fileInput = ref(null)

const currentImage = computed(() => {
    if (!props.page.background_image) return null

    if (props.page.background_image.startsWith('http')) {
        return props.page.background_image
    }

    return `/storage/${props.page.background_image.replace(/^\/+/, '')}`
})

const displayedImage = computed(() => imagePreview.value || currentImage.value)

watch(
    () => form.background_image,
    (file) => {
        if (imagePreview.value) {
            URL.revokeObjectURL(imagePreview.value)
            imagePreview.value = null
        }

        if (file instanceof File) {
            imagePreview.value = URL.createObjectURL(file)
        }
    }
)

onBeforeUnmount(() => {
    if (imagePreview.value) {
        URL.revokeObjectURL(imagePreview.value)
    }
})

function selectImage(event) {
    const file = event.target.files?.[0]

    if (file) {
        form.background_image = file
    }
}

function removeSelectedImage() {
    form.background_image = null

    if (fileInput.value) {
        fileInput.value.value = ''
    }
}

function submit() {
    form
        .transform((data) => ({
            ...data,
            _method: 'PUT',
        }))
        .post(route('admin.header-pages.update', props.page.id), {
            forceFormData: true,
            preserveScroll: true,
        })
}
</script>

<template>
    <Head :title="`Edit ${page.title} Header`" />

    <AdminLayout>
        <div class="min-h-screen bg-slate-50 px-4 py-6 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl space-y-6">

                <!-- Header -->
                <div>
                    <div class="mb-2 flex items-center gap-2 text-sm text-slate-500">
                        <span>Website Content</span>
                        <span>/</span>
                        <Link
                            :href="route('admin.header-pages.index')"
                            class="hover:text-orange-600"
                        >
                            Header Pages
                        </Link>
                        <span>/</span>
                        <span class="text-orange-600">Edit</span>
                    </div>

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">
                                Edit {{ page.title }} Header
                            </h1>
                            <p class="mt-2 text-sm text-slate-500">
                                Configure the hero section displayed on the {{ page.title }} page.
                            </p>
                        </div>

                        <Link
                            :href="route('admin.header-pages.index')"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50"
                        >
                            <ArrowLeft class="h-4 w-4" />
                            Back to Pages
                        </Link>
                    </div>
                </div>

                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 items-start gap-6 xl:grid-cols-3">

                        <!-- Main Form -->
                        <div class="space-y-6 xl:col-span-2">

                            <!-- Basic Information -->
                            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                                <div class="flex items-center gap-3 border-b border-slate-100 p-5">
                                    <div class="rounded-xl bg-orange-50 p-2.5 text-orange-600">
                                        <Type class="h-5 w-5" />
                                    </div>
                                    <div>
                                        <h2 class="font-semibold text-slate-900">
                                            Header Information
                                        </h2>
                                        <p class="text-xs text-slate-500">
                                            Main title and description of the page.
                                        </p>
                                    </div>
                                </div>

                                <div class="space-y-5 p-5 sm:p-6">
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-slate-700">
                                            Page Name
                                        </label>
                                        <input
                                            :value="page.title"
                                            disabled
                                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500"
                                        />
                                        <p class="mt-1 text-xs text-slate-400">
                                            Page key: {{ page.page_key }}
                                        </p>
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-slate-700">
                                            Header Title <span class="text-red-500">*</span>
                                        </label>
                                        <input
                                            v-model="form.title"
                                            type="text"
                                            placeholder="Enter page heading..."
                                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                            :class="{ 'border-red-400': form.errors.title }"
                                        />
                                        <p v-if="form.errors.title" class="mt-1 text-xs text-red-500">
                                            {{ form.errors.title }}
                                        </p>
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-slate-700">
                                            Description
                                        </label>
                                        <textarea
                                            v-model="form.description"
                                            rows="5"
                                            placeholder="Write a short description for this page..."
                                            class="w-full resize-y rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                        />
                                        <p v-if="form.errors.description" class="mt-1 text-xs text-red-500">
                                            {{ form.errors.description }}
                                        </p>
                                    </div>
                                </div>
                            </section>

                            <!-- Buttons -->
                            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                                <div class="flex items-center gap-3 border-b border-slate-100 p-5">
                                    <div class="rounded-xl bg-orange-50 p-2.5 text-orange-600">
                                        <LinkIcon class="h-5 w-5" />
                                    </div>
                                    <div>
                                        <h2 class="font-semibold text-slate-900">
                                            Header Buttons
                                        </h2>
                                        <p class="text-xs text-slate-500">
                                            Configure the two call-to-action buttons.
                                        </p>
                                    </div>
                                </div>

                                <div class="space-y-6 p-5 sm:p-6">
                                    <!-- Primary -->
                                    <div class="space-y-4">
                                        <div>
                                            <h3 class="text-sm font-semibold text-slate-800">
                                                Primary Button
                                            </h3>
                                            <p class="text-xs text-slate-400">
                                                Main highlighted button.
                                            </p>
                                        </div>

                                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                            <div>
                                                <label class="mb-2 block text-sm text-slate-600">
                                                    Button Text
                                                </label>
                                                <input
                                                    v-model="form.primary_button_text"
                                                    type="text"
                                                    placeholder="Get to Know"
                                                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400"
                                                />
                                            </div>

                                            <div>
                                                <label class="mb-2 block text-sm text-slate-600">
                                                    Button URL
                                                </label>
                                                <input
                                                    v-model="form.primary_button_url"
                                                    type="text"
                                                    placeholder="/about"
                                                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400"
                                                />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border-t border-slate-100" />

                                    <!-- Secondary -->
                                    <div class="space-y-4">
                                        <div>
                                            <h3 class="text-sm font-semibold text-slate-800">
                                                Secondary Button
                                            </h3>
                                            <p class="text-xs text-slate-400">
                                                Secondary outlined button.
                                            </p>
                                        </div>

                                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                            <div>
                                                <label class="mb-2 block text-sm text-slate-600">
                                                    Button Text
                                                </label>
                                                <input
                                                    v-model="form.secondary_button_text"
                                                    type="text"
                                                    placeholder="Contact"
                                                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400"
                                                />
                                            </div>

                                            <div>
                                                <label class="mb-2 block text-sm text-slate-600">
                                                    Button URL
                                                </label>
                                                <input
                                                    v-model="form.secondary_button_url"
                                                    type="text"
                                                    placeholder="/contact"
                                                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!-- Right Sidebar -->
                        <div class="space-y-6">

                            <!-- Status -->
                            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                                <h2 class="font-semibold text-slate-900">
                                    Publishing Status
                                </h2>

                                <label class="mt-5 flex cursor-pointer items-center justify-between gap-3">
                                    <div class="flex items-center gap-3">
                                        <div class="rounded-xl bg-emerald-50 p-2.5 text-emerald-600">
                                            <Eye class="h-5 w-5" />
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-slate-800">
                                                Active
                                            </p>
                                            <p class="text-xs text-slate-400">
                                                Display header on website
                                            </p>
                                        </div>
                                    </div>

                                    <input
                                        v-model="form.is_active"
                                        type="checkbox"
                                        class="peer sr-only"
                                    />

                                    <span class="relative h-6 w-11 shrink-0 rounded-full bg-slate-300 transition peer-checked:bg-orange-500 after:absolute after:left-1 after:top-1 after:h-4 after:w-4 after:rounded-full after:bg-white after:transition peer-checked:after:translate-x-5" />
                                </label>
                            </section>

                            <!-- Background Image -->
                            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                                <div class="border-b border-slate-100 p-5">
                                    <h2 class="font-semibold text-slate-900">
                                        Background Image
                                    </h2>
                                    <p class="mt-1 text-xs text-slate-500">
                                        Hero background displayed at the top of the page.
                                    </p>
                                </div>

                                <div class="space-y-4 p-5">
                                    <div
                                        v-if="displayedImage"
                                        class="group relative overflow-hidden rounded-xl bg-slate-100"
                                    >
                                        <img
                                            :src="displayedImage"
                                            alt="Header background preview"
                                            class="h-52 w-full object-cover"
                                        />

                                        <div class="absolute inset-0 flex items-center justify-center bg-black/30 opacity-0 transition group-hover:opacity-100">
                                            <button
                                                type="button"
                                                @click="removeSelectedImage"
                                                class="inline-flex items-center gap-2 rounded-lg bg-white px-3 py-2 text-sm font-medium text-red-600"
                                            >
                                                <Trash2 class="h-4 w-4" />
                                                Remove selected image
                                            </button>
                                        </div>
                                    </div>

                                    <label
                                        class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 px-4 py-8 text-center transition hover:border-orange-300 hover:bg-orange-50/40"
                                    >
                                        <div class="mb-3 rounded-xl bg-white p-3 text-orange-500 shadow-sm">
                                            <ImagePlus class="h-6 w-6" />
                                        </div>

                                        <span class="text-sm font-semibold text-slate-700">
                                            {{ form.background_image ? 'Change Image' : 'Upload Background Image' }}
                                        </span>

                                        <span class="mt-1 text-xs text-slate-400">
                                            PNG, JPG or WEBP (Max. 5 MB)
                                        </span>

                                        <input
                                            ref="fileInput"
                                            type="file"
                                            accept="image/png,image/jpeg,image/webp"
                                            class="hidden"
                                            @change="selectImage"
                                        />
                                    </label>

                                    <p v-if="form.errors.background_image" class="text-xs text-red-500">
                                        {{ form.errors.background_image }}
                                    </p>

                                    <p class="text-xs leading-5 text-slate-400">
                                        Recommended: Landscape image with at least 1920px width.
                                    </p>
                                </div>
                            </section>

                            <!-- Page Information -->
                            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                                <h2 class="font-semibold text-slate-900">
                                    Page Information
                                </h2>

                                <div class="mt-4 space-y-3 text-sm">
                                    <div class="flex justify-between gap-3">
                                        <span class="text-slate-500">Page</span>
                                        <span class="font-medium text-slate-800">
                                            {{ page.title }}
                                        </span>
                                    </div>

                                    <div class="flex justify-between gap-3">
                                        <span class="text-slate-500">Page Key</span>
                                        <span class="font-medium text-slate-800">
                                            {{ page.page_key }}
                                        </span>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                    <!-- Bottom Actions -->
                    <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                        <Link
                            :href="route('admin.header-pages.index')"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50"
                        >
                            Cancel
                        </Link>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-orange-500 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600 disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            <Save class="h-4 w-4" />
                            {{ form.processing ? 'Saving...' : 'Save Changes' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

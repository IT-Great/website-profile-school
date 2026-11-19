
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
    ArrowUp,
    ArrowDown,
    GraduationCap,
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

    levels: (props.page.levels ?? []).map(level => ({
        id: level.id,
        name: level.name ?? '',
        grade_label: level.grade_label ?? '',
        description: level.description ?? '',
        image: level.image ?? null,
        new_image: null,
        remove_image: false,
        is_active: Boolean(level.is_active),

        points: (level.points ?? []).map(point => ({
            id: point.id,
            title: point.title ?? '',
            is_active: Boolean(point.is_active),
        })),
    })),
})

const addLevel = () => {
    form.levels.push({
        id: null,
        name: '',
        grade_label: '',
        description: '',
        image: null,
        new_image: null,
        remove_image: false,
        is_active: true,
        points: [
            {
                id: null,
                title: '',
                is_active: true,
            },
        ],
    })
}

const removeLevel = (index) => {
    if (confirm('Apakah Anda yakin ingin menghapus level ini beserta seluruh learning points-nya?')) {
        form.levels.splice(index, 1)
    }
}

const addPoint = (level) => {
    level.points.push({
        id: null,
        title: '',
        is_active: true,
    })
}

const removePoint = (level, index) => {
    if (confirm('Hapus learning point ini?')) {
        level.points.splice(index, 1)
    }
}

const movePoint = (level, index, direction) => {
    const targetIndex = index + direction

    if (targetIndex < 0 || targetIndex >= level.points.length) {
        return
    }

    const point = level.points.splice(index, 1)[0]
    level.points.splice(targetIndex, 0, point)
}

const selectImage = (event, level) => {
    const file = event.target.files?.[0]

    if (file) {
        level.new_image = file
        level.remove_image = false
    }

    event.target.value = ''
}

const removeImage = (level) => {
    level.new_image = null
    level.remove_image = true
    level.image = null
}

const imageUrl = (level) => {
    if (level.new_image) {
        return URL.createObjectURL(level.new_image)
    }

    if (level.image && !level.remove_image) {
        return `/storage/${level.image}`
    }

    return null
}

const submit = () => {
    form.post(route('admin.primary-program.levels.update'), {
        forceFormData: true,
        preserveScroll: true,
    })
}
</script>

<template>
    <Head title="Manage Primary Levels" />

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
                        Primary Levels
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Manage Lower Primary and Upper Primary information.
                    </p>
                </div>

                <button
                    type="button"
                    @click="submit"
                    :disabled="form.processing"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-orange-500 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-orange-600 disabled:opacity-60"
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

            <!-- Information -->
            <div class="rounded-2xl border border-blue-100 bg-blue-50 p-5">
                <div class="flex items-start gap-3">
                    <GraduationCap class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" />
                    <div>
                        <h3 class="font-semibold text-blue-900">
                            Primary Education Levels
                        </h3>
                        <p class="mt-1 text-sm leading-6 text-blue-800">
                            Organize the primary education stages, their grade ranges,
                            descriptions, images, and learning outcomes.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Section Header -->
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">
                        Level List
                    </h2>
                    <p class="text-sm text-gray-500">
                        Add or manage the primary education levels.
                    </p>
                </div>

                <button
                    type="button"
                    @click="addLevel"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-orange-200 bg-orange-50 px-4 py-2.5 text-sm font-semibold text-orange-600 hover:bg-orange-100"
                >
                    <Plus class="h-4 w-4" />
                    Add Level
                </button>
            </div>

            <!-- Empty State -->
            <div
                v-if="form.levels.length === 0"
                class="rounded-2xl border-2 border-dashed border-gray-300 bg-white p-10 text-center"
            >
                <GraduationCap class="mx-auto mb-3 h-10 w-10 text-gray-300" />
                <h3 class="font-semibold text-gray-700">No levels yet</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Click Add Level to create a primary education level.
                </p>
            </div>

            <!-- Level Cards -->
            <div
                v-for="(level, index) in form.levels"
                :key="level.id ?? `new-${index}`"
                class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6"
            >
                <div class="mb-5 flex items-center justify-between border-b border-gray-100 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-50 text-orange-600">
                            <GraduationCap class="h-5 w-5" />
                        </div>

                        <div>
                            <h3 class="font-bold text-gray-800">
                                Level {{ index + 1 }}
                            </h3>
                            <p class="text-xs text-gray-400">
                                {{ level.id ? `ID: ${level.id}` : 'New level' }}
                            </p>
                        </div>
                    </div>

                    <button
                        type="button"
                        @click="removeLevel(index)"
                        class="rounded-lg p-2 text-red-500 hover:bg-red-50"
                        title="Remove level"
                    >
                        <Trash2 class="h-5 w-5" />
                    </button>
                </div>

                <!-- Level Information -->
                <div class="grid gap-5 md:grid-cols-2">

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            Level Name
                        </label>
                        <input
                            v-model="level.name"
                            type="text"
                            placeholder="Lower Primary"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-orange-500"
                        />
                        <p
                            v-if="form.errors[`levels.${index}.name`]"
                            class="mt-1 text-sm text-red-500"
                        >
                            {{ form.errors[`levels.${index}.name`] }}
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            Grade Label
                        </label>
                        <input
                            v-model="level.grade_label"
                            type="text"
                            placeholder="Grades 1 – 3"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-orange-500"
                        />
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            Description
                        </label>
                        <textarea
                            v-model="level.description"
                            rows="3"
                            placeholder="Describe this primary education level..."
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-orange-500"
                        ></textarea>
                    </div>

                    <!-- Image -->
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            Level Image
                        </label>

                        <div class="flex flex-col gap-4 sm:flex-row">
                            <div class="flex h-44 w-full items-center justify-center overflow-hidden rounded-xl border border-gray-200 bg-gray-50 sm:w-64">
                                <img
                                    v-if="imageUrl(level)"
                                    :src="imageUrl(level)"
                                    alt="Primary level"
                                    class="h-full w-full object-cover"
                                />

                                <div v-else class="text-center text-gray-400">
                                    <ImagePlus class="mx-auto mb-2 h-8 w-8" />
                                    <span class="text-xs">No image selected</span>
                                </div>
                            </div>

                            <div class="flex flex-col items-start justify-center gap-3">
                                <label
                                    class="inline-flex cursor-pointer items-center gap-2 rounded-xl border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-50"
                                >
                                    <ImagePlus class="h-4 w-4" />
                                    {{ level.image || level.new_image ? 'Change Image' : 'Upload Image' }}

                                    <input
                                        type="file"
                                        accept="image/jpeg,image/png,image/webp"
                                        class="hidden"
                                        @change="selectImage($event, level)"
                                    />
                                </label>

                                <button
                                    v-if="level.image || level.new_image"
                                    type="button"
                                    @click="removeImage(level)"
                                    class="inline-flex items-center gap-2 text-sm font-medium text-red-500 hover:text-red-600"
                                >
                                    <X class="h-4 w-4" />
                                    Remove Image
                                </button>

                                <p class="text-xs text-gray-400">
                                    JPG, PNG, WEBP. Maximum 5 MB.
                                </p>

                                <p
                                    v-if="form.errors[`levels.${index}.new_image`]"
                                    class="text-sm text-red-500"
                                >
                                    {{ form.errors[`levels.${index}.new_image`] }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="md:col-span-2">
                        <label class="flex items-center gap-3 border-t border-gray-100 pt-4">
                            <input
                                v-model="level.is_active"
                                type="checkbox"
                                class="h-4 w-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500"
                            />
                            <span class="text-sm font-medium text-gray-700">
                                Active / Visible
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Learning Points -->
                <div class="mt-7 border-t border-gray-100 pt-6">
                    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h4 class="font-bold text-gray-800">
                                Learning Points
                            </h4>
                            <p class="text-xs text-gray-500">
                                Key learning outcomes for this level.
                            </p>
                        </div>

                        <button
                            type="button"
                            @click="addPoint(level)"
                            class="inline-flex items-center gap-2 rounded-lg border border-gray-200 px-3 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50"
                        >
                            <Plus class="h-4 w-4" />
                            Add Point
                        </button>
                    </div>

                    <div
                        v-if="level.points.length === 0"
                        class="rounded-xl border-2 border-dashed border-gray-200 p-5 text-center text-sm text-gray-400"
                    >
                        No learning points. Add at least one point.
                    </div>

                    <div class="space-y-3">
                        <div
                            v-for="(point, pointIndex) in level.points"
                            :key="point.id ?? `point-${index}-${pointIndex}`"
                            class="flex flex-col gap-3 rounded-xl border border-gray-200 p-3 sm:flex-row sm:items-center"
                        >
                            <div class="flex items-center gap-1">
                                <GripVertical class="h-4 w-4 text-gray-300" />

                                <button
                                    type="button"
                                    @click="movePoint(level, pointIndex, -1)"
                                    :disabled="pointIndex === 0"
                                    class="rounded p-1 text-gray-500 hover:bg-gray-100 disabled:opacity-30"
                                    title="Move up"
                                >
                                    <ArrowUp class="h-4 w-4" />
                                </button>

                                <button
                                    type="button"
                                    @click="movePoint(level, pointIndex, 1)"
                                    :disabled="pointIndex === level.points.length - 1"
                                    class="rounded p-1 text-gray-500 hover:bg-gray-100 disabled:opacity-30"
                                    title="Move down"
                                >
                                    <ArrowDown class="h-4 w-4" />
                                </button>
                            </div>

                            <div class="min-w-0 flex-1">
                                <input
                                    v-model="point.title"
                                    type="text"
                                    placeholder="Enter learning point..."
                                    class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm outline-none focus:border-orange-500"
                                />

                                <p
                                    v-if="form.errors[`levels.${index}.points.${pointIndex}.title`]"
                                    class="mt-1 text-xs text-red-500"
                                >
                                    {{ form.errors[`levels.${index}.points.${pointIndex}.title`] }}
                                </p>
                            </div>

                            <label class="flex items-center gap-2 text-xs text-gray-600">
                                <input
                                    v-model="point.is_active"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-orange-500"
                                />
                                Active
                            </label>

                            <button
                                type="button"
                                @click="removePoint(level, pointIndex)"
                                class="self-end rounded-lg p-2 text-red-500 hover:bg-red-50 sm:self-auto"
                                title="Remove point"
                            >
                                <Trash2 class="h-4 w-4" />
                            </button>
                        </div>
                    </div>

                    <p
                        v-if="form.errors[`levels.${index}.points`]"
                        class="mt-2 text-sm text-red-500"
                    >
                        {{ form.errors[`levels.${index}.points`] }}
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

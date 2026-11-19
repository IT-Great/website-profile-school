
<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import {
    ArrowLeft,
    ArrowUp,
    ArrowDown,
    Plus,
    Trash2,
    Save,
    ImagePlus,
    X,
    GraduationCap,
    ListChecks,
} from 'lucide-vue-next'

const props = defineProps({
    page: {
        type: Object,
        required: true,
    },
})

const form = useForm({
    _method: 'PUT',

    classes: (props.page.classes ?? []).map((item, index) => ({
        id: item.id,
        name: item.name ?? '',
        age_range: item.age_range ?? '',
        description: item.description ?? '',
        image: item.image ?? null,
        new_image: null,
        preview_url: null,
        remove_image: false,
        button_text: item.button_text ?? 'Learn More',
        button_url: item.button_url ?? '',
        is_active: Boolean(item.is_active),

        points: (item.points ?? []).map(point => ({
            id: point.id,
            title: point.title ?? '',
            is_active: Boolean(point.is_active),
        })),
    })),
})

const addClass = () => {
    form.classes.push({
        id: null,
        name: '',
        age_range: '',
        description: '',
        image: null,
        new_image: null,
        preview_url: null,
        remove_image: false,
        button_text: 'Learn More',
        button_url: '',
        is_active: true,
        points: [],
    })
}

const removeClass = (index) => {
    if (!confirm('Are you sure you want to remove this class?')) {
        return
    }

    const item = form.classes[index]

    if (item.preview_url) {
        URL.revokeObjectURL(item.preview_url)
    }

    form.classes.splice(index, 1)
}

const moveClass = (index, direction) => {
    const target = index + direction

    if (target < 0 || target >= form.classes.length) return

    const items = [...form.classes]
    const current = items[index]

    items[index] = items[target]
    items[target] = current

    form.classes = items
}

const selectImage = (event, item) => {
    const file = event.target.files?.[0]

    if (!file) return

    if (item.preview_url) {
        URL.revokeObjectURL(item.preview_url)
    }

    item.new_image = file
    item.preview_url = URL.createObjectURL(file)
    item.remove_image = false

    event.target.value = ''
}

const removeImage = (item) => {
    if (item.preview_url) {
        URL.revokeObjectURL(item.preview_url)
    }

    item.preview_url = null
    item.new_image = null
    item.image = null
    item.remove_image = true
}

const addPoint = (item) => {
    item.points.push({
        id: null,
        title: '',
        is_active: true,
    })
}

const removePoint = (item, index) => {
    item.points.splice(index, 1)
}

const movePoint = (item, index, direction) => {
    const target = index + direction

    if (target < 0 || target >= item.points.length) return

    const items = [...item.points]
    const current = items[index]

    items[index] = items[target]
    items[target] = current

    item.points = items
}

const submit = () => {
    form.post(route('admin.preschool.classes.update'), {
        forceFormData: true,
        preserveScroll: true,
    })
}
</script>

<template>
    <Head title="Manage Preschool Classes" />

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
                        Manage Our Classes
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Manage class information, photos, age ranges, and learning points.
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

            <!-- Success Message -->
            <div
                v-if="$page.props.flash?.success"
                class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700"
            >
                {{ $page.props.flash.success }}
            </div>

            <!-- Information -->
            <div class="flex gap-3 rounded-xl border border-blue-100 bg-blue-50 p-4">
                <GraduationCap class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" />
                <div>
                    <h3 class="text-sm font-semibold text-blue-800">
                        Preschool Classes
                    </h3>
                    <p class="mt-1 text-sm text-blue-700">
                        Organize each class according to the children's age and
                        developmental stage. Add learning points to highlight
                        the skills children will develop.
                    </p>
                </div>
            </div>

            <!-- Class List -->
            <div class="space-y-6">
                <div
                    v-for="(item, index) in form.classes"
                    :key="item.id ?? `new-${index}`"
                    class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm"
                >
                    <!-- Card Header -->
                    <div class="flex items-center justify-between border-b border-gray-100 bg-gray-50 px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-orange-100 text-orange-600">
                                <GraduationCap class="h-5 w-5" />
                            </div>

                            <div>
                                <h3 class="font-semibold text-gray-800">
                                    Class {{ index + 1 }}
                                </h3>
                                <p class="text-xs text-gray-500">
                                    {{ item.name || 'New class' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-1">
                            <button
                                type="button"
                                @click="moveClass(index, -1)"
                                :disabled="index === 0"
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 disabled:opacity-30"
                                title="Move up"
                            >
                                <ArrowUp class="h-4 w-4" />
                            </button>

                            <button
                                type="button"
                                @click="moveClass(index, 1)"
                                :disabled="index === form.classes.length - 1"
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 disabled:opacity-30"
                                title="Move down"
                            >
                                <ArrowDown class="h-4 w-4" />
                            </button>

                            <button
                                type="button"
                                @click="removeClass(index)"
                                class="rounded-lg p-2 text-red-500 hover:bg-red-50"
                                title="Remove class"
                            >
                                <Trash2 class="h-4 w-4" />
                            </button>
                        </div>
                    </div>

                    <div class="space-y-6 p-5">

                        <!-- Basic Information -->
                        <div>
                            <h4 class="mb-4 text-sm font-semibold text-gray-800">
                                Class Information
                            </h4>

                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">
                                        Class Name
                                    </label>

                                    <input
                                        v-model="item.name"
                                        type="text"
                                        placeholder="Example: Nursery"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-100"
                                    />

                                    <p
                                        v-if="form.errors[`classes.${index}.name`]"
                                        class="mt-1 text-xs text-red-500"
                                    >
                                        {{ form.errors[`classes.${index}.name`] }}
                                    </p>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">
                                        Age Range
                                    </label>

                                    <input
                                        v-model="item.age_range"
                                        type="text"
                                        placeholder="Example: Ages 1 – 2 Years"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-100"
                                    />
                                </div>

                                <div class="md:col-span-2">
                                    <label class="mb-2 block text-sm font-medium text-gray-700">
                                        Description
                                    </label>

                                    <textarea
                                        v-model="item.description"
                                        rows="3"
                                        placeholder="Write a description about this class..."
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-100"
                                    ></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Class Image -->
                        <div>
                            <h4 class="mb-4 text-sm font-semibold text-gray-800">
                                Class Photo
                            </h4>

                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                                <div
                                    v-if="item.preview_url || (item.image && !item.remove_image)"
                                    class="relative w-full overflow-hidden rounded-xl border border-gray-200 sm:w-64"
                                >
                                    <img
                                        :src="item.preview_url || `/storage/${item.image}`"
                                        class="h-44 w-full object-cover"
                                        alt="Class photo"
                                    />

                                    <button
                                        type="button"
                                        @click="removeImage(item)"
                                        class="absolute right-2 top-2 rounded-full bg-red-500 p-2 text-white shadow hover:bg-red-600"
                                    >
                                        <X class="h-4 w-4" />
                                    </button>
                                </div>

                                <label
                                    class="flex min-h-44 w-full cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 p-5 text-center hover:border-orange-400 hover:bg-orange-50 sm:flex-1"
                                >
                                    <ImagePlus class="h-9 w-9 text-orange-500" />

                                    <span class="mt-3 text-sm font-semibold text-gray-700">
                                        {{ item.image || item.new_image ? 'Change Photo' : 'Upload Class Photo' }}
                                    </span>

                                    <span class="mt-1 text-xs text-gray-500">
                                        JPG, PNG, WEBP · Maximum 5 MB
                                    </span>

                                    <input
                                        type="file"
                                        accept="image/jpeg,image/png,image/webp"
                                        class="hidden"
                                        @change="selectImage($event, item)"
                                    />
                                </label>
                            </div>

                            <p
                                v-if="form.errors[`classes.${index}.new_image`]"
                                class="mt-2 text-xs text-red-500"
                            >
                                {{ form.errors[`classes.${index}.new_image`] }}
                            </p>
                        </div>

                        <!-- Learning Points -->
                        <div class="rounded-xl border border-gray-200">
                            <div class="flex flex-col gap-3 border-b border-gray-100 bg-gray-50 px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <ListChecks class="h-4 w-4 text-orange-500" />
                                        <h4 class="text-sm font-semibold text-gray-800">
                                            Learning Points
                                        </h4>
                                    </div>

                                    <p class="mt-1 text-xs text-gray-500">
                                        Skills and learning outcomes for this class.
                                    </p>
                                </div>

                                <button
                                    type="button"
                                    @click="addPoint(item)"
                                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-orange-300 bg-orange-50 px-3 py-2 text-xs font-semibold text-orange-600 hover:bg-orange-100"
                                >
                                    <Plus class="h-4 w-4" />
                                    Add Point
                                </button>
                            </div>

                            <div class="space-y-3 p-4">
                                <div
                                    v-for="(point, pointIndex) in item.points"
                                    :key="point.id ?? `point-${index}-${pointIndex}`"
                                    class="flex flex-col gap-3 rounded-lg border border-gray-100 p-3 sm:flex-row sm:items-center"
                                >
                                    <div class="flex flex-1 items-center gap-3">
                                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-orange-50 text-xs font-semibold text-orange-600">
                                            {{ pointIndex + 1 }}
                                        </span>

                                        <div class="min-w-0 flex-1">
                                            <input
                                                v-model="point.title"
                                                type="text"
                                                placeholder="Enter learning point..."
                                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-orange-500 focus:outline-none"
                                            />

                                            <p
                                                v-if="form.errors[`classes.${index}.points.${pointIndex}.title`]"
                                                class="mt-1 text-xs text-red-500"
                                            >
                                                {{ form.errors[`classes.${index}.points.${pointIndex}.title`] }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between gap-2 sm:justify-end">
                                        <label class="flex items-center gap-2 text-xs text-gray-600">
                                            <input
                                                v-model="point.is_active"
                                                type="checkbox"
                                                class="h-4 w-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500"
                                            />
                                            Active
                                        </label>

                                        <div class="flex items-center gap-1">
                                            <button
                                                type="button"
                                                @click="movePoint(item, pointIndex, -1)"
                                                :disabled="pointIndex === 0"
                                                class="rounded p-2 text-gray-500 hover:bg-gray-100 disabled:opacity-30"
                                            >
                                                <ArrowUp class="h-4 w-4" />
                                            </button>

                                            <button
                                                type="button"
                                                @click="movePoint(item, pointIndex, 1)"
                                                :disabled="pointIndex === item.points.length - 1"
                                                class="rounded p-2 text-gray-500 hover:bg-gray-100 disabled:opacity-30"
                                            >
                                                <ArrowDown class="h-4 w-4" />
                                            </button>

                                            <button
                                                type="button"
                                                @click="removePoint(item, pointIndex)"
                                                class="rounded p-2 text-red-500 hover:bg-red-50"
                                            >
                                                <Trash2 class="h-4 w-4" />
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    v-if="item.points.length === 0"
                                    class="rounded-lg border-2 border-dashed border-gray-200 px-4 py-8 text-center"
                                >
                                    <ListChecks class="mx-auto h-7 w-7 text-gray-300" />
                                    <p class="mt-2 text-sm text-gray-500">
                                        No learning points added yet.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Button Settings -->
                        <div>
                            <h4 class="mb-4 text-sm font-semibold text-gray-800">
                                Learn More Button
                            </h4>

                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">
                                        Button Text
                                    </label>

                                    <input
                                        v-model="item.button_text"
                                        type="text"
                                        placeholder="Learn More"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-orange-500 focus:outline-none"
                                    />
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">
                                        Button URL
                                    </label>

                                    <input
                                        v-model="item.button_url"
                                        type="text"
                                        placeholder="/program/preschool/nursery"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-orange-500 focus:outline-none"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="border-t border-gray-100 pt-4">
                            <label class="flex cursor-pointer items-center gap-3">
                                <input
                                    v-model="item.is_active"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500"
                                />

                                <span class="text-sm font-medium text-gray-700">
                                    Active – Display this class on the website
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div
                    v-if="form.classes.length === 0"
                    class="rounded-xl border-2 border-dashed border-gray-300 bg-white px-6 py-12 text-center"
                >
                    <GraduationCap class="mx-auto h-10 w-10 text-gray-300" />
                    <h3 class="mt-3 font-semibold text-gray-700">
                        No classes added
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Click the button below to add your first class.
                    </p>
                </div>
            </div>

            <!-- Add Class -->
            <button
                type="button"
                @click="addClass"
                class="inline-flex items-center gap-2 rounded-lg border border-orange-300 bg-orange-50 px-4 py-2.5 text-sm font-semibold text-orange-600 hover:bg-orange-100"
            >
                <Plus class="h-4 w-4" />
                Add Class
            </button>

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

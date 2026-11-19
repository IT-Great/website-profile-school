
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
    Palette,
    GraduationCap,
} from 'lucide-vue-next'

const props = defineProps({
    page: {
        type: Object,
        required: true,
    },
})

const form = useForm({
    extracurriculars: (props.page.extracurriculars ?? []).map(item => ({
        id: item.id,
        name: item.name ?? '',
        description: item.description ?? '',
        icon: item.icon ?? '',
        color: item.color ?? '#F97316',
        is_active: Boolean(item.is_active),
    })),
})

const addActivity = () => {
    form.extracurriculars.push({
        id: null,
        name: '',
        description: '',
        icon: 'Star',
        color: '#F97316',
        is_active: true,
    })
}

const removeActivity = (index) => {
    if (!confirm('Are you sure you want to remove this activity?')) {
        return
    }

    form.extracurriculars.splice(index, 1)
}

const moveActivity = (index, direction) => {
    const target = index + direction

    if (target < 0 || target >= form.extracurriculars.length) {
        return
    }

    const items = [...form.extracurriculars]
    const current = items[index]

    items[index] = items[target]
    items[target] = current

    form.extracurriculars = items
}

const submit = () => {
    form.put(route('admin.primary-program.extracurricular.update'), {
        preserveScroll: true,
    })
}
</script>

<template>
    <Head title="Manage Extracurricular Activities" />

    <AdminLayout>
        <div class="space-y-6">

            <!-- Header -->
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <Link
                        :href="route('admin.primary-program.index')"
                        class="mb-3 inline-flex items-center gap-2 text-sm text-gray-500 hover:text-orange-600"
                    >
                        <ArrowLeft class="h-4 w-4" />
                        Back to Primary Program
                    </Link>

                    <h1 class="text-2xl font-bold text-gray-800">
                        Manage Extracurricular Activities
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Manage extracurricular activities displayed on the Primary Program page.
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
                        Extracurricular Content
                    </h3>
                    <p class="mt-1 text-sm text-blue-700">
                        Add activities that support students' creativity, interests,
                        talents, and personal development.
                    </p>
                </div>
            </div>

            <!-- Activity List -->
            <div class="space-y-5">
                <div
                    v-for="(item, index) in form.extracurriculars"
                    :key="item.id ?? `new-${index}`"
                    class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm"
                >
                    <!-- Card Header -->
                    <div class="flex items-center justify-between border-b border-gray-100 bg-gray-50 px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-lg text-white"
                                :style="{ backgroundColor: item.color || '#F97316' }"
                            >
                                <Palette class="h-5 w-5" />
                            </div>

                            <div>
                                <h3 class="font-semibold text-gray-800">
                                    Activity {{ index + 1 }}
                                </h3>
                                <p class="text-xs text-gray-500">
                                    {{ item.name || 'New activity' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-1">
                            <button
                                type="button"
                                @click="moveActivity(index, -1)"
                                :disabled="index === 0"
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 disabled:opacity-30"
                                title="Move up"
                            >
                                <ArrowUp class="h-4 w-4" />
                            </button>

                            <button
                                type="button"
                                @click="moveActivity(index, 1)"
                                :disabled="index === form.extracurriculars.length - 1"
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 disabled:opacity-30"
                                title="Move down"
                            >
                                <ArrowDown class="h-4 w-4" />
                            </button>

                            <button
                                type="button"
                                @click="removeActivity(index)"
                                class="rounded-lg p-2 text-red-500 hover:bg-red-50"
                                title="Remove activity"
                            >
                                <Trash2 class="h-4 w-4" />
                            </button>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2">

                        <!-- Activity Name -->
                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Activity Name
                            </label>

                            <input
                                v-model="item.name"
                                type="text"
                                placeholder="Example: Music"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-100"
                            />

                            <p
                                v-if="form.errors[`extracurriculars.${index}.name`]"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ form.errors[`extracurriculars.${index}.name`] }}
                            </p>
                        </div>

                        <!-- Icon -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Lucide Icon Name
                            </label>

                            <input
                                v-model="item.icon"
                                type="text"
                                placeholder="Example: Music"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-100"
                            />

                            <p class="mt-1 text-xs text-gray-400">
                                Example: Music, Palette, Trophy, Code, Camera.
                            </p>
                        </div>

                        <!-- Color -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Theme Color
                            </label>

                            <div class="flex items-center gap-3">
                                <input
                                    v-model="item.color"
                                    type="color"
                                    class="h-11 w-14 cursor-pointer rounded-lg border border-gray-300 bg-white p-1"
                                />

                                <input
                                    v-model="item.color"
                                    type="text"
                                    placeholder="#F97316"
                                    class="min-w-0 flex-1 rounded-lg border border-gray-300 px-3 py-2.5 text-sm uppercase focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-100"
                                />
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Description
                            </label>

                            <textarea
                                v-model="item.description"
                                rows="4"
                                placeholder="Write a short description about this activity..."
                                class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-100"
                            ></textarea>
                        </div>

                        <!-- Status -->
                        <div class="md:col-span-2">
                            <label class="flex cursor-pointer items-center gap-3">
                                <input
                                    v-model="item.is_active"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500"
                                />

                                <span class="text-sm font-medium text-gray-700">
                                    Active – Display this activity on the website
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div
                    v-if="form.extracurriculars.length === 0"
                    class="rounded-xl border-2 border-dashed border-gray-300 bg-white px-6 py-12 text-center"
                >
                    <GraduationCap class="mx-auto h-10 w-10 text-gray-300" />

                    <h3 class="mt-3 font-semibold text-gray-700">
                        No extracurricular activities
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Click the button below to add your first activity.
                    </p>
                </div>
            </div>

            <!-- Add Activity -->
            <button
                type="button"
                @click="addActivity"
                class="inline-flex items-center gap-2 rounded-lg border border-orange-300 bg-orange-50 px-4 py-2.5 text-sm font-semibold text-orange-600 hover:bg-orange-100"
            >
                <Plus class="h-4 w-4" />
                Add Activity
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


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
    BookOpen,
    Layers,
} from 'lucide-vue-next'

const props = defineProps({
    page: {
        type: Object,
        required: true,
    },
})

const form = useForm({
    _method: 'PUT',
    curriculums: (props.page.curriculums ?? []).map(item => ({
        id: item.id,
        name: item.name ?? '',
        short_name: item.short_name ?? '',
        icon: item.icon ?? '',
        description: item.description ?? '',
        is_active: Boolean(item.is_active),
    })),
})

const addCurriculum = () => {
    form.curriculums.push({
        id: null,
        name: '',
        short_name: '',
        icon: 'BookOpen',
        description: '',
        is_active: true,
    })
}

const removeCurriculum = (index) => {
    if (!confirm('Are you sure you want to remove this curriculum?')) {
        return
    }

    form.curriculums.splice(index, 1)
}

const moveCurriculum = (index, direction) => {
    const target = index + direction

    if (target < 0 || target >= form.curriculums.length) {
        return
    }

    const items = [...form.curriculums]
    const current = items[index]

    items[index] = items[target]
    items[target] = current

    form.curriculums = items
}

const submit = () => {
    form.post(route('admin.primary-program.curriculum.update'), {
        forceFormData: true,
        preserveScroll: true,
    })
}
</script>

<template>
    <Head title="Manage Primary Curriculum" />

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
                        Manage Curriculum
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Manage curriculum information displayed on the Primary Program page.
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

            <!-- Curriculum List -->
            <div class="space-y-5">
                <div
                    v-for="(item, index) in form.curriculums"
                    :key="item.id ?? `new-${index}`"
                    class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm"
                >
                    <div class="flex items-center justify-between border-b border-gray-100 bg-gray-50 px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-orange-100 text-orange-600">
                                <BookOpen class="h-5 w-5" />
                            </div>

                            <div>
                                <h3 class="font-semibold text-gray-800">
                                    Curriculum {{ index + 1 }}
                                </h3>
                                <p class="text-xs text-gray-500">
                                    Manage curriculum details
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-1">
                            <button
                                type="button"
                                @click="moveCurriculum(index, -1)"
                                :disabled="index === 0"
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 disabled:opacity-30"
                                title="Move up"
                            >
                                <ArrowUp class="h-4 w-4" />
                            </button>

                            <button
                                type="button"
                                @click="moveCurriculum(index, 1)"
                                :disabled="index === form.curriculums.length - 1"
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 disabled:opacity-30"
                                title="Move down"
                            >
                                <ArrowDown class="h-4 w-4" />
                            </button>

                            <button
                                type="button"
                                @click="removeCurriculum(index)"
                                class="rounded-lg p-2 text-red-500 hover:bg-red-50"
                                title="Remove curriculum"
                            >
                                <Trash2 class="h-4 w-4" />
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2">

                        <!-- Name -->
                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Curriculum Name
                            </label>
                            <input
                                v-model="item.name"
                                type="text"
                                placeholder="Example: Cambridge International Curriculum"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-100"
                            />
                            <p v-if="form.errors[`curriculums.${index}.name`]" class="mt-1 text-xs text-red-500">
                                {{ form.errors[`curriculums.${index}.name`] }}
                            </p>
                        </div>

                        <!-- Short Name -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Short Name
                            </label>
                            <input
                                v-model="item.short_name"
                                type="text"
                                placeholder="Example: Cambridge"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-100"
                            />
                        </div>

                        <!-- Icon -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Icon Name
                            </label>
                            <input
                                v-model="item.icon"
                                type="text"
                                placeholder="Example: BookOpen"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-100"
                            />
                            <p class="mt-1 text-xs text-gray-400">
                                Enter a Lucide icon name, for example BookOpen or Globe.
                            </p>
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Description
                            </label>
                            <textarea
                                v-model="item.description"
                                rows="4"
                                placeholder="Write a short description about this curriculum..."
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
                                    Active – Display this curriculum on the website
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div
                    v-if="form.curriculums.length === 0"
                    class="rounded-xl border-2 border-dashed border-gray-300 bg-white px-6 py-12 text-center"
                >
                    <Layers class="mx-auto h-10 w-10 text-gray-300" />
                    <h3 class="mt-3 font-semibold text-gray-700">
                        No curriculum added
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Click the button below to add your first curriculum.
                    </p>
                </div>
            </div>

            <!-- Add Button -->
            <button
                type="button"
                @click="addCurriculum"
                class="inline-flex items-center gap-2 rounded-lg border border-orange-300 bg-orange-50 px-4 py-2.5 text-sm font-semibold text-orange-600 hover:bg-orange-100"
            >
                <Plus class="h-4 w-4" />
                Add Curriculum
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

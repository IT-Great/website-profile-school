
<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import {
    ArrowLeft,
    Plus,
    Trash2,
    Save,
    GripVertical,
    BookOpen,
} from 'lucide-vue-next'

const props = defineProps({
    page: {
        type: Object,
        required: true,
    },
})

const form = useForm({
    curriculums: (props.page.curriculums ?? []).map(item => ({
        id: item.id,
        name: item.name ?? '',
        short_name: item.short_name ?? '',
        icon: item.icon ?? 'book-open',
        description: item.description ?? '',
        is_active: Boolean(item.is_active),
    })),
})

const addCurriculum = () => {
    form.curriculums.push({
        id: null,
        name: '',
        short_name: '',
        icon: 'book-open',
        description: '',
        is_active: true,
    })
}

const removeCurriculum = (index) => {
    if (confirm('Are you sure you want to remove this curriculum?')) {
        form.curriculums.splice(index, 1)
    }
}

const submit = () => {
    form.put(route('admin.secondary-program.curriculum.update'), {
        preserveScroll: true,
    })
}
</script>

<template>
    <Head title="Manage Curriculum" />

    <AdminLayout>
        <div class="space-y-6 pb-10">

            <!-- Header -->
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <Link
                        :href="route('admin.secondary-program.index')"
                        class="mb-3 inline-flex items-center gap-2 text-sm text-gray-500 hover:text-orange-600"
                    >
                        <ArrowLeft class="h-4 w-4" />
                        Back to Secondary Program
                    </Link>

                    <h1 class="text-2xl font-bold text-gray-800">
                        Manage Curriculum
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Manage the curriculum programs offered in Secondary School.
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

            <!-- Information -->
            <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4">
                <div class="flex gap-3">
                    <BookOpen class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" />
                    <div>
                        <h3 class="text-sm font-semibold text-blue-800">
                            Curriculum Information
                        </h3>
                        <p class="mt-1 text-sm text-blue-700">
                            Add and manage the curriculum offered by Great Crystal School.
                            For example, Cambridge Curriculum and Kurikulum Merdeka.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Curriculum List -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">

                <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">
                            Curriculum List
                        </h2>
                        <p class="text-sm text-gray-500">
                            {{ form.curriculums.length }} curriculum item(s)
                        </p>
                    </div>

                    <button
                        type="button"
                        @click="addCurriculum"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-orange-200 bg-orange-50 px-4 py-2.5 text-sm font-semibold text-orange-600 transition hover:bg-orange-100"
                    >
                        <Plus class="h-4 w-4" />
                        Add Curriculum
                    </button>
                </div>

                <div class="space-y-5">
                    <div
                        v-for="(curriculum, index) in form.curriculums"
                        :key="curriculum.id ?? `new-${index}`"
                        class="rounded-xl border border-gray-200 p-4 sm:p-5"
                    >
                        <!-- Item Header -->
                        <div class="mb-5 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <GripVertical class="h-5 w-5 text-gray-400" />
                                <span class="text-sm font-bold text-gray-700">
                                    Curriculum {{ index + 1 }}
                                </span>
                            </div>

                            <button
                                type="button"
                                @click="removeCurriculum(index)"
                                class="rounded-lg p-2 text-red-500 transition hover:bg-red-50"
                                title="Remove curriculum"
                            >
                                <Trash2 class="h-4 w-4" />
                            </button>
                        </div>

                        <!-- Name and Short Name -->
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700">
                                    Curriculum Name
                                </label>

                                <input
                                    v-model="curriculum.name"
                                    type="text"
                                    placeholder="Cambridge Curriculum"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500"
                                />

                                <p
                                    v-if="form.errors[`curriculums.${index}.name`]"
                                    class="mt-1 text-xs text-red-500"
                                >
                                    {{ form.errors[`curriculums.${index}.name`] }}
                                </p>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700">
                                    Short Name
                                </label>

                                <input
                                    v-model="curriculum.short_name"
                                    type="text"
                                    placeholder="CIE"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500"
                                />
                            </div>
                        </div>

                        <!-- Icon -->
                        <div class="mt-4">
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Icon Name
                            </label>

                            <input
                                v-model="curriculum.icon"
                                type="text"
                                placeholder="book-open"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500"
                            />

                            <p class="mt-1 text-xs text-gray-400">
                                Use Lucide icon name, e.g. book-open, graduation-cap, globe.
                            </p>
                        </div>

                        <!-- Description -->
                        <div class="mt-4">
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Description
                            </label>

                            <textarea
                                v-model="curriculum.description"
                                rows="4"
                                placeholder="Describe this curriculum..."
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500"
                            />

                            <p
                                v-if="form.errors[`curriculums.${index}.description`]"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ form.errors[`curriculums.${index}.description`] }}
                            </p>
                        </div>

                        <!-- Status -->
                        <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-4">
                            <div>
                                <p class="text-sm font-medium text-gray-700">
                                    Curriculum Status
                                </p>
                                <p class="text-xs text-gray-400">
                                    Only active curriculum will be displayed publicly.
                                </p>
                            </div>

                            <label class="flex cursor-pointer items-center gap-2">
                                <input
                                    v-model="curriculum.is_active"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500"
                                />
                                <span class="text-sm font-medium text-gray-700">
                                    Active
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Empty state -->
                    <div
                        v-if="form.curriculums.length === 0"
                        class="rounded-xl border-2 border-dashed border-gray-200 py-12 text-center"
                    >
                        <BookOpen class="mx-auto mb-3 h-8 w-8 text-gray-300" />

                        <p class="text-sm font-medium text-gray-600">
                            No curriculum available
                        </p>

                        <p class="mt-1 text-xs text-gray-400">
                            Click Add Curriculum to create your first item.
                        </p>
                    </div>

                    <p v-if="form.errors.curriculums" class="text-sm text-red-500">
                        {{ form.errors.curriculums }}
                    </p>
                </div>
            </div>

            <!-- Bottom Save -->
            <div class="flex justify-end">
                <button
                    type="button"
                    @click="submit"
                    :disabled="form.processing"
                    class="inline-flex items-center gap-2 rounded-xl bg-orange-500 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600 disabled:opacity-60"
                >
                    <Save class="h-4 w-4" />
                    {{ form.processing ? 'Saving...' : 'Save Changes' }}
                </button>
            </div>

        </div>
    </AdminLayout>
</template>

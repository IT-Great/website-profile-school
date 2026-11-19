
<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import {
    ArrowLeft,
    Plus,
    Trash2,
    Save,
    GripVertical,
    Lightbulb,
    Eye,
    ArrowUp,
    ArrowDown,
} from 'lucide-vue-next'

const props = defineProps({
    page: {
        type: Object,
        required: true,
    },
})

const form = useForm({
    outcomes: (props.page.outcomes ?? []).map(item => ({
        id: item.id,
        icon: item.icon ?? 'lightbulb',
        title: item.title ?? '',
        is_active: Boolean(item.is_active),
    })),
})

const addOutcome = () => {
    form.outcomes.push({
        id: null,
        icon: 'star',
        title: '',
        is_active: true,
    })
}

const removeOutcome = (index) => {
    if (confirm('Are you sure you want to remove this learning outcome?')) {
        form.outcomes.splice(index, 1)
    }
}

const submit = () => {
    form.put(route('admin.secondary-program.outcomes.update'), {
        preserveScroll: true,
    })
}

const moveUp = (index) => {
    if (index > 0) {
        const item = form.outcomes.splice(index, 1)[0]
        form.outcomes.splice(index - 1, 0, item)
    }
}

const moveDown = (index) => {
    if (index < form.outcomes.length - 1) {
        const item = form.outcomes.splice(index, 1)[0]
        form.outcomes.splice(index + 1, 0, item)
    }
}
</script>

<template>
    <Head title="Manage Learning Outcomes" />

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
                        Manage Learning Outcomes
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Manage the skills and competencies students are expected to develop.
                    </p>
                </div>

                <button
                    type="button"
                    @click="submit"
                    :disabled="form.processing || form.outcomes.length === 0"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-orange-500 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <Save class="h-4 w-4" />
                    {{ form.processing ? 'Saving...' : 'Save Changes' }}
                </button>
            </div>

            <!-- Success Message -->
            <div
                v-if="$page.props.flash?.success"
                class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700"
            >
                {{ $page.props.flash.success }}
            </div>

            <!-- Information -->
            <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4">
                <div class="flex gap-3">
                    <Lightbulb class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" />

                    <div>
                        <h3 class="text-sm font-semibold text-blue-800">
                            About Learning Outcomes
                        </h3>

                        <p class="mt-1 text-sm text-blue-700">
                            These outcomes describe the knowledge, skills, and attitudes
                            students develop throughout the Secondary Program.
                            You can add, edit, remove, and reorder the outcomes below.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Outcomes List -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">

                <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">
                            Learning Outcomes List
                        </h2>

                        <p class="text-sm text-gray-500">
                            {{ form.outcomes.length }} outcome(s)
                        </p>
                    </div>

                    <button
                        type="button"
                        @click="addOutcome"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-orange-200 bg-orange-50 px-4 py-2.5 text-sm font-semibold text-orange-600 transition hover:bg-orange-100"
                    >
                        <Plus class="h-4 w-4" />
                        Add Outcome
                    </button>
                </div>

                <div class="space-y-4">

                    <div
                        v-for="(outcome, index) in form.outcomes"
                        :key="outcome.id ?? `new-${index}`"
                        class="rounded-xl border border-gray-200 p-4 sm:p-5"
                    >
                        <!-- Item Header -->
                       <div class="mb-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <GripVertical class="h-5 w-5 text-gray-400" />

                                <span class="text-sm font-bold text-gray-700">
                                    Outcome {{ index + 1 }}
                                </span>

                                <button
                                    type="button"
                                    @click="moveUp(index)"
                                    :disabled="index === 0"
                                    class="rounded-md p-1 text-gray-500 hover:bg-gray-100 disabled:opacity-30"
                                    title="Move Up"
                                >
                                    <ArrowUp class="h-4 w-4" />
                                </button>

                                <button
                                    type="button"
                                    @click="moveDown(index)"
                                    :disabled="index === form.outcomes.length - 1"
                                    class="rounded-md p-1 text-gray-500 hover:bg-gray-100 disabled:opacity-30"
                                    title="Move Down"
                                >
                                    <ArrowDown class="h-4 w-4" />
                                </button>
                            </div>

                            <button
                                type="button"
                                @click="removeOutcome(index)"
                                class="rounded-lg p-2 text-red-500 hover:bg-red-50"
                                title="Remove outcome"
                            >
                                <Trash2 class="h-4 w-4" />
                            </button>
                        </div>

                        <!-- Icon and Title -->
                        <div class="grid gap-4 sm:grid-cols-2">

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700">
                                    Icon Name
                                </label>

                                <input
                                    v-model="outcome.icon"
                                    type="text"
                                    placeholder="lightbulb"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500"
                                />

                                <p class="mt-1 text-xs text-gray-400">
                                    Use Lucide icon name, e.g. lightbulb, book-open, palette.
                                </p>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700">
                                    Outcome Title
                                </label>

                                <input
                                    v-model="outcome.title"
                                    type="text"
                                    placeholder="Critical Thinking & Problem Solving"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500"
                                />

                                <p
                                    v-if="form.errors[`outcomes.${index}.title`]"
                                    class="mt-1 text-xs text-red-500"
                                >
                                    {{ form.errors[`outcomes.${index}.title`] }}
                                </p>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-4">
                            <div>
                                <p class="text-sm font-medium text-gray-700">
                                    Outcome Status
                                </p>

                                <p class="text-xs text-gray-400">
                                    Only active outcomes will be displayed publicly.
                                </p>
                            </div>

                            <label class="flex cursor-pointer items-center gap-2">
                                <input
                                    v-model="outcome.is_active"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500"
                                />

                                <span class="text-sm font-medium text-gray-700">
                                    Active
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div
                        v-if="form.outcomes.length === 0"
                        class="rounded-xl border-2 border-dashed border-gray-200 py-12 text-center"
                    >
                        <Lightbulb class="mx-auto mb-3 h-8 w-8 text-gray-300" />

                        <p class="text-sm font-medium text-gray-600">
                            No learning outcomes available
                        </p>

                        <p class="mt-1 text-xs text-gray-400">
                            Add your first learning outcome to get started.
                        </p>
                    </div>

                    <p v-if="form.errors.outcomes" class="text-sm text-red-500">
                        {{ form.errors.outcomes }}
                    </p>
                </div>
            </div>

            <!-- Bottom Save -->
            <div class="flex justify-end">
                <button
                    type="button"
                    @click="submit"
                    :disabled="form.processing || form.outcomes.length === 0"
                    class="inline-flex items-center gap-2 rounded-xl bg-orange-500 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600 disabled:opacity-60"
                >
                    <Save class="h-4 w-4" />
                    {{ form.processing ? 'Saving...' : 'Save Changes' }}
                </button>
            </div>

        </div>
    </AdminLayout>
</template>

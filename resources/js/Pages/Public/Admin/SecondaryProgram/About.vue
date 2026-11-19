
<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import {
    ArrowLeft,
    Plus,
    Trash2,
    Save,
    GripVertical,
    Eye,
} from 'lucide-vue-next'

const props = defineProps({
    page: {
        type: Object,
        required: true,
    },
})

const form = useForm({
    badge: props.page.badge ?? '',
    title: props.page.title ?? '',
    description: props.page.description ?? '',
    is_active: Boolean(props.page.is_active),

    features: (props.page.features ?? []).map(feature => ({
        id: feature.id,
        icon: feature.icon ?? '',
        title: feature.title ?? '',
        description: feature.description ?? '',
        is_active: Boolean(feature.is_active),
    })),
})

const addFeature = () => {
    form.features.push({
        id: null,
        icon: 'star',
        title: '',
        description: '',
        is_active: true,
    })
}

const removeFeature = (index) => {
    if (confirm('Are you sure you want to remove this feature?')) {
        form.features.splice(index, 1)
    }
}

const submit = () => {
    form.put(route('admin.secondary-program.about.update'), {
        preserveScroll: true,
    })
}
</script>

<template>
    <Head title="Manage About Secondary" />

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
                        About Secondary
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Manage the introduction and features of the Secondary Program.
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

            <!-- Success message -->
            <div
                v-if="$page.props.flash?.success"
                class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700"
            >
                {{ $page.props.flash.success }}
            </div>

            <!-- Main Information -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">
                            Main Information
                        </h2>
                        <p class="text-sm text-gray-500">
                            Main introduction displayed on the public page.
                        </p>
                    </div>

                    <span class="rounded-lg bg-orange-50 px-3 py-1 text-xs font-semibold text-orange-600">
                        ABOUT SECTION
                    </span>
                </div>

                <div class="space-y-5">

                    <!-- Badge -->
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            Section Badge
                        </label>

                        <input
                            v-model="form.badge"
                            type="text"
                            placeholder="ABOUT SECONDARY"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500"
                        />

                        <p v-if="form.errors.badge" class="mt-1 text-xs text-red-500">
                            {{ form.errors.badge }}
                        </p>
                    </div>

                    <!-- Title -->
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            Section Title
                        </label>

                        <input
                            v-model="form.title"
                            type="text"
                            placeholder="About Secondary Program"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500"
                        />

                        <p v-if="form.errors.title" class="mt-1 text-xs text-red-500">
                            {{ form.errors.title }}
                        </p>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            Description
                        </label>

                        <textarea
                            v-model="form.description"
                            rows="6"
                            placeholder="Write the introduction of Secondary Program..."
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500"
                        />

                        <p v-if="form.errors.description" class="mt-1 text-xs text-red-500">
                            {{ form.errors.description }}
                        </p>
                    </div>

                    <!-- Status -->
                    <div class="flex items-center justify-between rounded-xl bg-gray-50 p-4">
                        <div>
                            <p class="text-sm font-semibold text-gray-700">
                                Publish About Section
                            </p>
                            <p class="text-xs text-gray-500">
                                Show or hide this section on the public website.
                            </p>
                        </div>

                        <button
                            type="button"
                            @click="form.is_active = !form.is_active"
                            :class="form.is_active ? 'bg-orange-500' : 'bg-gray-300'"
                            class="relative h-6 w-11 rounded-full transition"
                            :aria-pressed="form.is_active"
                        >
                            <span
                                :class="form.is_active ? 'translate-x-6' : 'translate-x-1'"
                                class="absolute left-0 top-1 h-4 w-4 rounded-full bg-white transition"
                            />
                        </button>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">

                <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">
                            Program Features
                        </h2>
                        <p class="text-sm text-gray-500">
                            Manage the key advantages of the Secondary Program.
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

                <div class="space-y-4">

                    <div
                        v-for="(feature, index) in form.features"
                        :key="feature.id ?? `new-${index}`"
                        class="rounded-xl border border-gray-200 p-4 sm:p-5"
                    >
                        <div class="mb-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <GripVertical class="h-5 w-5 text-gray-400" />

                                <span class="text-sm font-bold text-gray-700">
                                    Feature {{ index + 1 }}
                                </span>
                            </div>

                            <button
                                type="button"
                                @click="removeFeature(index)"
                                class="rounded-lg p-2 text-red-500 transition hover:bg-red-50"
                                title="Remove feature"
                            >
                                <Trash2 class="h-4 w-4" />
                            </button>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">

                            <!-- Icon -->
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">
                                    Icon Name
                                </label>

                                <input
                                    v-model="feature.icon"
                                    type="text"
                                    placeholder="graduation-cap"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500"
                                />

                                <p class="mt-1 text-xs text-gray-400">
                                    Use Lucide icon name, e.g. graduation-cap, globe, heart.
                                </p>
                            </div>

                            <!-- Title -->
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">
                                    Feature Title
                                </label>

                                <input
                                    v-model="feature.title"
                                    type="text"
                                    placeholder="Academic Excellence"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500"
                                />

                                <p
                                    v-if="form.errors[`features.${index}.title`]"
                                    class="mt-1 text-xs text-red-500"
                                >
                                    {{ form.errors[`features.${index}.title`] }}
                                </p>
                            </div>

                        </div>

                        <!-- Description -->
                        <div class="mt-4">
                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Description
                            </label>

                            <textarea
                                v-model="feature.description"
                                rows="3"
                                placeholder="Describe this feature..."
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500"
                            />
                        </div>

                        <!-- Feature status -->
                        <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-4">
                            <span class="text-sm text-gray-600">
                                Feature Status
                            </span>

                            <label class="flex cursor-pointer items-center gap-2">
                                <input
                                    v-model="feature.is_active"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500"
                                />
                                <span class="text-sm font-medium text-gray-700">
                                    Active
                                </span>
                            </label>
                        </div>
                    </div>

                    <div
                        v-if="form.features.length === 0"
                        class="rounded-xl border-2 border-dashed border-gray-200 py-10 text-center"
                    >
                        <p class="text-sm text-gray-500">
                            No features available. Click Add Feature to create one.
                        </p>
                    </div>

                    <p v-if="form.errors.features" class="text-sm text-red-500">
                        {{ form.errors.features }}
                    </p>

                </div>
            </div>

            <!-- Bottom Save Button -->
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

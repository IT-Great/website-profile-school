
<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import {
    BookOpen,
    GraduationCap,
    Lightbulb,
    Users,
    Image,
    ArrowRight,
    Layers,
    Globe,
} from 'lucide-vue-next'

const props = defineProps({
    page: {
        type: Object,
        default: null,
    },
})

const sections = [
    {
        title: 'About Primary Program',
        description: 'Manage the main introduction, carousel photos, and four program features.',
        icon: BookOpen,
        color: 'orange',
        count: props.page?.features?.length ?? 0,
        countLabel: 'Features',
        href: route('admin.primary-program.about.edit'),
    },
    {
        title: 'Primary Levels',
        description: 'Manage Lower Primary, Upper Primary, descriptions, images, and learning points.',
        icon: GraduationCap,
        color: 'blue',
        count: props.page?.levels?.length ?? 0,
        countLabel: 'Levels',
        href: route('admin.primary-program.levels.edit'),
    },
    {
        title: 'Curriculum',
        description: 'Manage the curriculum information displayed on the Primary Program page.',
        icon: Layers,
        color: 'purple',
        count: props.page?.curriculums?.length ?? 0,
        countLabel: 'Curriculums',
        href: route('admin.primary-program.curriculum.edit'),
    },
    {
        title: 'Extracurricular Activities',
        description: 'Manage the extracurricular activities, icons, colors, and descriptions.',
        icon: Users,
        color: 'green',
        count: props.page?.extracurriculars?.length ?? 0,
        countLabel: 'Activities',
        href: route('admin.primary-program.extracurricular.edit'),
    },
]

const colorClasses = {
    orange: 'bg-orange-50 text-orange-600',
    blue: 'bg-blue-50 text-blue-600',
    purple: 'bg-purple-50 text-purple-600',
    green: 'bg-green-50 text-green-600',
}
</script>

<template>
    <Head title="Primary Program Management" />

    <AdminLayout>
        <div class="space-y-6 pb-10">

            <!-- Header -->
            <div>
                <div class="mb-2 flex items-center gap-2 text-sm text-gray-500">
                    <Globe class="h-4 w-4" />
                    Website Management
                    <span>/</span>
                    <span class="font-medium text-orange-600">Primary Program</span>
                </div>

                <h1 class="text-2xl font-bold text-gray-800">
                    Primary Program
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Manage all content displayed on the Primary Program page.
                </p>
            </div>

            <!-- Page Overview -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-orange-100 text-orange-600">
                        <GraduationCap class="h-8 w-8" />
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="mb-1 flex flex-wrap items-center gap-2">
                            <h2 class="text-lg font-bold text-gray-800">
                                {{ page?.title ?? 'Primary Program' }}
                            </h2>

                            <span
                                v-if="page?.is_active"
                                class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-600"
                            >
                                Active
                            </span>

                            <span
                                v-else
                                class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-500"
                            >
                                Inactive
                            </span>
                        </div>

                        <p class="line-clamp-2 text-sm text-gray-500">
                            {{ page?.description ?? 'No description available.' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="mb-3 flex items-center justify-between">
                        <span class="text-sm text-gray-500">About Features</span>
                        <Lightbulb class="h-5 w-5 text-orange-500" />
                    </div>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ page?.features?.length ?? 0 }}
                    </p>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="mb-3 flex items-center justify-between">
                        <span class="text-sm text-gray-500">Primary Levels</span>
                        <GraduationCap class="h-5 w-5 text-blue-500" />
                    </div>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ page?.levels?.length ?? 0 }}
                    </p>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="mb-3 flex items-center justify-between">
                        <span class="text-sm text-gray-500">Curriculums</span>
                        <BookOpen class="h-5 w-5 text-purple-500" />
                    </div>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ page?.curriculums?.length ?? 0 }}
                    </p>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="mb-3 flex items-center justify-between">
                        <span class="text-sm text-gray-500">Activities</span>
                        <Users class="h-5 w-5 text-green-500" />
                    </div>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ page?.extracurriculars?.length ?? 0 }}
                    </p>
                </div>
            </div>

            <!-- Management Sections -->
            <div>
                <div class="mb-4">
                    <h2 class="text-lg font-bold text-gray-800">
                        Manage Content
                    </h2>
                    <p class="text-sm text-gray-500">
                        Select a section to manage its content.
                    </p>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div
                        v-for="section in sections"
                        :key="section.route"
                        class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-orange-200 hover:shadow-md"
                    >
                        <div class="mb-5 flex items-start justify-between">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-xl"
                                :class="colorClasses[section.color]"
                            >
                                <component :is="section.icon" class="h-6 w-6" />
                            </div>

                            <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                                {{ section.count }} {{ section.countLabel }}
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-gray-800">
                            {{ section.title }}
                        </h3>

                        <p class="mt-2 min-h-12 text-sm leading-6 text-gray-500">
                            {{ section.description }}
                        </p>

                        <div class="mt-5 flex items-center justify-between border-t border-gray-100 pt-4">
                            <span class="text-xs font-medium text-gray-400">
                                Content Management
                            </span>

                            <Link
                                v-if="section.href"
                                :href="section.href"
                                class="inline-flex items-center gap-2 text-sm font-semibold text-orange-600 hover:text-orange-700"
                            >
                                Manage Content
                                <ArrowRight class="h-4 w-4" />
                            </Link>

                            <span
                                v-else
                                class="text-sm font-medium text-gray-400"
                            >
                                Coming next
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Photo Information -->
            <div class="rounded-2xl border border-blue-100 bg-blue-50 p-5">
                <div class="flex items-start gap-3">
                    <Image class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" />

                    <div>
                        <h3 class="font-semibold text-blue-900">
                            Image Management
                        </h3>
                        <p class="mt-1 text-sm leading-6 text-blue-800">
                            About Primary carousel photos and Primary Level images
                            will be managed directly from their respective content
                            sections.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </AdminLayout>
</template>

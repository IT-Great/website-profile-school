
<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import {
    ArrowLeft,
    ArrowRight,
    BookOpen,
    Image,
    GraduationCap,
    Heart,
    Layers,
} from 'lucide-vue-next'

const props = defineProps({
    page: {
        type: Object,
        required: true,
    },
})

const sections = [
    {
        title: 'About Preschool',
        description: 'Manage the introduction, photos, and preschool features.',
        icon: Image,
        count: `${props.page.photos?.length ?? 0} Photos`,
        href: route('admin.preschool.about.edit'),
    },
    {
        title: 'Our Classes',
        description: 'Manage Nursery and Kindergarten classes and learning points.',
        icon: GraduationCap,
        count: `${props.page.classes?.length ?? 0} Classes`,
        href: route('admin.preschool.classes.edit'),
    },
]
</script>

<template>
    <Head title="Manage Preschool" />

    <AdminLayout>
        <div class="space-y-6">

            <!-- Header -->
            <div>
                <Link
                    :href="route('dashboard')"
                    class="mb-3 inline-flex items-center gap-2 text-sm text-gray-500 hover:text-orange-600"
                >
                    <ArrowLeft class="h-4 w-4" />
                    Back to Dashboard
                </Link>

                <h1 class="text-2xl font-bold text-gray-800">
                    Manage Preschool
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Manage all content displayed on the Preschool Program page.
                </p>
            </div>

            <!-- Summary -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="rounded-lg bg-orange-100 p-3 text-orange-600">
                            <Heart class="h-5 w-5" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Features</p>
                            <h3 class="text-xl font-bold text-gray-800">
                                {{ page.features?.length ?? 0 }}
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="rounded-lg bg-blue-100 p-3 text-blue-600">
                            <Image class="h-5 w-5" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Photos</p>
                            <h3 class="text-xl font-bold text-gray-800">
                                {{ page.photos?.length ?? 0 }}
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="rounded-lg bg-green-100 p-3 text-green-600">
                            <GraduationCap class="h-5 w-5" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Classes</p>
                            <h3 class="text-xl font-bold text-gray-800">
                                {{ page.classes?.length ?? 0 }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sections -->
            <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                <div
                    v-for="section in sections"
                    :key="section.title"
                    class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition hover:border-orange-200 hover:shadow-md"
                >
                    <div class="flex items-start justify-between">
                        <div class="rounded-xl bg-orange-50 p-3 text-orange-600">
                            <component :is="section.icon" class="h-6 w-6" />
                        </div>

                        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                            {{ section.count }}
                        </span>
                    </div>

                    <h2 class="mt-5 text-lg font-bold text-gray-800">
                        {{ section.title }}
                    </h2>

                    <p class="mt-2 min-h-10 text-sm leading-6 text-gray-500">
                        {{ section.description }}
                    </p>

                    <Link
                        :href="section.href"
                        class="mt-5 inline-flex items-center gap-2 rounded-lg bg-orange-500 px-4 py-2.5 text-sm font-semibold text-white hover:bg-orange-600"
                    >
                        Manage Content
                        <ArrowRight class="h-4 w-4" />
                    </Link>
                </div>
            </div>

        </div>
    </AdminLayout>
</template>

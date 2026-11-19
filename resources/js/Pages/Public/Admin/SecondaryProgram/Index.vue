
<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import {
    GraduationCap,
    BookOpen,
    Lightbulb,
    MapPin,
    FlaskConical,
    Trophy,
    ArrowRight,
    Globe,
    Users,
    Heart,
    Target,
    CheckCircle,
    CircleX,
} from 'lucide-vue-next'

const props = defineProps({
    page: {
        type: Object,
        default: null,
    },
    sections: {
        type: Array,
        default: () => [],
    },
})

const sectionBySlug = (slug) => {
    return props.sections.find(section => section.slug === slug)
}

const dashboardCards = [
    {
        title: 'About Secondary',
        description: 'Manage the main introduction and program highlights.',
        icon: GraduationCap,
        color: 'orange',
        count: () => props.page?.features?.length ?? 0,
        countLabel: 'Program Features',
        anchor: '#about',
        link: route('admin.secondary-program.about.edit'),
    },
    {
        title: 'Curriculum',
        description: 'Manage the curriculum information used by the school.',
        icon: BookOpen,
        color: 'blue',
        count: () => props.page?.curriculums?.length ?? 0,
        countLabel: 'Curriculums',
        anchor: '#curriculum',
        link: route('admin.secondary-program.curriculum.edit'),
    },
    {
        title: 'Learning Outcomes',
        description: 'Manage the skills and competencies students will learn.',
        icon: Lightbulb,
        color: 'purple',
        count: () => props.page?.outcomes?.length ?? 0,
        countLabel: 'Learning Outcomes',
        anchor: '#outcomes',
        link: route('admin.secondary-program.outcomes.edit'),
    },
    {
        title: 'Field Trips',
        description: 'Manage educational visits, descriptions, and photos.',
        icon: MapPin,
        color: 'green',
        slug: 'field-trips',
        count: () => sectionBySlug('field-trips')?.items?.length ?? 0,
        countLabel: 'Activities',
        anchor: '#field-trips',
        link: '',
    },
    {
        title: 'School Activities',
        description: 'Manage activities and memorable moments at school.',
        icon: FlaskConical,
        color: 'blue',
        slug: 'school-activities',
        count: () => sectionBySlug('school-activities')?.items?.length ?? 0,
        countLabel: 'Activities',
        anchor: '#school-activities',
        link: '',
    },
    {
        title: 'Extracurriculars',
        description: 'Manage clubs, sports, and student extracurricular programs.',
        icon: Trophy,
        color: 'purple',
        slug: 'extracurriculars',
        count: () => sectionBySlug('extracurriculars')?.items?.length ?? 0,
        countLabel: 'Programs',
        anchor: '#extracurriculars',
        link: route('admin.secondary-program.extracurriculars.edit'),
    },
]

const activeSections = props.sections.filter(section => section.is_active).length
</script>

<template>
    <Head title="Secondary Program Management" />

    <AdminLayout>
        <div class="space-y-6 pb-10">

            <!-- Page Header -->
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="mb-2 flex items-center gap-2 text-sm text-gray-500">
                        <span>Homepage</span>
                        <span>/</span>
                        <span class="font-medium text-orange-600">Secondary Program</span>
                    </div>

                    <h1 class="text-2xl font-bold text-gray-900">
                        Secondary Program
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Manage all content displayed on the Secondary Program page.
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <span
                        class="inline-flex items-center gap-2 rounded-full px-3 py-2 text-sm font-medium"
                        :class="page?.is_active
                            ? 'bg-green-50 text-green-700'
                            : 'bg-gray-100 text-gray-600'"
                    >
                        <CheckCircle v-if="page?.is_active" :size="16" />
                        <CircleX v-else :size="16" />

                        {{ page?.is_active ? 'Page Active' : 'Page Inactive' }}
                    </span>
                </div>
            </div>

            <!-- Summary -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-xl border border-gray-200 bg-white p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Sections</p>
                            <h3 class="mt-2 text-2xl font-bold text-gray-900">
                                {{ dashboardCards.length }}
                            </h3>
                        </div>
                        <div class="rounded-lg bg-orange-50 p-3 text-orange-600">
                            <BookOpen :size="23" />
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Active Sections</p>
                            <h3 class="mt-2 text-2xl font-bold text-gray-900">
                                {{ activeSections }}
                            </h3>
                        </div>
                        <div class="rounded-lg bg-green-50 p-3 text-green-600">
                            <CheckCircle :size="23" />
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Features</p>
                            <h3 class="mt-2 text-2xl font-bold text-gray-900">
                                {{ page?.features?.length ?? 0 }}
                            </h3>
                        </div>
                        <div class="rounded-lg bg-blue-50 p-3 text-blue-600">
                            <Users :size="23" />
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Outcomes</p>
                            <h3 class="mt-2 text-2xl font-bold text-gray-900">
                                {{ page?.outcomes?.length ?? 0 }}
                            </h3>
                        </div>
                        <div class="rounded-lg bg-purple-50 p-3 text-purple-600">
                            <Target :size="23" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="rounded-xl border border-gray-200 bg-white p-5 sm:p-6">
                <div class="mb-6">
                    <h2 class="text-lg font-bold text-gray-900">
                        Manage Page Content
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Select a section below to manage its content.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                    <div
                        v-for="card in dashboardCards"
                        :key="card.title"
                        class="group rounded-xl border border-gray-200 p-5 transition hover:border-orange-300 hover:shadow-md"
                    >
                        <div class="flex items-start justify-between">
                            <div
                                class="rounded-xl p-3"
                                :class="{
                                    'bg-orange-50 text-orange-600': card.color === 'orange',
                                    'bg-blue-50 text-blue-600': card.color === 'blue',
                                    'bg-purple-50 text-purple-600': card.color === 'purple',
                                    'bg-green-50 text-green-600': card.color === 'green',
                                }"
                            >
                                <component :is="card.icon" :size="24" />
                            </div>

                            <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                                {{ card.count() }} {{ card.countLabel }}
                            </span>
                        </div>

                        <h3 class="mt-5 font-semibold text-gray-900">
                            {{ card.title }}
                        </h3>

                        <p class="mt-2 min-h-10 text-sm leading-6 text-gray-500">
                            {{ card.description }}
                        </p>

                        <div class="mt-5 border-t border-gray-100 pt-4">
                            <a
                                :href="card.anchor"
                                class="inline-flex items-center gap-2 text-sm font-semibold text-orange-600 transition group-hover:gap-3"
                            >
                                View Section
                                <ArrowRight :size="16" />
                            </a>
                            <Link
                                :href="card.link"
                                class="inline-flex items-center gap-2 rounded-lg bg-orange-500 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-600"
                            >
                                Manage {{ card.title }}
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- About Preview -->
            <div id="about" class="scroll-mt-24 rounded-xl border border-gray-200 bg-white p-5 sm:p-6">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">About Secondary Program</h2>
                        <p class="mt-1 text-sm text-gray-500">Main introduction and program features.</p>
                    </div>
                    <span class="text-xs font-medium text-gray-400">Content overview</span>
                </div>

                <div class="mt-5 rounded-lg bg-gray-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-orange-600">
                        {{ page?.badge ?? 'ABOUT SECONDARY' }}
                    </p>
                    <h3 class="mt-2 text-xl font-bold text-gray-900">
                        {{ page?.title ?? 'About Secondary Program' }}
                    </h3>
                    <p class="mt-3 text-sm leading-6 text-gray-600">
                        {{ page?.description ?? 'No description available.' }}
                    </p>
                </div>

                <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    <div
                        v-for="feature in page?.features ?? []"
                        :key="feature.id"
                        class="rounded-lg border border-gray-100 p-4"
                    >
                        <h4 class="font-semibold text-gray-800">{{ feature.title }}</h4>
                        <p class="mt-2 text-xs leading-5 text-gray-500">{{ feature.description }}</p>
                    </div>
                </div>
            </div>

            <!-- Curriculum Preview -->
            <div id="curriculum" class="scroll-mt-24 rounded-xl border border-gray-200 bg-white p-5 sm:p-6">
                <h2 class="text-lg font-bold text-gray-900">Curriculum</h2>
                <p class="mt-1 text-sm text-gray-500">Curriculum information currently displayed.</p>

                <div class="mt-5 grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div
                        v-for="curriculum in page?.curriculums ?? []"
                        :key="curriculum.id"
                        class="rounded-lg border border-gray-200 p-4"
                    >
                        <div class="flex items-center gap-3">
                            <div class="rounded-lg bg-blue-50 px-3 py-2 font-bold text-blue-600">
                                {{ curriculum.short_name || '—' }}
                            </div>
                            <h3 class="font-semibold text-gray-900">{{ curriculum.name }}</h3>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-gray-500">
                            {{ curriculum.description }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Outcomes Preview -->
            <div id="outcomes" class="scroll-mt-24 rounded-xl border border-gray-200 bg-white p-5 sm:p-6">
                <h2 class="text-lg font-bold text-gray-900">Learning Outcomes</h2>
                <p class="mt-1 text-sm text-gray-500">Skills and competencies students will learn.</p>

                <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="outcome in page?.outcomes ?? []"
                        :key="outcome.id"
                        class="flex items-center gap-3 rounded-lg border border-gray-100 p-4"
                    >
                        <div class="rounded-lg bg-orange-50 p-2 text-orange-600">
                            <Lightbulb :size="19" />
                        </div>
                        <span class="text-sm font-medium text-gray-800">{{ outcome.title }}</span>
                    </div>
                </div>
            </div>

            <!-- Activity Sections -->
            <div
                v-for="section in sections"
                :key="section.id"
                :id="section.slug"
                class="scroll-mt-24 rounded-xl border border-gray-200 bg-white p-5 sm:p-6"
            >
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">{{ section.title }}</h2>
                        <p class="mt-1 text-sm text-gray-500">{{ section.description }}</p>
                    </div>

                    <span
                        class="w-fit rounded-full px-3 py-1 text-xs font-medium"
                        :class="section.is_active
                            ? 'bg-green-50 text-green-700'
                            : 'bg-gray-100 text-gray-500'"
                    >
                        {{ section.is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="item in section.items"
                        :key="item.id"
                        class="rounded-lg border border-gray-100 p-4"
                    >
                        <div class="flex items-center justify-between gap-2">
                            <h3 class="font-semibold text-gray-800">{{ item.name }}</h3>
                            <span class="text-xs text-gray-400">#{{ item.sort_order }}</span>
                        </div>

                        <p v-if="item.description" class="mt-2 text-sm text-gray-500">
                            {{ item.description }}
                        </p>

                        <div v-if="item.photos?.length" class="mt-3 flex gap-2">
                            <img
                                v-for="photo in item.photos.slice(0, 3)"
                                :key="photo.id"
                                :src="`/storage/${photo.image}`"
                                class="h-16 w-20 rounded-lg object-cover"
                                alt="Activity photo"
                            />
                        </div>

                        <div v-if="section.slug === 'extracurriculars'" class="mt-3 flex items-center gap-2 text-xs text-gray-500">
                            <span
                                class="h-4 w-4 rounded-full border"
                                :style="{ backgroundColor: item.color || '#f3f4f6' }"
                            ></span>
                            {{ item.icon || 'No icon' }}
                        </div>
                    </div>

                    <div
                        v-if="!section.items?.length"
                        class="col-span-full rounded-lg bg-gray-50 p-6 text-center text-sm text-gray-500"
                    >
                        No items available.
                    </div>
                </div>
            </div>

        </div>
    </AdminLayout>
</template>

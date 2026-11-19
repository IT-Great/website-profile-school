<script setup>
import { computed } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import {
    ArrowLeft,
    Save,
    Trophy,
    UserRound,
    CalendarDays,
    ImagePlus,
    X,
} from 'lucide-vue-next'

const props = defineProps({
    achievement: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        default: () => [
            'Academic',
            'Sports',
            'Arts',
            'Technology',
            'Other',
        ],
    },
    levels: {
        type: Array,
        default: () => [
            'School',
            'City',
            'Regional',
            'National',
            'International',
        ],
    },
})

const form = useForm({
    title: props.achievement.title ?? '',
    student_name: props.achievement.student_name ?? '',
    student_class: props.achievement.student_class ?? '',
    competition_name: props.achievement.competition_name ?? '',
    category: props.achievement.category ?? 'Academic',
    award: props.achievement.award ?? '',
    achievement_level: props.achievement.achievement_level ?? 'School',
    achievement_date: props.achievement.achievement_date
        ? String(props.achievement.achievement_date).slice(0, 10)
        : '',
    description: props.achievement.description ?? '',
    image: null,
    is_active: Boolean(props.achievement.is_active),
})

const imagePreview = computed(() => {
    if (form.image instanceof File) {
        return URL.createObjectURL(form.image)
    }

    return null
})

const existingImageUrl = computed(() => {
    if (!props.achievement.image) return null

    return `/storage/${props.achievement.image}`
})

function handleImageChange(event) {
    const file = event.target.files?.[0]

    if (!file) return

    const allowedTypes = ['image/jpeg', 'image/png', 'image/webp']

    if (!allowedTypes.includes(file.type)) {
        alert('Gunakan gambar JPG, PNG, atau WEBP.')
        event.target.value = ''
        return
    }

    if (file.size > 5 * 1024 * 1024) {
        alert('Ukuran gambar maksimal 5 MB.')
        event.target.value = ''
        return
    }

    form.image = file
}

function submit() {
    form.transform((data) => ({
        ...data,
        _method: 'PUT',
    })).post(route('admin.achievements.update', props.achievement.id), {
        forceFormData: true,
        preserveScroll: true,
    })
}
</script>

<template>
    <Head title="Edit Student Achievement" />

    <AdminLayout>
        <div class="min-h-screen bg-gray-50/70 px-4 py-6 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-8xl">
                <!-- Header -->
                <div class="mb-7">
                    <Link
                        :href="route('admin.achievements.index')"
                        class="mb-4 inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-orange-600"
                    >
                        <ArrowLeft class="h-4 w-4" />
                        Kembali ke daftar prestasi
                    </Link>

                    <div class="flex items-start gap-3">
                        <div class="rounded-xl bg-orange-100 p-3 text-orange-600">
                            <Trophy class="h-6 w-6" />
                        </div>

                        <div>
                            <h1 class="text-2xl font-bold tracking-tight text-gray-900">
                                Edit Student Achievement
                            </h1>
                            <p class="mt-1 text-sm text-gray-500">
                                Perbarui informasi prestasi siswa.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Student information -->
                    <section class="rounded-2xl border border-gray-200 bg-white shadow-sm">
                        <div class="flex items-center gap-3 border-b border-gray-100 px-6 py-5">
                            <UserRound class="h-5 w-5 text-orange-500" />
                            <div>
                                <h2 class="font-semibold text-gray-900">
                                    Informasi Siswa dan Prestasi
                                </h2>
                                <p class="text-sm text-gray-500">
                                    Informasi utama prestasi yang diraih.
                                </p>
                            </div>
                        </div>

                        <div class="grid gap-5 p-6 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-medium text-gray-700">
                                    Judul Prestasi <span class="text-red-500">*</span>
                                </label>
                                <input
                                    v-model="form.title"
                                    type="text"
                                    required
                                    class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-4 focus:ring-orange-100"
                                    placeholder="Contoh: Juara 1 Olimpiade Matematika"
                                />
                                <p v-if="form.errors.title" class="mt-1 text-sm text-red-500">
                                    {{ form.errors.title }}
                                </p>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">
                                    Nama Siswa <span class="text-red-500">*</span>
                                </label>
                                <input
                                    v-model="form.student_name"
                                    type="text"
                                    required
                                    class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-4 focus:ring-orange-100"
                                    placeholder="Nama lengkap siswa"
                                />
                                <p v-if="form.errors.student_name" class="mt-1 text-sm text-red-500">
                                    {{ form.errors.student_name }}
                                </p>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">
                                    Kelas
                                </label>
                                <input
                                    v-model="form.student_class"
                                    type="text"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-4 focus:ring-orange-100"
                                    placeholder="Contoh: Primary 6"
                                />
                                <p v-if="form.errors.student_class" class="mt-1 text-sm text-red-500">
                                    {{ form.errors.student_class }}
                                </p>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">
                                    Nama Kompetisi <span class="text-red-500">*</span>
                                </label>
                                <input
                                    v-model="form.competition_name"
                                    type="text"
                                    required
                                    class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-4 focus:ring-orange-100"
                                    placeholder="Nama lomba atau kompetisi"
                                />
                                <p v-if="form.errors.competition_name" class="mt-1 text-sm text-red-500">
                                    {{ form.errors.competition_name }}
                                </p>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">
                                    Penghargaan <span class="text-red-500">*</span>
                                </label>
                                <input
                                    v-model="form.award"
                                    type="text"
                                    required
                                    class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-4 focus:ring-orange-100"
                                    placeholder="Contoh: Juara 1"
                                />
                                <p v-if="form.errors.award" class="mt-1 text-sm text-red-500">
                                    {{ form.errors.award }}
                                </p>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select
                                    v-model="form.category"
                                    required
                                    class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-4 focus:ring-orange-100"
                                >
                                    <option
                                        v-for="category in categories"
                                        :key="category"
                                        :value="category"
                                    >
                                        {{ category }}
                                    </option>
                                </select>
                                <p v-if="form.errors.category" class="mt-1 text-sm text-red-500">
                                    {{ form.errors.category }}
                                </p>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">
                                    Tingkat Kompetisi <span class="text-red-500">*</span>
                                </label>
                                <select
                                    v-model="form.achievement_level"
                                    required
                                    class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-4 focus:ring-orange-100"
                                >
                                    <option
                                        v-for="level in levels"
                                        :key="level"
                                        :value="level"
                                    >
                                        {{ level }}
                                    </option>
                                </select>
                                <p v-if="form.errors.achievement_level" class="mt-1 text-sm text-red-500">
                                    {{ form.errors.achievement_level }}
                                </p>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">
                                    Tanggal Prestasi <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <CalendarDays class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                                    <input
                                        v-model="form.achievement_date"
                                        type="date"
                                        required
                                        class="w-full rounded-xl border border-gray-200 py-3 pl-10 pr-4 text-sm outline-none focus:border-orange-400 focus:ring-4 focus:ring-orange-100"
                                    />
                                </div>
                                <p v-if="form.errors.achievement_date" class="mt-1 text-sm text-red-500">
                                    {{ form.errors.achievement_date }}
                                </p>
                            </div>

                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-medium text-gray-700">
                                    Deskripsi
                                </label>
                                <textarea
                                    v-model="form.description"
                                    rows="4"
                                    class="w-full resize-y rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-4 focus:ring-orange-100"
                                    placeholder="Ceritakan detail prestasi siswa..."
                                />
                                <p v-if="form.errors.description" class="mt-1 text-sm text-red-500">
                                    {{ form.errors.description }}
                                </p>
                            </div>
                        </div>
                    </section>

                    <!-- Image -->
                    <section class="rounded-2xl border border-gray-200 bg-white shadow-sm">
                        <div class="flex items-center gap-3 border-b border-gray-100 px-6 py-5">
                            <ImagePlus class="h-5 w-5 text-orange-500" />
                            <div>
                                <h2 class="font-semibold text-gray-900">
                                    Foto Prestasi
                                </h2>
                                <p class="text-sm text-gray-500">
                                    Unggah foto baru atau pertahankan foto saat ini.
                                </p>
                            </div>
                        </div>

                        <div class="p-6">
                            <div
                                v-if="imagePreview || existingImageUrl"
                                class="mb-4"
                            >
                                <p class="mb-2 text-sm font-medium text-gray-700">
                                    {{ imagePreview ? 'Pratinjau foto baru' : 'Foto saat ini' }}
                                </p>

                                <div class="relative inline-block">
                                    <img
                                        :src="imagePreview || existingImageUrl"
                                        alt="Foto prestasi siswa"
                                        class="max-h-64 max-w-full rounded-xl border border-gray-200 object-contain"
                                    />

                                    <button
                                        v-if="imagePreview"
                                        type="button"
                                        @click="form.image = null"
                                        class="absolute -right-2 -top-2 rounded-full bg-gray-900 p-1.5 text-white hover:bg-red-600"
                                        aria-label="Batalkan foto baru"
                                    >
                                        <X class="h-4 w-4" />
                                    </button>
                                </div>
                            </div>

                            <label class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-200 px-6 py-8 text-center transition hover:border-orange-300 hover:bg-orange-50/50">
                                <ImagePlus class="mb-3 h-8 w-8 text-gray-400" />
                                <span class="text-sm font-medium text-gray-700">
                                    Klik untuk memilih foto
                                </span>
                                <span class="mt-1 text-xs text-gray-500">
                                    JPG, PNG, WEBP · Maksimal 5 MB
                                </span>
                                <input
                                    type="file"
                                    accept="image/jpeg,image/png,image/webp"
                                    class="hidden"
                                    @change="handleImageChange"
                                />
                            </label>

                            <p v-if="form.errors.image" class="mt-2 text-sm text-red-500">
                                {{ form.errors.image }}
                            </p>
                        </div>
                    </section>

                    <!-- Status -->
                    <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                        <label class="flex cursor-pointer items-center justify-between gap-4">
                            <div>
                                <p class="font-semibold text-gray-900">
                                    Publikasikan prestasi
                                </p>
                                <p class="mt-1 text-sm text-gray-500">
                                    Prestasi aktif dapat ditampilkan di halaman website.
                                </p>
                            </div>

                            <input
                                v-model="form.is_active"
                                type="checkbox"
                                class="h-5 w-5 rounded border-gray-300 text-orange-500 focus:ring-orange-400"
                            />
                        </label>
                        <p v-if="form.errors.is_active" class="mt-2 text-sm text-red-500">
                            {{ form.errors.is_active }}
                        </p>
                    </section>

                    <!-- Actions -->
                    <div class="flex flex-col-reverse justify-end gap-3 sm:flex-row">
                        <Link
                            :href="route('admin.achievements.index')"
                            class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                        >
                            Batal
                        </Link>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-orange-500 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600 disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            <Save class="h-4 w-4" />
                            {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
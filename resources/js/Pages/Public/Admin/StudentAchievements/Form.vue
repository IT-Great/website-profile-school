
<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import { onBeforeUnmount, ref } from 'vue'
import {
    ArrowLeft,
    Plus,
    Trash2,
    UserRound,
    Award,
    ImagePlus,
    Save,
    LoaderCircle,
    ChevronDown,
    ChevronUp,
} from 'lucide-vue-next'

const props = defineProps({
    achievement: {
        type: Object,
        default: null,
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

let nextId = 2
const imagePreviews = ref({})
const collapsed = ref({})
const imageInputs = ref({})
const previewUrls = new Set()

function newStudent() {
    return {
        _key: nextId++,
        title: '',
        student_name: '',
        student_class: '',
        competition_name: '',
        category: 'Academic',
        award: '',
        achievement_level: 'School',
        achievement_date: '',
        description: '',
        image: null,
        is_active: false,
    }
}

const form = useForm({
    title: props.achievement?.title ?? '',
    student_name: props.achievement?.student_name ?? '',
    student_class: props.achievement?.student_class ?? '',
    competition_name: props.achievement?.competition_name ?? '',
    category: props.achievement?.category ?? 'Academic',
    award: props.achievement?.award ?? '',
    achievement_level: props.achievement?.achievement_level ?? 'School',
    achievement_date: props.achievement?.achievement_date ?? '',
    description: props.achievement?.description ?? '',
    image: null,
    is_active: Boolean(props.achievement?.is_active ?? true),
})

function addStudent() {
    form.students.push(newStudent())
}

function removeStudent(index) {
    if (form.students.length === 1) return

    const student = form.students[index]
    const key = student._key

    if (imagePreviews.value[key]) {
        URL.revokeObjectURL(imagePreviews.value[key])
        previewUrls.delete(imagePreviews.value[key])
    }

    delete imagePreviews.value[key]
    delete collapsed.value[key]
    delete imageInputs.value[key]

    form.students.splice(index, 1)
}

function chooseImage(student, event) {
    const file = event.target.files?.[0]
    if (!file) return

    if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
        form.setError(`students.${form.students.indexOf(student)}.image`,
            'Gunakan format JPG, PNG, atau WEBP.')
        event.target.value = ''
        return
    }

    if (file.size > 5 * 1024 * 1024) {
        form.setError(`students.${form.students.indexOf(student)}.image`,
            'Ukuran gambar maksimal 5 MB.')
        event.target.value = ''
        return
    }

    const key = student._key
    const oldPreview = imagePreviews.value[key]

    if (oldPreview) {
        URL.revokeObjectURL(oldPreview)
        previewUrls.delete(oldPreview)
    }

    form.clearErrors(`students.${form.students.indexOf(student)}.image`)
    student.image = file

    const url = URL.createObjectURL(file)
    imagePreviews.value[key] = url
    previewUrls.add(url)
}

function removeImage(student) {
    const key = student._key
    const oldPreview = imagePreviews.value[key]

    if (oldPreview) {
        URL.revokeObjectURL(oldPreview)
        previewUrls.delete(oldPreview)
    }

    delete imagePreviews.value[key]
    student.image = null

    if (imageInputs.value[key]) {
        imageInputs.value[key].value = ''
    }
}

function errorFor(index, field) {
    return form.errors[`students.${index}.${field}`]
}

function toggleCollapsed(key) {
    collapsed.value[key] = !collapsed.value[key]
}

function submit() {
    // Hilangkan properti internal yang hanya digunakan oleh UI.
    form.transform((data) => ({
        students: data.students.map(({ _key, ...student }) => student),
    })).post(route('admin.achievements.store'), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            previewUrls.forEach((url) => URL.revokeObjectURL(url))
            previewUrls.clear()
            imagePreviews.value = {}
        },
    })
}

onBeforeUnmount(() => {
    previewUrls.forEach((url) => URL.revokeObjectURL(url))
})
</script>

<template>
    <Head title="Tambah Prestasi Siswa" />

    <div class="min-h-screen space-y-6 bg-gray-50/70 p-4 sm:p-6 lg:p-8">
        <!-- Header -->
        <div>
            <Link
                :href="route('admin.achievements.index')"
                class="mb-4 inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-orange-600"
            >
                <ArrowLeft class="h-4 w-4" />
                Kembali ke daftar prestasi
            </Link>

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-gray-900">
                        Tambah Prestasi Siswa
                    </h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Tambahkan satu atau beberapa siswa dalam satu kali proses.
                    </p>
                </div>

                <div class="inline-flex w-fit items-center gap-2 rounded-xl border border-orange-100 bg-orange-50 px-4 py-2.5 text-sm font-semibold text-orange-700">
                    <UserRound class="h-4 w-4" />
                    {{ form.students.length }} siswa
                </div>
            </div>
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <!-- Dynamic Student Forms -->
            <section
                v-for="(student, index) in form.students"
                :key="student._key"
                class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm"
            >
                <!-- Card Header -->
                <div class="flex items-center justify-between gap-3 border-b border-gray-100 bg-white px-5 py-4 sm:px-6">
                    <button
                        type="button"
                        @click="toggleCollapsed(student._key)"
                        class="flex min-w-0 items-center gap-3 text-left"
                    >
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-orange-100 text-orange-600">
                            <UserRound class="h-5 w-5" />
                        </div>

                        <div class="min-w-0">
                            <h2 class="font-semibold text-gray-900">
                                Siswa {{ index + 1 }}
                                <span v-if="student.student_name" class="font-normal text-gray-500">
                                    — {{ student.student_name }}
                                </span>
                            </h2>
                            <p class="mt-0.5 text-xs text-gray-500">
                                {{ student.title || 'Formulir prestasi baru' }}
                            </p>
                        </div>

                        <ChevronUp
                            v-if="collapsed[student._key]"
                            class="h-4 w-4 shrink-0 text-gray-400"
                        />
                        <ChevronDown
                            v-else
                            class="h-4 w-4 shrink-0 text-gray-400"
                        />
                    </button>

                    <button
                        v-if="form.students.length > 1"
                        type="button"
                        @click="removeStudent(index)"
                        class="inline-flex shrink-0 items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50"
                    >
                        <Trash2 class="h-4 w-4" />
                        <span class="hidden sm:inline">Hapus</span>
                    </button>
                </div>

                <div v-if="!collapsed[student._key]" class="grid grid-cols-1 gap-6 p-5 sm:p-6 xl:grid-cols-3">
                    <!-- Main Fields -->
                    <div class="space-y-5 xl:col-span-2">
                        <div>
                            <h3 class="mb-4 text-sm font-semibold text-gray-900">
                                Informasi Prestasi
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">
                                        Judul Prestasi <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        v-model="student.title"
                                        required
                                        maxlength="255"
                                        placeholder="Contoh: Juara 1 Olimpiade Matematika"
                                        class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                        :class="{ 'border-red-400': errorFor(index, 'title') }"
                                    />
                                    <p v-if="errorFor(index, 'title')" class="mt-1 text-sm text-red-600">
                                        {{ errorFor(index, 'title') }}
                                    </p>
                                </div>

                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-gray-700">
                                            Kategori <span class="text-red-500">*</span>
                                        </label>
                                        <select
                                            v-model="student.category"
                                            required
                                            class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                        >
                                            <option v-for="item in categories" :key="item" :value="item">
                                                {{ item }}
                                            </option>
                                        </select>
                                        <p v-if="errorFor(index, 'category')" class="mt-1 text-sm text-red-600">
                                            {{ errorFor(index, 'category') }}
                                        </p>
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-gray-700">
                                            Tingkat <span class="text-red-500">*</span>
                                        </label>
                                        <select
                                            v-model="student.achievement_level"
                                            required
                                            class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                        >
                                            <option v-for="item in levels" :key="item" :value="item">
                                                {{ item }}
                                            </option>
                                        </select>
                                        <p v-if="errorFor(index, 'achievement_level')" class="mt-1 text-sm text-red-600">
                                            {{ errorFor(index, 'achievement_level') }}
                                        </p>
                                    </div>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">
                                        Nama Kompetisi / Kegiatan <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        v-model="student.competition_name"
                                        required
                                        placeholder="Nama kompetisi atau kegiatan"
                                        class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                    />
                                    <p v-if="errorFor(index, 'competition_name')" class="mt-1 text-sm text-red-600">
                                        {{ errorFor(index, 'competition_name') }}
                                    </p>
                                </div>

                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-gray-700">
                                            Penghargaan <span class="text-red-500">*</span>
                                        </label>
                                        <input
                                            v-model="student.award"
                                            required
                                            placeholder="Contoh: Juara 1 / Gold Medal"
                                            class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                        />
                                        <p v-if="errorFor(index, 'award')" class="mt-1 text-sm text-red-600">
                                            {{ errorFor(index, 'award') }}
                                        </p>
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-gray-700">
                                            Tanggal Prestasi <span class="text-red-500">*</span>
                                        </label>
                                        <input
                                            v-model="student.achievement_date"
                                            type="date"
                                            required
                                            class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                        />
                                        <p v-if="errorFor(index, 'achievement_date')" class="mt-1 text-sm text-red-600">
                                            {{ errorFor(index, 'achievement_date') }}
                                        </p>
                                    </div>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">
                                        Deskripsi
                                    </label>
                                    <textarea
                                        v-model="student.description"
                                        rows="4"
                                        placeholder="Ceritakan detail prestasi siswa..."
                                        class="w-full resize-y rounded-xl border border-gray-200 px-4 py-3 text-sm leading-6 outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                    ></textarea>
                                    <p v-if="errorFor(index, 'description')" class="mt-1 text-sm text-red-600">
                                        {{ errorFor(index, 'description') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Student Details -->
                        <div class="border-t border-gray-100 pt-5">
                            <h3 class="mb-4 text-sm font-semibold text-gray-900">
                                Informasi Siswa
                            </h3>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">
                                        Nama Siswa <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        v-model="student.student_name"
                                        required
                                        placeholder="Nama lengkap siswa"
                                        class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                    />
                                    <p v-if="errorFor(index, 'student_name')" class="mt-1 text-sm text-red-600">
                                        {{ errorFor(index, 'student_name') }}
                                    </p>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">
                                        Kelas
                                    </label>
                                    <input
                                        v-model="student.student_class"
                                        placeholder="Contoh: Grade 5"
                                        class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                    />
                                    <p v-if="errorFor(index, 'student_class')" class="mt-1 text-sm text-red-600">
                                        {{ errorFor(index, 'student_class') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Fields -->
                    <div class="space-y-5">
                        <section class="rounded-xl border border-gray-200 p-4">
                            <h3 class="font-semibold text-gray-900">
                                Status Publikasi
                            </h3>

                            <div class="mt-3 space-y-3">
                                <label class="flex cursor-pointer items-start gap-3 rounded-xl border p-3"
                                    :class="student.is_active ? 'border-green-200 bg-green-50' : 'border-gray-200'">
                                    <input
                                        v-model="student.is_active"
                                        type="radio"
                                        :name="`status-${student._key}`"
                                        :value="true"
                                        class="mt-1 accent-green-600"
                                    />
                                    <span>
                                        <span class="block text-sm font-semibold text-gray-800">Published</span>
                                        <span class="mt-1 block text-xs leading-5 text-gray-500">
                                            Ditampilkan di website.
                                        </span>
                                    </span>
                                </label>

                                <label class="flex cursor-pointer items-start gap-3 rounded-xl border p-3"
                                    :class="!student.is_active ? 'border-orange-200 bg-orange-50' : 'border-gray-200'">
                                    <input
                                        v-model="student.is_active"
                                        type="radio"
                                        :name="`status-${student._key}`"
                                        :value="false"
                                        class="mt-1 accent-orange-500"
                                    />
                                    <span>
                                        <span class="block text-sm font-semibold text-gray-800">Draft</span>
                                        <span class="mt-1 block text-xs leading-5 text-gray-500">
                                            Belum ditampilkan ke publik.
                                        </span>
                                    </span>
                                </label>
                            </div>
                            <p v-if="errorFor(index, 'is_active')" class="mt-2 text-sm text-red-600">
                                {{ errorFor(index, 'is_active') }}
                            </p>
                        </section>

                        <section class="rounded-xl border border-gray-200 p-4">
                            <h3 class="font-semibold text-gray-900">
                                Foto Prestasi
                            </h3>
                            <p class="mt-1 text-xs leading-5 text-gray-500">
                                Foto atau sertifikat milik siswa ini.
                            </p>

                            <input
                                :ref="(el) => imageInputs[student._key] = el"
                                type="file"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="hidden"
                                @change="chooseImage(student, $event)"
                            />

                            <div v-if="imagePreviews[student._key]" class="relative mt-4 overflow-hidden rounded-xl">
                                <img
                                    :src="imagePreviews[student._key]"
                                    alt="Preview foto"
                                    class="aspect-[4/3] w-full object-cover"
                                />
                                <button
                                    type="button"
                                    @click="removeImage(student)"
                                    class="absolute right-2 top-2 rounded-lg bg-white p-2 text-red-600 shadow hover:bg-red-50"
                                >
                                    <Trash2 class="h-4 w-4" />
                                </button>
                            </div>

                            <button
                                v-else
                                type="button"
                                @click="imageInputs[student._key]?.click()"
                                class="mt-4 flex aspect-[4/3] w-full flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 px-3 text-center transition hover:border-orange-300 hover:bg-orange-50"
                            >
                                <ImagePlus class="h-8 w-8 text-orange-500" />
                                <span class="mt-2 text-sm font-medium text-gray-700">
                                    Upload foto
                                </span>
                                <span class="mt-1 text-xs text-gray-400">
                                    JPG, PNG, WEBP · Maks. 5 MB
                                </span>
                            </button>

                            <p v-if="errorFor(index, 'image')" class="mt-2 text-sm text-red-600">
                                {{ errorFor(index, 'image') }}
                            </p>
                        </section>
                    </div>
                </div>
            </section>

            <!-- Add Another Student -->
            <button
                type="button"
                @click="addStudent"
                class="flex w-full items-center justify-center gap-2 rounded-2xl border-2 border-dashed border-orange-200 bg-orange-50/50 px-4 py-5 text-sm font-semibold text-orange-700 transition hover:border-orange-400 hover:bg-orange-50"
            >
                <Plus class="h-5 w-5" />
                Tambah Siswa
            </button>

            <!-- Form Actions -->
            <div class="flex flex-col-reverse justify-between gap-3 rounded-2xl border border-gray-200 bg-white p-4 sm:flex-row sm:items-center sm:p-5">
                <p class="text-sm text-gray-500">
                    Total {{ form.students.length }} siswa akan diproses.
                </p>

                <div class="flex flex-col-reverse gap-3 sm:flex-row">
                    <Link
                        :href="route('admin.achievements.index')"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-200 px-5 py-3 text-sm font-semibold text-gray-600 hover:bg-gray-50"
                    >
                        Batal
                    </Link>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-orange-500 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600 disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        <Save v-else class="h-4 w-4" />
                        {{ form.processing ? 'Menyimpan...' : `Simpan ${form.students.length} Prestasi` }}
                    </button>
                </div>
            </div>

            <p class="text-xs text-gray-400">
                Field bertanda <span class="text-red-500">*</span> wajib diisi.
                Setiap siswa akan disimpan sebagai data prestasi tersendiri.
            </p>
        </form>
    </div>
</template>

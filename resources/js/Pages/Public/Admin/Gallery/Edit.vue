<script setup>
import { ref } from 'vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import {
    ArrowLeft,
    Save,
    Upload,
    Image as ImageIcon,
} from 'lucide-vue-next';

import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';

const props = defineProps({
    gallery: {
        type: Object,
        required: true,
    },
});

// Inertia Form Setup
const form = useForm({
    title: props.gallery.title ?? '',
    description: props.gallery.description ?? '',
    category: props.gallery.category ?? '',
    is_published: props.gallery.is_published ?? true,
    show_on_home: props.gallery.show_on_home ?? true,
    image: null,
});

// State untuk Preview Gambar
const imagePreview = ref(
    props.gallery.image_url 
        ? props.gallery.image_url 
        : (props.gallery.image_path ? `/storage/${props.gallery.image_path}` : null)
);

// Handle Upload Gambar Baru
const handleImageUpload = (event) => {
    const file = event.target.files && event.target.files[0];
    if (file) {
        form.image = file;
        // URL sementara browser untuk preview gambar lokal
        imagePreview.value = URL.createObjectURL(file);
    }
};

// Submit Update
const submit = () => {
    // Memakai router.post dengan _method: 'put' agar upload file FormData terbaca Laravel
    router.post(
        route('admin.galleries.update', props.gallery.id),
        {
            _method: 'put',
            title: form.title,
            description: form.description,
            category: form.category,
            is_published: form.is_published ? 1 : 0,
            show_on_home: form.show_on_home ? 1 : 0,
            image: form.image,
        },
        {
            forceFormData: true,
            preserveScroll: true,
        }
    );
};
</script>

<template>
    <Head :title="`Edit Gallery - ${gallery.title}`" />

    <AdminLayout>
        <div class="min-h-screen bg-slate-50/50 pb-16">
            <!-- TOP BAR / HEADER -->
            <div class="sticky top-0 z-10 border-b border-slate-200 bg-white/80 backdrop-blur-md">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                    <div class="flex items-center gap-4">
                        <Link
                            :href="route('admin.galleries.index')"
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900"
                        >
                            <ArrowLeft class="h-5 w-5" />
                        </Link>
                        <div>
                            <h1 class="text-lg font-bold text-slate-900">
                                Edit Data Galeri
                            </h1>
                            <p class="text-xs text-slate-500">
                                Perbarui informasi atau ubah foto galeri.
                            </p>
                        </div>
                    </div>

                    <button
                        type="button"
                        @click="submit"
                        :disabled="form.processing"
                        class="inline-flex items-center gap-2 rounded-xl bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-orange-500/30 transition hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 disabled:opacity-50"
                    >
                        <Save class="h-4 w-4" />
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                    </button>
                </div>
            </div>

            <!-- MAIN CONTAINER -->
            <div class="mx-auto max-w-7xl p-6">
                <form @submit.prevent="submit">
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <!-- CARD HEADER -->
                        <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-3.5">
                            <h3 class="text-sm font-semibold text-slate-800">
                                Form Edit Galeri
                            </h3>
                        </div>

                        <!-- CARD BODY: GRID 50% | 50% -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                                <!-- LAYOUT KIRI (50%): GAMBAR & OPTIONS -->
                                <div class="space-y-4">
                                    <div>
                                        <label class="mb-2 block text-xs font-semibold uppercase tracking-wider text-slate-500">
                                            Foto Galeri
                                        </label>

                                        <!-- Container Upload / Preview Gambar -->
                                        <div
                                            class="group relative flex aspect-[16/10] w-full flex-col items-center justify-center overflow-hidden rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 transition hover:border-orange-400 hover:bg-orange-50/20"
                                        >
                                            <img
                                                v-if="imagePreview"
                                                :src="imagePreview"
                                                class="h-full w-full object-cover"
                                            />

                                            <div v-else class="flex flex-col items-center p-4 text-center">
                                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-400 transition group-hover:bg-orange-100 group-hover:text-orange-500">
                                                    <Upload class="h-5 w-5" />
                                                </div>
                                                <p class="mt-2 text-xs font-semibold text-slate-700">
                                                    Klik untuk Mengganti Foto
                                                </p>
                                                <p class="mt-0.5 text-[11px] text-slate-400">
                                                    PNG, JPG, WEBP hingga 5MB
                                                </p>
                                            </div>

                                            <input
                                                type="file"
                                                accept="image/*"
                                                @change="handleImageUpload"
                                                class="absolute inset-0 cursor-pointer opacity-0"
                                            />
                                        </div>

                                        <p class="mt-1.5 text-[11px] text-slate-400">
                                            Biarkan kosong jika tidak ingin mengubah foto saat ini.
                                        </p>

                                        <span v-if="form.errors.image" class="mt-1.5 block text-xs font-medium text-red-500">
                                            {{ form.errors.image }}
                                        </span>
                                    </div>

                                    <!-- CHECKBOX OPTIONS -->
                                    <div class="grid grid-cols-2 gap-3 pt-1">
                                        <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50/50 p-3 cursor-pointer transition hover:bg-slate-100/80">
                                            <input
                                                v-model="form.is_published"
                                                type="checkbox"
                                                class="h-4 w-4 rounded border-slate-300 text-orange-500 focus:ring-orange-500"
                                            />
                                            <div class="text-xs">
                                                <p class="font-semibold text-slate-800">Publikasi</p>
                                                <p class="text-slate-400">Tampil di web</p>
                                            </div>
                                        </label>

                                        <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50/50 p-3 cursor-pointer transition hover:bg-slate-100/80">
                                            <input
                                                v-model="form.show_on_home"
                                                type="checkbox"
                                                class="h-4 w-4 rounded border-slate-300 text-orange-500 focus:ring-orange-500"
                                            />
                                            <div class="text-xs">
                                                <p class="font-semibold text-slate-800">Beranda</p>
                                                <p class="text-slate-400">Section Home</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- LAYOUT KANAN (50%): TITLE, DESCRIPTION, CATEGORY -->
                                <div class="flex flex-col justify-between space-y-4">
                                    <!-- Title -->
                                    <div>
                                        <label class="mb-2 block text-xs font-semibold uppercase tracking-wider text-slate-500">
                                            Judul Galeri <span class="text-red-500">*</span>
                                        </label>
                                        <input
                                            v-model="form.title"
                                            type="text"
                                            placeholder="Masukkan judul foto / kegiatan..."
                                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                        />
                                        <span v-if="form.errors.title" class="mt-1.5 block text-xs font-medium text-red-500">
                                            {{ form.errors.title }}
                                        </span>
                                    </div>

                                    <!-- Description -->
                                    <div class="flex-1">
                                        <label class="mb-2 block text-xs font-semibold uppercase tracking-wider text-slate-500">
                                            Deskripsi
                                        </label>
                                        <textarea
                                            v-model="form.description"
                                            rows="4"
                                            placeholder="Tuliskan keterangan rinci mengenai foto ini..."
                                            class="w-full resize-none rounded-xl border border-slate-200 px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                        ></textarea>
                                    </div>

                                    <!-- Category -->
                                    <div>
                                        <label class="mb-2 block text-xs font-semibold uppercase tracking-wider text-slate-500">
                                            Kategori Galeri
                                        </label>
                                        <select
                                            v-model="form.category"
                                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                        >
                                            <option value="">Pilih Kategori</option>
                                            <option value="academic">Academic Activities</option>
                                            <option value="events">Events & Celebrations</option>
                                            <option value="sports">Sports & Competitions</option>
                                            <option value="arts">Arts & Creativity</option>
                                            <option value="field_trips">Field Trips</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
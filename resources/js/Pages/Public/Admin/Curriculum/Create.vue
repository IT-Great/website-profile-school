<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, Save, Upload, Plus, Trash2 } from 'lucide-vue-next';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';

const form = useForm({
    badge_title: '',
    title: '',
    description: '',
    image_position: 'left',
    sort_order: 0,
    status: true,
    features: [''], // Default 1 poin kosong
    image: null,
});

const imagePreview = ref(null);

const handleImageUpload = (event) => {
    const file = event.target.files && event.target.files[0];
    if (file) {
        form.image = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};

const addFeature = () => {
    form.features.push('');
};

const removeFeature = (index) => {
    form.features.splice(index, 1);
};

const submit = () => {
    form.post(route('admin.curriculum.store'), {
        forceFormData: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Create Curriculum Item" />

    <AdminLayout>
        <div class="min-h-screen bg-slate-50/50 pb-16">
            <!-- HEADER BAR -->
            <div class="sticky top-0 z-10 border-b border-slate-200 bg-white/80 backdrop-blur-md">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                    <div class="flex items-center gap-4">
                        <Link
                            :href="route('admin.curriculum.index')"
                            class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100"
                        >
                            <ArrowLeft class="h-5 w-5" />
                        </Link>
                        <div>
                            <h1 class="text-lg font-bold text-slate-900">Add Curriculum Block</h1>
                            <p class="text-xs text-slate-500">Create new curriculum section (Preschool, Primary, Secondary, etc.)</p>
                        </div>
                    </div>

                    <button
                        type="button"
                        @click="submit"
                        :disabled="form.processing"
                        class="inline-flex items-center gap-2 rounded-xl bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-600 disabled:opacity-50"
                    >
                        <Save class="h-4 w-4" />
                        {{ form.processing ? 'Saving...' : 'Save Item' }}
                    </button>
                </div>
            </div>

            <!-- FORM CONTENT (50% | 50%) -->
            <div class="mx-auto max-w-7xl p-6">
                <form @submit.prevent="submit">
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                            
                            <!-- KIRI (50%): GAMBAR & LAYOUT SETTINGS -->
                            <div class="space-y-4">
                                <div>
                                    <label class="mb-2 block text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Section Image <span class="text-red-500">*</span>
                                    </label>

                                    <div class="group relative flex aspect-[16/10] w-full flex-col items-center justify-center overflow-hidden rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 hover:border-orange-400">
                                        <img v-if="imagePreview" :src="imagePreview" class="h-full w-full object-cover" />
                                        <div v-else class="flex flex-col items-center p-4 text-center">
                                            <Upload class="h-8 w-8 text-slate-400" />
                                            <p class="mt-2 text-xs font-semibold text-slate-700">Click to Upload Image</p>
                                            <p class="mt-0.5 text-[11px] text-slate-400">JPG, PNG, WEBP max 5MB</p>
                                        </div>
                                        <input type="file" accept="image/*" @change="handleImageUpload" class="absolute inset-0 z-10 cursor-pointer opacity-0" />
                                    </div>
                                    <span v-if="form.errors.image" class="mt-1 block text-xs text-red-500">{{ form.errors.image }}</span>
                                </div>

                                <div class="grid grid-cols-2 gap-4 pt-2">
                                    <div>
                                        <label class="mb-1.5 block text-xs font-semibold text-slate-600">Image Position</label>
                                        <select v-model="form.image_position" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:border-orange-500">
                                            <option value="left">Left</option>
                                            <option value="right">Right</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="mb-1.5 block text-xs font-semibold text-slate-600">Sort Order</label>
                                        <input v-model="form.sort_order" type="number" min="0" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:border-orange-500" />
                                    </div>
                                </div>

                                <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50/50 p-3 cursor-pointer">
                                    <input v-model="form.status" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-orange-500 focus:ring-orange-500" />
                                    <div class="text-xs">
                                        <p class="font-semibold text-slate-800">Active Status</p>
                                        <p class="text-slate-400">Display this curriculum block on website</p>
                                    </div>
                                </label>
                            </div>

                            <!-- KANAN (50%): BADGE, TITLE, DESCRIPTION, FEATURES -->
                            <div class="space-y-4">
                                <div>
                                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Badge Subtitle <span class="text-red-500">*</span>
                                    </label>
                                    <input v-model="form.badge_title" type="text" placeholder="e.g., PRESCHOOL CURRICULUM" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm outline-none focus:border-orange-500" />
                                    <span v-if="form.errors.badge_title" class="mt-1 block text-xs text-red-500">{{ form.errors.badge_title }}</span>
                                </div>

                                <div>
                                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Main Title <span class="text-red-500">*</span>
                                    </label>
                                    <input v-model="form.title" type="text" placeholder="e.g., Learning Through Play" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm outline-none focus:border-orange-500" />
                                    <span v-if="form.errors.title" class="mt-1 block text-xs text-red-500">{{ form.errors.title }}</span>
                                </div>

                                <div>
                                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Description <span class="text-red-500">*</span>
                                    </label>
                                    <textarea v-model="form.description" rows="3" placeholder="Paragraf penjelasan kurikulum..." class="w-full resize-none rounded-xl border border-slate-200 px-4 py-2.5 text-sm outline-none focus:border-orange-500"></textarea>
                                </div>

                                <!-- FEATURES CHECKLIST LIST -->
                                <div>
                                    <div class="mb-2 flex items-center justify-between">
                                        <label class="text-xs font-semibold uppercase tracking-wider text-slate-500">Key Features / Centang Poin</label>
                                        <button type="button" @click="addFeature" class="text-xs font-bold text-orange-600 hover:underline flex items-center gap-1">
                                            <Plus class="h-3 w-3" /> Add Feature
                                        </button>
                                    </div>

                                    <div class="space-y-2">
                                        <div v-for="(feat, idx) in form.features" :key="idx" class="flex items-center gap-2">
                                            <span class="text-orange-500 font-bold">✓</span>
                                            <input v-model="form.features[idx]" type="text" placeholder="e.g., Play-based & inquiry learning" class="w-full rounded-lg border border-slate-200 px-3 py-1.5 text-xs outline-none focus:border-orange-500" />
                                            <button v-if="form.features.length > 1" type="button" @click="removeFeature(idx)" class="text-red-500 hover:text-red-700">
                                                <Trash2 class="h-4 w-4" />
                                            </button>
                                        </div>
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
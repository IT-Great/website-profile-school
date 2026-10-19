<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';

import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';

const props = defineProps({
    setting: {
        type: Object,
        required: true,
    },
});

const imageInput = ref(null);

const form = useForm({
    title: props.setting.title ?? 'Curriculum',

    description:
        props.setting.description ?? '',

    background_image: null,

    primary_button_text:
        props.setting.primary_button_text ?? 'Get to Know',

    primary_button_url:
        props.setting.primary_button_url ?? '/about',

    secondary_button_text:
        props.setting.secondary_button_text ?? 'Contact',

    secondary_button_url:
        props.setting.secondary_button_url ?? '/contact',

    is_active:
        Boolean(props.setting.is_active),
});

const previewImage = ref(
    props.setting.background_image
        ? `/storage/${props.setting.background_image}`
        : null
);

const handleImage = (event) => {

    const file = event.target.files[0];

    if (!file) {
        return;
    }

    form.background_image = file;

    previewImage.value =
        URL.createObjectURL(file);
};

const removeImage = () => {

    form.background_image = null;

    previewImage.value =
        props.setting.background_image
            ? `/storage/${props.setting.background_image}`
            : null;

    if (imageInput.value) {
        imageInput.value.value = '';
    }
};

const submit = () => {

    form.post(
        route('admin.curriculum.edit.header'),
        {
            forceFormData: true,
            preserveScroll: true,
        }
    );
};
</script>

<template>

    <Head title="Curriculum Header" />

    <AdminLayout>

        <div class="min-h-screen bg-slate-50">

            <!-- HEADER -->

            <div class="border-b border-slate-200 bg-white">

                <div class="px-6 py-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <h1 class="text-xl font-bold text-slate-900">
                                Curriculum Header
                            </h1>

                            <p class="mt-1 text-sm text-slate-500">
                                Manage the header section displayed on the Curriculum page.
                            </p>

                        </div>

                        <button
                            type="button"
                            @click="submit"
                            :disabled="form.processing"
                            class="rounded-lg bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-600 disabled:opacity-60"
                        >
                            {{
                                form.processing
                                    ? 'Saving...'
                                    : 'Save Changes'
                            }}
                        </button>

                    </div>

                </div>

            </div>


            <div class="p-6">

                <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

                    <!-- LEFT -->

                    <div class="space-y-6 xl:col-span-2">

                        <!-- CONTENT -->

                        <div class="rounded-xl border border-slate-200 bg-white">

                            <div class="border-b border-slate-200 p-6">

                                <h2 class="font-semibold text-slate-900">
                                    Header Content
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Content displayed on the Facility page hero.
                                </p>

                            </div>

                            <div class="space-y-5 p-6">

                                <!-- TITLE -->

                                <div>

                                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                                        Title
                                    </label>

                                    <input
                                        v-model="form.title"
                                        type="text"
                                        class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                    />

                                    <p
                                        v-if="form.errors.title"
                                        class="mt-1 text-sm text-red-500"
                                    >
                                        {{ form.errors.title }}
                                    </p>

                                </div>


                                <!-- DESCRIPTION -->

                                <div>

                                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                                        Description
                                    </label>

                                    <textarea
                                        v-model="form.description"
                                        rows="5"
                                        class="w-full resize-none rounded-lg border border-slate-300 px-4 py-3 text-sm leading-6 outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                    ></textarea>

                                </div>


                                <!-- BUTTONS -->

                                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                                    <!-- Primary -->

                                    <div class="rounded-xl border border-orange-100 bg-orange-50/40 p-4">

                                        <h3 class="mb-4 text-sm font-semibold text-slate-800">
                                            Primary Button
                                        </h3>

                                        <div class="space-y-4">

                                            <div>

                                                <label class="mb-2 block text-xs font-semibold text-slate-600">
                                                    Button Text
                                                </label>

                                                <input
                                                    v-model="form.primary_button_text"
                                                    type="text"
                                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-orange-500"
                                                />

                                            </div>

                                            <div>

                                                <label class="mb-2 block text-xs font-semibold text-slate-600">
                                                    Button URL
                                                </label>

                                                <input
                                                    v-model="form.primary_button_url"
                                                    type="text"
                                                    placeholder="/about"
                                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-orange-500"
                                                />

                                            </div>

                                        </div>

                                    </div>


                                    <!-- Secondary -->

                                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

                                        <h3 class="mb-4 text-sm font-semibold text-slate-800">
                                            Secondary Button
                                        </h3>

                                        <div class="space-y-4">

                                            <div>

                                                <label class="mb-2 block text-xs font-semibold text-slate-600">
                                                    Button Text
                                                </label>

                                                <input
                                                    v-model="form.secondary_button_text"
                                                    type="text"
                                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-orange-500"
                                                />

                                            </div>

                                            <div>

                                                <label class="mb-2 block text-xs font-semibold text-slate-600">
                                                    Button URL
                                                </label>

                                                <input
                                                    v-model="form.secondary_button_url"
                                                    type="text"
                                                    placeholder="/contact"
                                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-orange-500"
                                                />

                                            </div>

                                        </div>

                                    </div>

                                </div>


                                <!-- ACTIVE -->

                                <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-slate-200 p-4">

                                    <input
                                        v-model="form.is_active"
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-slate-300 text-orange-500 focus:ring-orange-500"
                                    />

                                    <div>

                                        <p class="text-sm font-semibold text-slate-800">
                                            Active
                                        </p>

                                        <p class="text-xs text-slate-500">
                                            Display this header on the public Curriculum page.
                                        </p>

                                    </div>

                                </label>

                            </div>

                        </div>

                    </div>


                    <!-- RIGHT -->

                    <div>

                        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                            <div class="border-b border-slate-200 p-5">

                                <h2 class="font-semibold text-slate-900">
                                    Background Image
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Image displayed behind the Curriculum header.
                                </p>

                            </div>

                            <div class="p-5">

                                <input
                                    ref="imageInput"
                                    type="file"
                                    accept="image/png,image/jpeg,image/webp"
                                    class="hidden"
                                    @change="handleImage"
                                />


                                <div
                                    v-if="previewImage"
                                    class="overflow-hidden rounded-xl border border-slate-200"
                                >

                                    <img
                                        :src="previewImage"
                                        class="aspect-video w-full object-cover"
                                        alt="Curriculum header"
                                    />

                                    <div class="flex gap-2 p-3">

                                        <button
                                            type="button"
                                            @click="imageInput?.click()"
                                            class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50"
                                        >
                                            Change
                                        </button>

                                        <button
                                            type="button"
                                            @click="removeImage"
                                            class="rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-100"
                                        >
                                            Remove
                                        </button>

                                    </div>

                                </div>


                                <button
                                    v-else
                                    type="button"
                                    @click="imageInput?.click()"
                                    class="flex aspect-video w-full flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 hover:border-orange-300 hover:bg-orange-50/30"
                                >

                                    <div class="mb-3 text-orange-500">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-8 w-8"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M12 16V4m0 0l-4 4m4-4l4 4"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2"
                                            />
                                        </svg>
                                    </div>

                                    <span class="text-sm font-semibold text-slate-700">
                                        Upload Image
                                    </span>

                                    <span class="mt-1 text-xs text-slate-400">
                                        JPG, PNG or WEBP · Max 5 MB
                                    </span>

                                </button>

                                <p
                                    v-if="form.errors.background_image"
                                    class="mt-2 text-sm text-red-500"
                                >
                                    {{ form.errors.background_image }}
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- LIVE PREVIEW -->

                <div class="mt-6 rounded-xl border border-slate-200 bg-white">

                    <div class="border-b border-slate-200 p-5">

                        <h2 class="font-semibold text-slate-900">
                            Live Preview
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Preview of the Curriculum page header.
                        </p>

                    </div>

                    <div class="p-5">

                        <div
                            class="relative min-h-[420px] overflow-hidden rounded-xl bg-slate-900 bg-cover bg-center"
                            :style="{
                                backgroundImage: previewImage
                                    ? `linear-gradient(rgba(0,0,0,.52), rgba(0,0,0,.52)), url('${previewImage}')`
                                    : 'linear-gradient(135deg,#334155,#0f172a)'
                            }"
                        >

                            <div class="absolute inset-0 flex items-center">

                                <div class="max-w-3xl px-10">

                                    <h2 class="text-5xl font-bold text-white">
                                        {{ form.title || 'Curriculum' }}
                                    </h2>

                                    <p class="mt-6 text-lg leading-8 text-white/90">
                                        {{
                                            form.description ||
                                            'Curriculum page description goes here.'
                                        }}
                                    </p>

                                    <div class="mt-8 flex flex-wrap gap-4">

                                        <span
                                            v-if="form.primary_button_text"
                                            class="rounded-full bg-orange-500 px-7 py-3 font-semibold text-white"
                                        >
                                            {{ form.primary_button_text }}
                                            →
                                        </span>

                                        <span
                                            v-if="form.secondary_button_text"
                                            class="rounded-full border border-white px-7 py-3 font-semibold text-white"
                                        >
                                            {{ form.secondary_button_text }}
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </AdminLayout>

</template>
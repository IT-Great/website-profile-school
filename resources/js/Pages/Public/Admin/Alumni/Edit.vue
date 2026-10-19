<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';

const props = defineProps({
    alumni: {
        type: Object,
        required: true,
    },
});

const imageInput = ref(null);

const form = useForm({
    name: props.alumni.name ?? '',
    position: props.alumni.position ?? '',
    company: props.alumni.company ?? '',
    testimonial: props.alumni.testimonial ?? '',
    photo: null,
    sort_order: props.alumni.sort_order ?? 0,
    is_active: Boolean(props.alumni.is_active),
});

const previewImage = ref(
    props.alumni.photo
        ? `/storage/${props.alumni.photo}`
        : null
);

const handlePhoto = (event) => {

    const file = event.target.files[0];

    if (!file) {
        return;
    }

    form.photo = file;

    previewImage.value =
        URL.createObjectURL(file);
};

const removePhoto = () => {

    form.photo = null;

    previewImage.value = null;

    if (imageInput.value) {
        imageInput.value.value = '';
    }
};

const submit = () => {

    form
        .transform((data) => ({
            ...data,
            _method: 'PUT',
        }))
        .post(
            route(
                'admin.alumnis.update',
                props.alumni.id
            ),
            {
                forceFormData: true,
                preserveScroll: true,
            }
        );
};
</script>


<template>

    <Head title="Edit Alumni" />

    <AdminLayout>

        <div class="min-h-screen bg-slate-50">

            <!-- HEADER -->

            <div class="border-b border-slate-200 bg-white">

                <div class="flex items-center justify-between px-6 py-5">

                    <div>

                        <div class="flex items-center gap-2">

                            <Link
                                :href="route('admin.alumnis.index')"
                                class="text-sm text-slate-400 hover:text-orange-500"
                            >
                                Alumni
                            </Link>

                            <span class="text-slate-300">
                                /
                            </span>

                            <span class="text-sm text-slate-600">
                                Edit
                            </span>

                        </div>

                        <h1 class="mt-2 text-xl font-bold text-slate-900">
                            Edit Alumni
                        </h1>

                        <p class="mt-1 text-sm text-slate-500">
                            Update alumni profile information.
                        </p>

                    </div>


                    <div class="flex items-center gap-3">

                        <Link
                            :href="route('admin.alumnis.index')"
                            class="rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50"
                        >
                            Cancel
                        </Link>

                        <button
                            type="button"
                            @click="submit"
                            :disabled="form.processing"
                            class="rounded-lg bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-orange-600 disabled:opacity-50"
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


            <!-- CONTENT -->

            <div class="p-6">

                <div class="mx-auto max-w-6xl">

                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

                        <!-- LEFT : INFORMATION -->

                        <div class="space-y-6 lg:col-span-2">

                            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                                <div class="border-b border-slate-200 p-6">

                                    <h2 class="font-semibold text-slate-900">
                                        Alumni Information
                                    </h2>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Basic information displayed on the alumni page.
                                    </p>

                                </div>


                                <div class="space-y-5 p-6">

                                    <!-- NAME -->

                                    <div>

                                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                                            Name
                                        </label>

                                        <input
                                            v-model="form.name"
                                            type="text"
                                            placeholder="Shivani Bangia"
                                            class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                        />

                                        <p
                                            v-if="form.errors.name"
                                            class="mt-1 text-xs text-red-500"
                                        >
                                            {{ form.errors.name }}
                                        </p>

                                    </div>


                                    <!-- POSITION + COMPANY -->

                                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                                        <div>

                                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                                Position
                                            </label>

                                            <input
                                                v-model="form.position"
                                                type="text"
                                                placeholder="Software Engineer"
                                                class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                            />

                                            <p
                                                v-if="form.errors.position"
                                                class="mt-1 text-xs text-red-500"
                                            >
                                                {{ form.errors.position }}
                                            </p>

                                        </div>


                                        <div>

                                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                                Company
                                            </label>

                                            <input
                                                v-model="form.company"
                                                type="text"
                                                placeholder="Google"
                                                class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                            />

                                            <p
                                                v-if="form.errors.company"
                                                class="mt-1 text-xs text-red-500"
                                            >
                                                {{ form.errors.company }}
                                            </p>

                                        </div>

                                    </div>


                                    <!-- TESTIMONIAL -->

                                    <div>

                                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                                            Testimonial / Story
                                        </label>

                                        <textarea
                                            v-model="form.testimonial"
                                            rows="8"
                                            placeholder="Write the alumni story or testimonial..."
                                            class="w-full resize-none rounded-lg border border-slate-300 px-4 py-3 text-sm leading-6 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                        ></textarea>

                                        <p
                                            v-if="form.errors.testimonial"
                                            class="mt-1 text-xs text-red-500"
                                        >
                                            {{ form.errors.testimonial }}
                                        </p>

                                    </div>

                                </div>

                            </div>


                            <!-- SETTINGS -->

                            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                                <div class="border-b border-slate-200 p-6">

                                    <h2 class="font-semibold text-slate-900">
                                        Display Settings
                                    </h2>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Control the order and visibility of this alumni.
                                    </p>

                                </div>


                                <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">

                                    <!-- SORT ORDER -->

                                    <div>

                                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                                            Sort Order
                                        </label>

                                        <input
                                            v-model.number="form.sort_order"
                                            type="number"
                                            min="0"
                                            class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                        />

                                        <p class="mt-1 text-xs text-slate-400">
                                            Lower numbers appear first.
                                        </p>

                                    </div>


                                    <!-- ACTIVE -->

                                    <div>

                                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                                            Status
                                        </label>

                                        <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-slate-300 px-4 py-3">

                                            <input
                                                v-model="form.is_active"
                                                type="checkbox"
                                                class="h-4 w-4 rounded border-slate-300 text-orange-500 focus:ring-orange-500"
                                            />

                                            <div>

                                                <p class="text-sm font-semibold text-slate-700">
                                                    Active
                                                </p>

                                                <p class="text-xs text-slate-400">
                                                    Show this alumni on the website.
                                                </p>

                                            </div>

                                        </label>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- RIGHT : PHOTO -->

                        <div>

                            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                                <div class="border-b border-slate-200 p-5">

                                    <h2 class="font-semibold text-slate-900">
                                        Alumni Photo
                                    </h2>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Profile photo displayed on the alumni card.
                                    </p>

                                </div>


                                <div class="p-5">

                                    <input
                                        ref="imageInput"
                                        type="file"
                                        accept="image/jpeg,image/png,image/webp"
                                        class="hidden"
                                        @change="handlePhoto"
                                    />


                                    <!-- PREVIEW -->

                                    <div
                                        v-if="previewImage"
                                        class="overflow-hidden rounded-xl border border-slate-200"
                                    >

                                        <div class="aspect-square bg-slate-100">

                                            <img
                                                :src="previewImage"
                                                alt="Alumni photo"
                                                class="h-full w-full object-cover"
                                            />

                                        </div>


                                        <div class="flex gap-2 border-t border-slate-200 p-3">

                                            <button
                                                type="button"
                                                @click="imageInput?.click()"
                                                class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50"
                                            >
                                                Change Photo
                                            </button>

                                            <button
                                                type="button"
                                                @click="removePhoto"
                                                class="rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-100"
                                            >
                                                Remove
                                            </button>

                                        </div>

                                    </div>


                                    <!-- UPLOAD -->

                                    <button
                                        v-else
                                        type="button"
                                        @click="imageInput?.click()"
                                        class="flex aspect-square w-full flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 transition hover:border-orange-300 hover:bg-orange-50"
                                    >

                                        <div class="mb-3 text-3xl text-orange-500">
                                            ↑
                                        </div>

                                        <span class="text-sm font-semibold text-slate-700">
                                            Upload Photo
                                        </span>

                                        <span class="mt-1 text-xs text-slate-400">
                                            JPG, PNG or WEBP
                                        </span>

                                        <span class="mt-1 text-xs text-slate-400">
                                            Maximum 5 MB
                                        </span>

                                    </button>


                                    <p
                                        v-if="form.errors.photo"
                                        class="mt-2 text-xs text-red-500"
                                    >
                                        {{ form.errors.photo }}
                                    </p>

                                </div>

                            </div>


                            <!-- ALUMNI ID -->

                            <div class="mt-4 rounded-xl border border-slate-200 bg-white p-5">

                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    Alumni ID
                                </p>

                                <p class="mt-1 text-lg font-bold text-slate-800">
                                    #{{ alumni.id }}
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </AdminLayout>

</template>
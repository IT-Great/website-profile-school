<script setup>
import { ref, computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import {
    ArrowLeft,
    Building2,
    BookOpen,
    FlaskConical,
    Gamepad2,
    ImagePlus,
    LayoutGrid,
    Monitor,
    Music,
    Trophy,
    Utensils,
    X,
    Save,
} from 'lucide-vue-next';

import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';

const props = defineProps({
    facility: {
        type: Object,
        required: true,
    },
});

const imageInput = ref(null);

const form = useForm({
    title: props.facility.title ?? '',
    description: props.facility.description ?? '',
    icon: props.facility.icon ?? 'Building2',
    sort_order: props.facility.sort_order ?? 0,
    status: Boolean(props.facility.status),
    image: null,
});

const previewImage = ref(
    props.facility.image
        ? `/storage/${props.facility.image}`
        : null
);


/*
|--------------------------------------------------------------------------
| Icon Options
|--------------------------------------------------------------------------
*/

const iconOptions = [
    {
        name: 'LayoutGrid',
        label: 'Smart Classrooms',
        component: LayoutGrid,
    },
    {
        name: 'FlaskConical',
        label: 'Science Laboratory',
        component: FlaskConical,
    },
    {
        name: 'BookOpen',
        label: 'Library',
        component: BookOpen,
    },
    {
        name: 'Monitor',
        label: 'Computer Lab',
        component: Monitor,
    },
    {
        name: 'Trophy',
        label: 'Sports Facilities',
        component: Trophy,
    },
    {
        name: 'Music',
        label: 'Art & Music Room',
        component: Music,
    },
    {
        name: 'Gamepad2',
        label: 'Playground',
        component: Gamepad2,
    },
    {
        name: 'Utensils',
        label: 'Canteen',
        component: Utensils,
    },
    {
        name: 'Building2',
        label: 'Other',
        component: Building2,
    },
];


/*
|--------------------------------------------------------------------------
| Current Icon
|--------------------------------------------------------------------------
*/

const selectedIcon = computed(() => {
    return (
        iconOptions.find(
            item => item.name === form.icon
        )?.component ?? Building2
    );
});


/*
|--------------------------------------------------------------------------
| Image
|--------------------------------------------------------------------------
*/

const openImagePicker = () => {
    imageInput.value?.click();
};

const handleImage = (event) => {

    const file = event.target.files[0];

    if (!file) {
        return;
    }

    form.image = file;

    previewImage.value =
        URL.createObjectURL(file);
};

const removeImage = () => {

    form.image = null;
    previewImage.value = null;

    if (imageInput.value) {
        imageInput.value.value = '';
    }
};


/*
|--------------------------------------------------------------------------
| Submit
|--------------------------------------------------------------------------
*/

const submit = () => {

    form
        .transform(data => ({
            ...data,
            _method: 'PUT',
        }))
        .post(
            route(
                'admin.facilities.update',
                props.facility.id
            ),
            {
                forceFormData: true,
                preserveScroll: true,
            }
        );
};
</script>

<template>

    <Head :title="`Edit Facility - ${facility.title}`" />

    <AdminLayout>

        <div class="min-h-screen bg-slate-50">

            <!-- HEADER -->

            <div class="border-b border-slate-200 bg-white">

                <div class="flex items-center justify-between px-6 py-5">

                    <div>

                        <div class="flex items-center gap-2">

                            <Link
                                :href="route('admin.facilities.index')"
                                class="text-sm text-slate-400 transition hover:text-orange-500"
                            >
                                Facilities
                            </Link>

                            <span class="text-slate-300">
                                /
                            </span>

                            <span class="text-sm text-slate-600">
                                Edit
                            </span>

                        </div>

                        <h1 class="mt-2 text-xl font-bold text-slate-900">
                            Edit Facility
                        </h1>

                        <p class="mt-1 text-sm text-slate-500">
                            Update facility information and image.
                        </p>

                    </div>


                    <div class="flex items-center gap-3">

                        <Link
                            :href="route('admin.facilities.index')"
                            class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                        >
                            <ArrowLeft :size="16" />

                            Cancel
                        </Link>

                        <button
                            type="button"
                            @click="submit"
                            :disabled="form.processing"
                            class="flex items-center gap-2 rounded-lg bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-600 disabled:cursor-not-allowed disabled:opacity-50"
                        >

                            <Save :size="16" />

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

                        <!-- LEFT -->

                        <div class="space-y-6 lg:col-span-2">

                            <!-- INFORMATION -->

                            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                                <div class="border-b border-slate-200 p-6">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-orange-50 text-orange-500">
                                            <Building2 :size="20" />
                                        </div>

                                        <div>

                                            <h2 class="font-semibold text-slate-900">
                                                Facility Information
                                            </h2>

                                            <p class="mt-1 text-sm text-slate-500">
                                                Basic information about this facility.
                                            </p>

                                        </div>

                                    </div>

                                </div>


                                <div class="space-y-5 p-6">

                                    <!-- TITLE -->

                                    <div>

                                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                                            Facility Name
                                            <span class="text-red-500">*</span>
                                        </label>

                                        <input
                                            v-model="form.title"
                                            type="text"
                                            placeholder="e.g. Smart Classrooms"
                                            class="w-full rounded-lg border px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                            :class="
                                                form.errors.title
                                                    ? 'border-red-400'
                                                    : 'border-slate-300'
                                            "
                                        />

                                        <p
                                            v-if="form.errors.title"
                                            class="mt-1.5 text-xs text-red-500"
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
                                            rows="6"
                                            placeholder="Describe the facility..."
                                            class="w-full resize-none rounded-lg border border-slate-300 px-4 py-3 text-sm leading-6 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                        ></textarea>

                                        <div class="mt-1 flex justify-between">

                                            <p
                                                v-if="form.errors.description"
                                                class="text-xs text-red-500"
                                            >
                                                {{ form.errors.description }}
                                            </p>

                                            <span class="ml-auto text-xs text-slate-400">
                                                {{ form.description.length }}
                                                characters
                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <!-- DISPLAY SETTINGS -->

                            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                                <div class="border-b border-slate-200 p-6">

                                    <h2 class="font-semibold text-slate-900">
                                        Display Settings
                                    </h2>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Configure how this facility appears on the website.
                                    </p>

                                </div>


                                <div class="space-y-6 p-6">

                                    <!-- ICON -->

                                    <div>

                                        <label class="mb-3 block text-sm font-semibold text-slate-700">
                                            Facility Icon
                                        </label>

                                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4">

                                            <button
                                                v-for="icon in iconOptions"
                                                :key="icon.name"
                                                type="button"
                                                @click="form.icon = icon.name"
                                                class="rounded-lg border p-3 text-left transition"
                                                :class="
                                                    form.icon === icon.name
                                                        ? 'border-orange-400 bg-orange-50 ring-2 ring-orange-100'
                                                        : 'border-slate-200 hover:border-orange-200 hover:bg-slate-50'
                                                "
                                            >

                                                <div class="flex items-center gap-2">

                                                    <div
                                                        class="flex h-9 w-9 items-center justify-center rounded-lg"
                                                        :class="
                                                            form.icon === icon.name
                                                                ? 'bg-orange-100 text-orange-500'
                                                                : 'bg-slate-100 text-slate-500'
                                                        "
                                                    >

                                                        <component
                                                            :is="icon.component"
                                                            :size="18"
                                                        />

                                                    </div>

                                                    <span class="text-xs font-medium text-slate-700">
                                                        {{ icon.label }}
                                                    </span>

                                                </div>

                                                <p class="mt-2 text-[10px] text-slate-400">
                                                    {{ icon.name }}
                                                </p>

                                            </button>

                                        </div>

                                        <p class="mt-2 text-xs text-slate-400">
                                            Select an icon that represents this facility.
                                        </p>

                                    </div>


                                    <!-- SORT + STATUS -->

                                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                                        <!-- SORT ORDER -->

                                        <div>

                                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                                Sort Order
                                            </label>

                                            <input
                                                v-model.number="form.sort_order"
                                                type="number"
                                                min="0"
                                                class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                            />

                                            <p class="mt-1 text-xs text-slate-400">
                                                Lower numbers appear first.
                                            </p>

                                        </div>


                                        <!-- STATUS -->

                                        <div>

                                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                                Status
                                            </label>

                                            <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-slate-300 px-4 py-3">

                                                <input
                                                    v-model="form.status"
                                                    type="checkbox"
                                                    class="h-4 w-4 rounded border-slate-300 text-orange-500 focus:ring-orange-500"
                                                />

                                                <div>

                                                    <p class="text-sm font-semibold text-slate-700">
                                                        Active
                                                    </p>

                                                    <p class="text-xs text-slate-400">
                                                        Show this facility on the website.
                                                    </p>

                                                </div>

                                            </label>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- RIGHT -->

                        <div>

                            <!-- IMAGE -->

                            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                                <div class="border-b border-slate-200 p-5">

                                    <h2 class="font-semibold text-slate-900">
                                        Facility Image
                                    </h2>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Image displayed on the facility card.
                                    </p>

                                </div>


                                <div class="p-5">

                                    <input
                                        ref="imageInput"
                                        type="file"
                                        accept="image/jpeg,image/png,image/webp"
                                        class="hidden"
                                        @change="handleImage"
                                    />


                                    <!-- IMAGE PREVIEW -->

                                    <div
                                        v-if="previewImage"
                                        class="overflow-hidden rounded-xl border border-slate-200"
                                    >

                                        <div class="relative aspect-[4/3] bg-slate-100">

                                            <img
                                                :src="previewImage"
                                                :alt="form.title"
                                                class="h-full w-full object-cover"
                                            />

                                            <button
                                                type="button"
                                                @click="removeImage"
                                                class="absolute right-3 top-3 flex h-8 w-8 items-center justify-center rounded-full bg-white text-slate-600 shadow transition hover:bg-red-50 hover:text-red-500"
                                            >
                                                <X :size="16" />
                                            </button>

                                        </div>


                                        <div class="p-3">

                                            <button
                                                type="button"
                                                @click="openImagePicker"
                                                class="w-full rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50"
                                            >
                                                Change Image
                                            </button>

                                        </div>

                                    </div>


                                    <!-- EMPTY -->

                                    <button
                                        v-else
                                        type="button"
                                        @click="openImagePicker"
                                        class="flex aspect-[4/3] w-full flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 transition hover:border-orange-300 hover:bg-orange-50"
                                    >

                                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-orange-50 text-orange-500">
                                            <ImagePlus :size="24" />
                                        </div>

                                        <span class="text-sm font-semibold text-slate-700">
                                            Upload Facility Image
                                        </span>

                                        <span class="mt-1 text-xs text-slate-400">
                                            PNG, JPG or WEBP
                                        </span>

                                        <span class="mt-1 text-xs text-slate-400">
                                            Maximum file size 5 MB
                                        </span>

                                    </button>

                                    <p
                                        v-if="form.errors.image"
                                        class="mt-2 text-xs text-red-500"
                                    >
                                        {{ form.errors.image }}
                                    </p>

                                </div>

                            </div>


                            <!-- CURRENT FACILITY -->

                            <div class="mt-4 rounded-xl border border-slate-200 bg-white p-5">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-orange-50 text-orange-500">
                                        <component
                                            :is="selectedIcon"
                                            :size="19"
                                        />
                                    </div>

                                    <div>

                                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                            Current Facility
                                        </p>

                                        <p class="mt-1 font-semibold text-slate-800">
                                            {{ form.title || 'Untitled Facility' }}
                                        </p>

                                    </div>

                                </div>

                                <div class="mt-4 border-t border-slate-100 pt-4">

                                    <p class="text-xs text-slate-400">
                                        Facility ID
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-slate-700">
                                        #{{ facility.id }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- BOTTOM -->

                    <div class="mt-6 flex items-center justify-between rounded-xl border border-slate-200 bg-white p-5">

                        <div>

                            <p class="text-sm font-semibold text-slate-800">
                                Save facility changes
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                Updated information will appear on the website.
                            </p>

                        </div>

                        <button
                            type="button"
                            @click="submit"
                            :disabled="form.processing"
                            class="flex items-center gap-2 rounded-lg bg-orange-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-orange-600 disabled:opacity-50"
                        >

                            <Save :size="16" />

                            {{
                                form.processing
                                    ? 'Saving...'
                                    : 'Save Changes'
                            }}

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </AdminLayout>

</template>
<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import { ref, watch } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { Head, Link, useForm } from '@inertiajs/vue3'
import HeroSection from '@/Components/About/HeroSection.vue'

const props = defineProps({
    hero: {
        type: Object,
        default: null,
    }
})

const form = useForm({
    badge: props.hero?.badge ?? '',
    title: props.hero?.title ?? '',
    description: props.hero?.description ?? '',

    background_image: [],

    primary_button_text: props.hero?.primary_button_text ?? '',
    primary_button_url: props.hero?.primary_button_url ?? '',

    secondary_button_text: props.hero?.secondary_button_text ?? '',
    secondary_button_url: props.hero?.secondary_button_url ?? '',

    is_active: props.hero?.is_active ?? true,
})

const previews = ref([])

const imagePreview = ref(
    props.hero?.background_image
        ? `/storage/${props.hero.background_image}`
        : null
)

const onImageChange = (event) => {
    const files = Array.from(event.target.files)

    if (files.length > 3) {
        alert('Maksimal upload 3 gambar.')
        event.target.value = ''
        return
    }

    form.background_image = files

    previews.value = files.map(file => ({
        name: file.name,
        url: URL.createObjectURL(file)
    }))
}

const submit = () => {
    form.post(route('admin.home.hero.update'), {
        forceFormData: true,
        preserveScroll: true,

        onSuccess: (page) => {
            form.background_image = []

            console.log('Flash:', page.props.flash)

            if (page.props.flash?.success) {
                successMessage.value = page.props.flash.success
                showSuccess.value = true

                setTimeout(() => {
                    showSuccess.value = false
                }, 3000)
            }
        },
    })
}

const page = usePage()

const showSuccess = ref(false)

watch(
    () => page.props.flash?.success,
    (message) => {
        if (message) {
            showSuccess.value = true

            setTimeout(() => {
                showSuccess.value = false
            }, 3000)
        }
    },
    { immediate: true }
)
</script>

<template>

    <Head title="Edit Home Hero" />


    <AdminLayout>
        <div
            v-if="showSuccess && $page.props.flash?.success"
        >
            {{ $page.props.flash.success }}
        </div>
        
        <div class="min-h-screen bg-slate-50">

            <!-- TOP HEADER -->
            <div class="border-b border-slate-200 bg-white">

                <div class="mx-auto max-w-6xl px-6 py-6">

                    <div
                        class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between"
                    >

                        <div>

                            <!-- BREADCRUMB -->
                            <div
                                class="mb-2 flex items-center gap-2 text-sm text-slate-500"
                            >
                                <Link
                                    href="/admin/dashboard"
                                    class="transition hover:text-orange-500"
                                >
                                    Dashboard
                                </Link>

                                <span>/</span>

                                <span>
                                    Home
                                </span>

                                <span>/</span>

                                <span class="font-medium text-orange-500">
                                    Hero
                                </span>
                            </div>

                            <h1
                                class="text-2xl font-bold tracking-tight text-slate-900"
                            >
                                Edit Hero Section
                            </h1>

                            <p class="mt-1 text-sm text-slate-500">
                                Manage the main banner displayed at the top of the homepage.
                            </p>

                        </div>


                        <button
                            type="button"
                            @click="submit"
                            :disabled="form.processing"
                            class="inline-flex items-center justify-center gap-2 rounded-xl
                                bg-orange-500 px-5 py-3 text-sm font-semibold text-white
                                transition hover:bg-orange-600
                                disabled:cursor-not-allowed disabled:opacity-50"
                        >

                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"
                                />

                                <polyline
                                    points="17 21 17 13 7 13 7 21"
                                />

                                <polyline
                                    points="7 3 7 8 15 8"
                                />
                            </svg>

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
            <div class="mx-auto max-w-8xl px-2 py-4">

                <!-- SUCCESS -->
                <div
                    v-if="$page.props.flash?.success"
                    class="mb-6 rounded-xl border border-emerald-200
                        bg-emerald-50 px-5 py-4
                        text-sm font-medium text-emerald-700"
                >
                    {{ $page.props.flash.success }}
                </div>


                <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">

                    <!-- MAIN FORM -->
                    <div class="lg:col-span-9">

                        <div
                            class="overflow-hidden rounded-2xl
                                border border-slate-200
                                bg-white shadow-sm"
                        >

                            <!-- CARD HEADER -->
                            <div
                                class="border-b border-slate-100 px-6 py-5"
                            >

                                <h2
                                    class="text-lg font-bold text-slate-900"
                                >
                                    Hero Content
                                </h2>

                                <p
                                    class="mt-1 text-sm text-slate-500"
                                >
                                    Edit the main text and call-to-action buttons.
                                </p>

                            </div>


                            <div class="space-y-6 p-6">

                                <!-- BADGE / STATUS -->
                                <div
                                    class="grid gap-5 md:grid-cols-2"
                                >

                                    <div>

                                        <label class="form-label">
                                            Badge
                                        </label>

                                        <input
                                            v-model="form.badge"
                                            type="text"
                                            class="form-input"
                                            placeholder="BUILDING THE FUTURE"
                                        />

                                        <p
                                            class="mt-2 text-xs text-slate-400"
                                        >
                                            Small text displayed above the hero title.
                                        </p>

                                        <p
                                            v-if="form.errors.badge"
                                            class="form-error"
                                        >
                                            {{ form.errors.badge }}
                                        </p>

                                    </div>


                                    <div>

                                        <label class="form-label">
                                            Section Status
                                        </label>

                                        <div
                                            class="flex min-h-[48px]
                                                items-center
                                                rounded-xl
                                                border border-slate-200
                                                px-4"
                                        >

                                            <label
                                                class="flex cursor-pointer
                                                    items-center gap-3"
                                            >

                                                <button
                                                    type="button"
                                                    @click="
                                                        form.is_active =
                                                            !form.is_active
                                                    "
                                                    class="relative h-6 w-11
                                                        rounded-full transition"
                                                    :class="
                                                        form.is_active
                                                            ? 'bg-orange-500'
                                                            : 'bg-slate-300'
                                                    "
                                                >

                                                    <span
                                                        class="absolute top-0.5
                                                            h-5 w-5
                                                            rounded-full
                                                            bg-white shadow
                                                            transition-all"
                                                        :class="
                                                            form.is_active
                                                                ? 'left-[22px]'
                                                                : 'left-0.5'
                                                        "
                                                    ></span>

                                                </button>


                                                <div>

                                                    <div
                                                        class="text-sm font-semibold text-slate-700"
                                                    >
                                                        {{
                                                            form.is_active
                                                                ? 'Active'
                                                                : 'Inactive'
                                                        }}
                                                    </div>

                                                    <div
                                                        class="text-xs text-slate-400"
                                                    >
                                                        {{
                                                            form.is_active
                                                                ? 'Hero is visible on homepage'
                                                                : 'Hero is hidden from homepage'
                                                        }}
                                                    </div>

                                                </div>

                                            </label>

                                        </div>

                                    </div>

                                </div>


                                <!-- TITLE -->
                                <div>

                                    <label class="form-label">
                                        Hero Title

                                        <span class="text-red-500">
                                            *
                                        </span>
                                    </label>

                                    <input
                                        v-model="form.title"
                                        type="text"
                                        class="form-input"
                                        placeholder="Building Future Global Leaders"
                                    />

                                    <p
                                        v-if="form.errors.title"
                                        class="form-error"
                                    >
                                        {{ form.errors.title }}
                                    </p>

                                </div>


                                <!-- DESCRIPTION -->
                                <div>

                                    <label class="form-label">
                                        Description
                                    </label>

                                    <textarea
                                        v-model="form.description"
                                        rows="5"
                                        class="form-input resize-none"
                                        placeholder="Great Crystal School provides a nurturing environment..."
                                    ></textarea>

                                    <p
                                        v-if="form.errors.description"
                                        class="form-error"
                                    >
                                        {{ form.errors.description }}
                                    </p>

                                </div>


                                <!-- PRIMARY BUTTON -->
                                <div
                                    class="border-t border-slate-100 pt-6"
                                >

                                    <div class="mb-4">

                                        <h3
                                            class="font-bold text-slate-900"
                                        >
                                            Primary Button
                                        </h3>

                                        <p
                                            class="mt-1 text-sm text-slate-500"
                                        >
                                            Main call-to-action button in the hero.
                                        </p>

                                    </div>


                                    <div
                                        class="grid gap-5 md:grid-cols-2"
                                    >

                                        <div>

                                            <label class="form-label">
                                                Button Text
                                            </label>

                                            <input
                                                v-model="
                                                    form.primary_button_text
                                                "
                                                type="text"
                                                class="form-input"
                                                placeholder="Explore Our School"
                                            />

                                            <p
                                                v-if="
                                                    form.errors
                                                        .primary_button_text
                                                "
                                                class="form-error"
                                            >
                                                {{
                                                    form.errors
                                                        .primary_button_text
                                                }}
                                            </p>

                                        </div>


                                        <div>

                                            <label class="form-label">
                                                Button URL
                                            </label>

                                            <input
                                                v-model="
                                                    form.primary_button_url
                                                "
                                                type="text"
                                                class="form-input"
                                                placeholder="/about"
                                            />

                                            <p
                                                v-if="
                                                    form.errors
                                                        .primary_button_url
                                                "
                                                class="form-error"
                                            >
                                                {{
                                                    form.errors
                                                        .primary_button_url
                                                }}
                                            </p>

                                        </div>

                                    </div>

                                </div>


                                <!-- SECONDARY BUTTON -->
                                <div
                                    class="border-t border-slate-100 pt-6"
                                >

                                    <div class="mb-4">

                                        <h3
                                            class="font-bold text-slate-900"
                                        >
                                            Secondary Button
                                        </h3>

                                        <p
                                            class="mt-1 text-sm text-slate-500"
                                        >
                                            Optional secondary action displayed beside the main button.
                                        </p>

                                    </div>


                                    <div
                                        class="grid gap-5 md:grid-cols-2"
                                    >

                                        <div>

                                            <label class="form-label">
                                                Button Text
                                            </label>

                                            <input
                                                v-model="
                                                    form.secondary_button_text
                                                "
                                                type="text"
                                                class="form-input"
                                                placeholder="Contact"
                                            />

                                        </div>


                                        <div>

                                            <label class="form-label">
                                                Button URL
                                            </label>

                                            <input
                                                v-model="
                                                    form.secondary_button_url
                                                "
                                                type="text"
                                                class="form-input"
                                                placeholder="/contact"
                                            />

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- RIGHT SIDE -->
                    <div class="space-y-6 lg:col-span-3">

                        <!-- BACKGROUND IMAGE -->
                        <div
                            class="overflow-hidden rounded-2xl
                                border border-slate-200
                                bg-white shadow-sm"
                        >

                            <div
                                class="border-b border-slate-100 px-5 py-4"
                            >

                                <h2
                                    class="font-bold text-slate-900"
                                >
                                    Background Image
                                </h2>

                                <p
                                    class="mt-1 text-xs text-slate-500"
                                >
                                    Recommended landscape image.
                                </p>

                            </div>


                            <div class="p-5">

                                <div
                                    class="overflow-hidden rounded-xl
                                        border border-slate-200"
                                >

                                    <div
                                        v-if="imagePreview"
                                        class="relative aspect-[16/10]"
                                    >

                                        <img
                                            :src="imagePreview"
                                            class="h-full w-full object-cover"
                                        />

                                        <div
                                            class="absolute inset-0 bg-black/10"
                                        ></div>

                                    </div>


                                    <div
                                        v-else
                                        class="flex aspect-[16/10]
                                            flex-col items-center
                                            justify-center
                                            bg-slate-50
                                            text-slate-400"
                                    >

                                        <svg
                                            width="40"
                                            height="40"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                        >
                                            <rect
                                                x="3"
                                                y="3"
                                                width="18"
                                                height="18"
                                                rx="2"
                                            />

                                            <circle
                                                cx="8.5"
                                                cy="8.5"
                                                r="1.5"
                                            />

                                            <path
                                                d="m21 15-5-5L5 21"
                                            />
                                        </svg>

                                        <span
                                            class="mt-2 text-sm"
                                        >
                                            No image uploaded
                                        </span>

                                    </div>


                                    <label
                                        class="flex cursor-pointer
                                            items-center justify-center
                                            gap-2 border-t
                                            border-slate-200
                                            bg-white px-4 py-3
                                            text-sm font-semibold
                                            text-slate-600
                                            transition
                                            hover:bg-slate-50
                                            hover:text-orange-500"
                                    >

                                        <svg
                                            width="17"
                                            height="17"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"
                                            />

                                            <polyline
                                                points="17 8 12 3 7 8"
                                            />

                                            <line
                                                x1="12"
                                                y1="3"
                                                x2="12"
                                                y2="15"
                                            />
                                        </svg>

                                        {{
                                            imagePreview
                                                ? 'Change Image'
                                                : 'Upload Image'
                                        }}

                                        <input
                                            type="file"
                                            accept="image/png,image/jpeg,image/webp"
                                            multiple
                                            class="hidden"
                                            @change="onImageChange"
                                        />

                                        <div
                                            v-if="previews.length"
                                            class="grid grid-cols-3 gap-4 mt-4"
                                        >
                                            <div
                                                v-for="(image, index) in previews"
                                                :key="index"
                                                class="aspect-video overflow-hidden rounded-xl"
                                            >
                                                <img
                                                    :src="image.url"
                                                    :alt="image.name"
                                                    class="w-full h-full object-cover"
                                                />
                                            </div>
                                        </div>

                                    </label>

                                </div>


                                <p
                                    class="mt-3 text-xs leading-5 text-slate-400"
                                >
                                    JPG, PNG or WEBP. Maximum file size 5 MB.
                                </p>

                                <p
                                    v-if="form.errors.background_image"
                                    class="form-error"
                                >
                                    {{
                                        form.errors.background_image
                                    }}
                                </p>

                            </div>

                        </div>


                        <!-- HERO PREVIEW -->
                        <div
                            class="overflow-hidden rounded-2xl
                                border border-slate-200
                                bg-white shadow-sm"
                        >

                            <div
                                class="border-b border-slate-100 px-5 py-4"
                            >
                                <h2
                                    class="font-bold text-slate-900"
                                >
                                    Live Preview
                                </h2>

                                <p
                                    class="mt-1 text-xs text-slate-500"
                                >
                                    Approximate homepage appearance.
                                </p>
                            </div>


                            <div class="p-5">

                                <div
                                    class="relative min-h-[330px]
                                        overflow-hidden
                                        rounded-xl bg-slate-700"
                                >

                                    <img
                                        v-if="imagePreview"
                                        :src="imagePreview"
                                        class="absolute inset-0
                                            h-full w-full
                                            object-cover"
                                    />

                                    <div
                                        class="absolute inset-0
                                            bg-slate-900/60"
                                    ></div>


                                    <div
                                        class="relative z-10
                                            flex min-h-[330px]
                                            flex-col
                                            justify-center p-6"
                                    >

                                        <div
                                            v-if="form.badge"
                                            class="mb-3 text-[10px]
                                                font-bold uppercase
                                                tracking-[0.2em]
                                                text-orange-400"
                                        >
                                            {{ form.badge }}
                                        </div>


                                        <h3
                                            class="max-w-sm
                                                text-2xl font-bold
                                                leading-tight text-white"
                                        >
                                            {{
                                                form.title ||
                                                'Hero Title'
                                            }}
                                        </h3>


                                        <p
                                            v-if="form.description"
                                            class="mt-4
                                                line-clamp-4
                                                text-xs
                                                leading-6
                                                text-slate-200"
                                        >
                                            {{
                                                form.description
                                            }}
                                        </p>


                                        <div
                                            class="mt-5 flex
                                                flex-wrap gap-2"
                                        >

                                            <span
                                                v-if="
                                                    form.primary_button_text
                                                "
                                                class="rounded-lg
                                                    bg-orange-500
                                                    px-3 py-2
                                                    text-[11px]
                                                    font-semibold
                                                    text-white"
                                            >
                                                {{
                                                    form.primary_button_text
                                                }}
                                            </span>


                                            <span
                                                v-if="
                                                    form.secondary_button_text
                                                "
                                                class="rounded-lg
                                                    border
                                                    border-white/50
                                                    px-3 py-2
                                                    text-[11px]
                                                    font-semibold
                                                    text-white"
                                            >
                                                {{
                                                    form.secondary_button_text
                                                }}
                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- BOTTOM ACTION -->
                <div
                    class="mt-6 flex flex-col gap-4
                        rounded-2xl border border-slate-200
                        bg-white px-6 py-5 shadow-sm
                        sm:flex-row sm:items-center
                        sm:justify-between"
                >

                    <div>

                        <p
                            class="text-sm font-semibold text-slate-700"
                        >
                            Ready to update the homepage hero?
                        </p>

                        <p
                            class="mt-1 text-xs text-slate-400"
                        >
                            Changes will appear on the homepage after saving.
                        </p>

                    </div>


                    <div class="flex gap-3">

                        <Link
                            href="/admin/dashboard"
                            class="rounded-xl border
                                border-slate-200
                                bg-white px-5 py-2.5
                                text-sm font-semibold
                                text-slate-600
                                transition
                                hover:bg-slate-50"
                        >
                            Cancel
                        </Link>


                        <button
                            type="button"
                            @click="submit"
                            :disabled="form.processing"
                            class="rounded-xl bg-orange-500
                                px-5 py-2.5
                                text-sm font-semibold
                                text-white transition
                                hover:bg-orange-600
                                disabled:cursor-not-allowed
                                disabled:opacity-50"
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

        </div>

    </AdminLayout>
       

</template>



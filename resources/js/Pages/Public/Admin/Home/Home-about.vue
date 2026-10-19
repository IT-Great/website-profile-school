<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    about: {
        type: Object,
        default: null,
    }
})

const form = useForm({
    badge: props.about?.badge ?? '',
    title: props.about?.title ?? '',
    description: props.about?.description ?? '',

    image: null,

    button_text: props.about?.button_text ?? '',
    button_url: props.about?.button_url ?? '',

    is_active: props.about?.is_active ?? true,

    points: props.about?.points?.map(point => ({
        id: point.id,
        text: point.text ?? '',
    })) ?? [],
})


/*
|--------------------------------------------------------------------------
| IMAGE PREVIEW
|--------------------------------------------------------------------------
*/

const imagePreview = ref(
    props.about?.image
        ? `/storage/${props.about.image}`
        : null
)

const onImageChange = (event) => {
    const file = event.target.files[0]

    if (!file) return

    form.image = file

    imagePreview.value = URL.createObjectURL(file)
}


/*
|--------------------------------------------------------------------------
| POINTS
|--------------------------------------------------------------------------
*/

const addPoint = () => {
    form.points.push({
        id: null,
        text: '',
    })
}

const removePoint = (index) => {
    form.points.splice(index, 1)
}


/*
|--------------------------------------------------------------------------
| SUBMIT
|--------------------------------------------------------------------------
*/

const submit = () => {
    form.post(route('admin.home.about.update'), {
        forceFormData: true,
        preserveScroll: true,

        onSuccess: () => {
            form.image = null
        }
    })
}
</script>


<template>

    <Head title="Edit Homepage About" />

    <AdminLayout>

        <div class="min-h-screen bg-slate-50">

            <!-- PAGE HEADER -->
            <div class="border-b border-slate-200 bg-white">

                <div class="px-6 py-6 lg:px-8">

                    <div
                        class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between"
                    >

                        <div>

                            <!-- BREADCRUMB -->
                            <div
                                class="mb-2 flex items-center gap-2 text-sm text-slate-400"
                            >
                                <Link
                                    :href="route('dashboard')"
                                    class="transition hover:text-orange-500"
                                >
                                    Dashboard
                                </Link>

                                <span>/</span>

                                <span>Home</span>

                                <span>/</span>

                                <span class="font-medium text-orange-500">
                                    About
                                </span>
                            </div>


                            <h1
                                class="text-2xl font-bold tracking-tight text-slate-900"
                            >
                                Edit Homepage About
                            </h1>

                            <p class="mt-1 text-sm text-slate-500">
                                Manage the About Us section displayed on the homepage.
                            </p>

                        </div>


                        <!-- SAVE -->
                        <button
                            type="button"
                            @click="submit"
                            :disabled="form.processing"
                            class="inline-flex items-center justify-center gap-2
                                   rounded-xl bg-orange-500
                                   px-5 py-3 text-sm font-semibold text-white
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
            <div class="px-6 py-8 lg:px-8">

                <!-- SUCCESS -->
                <div
                    v-if="$page.props.flash?.success"
                    class="mb-6 rounded-xl
                           border border-emerald-200
                           bg-emerald-50
                           px-5 py-4
                           text-sm font-medium
                           text-emerald-700"
                >
                    {{ $page.props.flash.success }}
                </div>


                <div
                    class="grid grid-cols-1 gap-6 xl:grid-cols-12"
                >

                    <!-- ===================================================== -->
                    <!-- LEFT -->
                    <!-- ===================================================== -->

                    <div
                        class="space-y-6 xl:col-span-8"
                    >

                        <!-- MAIN CONTENT -->
                        <div
                            class="overflow-hidden rounded-2xl
                                   border border-slate-200
                                   bg-white shadow-sm"
                        >

                            <!-- CARD HEADER -->
                            <div
                                class="border-b border-slate-100
                                       px-6 py-5"
                            >

                                <h2
                                    class="text-lg font-bold text-slate-900"
                                >
                                    About Content
                                </h2>

                                <p
                                    class="mt-1 text-sm text-slate-500"
                                >
                                    Edit the title and description displayed next to the school image.
                                </p>

                            </div>


                            <div class="space-y-6 p-6">

                                <!-- BADGE + STATUS -->
                                <div
                                    class="grid gap-5 md:grid-cols-2"
                                >

                                    <!-- BADGE -->
                                    <div>

                                        <label class="form-label">
                                            Badge
                                        </label>

                                        <input
                                            v-model="form.badge"
                                            type="text"
                                            class="form-input"
                                            placeholder="ABOUT US"
                                        />

                                        <p
                                            class="mt-2 text-xs text-slate-400"
                                        >
                                            Small text displayed above the title.
                                        </p>

                                        <p
                                            v-if="form.errors.badge"
                                            class="form-error"
                                        >
                                            {{ form.errors.badge }}
                                        </p>

                                    </div>


                                    <!-- STATUS -->
                                    <div>

                                        <label class="form-label">
                                            Section Status
                                        </label>

                                        <div
                                            class="flex min-h-[48px]
                                                   items-center
                                                   rounded-xl
                                                   border border-slate-200
                                                   px-4 py-2"
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
                                                    class="relative
                                                           h-6 w-11
                                                           shrink-0
                                                           rounded-full
                                                           transition"
                                                    :class="
                                                        form.is_active
                                                            ? 'bg-orange-500'
                                                            : 'bg-slate-300'
                                                    "
                                                >

                                                    <span
                                                        class="absolute
                                                               top-0.5
                                                               h-5 w-5
                                                               rounded-full
                                                               bg-white
                                                               shadow
                                                               transition-all"
                                                        :class="
                                                            form.is_active
                                                                ? 'left-[22px]'
                                                                : 'left-0.5'
                                                        "
                                                    />

                                                </button>


                                                <div>

                                                    <p
                                                        class="text-sm
                                                               font-semibold
                                                               text-slate-700"
                                                    >
                                                        {{
                                                            form.is_active
                                                                ? 'Active'
                                                                : 'Inactive'
                                                        }}
                                                    </p>

                                                    <p
                                                        class="text-xs text-slate-400"
                                                    >
                                                        {{
                                                            form.is_active
                                                                ? 'Section visible on homepage'
                                                                : 'Section hidden from homepage'
                                                        }}
                                                    </p>

                                                </div>

                                            </label>

                                        </div>

                                    </div>

                                </div>


                                <!-- TITLE -->
                                <div>

                                    <label class="form-label">

                                        Title

                                        <span class="text-red-500">
                                            *
                                        </span>

                                    </label>

                                    <input
                                        v-model="form.title"
                                        type="text"
                                        class="form-input"
                                        placeholder="About Great Crystal School"
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

                                    <div
                                        class="mb-2 flex items-center justify-between"
                                    >

                                        <label
                                            class="text-sm font-semibold text-slate-700"
                                        >
                                            Description
                                        </label>

                                        <span
                                            class="text-xs text-slate-400"
                                        >
                                            {{ form.description.length }}
                                            characters
                                        </span>

                                    </div>

                                    <textarea
                                        v-model="form.description"
                                        rows="6"
                                        class="form-input resize-none"
                                        placeholder="We are committed to providing high-quality education..."
                                    />

                                    <p
                                        v-if="form.errors.description"
                                        class="form-error"
                                    >
                                        {{ form.errors.description }}
                                    </p>

                                </div>

                            </div>

                        </div>


                        <!-- ================================================= -->
                        <!-- KEY POINTS -->
                        <!-- ================================================= -->

                        <div
                            class="overflow-hidden rounded-2xl
                                   border border-slate-200
                                   bg-white shadow-sm"
                        >

                            <div
                                class="flex flex-col gap-4
                                       border-b border-slate-100
                                       px-6 py-5
                                       sm:flex-row
                                       sm:items-center
                                       sm:justify-between"
                            >

                                <div>

                                    <h2
                                        class="text-lg font-bold text-slate-900"
                                    >
                                        About Highlights
                                    </h2>

                                    <p
                                        class="mt-1 text-sm text-slate-500"
                                    >
                                        Manage the checklist displayed below the description.
                                    </p>

                                </div>


                                <button
                                    type="button"
                                    @click="addPoint"
                                    class="inline-flex items-center
                                           justify-center gap-2
                                           rounded-xl
                                           border border-orange-200
                                           bg-orange-50
                                           px-4 py-2.5
                                           text-sm font-semibold
                                           text-orange-600
                                           transition
                                           hover:bg-orange-100"
                                >

                                    <svg
                                        width="17"
                                        height="17"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path d="M12 5v14" />
                                        <path d="M5 12h14" />
                                    </svg>

                                    Add Point

                                </button>

                            </div>


                            <div class="p-6">

                                <!-- EMPTY -->
                                <div
                                    v-if="form.points.length === 0"
                                    class="rounded-xl
                                           border-2 border-dashed
                                           border-slate-200
                                           px-6 py-10
                                           text-center"
                                >

                                    <div
                                        class="mx-auto flex h-12 w-12
                                               items-center justify-center
                                               rounded-full bg-orange-50
                                               text-orange-500"
                                    >
                                        ✓
                                    </div>

                                    <h3
                                        class="mt-3 font-semibold text-slate-700"
                                    >
                                        No highlights yet
                                    </h3>

                                    <p
                                        class="mt-1 text-sm text-slate-400"
                                    >
                                        Add points such as Quality Education or Modern Facilities.
                                    </p>

                                    <button
                                        type="button"
                                        @click="addPoint"
                                        class="mt-4
                                               text-sm font-semibold
                                               text-orange-500"
                                    >
                                        + Add first point
                                    </button>

                                </div>


                                <!-- POINT LIST -->
                                <div
                                    v-else
                                    class="space-y-3"
                                >

                                    <div
                                        v-for="(point, index) in form.points"
                                        :key="point.id ?? index"
                                        class="group flex items-center gap-3
                                               rounded-xl
                                               border border-slate-200
                                               bg-slate-50/40
                                               p-3"
                                    >

                                        <!-- NUMBER -->
                                        <div
                                            class="flex h-9 w-9
                                                   shrink-0 items-center
                                                   justify-center
                                                   rounded-lg
                                                   bg-orange-50
                                                   text-sm font-bold
                                                   text-orange-500"
                                        >
                                            {{ index + 1 }}
                                        </div>


                                        <!-- INPUT -->
                                        <div class="flex-1">

                                            <input
                                                v-model="point.text"
                                                type="text"
                                                class="form-input"
                                                placeholder="Quality Education"
                                            />

                                            <p
                                                v-if="
                                                    form.errors[
                                                        `points.${index}.text`
                                                    ]
                                                "
                                                class="form-error"
                                            >
                                                {{
                                                    form.errors[
                                                        `points.${index}.text`
                                                    ]
                                                }}
                                            </p>

                                        </div>


                                        <!-- DELETE -->
                                        <button
                                            type="button"
                                            @click="removePoint(index)"
                                            class="flex h-10 w-10
                                                   shrink-0 items-center
                                                   justify-center
                                                   rounded-lg
                                                   text-slate-400
                                                   transition
                                                   hover:bg-red-50
                                                   hover:text-red-500"
                                        >

                                            <svg
                                                width="18"
                                                height="18"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <polyline
                                                    points="3 6 5 6 21 6"
                                                />

                                                <path
                                                    d="M19 6l-1 14H6L5 6"
                                                />

                                                <path
                                                    d="M10 11v6"
                                                />

                                                <path
                                                    d="M14 11v6"
                                                />

                                                <path
                                                    d="M9 6V4h6v2"
                                                />
                                            </svg>

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- ================================================= -->
                        <!-- BUTTON -->
                        <!-- ================================================= -->

                        <div
                            class="overflow-hidden rounded-2xl
                                   border border-slate-200
                                   bg-white shadow-sm"
                        >

                            <div
                                class="border-b border-slate-100 px-6 py-5"
                            >
                                <h2
                                    class="text-lg font-bold text-slate-900"
                                >
                                    Learn More Button
                                </h2>

                                <p
                                    class="mt-1 text-sm text-slate-500"
                                >
                                    Configure the call-to-action button.
                                </p>
                            </div>


                            <div
                                class="grid gap-5 p-6 md:grid-cols-2"
                            >

                                <div>

                                    <label class="form-label">
                                        Button Text
                                    </label>

                                    <input
                                        v-model="form.button_text"
                                        type="text"
                                        class="form-input"
                                        placeholder="Learn More"
                                    />

                                    <p
                                        v-if="form.errors.button_text"
                                        class="form-error"
                                    >
                                        {{ form.errors.button_text }}
                                    </p>

                                </div>


                                <div>

                                    <label class="form-label">
                                        Button URL
                                    </label>

                                    <input
                                        v-model="form.button_url"
                                        type="text"
                                        class="form-input"
                                        placeholder="/about"
                                    />

                                    <p
                                        v-if="form.errors.button_url"
                                        class="form-error"
                                    >
                                        {{ form.errors.button_url }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- ===================================================== -->
                    <!-- RIGHT SIDE -->
                    <!-- ===================================================== -->

                    <div
                        class="space-y-6 xl:col-span-4"
                    >

                        <!-- IMAGE -->
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
                                    About Image
                                </h2>

                                <p
                                    class="mt-1 text-xs text-slate-500"
                                >
                                    Image displayed on the left side.
                                </p>

                            </div>


                            <div class="p-5">

                                <div
                                    class="overflow-hidden rounded-xl
                                           border border-slate-200"
                                >

                                    <div
                                        v-if="imagePreview"
                                        class="relative aspect-[4/3]"
                                    >

                                        <img
                                            :src="imagePreview"
                                            alt="About preview"
                                            class="h-full w-full object-cover"
                                        />

                                        <div
                                            class="pointer-events-none
                                                   absolute inset-0
                                                   bg-black/5"
                                        />

                                    </div>


                                    <div
                                        v-else
                                        class="flex aspect-[4/3]
                                               flex-col
                                               items-center
                                               justify-center
                                               bg-slate-50
                                               text-slate-400"
                                    >

                                        <svg
                                            width="42"
                                            height="42"
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
                                            class="mt-3 text-sm"
                                        >
                                            No image uploaded
                                        </span>

                                    </div>


                                    <label
                                        class="flex cursor-pointer
                                               items-center
                                               justify-center
                                               gap-2
                                               border-t
                                               border-slate-200
                                               bg-white
                                               px-4 py-3
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
                                            class="hidden"
                                            @change="onImageChange"
                                        />

                                    </label>

                                </div>


                                <p
                                    class="mt-3 text-xs leading-5 text-slate-400"
                                >
                                    Recommended ratio 4:3. JPG, PNG or WEBP.
                                    Maximum 5 MB.
                                </p>

                                <p
                                    v-if="form.errors.image"
                                    class="form-error"
                                >
                                    {{ form.errors.image }}
                                </p>

                            </div>

                        </div>


                        <!-- ================================================ -->
                        <!-- LIVE PREVIEW -->
                        <!-- ================================================ -->

                        <div
                            class="overflow-hidden rounded-2xl
                                   border border-slate-200
                                   bg-white shadow-sm"
                        >

                            <div
                                class="border-b border-slate-100 px-5 py-4"
                            >

                                <div
                                    class="flex items-center justify-between"
                                >

                                    <div>

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


                                    <div
                                        class="flex items-center gap-2
                                               rounded-full px-2.5 py-1
                                               text-xs font-medium"
                                        :class="
                                            form.is_active
                                                ? 'bg-emerald-50 text-emerald-600'
                                                : 'bg-slate-100 text-slate-500'
                                        "
                                    >

                                        <span
                                            class="h-1.5 w-1.5 rounded-full"
                                            :class="
                                                form.is_active
                                                    ? 'bg-emerald-500'
                                                    : 'bg-slate-400'
                                            "
                                        />

                                        {{
                                            form.is_active
                                                ? 'Active'
                                                : 'Hidden'
                                        }}

                                    </div>

                                </div>

                            </div>


                            <div class="p-5">

                                <div
                                    class="overflow-hidden
                                           rounded-xl
                                           border border-slate-200
                                           bg-white"
                                >

                                    <!-- PREVIEW IMAGE -->
                                    <div
                                        v-if="imagePreview"
                                        class="aspect-[16/9]
                                               overflow-hidden"
                                    >
                                        <img
                                            :src="imagePreview"
                                            class="h-full w-full object-cover"
                                        />
                                    </div>


                                    <!-- PREVIEW CONTENT -->
                                    <div class="p-5">

                                        <p
                                            v-if="form.badge"
                                            class="text-[10px]
                                                   font-bold uppercase
                                                   tracking-[0.18em]
                                                   text-orange-500"
                                        >
                                            {{ form.badge }}
                                        </p>


                                        <h3
                                            class="mt-2
                                                   text-xl font-bold
                                                   leading-tight
                                                   text-slate-900"
                                        >
                                            {{
                                                form.title ||
                                                'About Great Crystal School'
                                            }}
                                        </h3>


                                        <p
                                            v-if="form.description"
                                            class="mt-3
                                                   line-clamp-4
                                                   text-xs
                                                   leading-5
                                                   text-slate-500"
                                        >
                                            {{ form.description }}
                                        </p>


                                        <!-- POINT PREVIEW -->
                                        <div
                                            v-if="form.points.length"
                                            class="mt-4 space-y-2"
                                        >

                                            <div
                                                v-for="(point, index) in form.points"
                                                :key="index"
                                                class="flex items-center gap-2"
                                            >

                                                <span
                                                    class="text-sm
                                                           font-bold
                                                           text-orange-500"
                                                >
                                                    ✓
                                                </span>

                                                <span
                                                    class="text-xs
                                                           text-slate-600"
                                                >
                                                    {{
                                                        point.text ||
                                                        'Highlight'
                                                    }}
                                                </span>

                                            </div>

                                        </div>


                                        <!-- BUTTON -->
                                        <div
                                            v-if="form.button_text"
                                            class="mt-5"
                                        >
                                            <span
                                                class="inline-flex
                                                       items-center gap-3
                                                       rounded-full
                                                       border
                                                       border-orange-500
                                                       px-4 py-2
                                                       text-xs
                                                       font-semibold
                                                       text-orange-500"
                                            >
                                                {{ form.button_text }}

                                                <span>
                                                    →
                                                </span>
                                            </span>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- ========================================================= -->
                <!-- BOTTOM SAVE -->
                <!-- ========================================================= -->

                <div
                    class="mt-6 flex flex-col gap-4
                           rounded-2xl
                           border border-slate-200
                           bg-white
                           px-6 py-5
                           shadow-sm
                           sm:flex-row
                           sm:items-center
                           sm:justify-between"
                >

                    <div>

                        <p
                            class="text-sm font-semibold text-slate-700"
                        >
                            Save Homepage About
                        </p>

                        <p
                            class="mt-1 text-xs text-slate-400"
                        >
                            Changes will appear on the homepage after saving.
                        </p>

                    </div>


                    <div class="flex gap-3">

                        <Link
                            :href="route('dashboard')"
                            class="rounded-xl
                                   border border-slate-200
                                   bg-white
                                   px-5 py-2.5
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
                            class="rounded-xl
                                   bg-orange-500
                                   px-5 py-2.5
                                   text-sm font-semibold
                                   text-white
                                   transition
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
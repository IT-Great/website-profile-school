<script setup>

import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'

import {
    Head,
    Link,
    useForm
} from '@inertiajs/vue3'

import { ref } from 'vue'

import {
    Save,
    Plus,
    Trash2,
    Eye,
    EyeOff,
    ChevronUp,
    ChevronDown,

    GraduationCap,
    UsersRound,
    Trophy,
    CalendarDays,
    School,
    BookOpen,
    Award,
    ArrowRight,
    Calendar,
    ImageIcon,
} from 'lucide-vue-next'


const props = defineProps({

    admission: {
        type: Object,
        default: null,
    }

})


/*
|--------------------------------------------------------------------------
| FORM
|--------------------------------------------------------------------------
*/

const form = useForm({

    badge:
        props.admission?.badge ??
        'ADMISSIONS OPEN',

    title:
        props.admission?.title ??
        'Ready to Build a Bright Future?',

    description:
        props.admission?.description ??
        '',


    background_image: null,


    primary_button_text:
        props.admission?.primary_button_text ??
        'Apply Now',

    primary_button_url:
        props.admission?.primary_button_url ??
        '',


    secondary_button_text:
        props.admission?.secondary_button_text ??
        'Schedule School Tour',

    secondary_button_url:
        props.admission?.secondary_button_url ??
        '',


    is_active:
        props.admission?.is_active ?? true,


    stats:
        props.admission?.stats?.map(
            stat => ({

                id: stat.id,

                icon:
                    stat.icon ??
                    'graduation',

                value:
                    stat.value ??
                    '',

                label:
                    stat.label ??
                    '',

                is_active:
                    Boolean(
                        stat.is_active
                    ),

            })
        ) ?? []

})


/*
|--------------------------------------------------------------------------
| BACKGROUND IMAGE
|--------------------------------------------------------------------------
*/

const imagePreview = ref(

    props.admission?.background_image

        ? `/storage/${props.admission.background_image}`

        : null

)


const onImageChange = (event) => {

    const file =
        event.target.files[0]

    if (!file) {
        return
    }


    form.background_image =
        file


    imagePreview.value =
        URL.createObjectURL(
            file
        )

}


/*
|--------------------------------------------------------------------------
| ICONS
|--------------------------------------------------------------------------
*/

const iconOptions = [

    {
        value: 'graduation',
        label: 'Graduation',
        component: GraduationCap,
    },

    {
        value: 'users',
        label: 'Teachers / Students',
        component: UsersRound,
    },

    {
        value: 'trophy',
        label: 'Achievement',
        component: Trophy,
    },

    {
        value: 'calendar',
        label: 'Experience',
        component: CalendarDays,
    },

    {
        value: 'school',
        label: 'School',
        component: School,
    },

    {
        value: 'book',
        label: 'Book',
        component: BookOpen,
    },

    {
        value: 'award',
        label: 'Award',
        component: Award,
    },

]


const getIcon = (name) => {

    return (
        iconOptions.find(
            icon =>
                icon.value === name
        )?.component
        ?? GraduationCap
    )

}


/*
|--------------------------------------------------------------------------
| STATS
|--------------------------------------------------------------------------
*/

const addStat = () => {

    form.stats.push({

        id: null,

        icon: 'graduation',

        value: '',

        label: '',

        is_active: true,

    })

}


const removeStat = (index) => {

    if (
        !confirm(
            'Remove this statistic?'
        )
    ) {
        return
    }

    form.stats.splice(
        index,
        1
    )

}


const moveUp = (index) => {

    if (index === 0) {
        return
    }

    const item =
        form.stats[index]

    form.stats.splice(
        index,
        1
    )

    form.stats.splice(
        index - 1,
        0,
        item
    )

}


const moveDown = (index) => {

    if (
        index ===
        form.stats.length - 1
    ) {
        return
    }

    const item =
        form.stats[index]

    form.stats.splice(
        index,
        1
    )

    form.stats.splice(
        index + 1,
        0,
        item
    )

}


/*
|--------------------------------------------------------------------------
| SUBMIT
|--------------------------------------------------------------------------
*/

const submit = () => {

    form.post(
        route(
            'admin.home.admission.update'
        ),
        {
            forceFormData: true,

            preserveScroll: true,

            onSuccess: () => {

                form.background_image =
                    null

            }
        }
    )

}

</script>

<template>

    <Head title="Admission Section" />


    <AdminLayout>

        <div class="min-h-screen bg-slate-50">


            <!-- ========================================================= -->
            <!-- HEADER -->
            <!-- ========================================================= -->

            <div
                class="border-b border-slate-200 bg-white"
            >

                <div class="px-6 py-6 lg:px-8">

                    <div
                        class="flex flex-col gap-4
                               md:flex-row
                               md:items-center
                               md:justify-between"
                    >

                        <div>

                            <div
                                class="mb-2 flex items-center
                                       gap-2 text-sm text-slate-400"
                            >

                                <Link
                                    :href="route('dashboard')"
                                    class="hover:text-orange-500"
                                >
                                    Dashboard
                                </Link>

                                <span>/</span>

                                <span>
                                    Homepage
                                </span>

                                <span>/</span>

                                <span
                                    class="font-medium text-orange-500"
                                >
                                    Admission
                                </span>

                            </div>


                            <h1
                                class="text-2xl font-bold text-slate-900"
                            >
                                Admission Section
                            </h1>


                            <p
                                class="mt-1 text-sm text-slate-500"
                            >
                                Manage admission call-to-action and
                                school statistics.
                            </p>

                        </div>


                        <button
                            type="button"
                            @click="submit"
                            :disabled="form.processing"
                            class="inline-flex items-center gap-2
                                   rounded-xl bg-orange-500
                                   px-5 py-3
                                   text-sm font-semibold text-white
                                   hover:bg-orange-600
                                   disabled:opacity-50"
                        >

                            <Save class="h-4 w-4" />

                            {{
                                form.processing
                                    ? 'Saving...'
                                    : 'Save Changes'
                            }}

                        </button>

                    </div>

                </div>

            </div>


            <!-- ========================================================= -->
            <!-- CONTENT -->
            <!-- ========================================================= -->

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
                    class="grid gap-6 xl:grid-cols-12"
                >


                    <!-- ================================================= -->
                    <!-- LEFT -->
                    <!-- ================================================= -->

                    <div
                        class="space-y-6 xl:col-span-8"
                    >


                        <!-- MAIN CONTENT -->

                        <div
                            class="overflow-hidden
                                   rounded-2xl
                                   border border-slate-200
                                   bg-white shadow-sm"
                        >

                            <div
                                class="border-b
                                       border-slate-100
                                       px-6 py-5"
                            >

                                <h2
                                    class="text-lg font-bold text-slate-900"
                                >
                                    Admission Content
                                </h2>

                                <p
                                    class="mt-1 text-sm text-slate-500"
                                >
                                    Configure the main admission message.
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
                                            placeholder="ADMISSIONS OPEN"
                                        />

                                    </div>


                                    <div>

                                        <label class="form-label">
                                            Section Status
                                        </label>


                                        <button
                                            type="button"
                                            @click="
                                                form.is_active =
                                                    !form.is_active
                                            "
                                            class="flex h-[46px]
                                                   w-full items-center
                                                   gap-3 rounded-xl
                                                   border border-slate-200
                                                   px-4"
                                        >

                                            <div
                                                class="relative
                                                       h-6 w-11
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
                                                           bg-white shadow
                                                           transition-all"
                                                    :class="
                                                        form.is_active
                                                            ? 'left-[22px]'
                                                            : 'left-0.5'
                                                    "
                                                />

                                            </div>


                                            <span
                                                class="text-sm
                                                       font-semibold
                                                       text-slate-700"
                                            >
                                                {{
                                                    form.is_active
                                                        ? 'Active'
                                                        : 'Inactive'
                                                }}
                                            </span>

                                        </button>

                                    </div>

                                </div>


                                <!-- TITLE -->

                                <div>

                                    <label class="form-label">
                                        Title
                                    </label>

                                    <input
                                        v-model="form.title"
                                        type="text"
                                        class="form-input"
                                        placeholder="Ready to Build a Bright Future?"
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
                                        placeholder="Join a learning community where students grow academically..."
                                    />

                                </div>

                            </div>

                        </div>


                        <!-- BUTTONS -->

                        <div
                            class="overflow-hidden
                                   rounded-2xl
                                   border border-slate-200
                                   bg-white shadow-sm"
                        >

                            <div
                                class="border-b
                                       border-slate-100
                                       px-6 py-5"
                            >

                                <h2
                                    class="text-lg font-bold text-slate-900"
                                >
                                    Call to Action Buttons
                                </h2>

                            </div>


                            <div class="space-y-6 p-6">


                                <!-- PRIMARY -->

                                <div>

                                    <h3
                                        class="mb-4
                                               text-sm font-bold
                                               text-slate-700"
                                    >
                                        Primary Button
                                    </h3>


                                    <div
                                        class="grid gap-5 md:grid-cols-2"
                                    >

                                        <div>

                                            <label class="form-label">
                                                Text
                                            </label>

                                            <input
                                                v-model="
                                                    form.primary_button_text
                                                "
                                                class="form-input"
                                                placeholder="Apply Now"
                                            />

                                        </div>


                                        <div>

                                            <label class="form-label">
                                                URL
                                            </label>

                                            <input
                                                v-model="
                                                    form.primary_button_url
                                                "
                                                class="form-input"
                                                placeholder="/admission"
                                            />

                                        </div>

                                    </div>

                                </div>


                                <hr class="border-slate-100">


                                <!-- SECONDARY -->

                                <div>

                                    <h3
                                        class="mb-4
                                               text-sm font-bold
                                               text-slate-700"
                                    >
                                        Secondary Button
                                    </h3>


                                    <div
                                        class="grid gap-5 md:grid-cols-2"
                                    >

                                        <div>

                                            <label class="form-label">
                                                Text
                                            </label>

                                            <input
                                                v-model="
                                                    form.secondary_button_text
                                                "
                                                class="form-input"
                                                placeholder="Schedule School Tour"
                                            />

                                        </div>


                                        <div>

                                            <label class="form-label">
                                                URL
                                            </label>

                                            <input
                                                v-model="
                                                    form.secondary_button_url
                                                "
                                                class="form-input"
                                                placeholder="/contact"
                                            />

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- ================================================= -->
                    <!-- RIGHT IMAGE -->
                    <!-- ================================================= -->

                    <div class="xl:col-span-4">

                        <div
                            class="overflow-hidden
                                   rounded-2xl
                                   border border-slate-200
                                   bg-white shadow-sm"
                        >

                            <div
                                class="border-b
                                       border-slate-100
                                       px-5 py-4"
                            >

                                <h2
                                    class="font-bold text-slate-900"
                                >
                                    Background Image
                                </h2>

                                <p
                                    class="mt-1 text-xs text-slate-500"
                                >
                                    Recommended wide landscape image.
                                </p>

                            </div>


                            <div class="p-5">

                                <div
                                    class="overflow-hidden
                                           rounded-xl
                                           border border-slate-200"
                                >

                                    <div
                                        v-if="imagePreview"
                                        class="relative aspect-video"
                                    >

                                        <img
                                            :src="imagePreview"
                                            class="h-full w-full object-cover"
                                        />

                                        <div
                                            class="absolute inset-0
                                                   bg-black/40"
                                        />

                                    </div>


                                    <div
                                        v-else
                                        class="flex aspect-video
                                               flex-col
                                               items-center
                                               justify-center
                                               bg-slate-50
                                               text-slate-400"
                                    >

                                        <ImageIcon
                                            class="h-10 w-10"
                                        />

                                        <span
                                            class="mt-2 text-sm"
                                        >
                                            No background image
                                        </span>

                                    </div>


                                    <label
                                        class="flex cursor-pointer
                                               items-center
                                               justify-center
                                               gap-2
                                               border-t
                                               border-slate-200
                                               px-4 py-3
                                               text-sm font-semibold
                                               text-slate-600
                                               hover:bg-slate-50
                                               hover:text-orange-500"
                                    >

                                        <ImageIcon
                                            class="h-4 w-4"
                                        />

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
                                    class="mt-3 text-xs
                                           leading-5 text-slate-400"
                                >
                                    JPG, PNG or WEBP.
                                    Maximum file size 5 MB.
                                </p>

                                <p
                                    v-if="
                                        form.errors.background_image
                                    "
                                    class="form-error"
                                >
                                    {{
                                        form.errors.background_image
                                    }}
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- ===================================================== -->
                <!-- STATISTICS -->
                <!-- ===================================================== -->

                <div
                    class="mt-6 overflow-hidden
                           rounded-2xl
                           border border-slate-200
                           bg-white shadow-sm"
                >

                    <div
                        class="flex items-center
                               justify-between
                               border-b border-slate-100
                               px-6 py-5"
                    >

                        <div>

                            <h2
                                class="text-lg font-bold text-slate-900"
                            >
                                Statistics
                            </h2>

                            <p
                                class="mt-1 text-sm text-slate-500"
                            >
                                Manage the statistics displayed
                                below the admission buttons.
                            </p>

                        </div>


                        <button
                            type="button"
                            @click="addStat"
                            class="inline-flex
                                   items-center gap-2
                                   rounded-xl
                                   bg-orange-50
                                   px-4 py-2.5
                                   text-sm font-semibold
                                   text-orange-600
                                   hover:bg-orange-100"
                        >

                            <Plus class="h-4 w-4" />

                            Add Statistic

                        </button>

                    </div>


                    <!-- LIST -->

                    <div
                        class="divide-y divide-slate-100"
                    >

                        <div
                            v-for="
                                (stat, index)
                                in form.stats
                            "
                            :key="stat.id ?? index"
                            class="p-6"
                        >

                            <div
                                class="grid gap-5
                                       lg:grid-cols-12
                                       lg:items-start"
                            >


                                <!-- ICON PREVIEW -->

                                <div class="lg:col-span-1">

                                    <div
                                        class="flex h-12 w-12
                                               items-center
                                               justify-center
                                               rounded-xl
                                               bg-orange-50
                                               text-orange-500"
                                    >

                                        <component
                                            :is="
                                                getIcon(
                                                    stat.icon
                                                )
                                            "
                                            class="h-6 w-6"
                                        />

                                    </div>

                                </div>


                                <!-- ICON -->

                                <div class="lg:col-span-3">

                                    <label class="form-label">
                                        Icon
                                    </label>

                                    <select
                                        v-model="stat.icon"
                                        class="form-input"
                                    >

                                        <option
                                            v-for="
                                                icon in iconOptions
                                            "
                                            :key="icon.value"
                                            :value="icon.value"
                                        >
                                            {{ icon.label }}
                                        </option>

                                    </select>

                                </div>


                                <!-- VALUE -->

                                <div class="lg:col-span-2">

                                    <label class="form-label">
                                        Value
                                    </label>

                                    <input
                                        v-model="stat.value"
                                        class="form-input"
                                        placeholder="1500+"
                                    />

                                </div>


                                <!-- LABEL -->

                                <div class="lg:col-span-3">

                                    <label class="form-label">
                                        Label
                                    </label>

                                    <input
                                        v-model="stat.label"
                                        class="form-input"
                                        placeholder="Students"
                                    />

                                </div>


                                <!-- ACTIONS -->

                                <div
                                    class="flex items-end
                                           gap-1 pt-7
                                           lg:col-span-3"
                                >

                                    <button
                                        type="button"
                                        @click="moveUp(index)"
                                        :disabled="index === 0"
                                        class="action-button"
                                    >
                                        <ChevronUp class="h-4 w-4" />
                                    </button>


                                    <button
                                        type="button"
                                        @click="moveDown(index)"
                                        :disabled="
                                            index ===
                                            form.stats.length - 1
                                        "
                                        class="action-button"
                                    >
                                        <ChevronDown class="h-4 w-4" />
                                    </button>


                                    <button
                                        type="button"
                                        @click="
                                            stat.is_active =
                                                !stat.is_active
                                        "
                                        class="action-button"
                                        :class="
                                            stat.is_active
                                                ? '!text-emerald-500'
                                                : ''
                                        "
                                    >

                                        <Eye
                                            v-if="stat.is_active"
                                            class="h-4 w-4"
                                        />

                                        <EyeOff
                                            v-else
                                            class="h-4 w-4"
                                        />

                                    </button>


                                    <button
                                        type="button"
                                        @click="removeStat(index)"
                                        class="action-button
                                               hover:!bg-red-50
                                               hover:!text-red-500"
                                    >
                                        <Trash2 class="h-4 w-4" />
                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- SAVE BOTTOM -->

                <div
                    class="mt-6 flex items-center
                           justify-between
                           rounded-2xl
                           border border-slate-200
                           bg-white
                           px-6 py-5 shadow-sm"
                >

                    <div>

                        <p
                            class="text-sm font-semibold text-slate-700"
                        >
                            Save Admission Section
                        </p>

                        <p
                            class="mt-1 text-xs text-slate-400"
                        >
                            {{
                                form.stats.length
                            }}
                            statistics configured.
                        </p>

                    </div>


                    <button
                        type="button"
                        @click="submit"
                        :disabled="form.processing"
                        class="inline-flex
                               items-center gap-2
                               rounded-xl
                               bg-orange-500
                               px-5 py-2.5
                               text-sm font-semibold
                               text-white
                               hover:bg-orange-600
                               disabled:opacity-50"
                    >

                        <Save class="h-4 w-4" />

                        {{
                            form.processing
                                ? 'Saving...'
                                : 'Save Changes'
                        }}

                    </button>

                </div>

            </div>

        </div>

    </AdminLayout>

</template>


<style scoped>

.form-label {
    @apply mb-2 block text-sm font-semibold text-slate-700;
}

.form-input {
    @apply w-full rounded-xl
           border border-slate-200
           bg-white
           px-4 py-3
           text-sm text-slate-700
           outline-none transition
           placeholder:text-slate-400
           focus:border-orange-400
           focus:ring-4
           focus:ring-orange-100;
}

.form-error {
    @apply mt-2 text-xs font-medium text-red-500;
}

.action-button {
    @apply flex h-10 w-10
           items-center justify-center
           rounded-lg
           text-slate-400
           transition
           hover:bg-slate-100
           hover:text-slate-700
           disabled:cursor-not-allowed
           disabled:opacity-30;
}

</style>f
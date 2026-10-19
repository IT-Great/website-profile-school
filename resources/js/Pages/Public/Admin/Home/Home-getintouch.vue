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
    Mail,
    Phone,
    MessageCircle,
    Clock3,
    MapPin,
    ImageIcon,
    ExternalLink,
} from 'lucide-vue-next'


const props = defineProps({

    getInTouch: {
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

    title:
        props.getInTouch?.title ??
        'Get in Touch',

    email:
        props.getInTouch?.email ??
        '',

    phone:
        props.getInTouch?.phone ??
        '',

    whatsapp:
        props.getInTouch?.whatsapp ??
        '',

    office_hours:
        props.getInTouch?.office_hours ??
        '',

    map_embed_url:
        props.getInTouch?.map_embed_url ??
        '',

    image: null,

    is_active:
        props.getInTouch?.is_active ?? true,

})


/*
|--------------------------------------------------------------------------
| IMAGE PREVIEW
|--------------------------------------------------------------------------
*/

const imagePreview = ref(

    props.getInTouch?.image

        ? `/storage/${props.getInTouch.image}`

        : null

)


const onImageChange = (event) => {

    const file =
        event.target.files[0]

    if (!file) {
        return
    }


    form.image = file


    imagePreview.value =
        URL.createObjectURL(file)

}


/*
|--------------------------------------------------------------------------
| SUBMIT
|--------------------------------------------------------------------------
*/

const submit = () => {

    form.post(
        route(
            'admin.home.get-in-touch.update'
        ),
        {
            forceFormData: true,

            preserveScroll: true,

            onSuccess: () => {
                form.image = null
            }
        }
    )

}

</script>

<template>

    <Head title="Get in Touch" />


    <AdminLayout>

        <div class="min-h-screen bg-slate-50">


            <!-- HEADER -->

            <div class="border-b border-slate-200 bg-white">

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
                                    Get in Touch
                                </span>

                            </div>


                            <h1
                                class="text-2xl font-bold text-slate-900"
                            >
                                Get in Touch
                            </h1>

                            <p
                                class="mt-1 text-sm text-slate-500"
                            >
                                Manage contact information, map,
                                office hours and section image.
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


                <div class="grid gap-6 xl:grid-cols-12">


                    <!-- ============================================== -->
                    <!-- CONTACT INFORMATION -->
                    <!-- ============================================== -->

                    <div class="xl:col-span-7">

                        <div
                            class="rounded-2xl
                                   border border-slate-200
                                   bg-white shadow-sm"
                        >

                            <div
                                class="border-b border-slate-100
                                       px-6 py-5"
                            >

                                <h2
                                    class="text-lg font-bold text-slate-900"
                                >
                                    Contact Information
                                </h2>

                                <p
                                    class="mt-1 text-sm text-slate-500"
                                >
                                    Information displayed in the
                                    Get in Touch section.
                                </p>

                            </div>


                            <div class="space-y-5 p-6">


                                <!-- TITLE -->

                                <div>

                                    <label class="form-label">
                                        Section Title
                                    </label>

                                    <input
                                        v-model="form.title"
                                        type="text"
                                        class="form-input"
                                        placeholder="Get in Touch"
                                    />

                                    <p
                                        v-if="form.errors.title"
                                        class="form-error"
                                    >
                                        {{ form.errors.title }}
                                    </p>

                                </div>


                                <!-- EMAIL -->

                                <div>

                                    <label class="form-label">
                                        Email
                                    </label>

                                    <div class="relative">

                                        <Mail
                                            class="input-icon"
                                        />

                                        <input
                                            v-model="form.email"
                                            type="email"
                                            class="form-input !pl-11"
                                            placeholder="admin@great.sch.id"
                                        />

                                    </div>

                                </div>


                                <div
                                    class="grid gap-5 md:grid-cols-2"
                                >

                                    <!-- PHONE -->

                                    <div>

                                        <label class="form-label">
                                            Phone
                                        </label>

                                        <div class="relative">

                                            <Phone
                                                class="input-icon"
                                            />

                                            <input
                                                v-model="form.phone"
                                                type="text"
                                                class="form-input !pl-11"
                                                placeholder="031-7348825"
                                            />

                                        </div>

                                    </div>


                                    <!-- WHATSAPP -->

                                    <div>

                                        <label class="form-label">
                                            WhatsApp
                                        </label>

                                        <div class="relative">

                                            <MessageCircle
                                                class="input-icon"
                                            />

                                            <input
                                                v-model="form.whatsapp"
                                                type="text"
                                                class="form-input !pl-11"
                                                placeholder="+62 813-3252-5678"
                                            />

                                        </div>

                                    </div>

                                </div>


                                <!-- OFFICE -->

                                <div>

                                    <label class="form-label">
                                        Office Hours
                                    </label>

                                    <div class="relative">

                                        <Clock3
                                            class="input-icon"
                                        />

                                        <input
                                            v-model="form.office_hours"
                                            type="text"
                                            class="form-input !pl-11"
                                            placeholder="Mon - Fri : 08.00 - 17.00"
                                        />

                                    </div>

                                </div>


                                <!-- STATUS -->

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
                                                       rounded-full bg-white
                                                       shadow transition-all"
                                                :class="
                                                    form.is_active
                                                        ? 'left-[22px]'
                                                        : 'left-0.5'
                                                "
                                            />

                                        </div>


                                        <span
                                            class="text-sm font-semibold
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

                        </div>

                    </div>


                    <!-- ============================================== -->
                    <!-- IMAGE -->
                    <!-- ============================================== -->

                    <div class="xl:col-span-5">

                        <div
                            class="rounded-2xl
                                   border border-slate-200
                                   bg-white shadow-sm"
                        >

                            <div
                                class="border-b border-slate-100
                                       px-6 py-5"
                            >

                                <h2
                                    class="font-bold text-slate-900"
                                >
                                    Section Image
                                </h2>

                                <p
                                    class="mt-1 text-sm text-slate-500"
                                >
                                    Image displayed on the right side.
                                </p>

                            </div>


                            <div class="p-6">

                                <div
                                    class="overflow-hidden
                                           rounded-xl
                                           border border-slate-200"
                                >

                                    <div
                                        v-if="imagePreview"
                                        class="aspect-[4/3]"
                                    >

                                        <img
                                            :src="imagePreview"
                                            class="h-full w-full object-cover"
                                        />

                                    </div>


                                    <div
                                        v-else
                                        class="flex aspect-[4/3]
                                               flex-col items-center
                                               justify-center bg-slate-50
                                               text-slate-400"
                                    >

                                        <ImageIcon
                                            class="h-10 w-10"
                                        />

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
                                            class="hidden"
                                            accept="image/jpeg,image/png,image/webp"
                                            @change="onImageChange"
                                        />

                                    </label>

                                </div>


                                <p
                                    class="mt-3 text-xs
                                           text-slate-400"
                                >
                                    JPG, PNG or WEBP.
                                    Maximum 5 MB.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- ============================================== -->
                <!-- GOOGLE MAP -->
                <!-- ============================================== -->

                <div
                    class="mt-6 rounded-2xl
                           border border-slate-200
                           bg-white shadow-sm"
                >

                    <div
                        class="border-b border-slate-100
                               px-6 py-5"
                    >

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-10 w-10
                                       items-center justify-center
                                       rounded-xl bg-orange-50
                                       text-orange-500"
                            >
                                <MapPin class="h-5 w-5" />
                            </div>

                            <div>

                                <h2
                                    class="font-bold text-slate-900"
                                >
                                    Google Maps
                                </h2>

                                <p
                                    class="text-sm text-slate-500"
                                >
                                    Google Maps embed URL for the
                                    school location.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="p-6">

                        <label class="form-label">
                            Google Maps Embed URL
                        </label>


                        <textarea
                            v-model="form.map_embed_url"
                            rows="3"
                            class="form-input resize-none"
                            placeholder="https://www.google.com/maps/embed?pb=..."
                        />


                        <p
                            class="mt-2 text-xs
                                   leading-5 text-slate-400"
                        >
                            Use the URL from Google Maps →
                            Share → Embed a map.
                            Copy only the URL inside the
                            iframe src attribute.
                        </p>


                        <!-- MAP PREVIEW -->

                        <div
                            v-if="form.map_embed_url"
                            class="mt-5 overflow-hidden
                                   rounded-xl
                                   border border-slate-200"
                        >

                            <iframe
                                :src="form.map_embed_url"
                                class="h-[350px] w-full"
                                style="border:0"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                            />

                        </div>

                    </div>

                </div>


                <!-- ============================================== -->
                <!-- PREVIEW CONTACT -->
                <!-- ============================================== -->

                <div
                    class="mt-6 rounded-2xl
                           border border-slate-200
                           bg-white p-6 shadow-sm"
                >

                    <div class="mb-5">

                        <p
                            class="text-xs font-bold
                                   uppercase tracking-[0.2em]
                                   text-orange-500"
                        >
                            Preview
                        </p>

                        <h2
                            class="mt-1 text-lg font-bold
                                   text-slate-900"
                        >
                            Contact Card
                        </h2>

                    </div>


                    <div
                        class="max-w-lg rounded-xl
                               bg-orange-50/50 p-6"
                    >

                        <h3
                            class="mb-5 text-xl font-bold
                                   text-slate-900"
                        >
                            {{ form.title || 'Get in Touch' }}
                        </h3>


                        <div class="space-y-5">


                            <div
                                v-if="form.email"
                                class="flex gap-4"
                            >

                                <Mail
                                    class="mt-1 h-5 w-5
                                           shrink-0 text-orange-500"
                                />

                                <div>

                                    <p class="preview-label">
                                        Email
                                    </p>

                                    <p class="preview-value">
                                        {{ form.email }}
                                    </p>

                                </div>

                            </div>


                            <div
                                v-if="form.phone"
                                class="flex gap-4"
                            >

                                <Phone
                                    class="mt-1 h-5 w-5
                                           shrink-0 text-orange-500"
                                />

                                <div>

                                    <p class="preview-label">
                                        Phone
                                    </p>

                                    <p class="preview-value">
                                        {{ form.phone }}
                                    </p>

                                </div>

                            </div>


                            <div
                                v-if="form.whatsapp"
                                class="flex gap-4"
                            >

                                <MessageCircle
                                    class="mt-1 h-5 w-5
                                           shrink-0 text-orange-500"
                                />

                                <div>

                                    <p class="preview-label">
                                        WhatsApp
                                    </p>

                                    <p class="preview-value">
                                        {{ form.whatsapp }}
                                    </p>

                                </div>

                            </div>


                            <div
                                v-if="form.office_hours"
                                class="flex gap-4"
                            >

                                <Clock3
                                    class="mt-1 h-5 w-5
                                           shrink-0 text-orange-500"
                                />

                                <div>

                                    <p class="preview-label">
                                        Office Hours
                                    </p>

                                    <p class="preview-value">
                                        {{ form.office_hours }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- BOTTOM SAVE -->

                <div
                    class="mt-6 flex items-center
                           justify-between rounded-2xl
                           border border-slate-200
                           bg-white px-6 py-5 shadow-sm"
                >

                    <div>

                        <p
                            class="text-sm font-semibold
                                   text-slate-700"
                        >
                            Save Get in Touch
                        </p>

                        <p
                            class="mt-1 text-xs text-slate-400"
                        >
                            Changes will be displayed
                            on the homepage.
                        </p>

                    </div>


                    <button
                        type="button"
                        @click="submit"
                        :disabled="form.processing"
                        class="inline-flex items-center
                               gap-2 rounded-xl
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

.input-icon {
    @apply absolute left-4 top-1/2
           h-4 w-4
           -translate-y-1/2
           text-slate-400;
}

.preview-label {
    @apply text-xs text-slate-400;
}

.preview-value {
    @apply mt-0.5 text-sm font-semibold
           text-slate-700;
}

</style>
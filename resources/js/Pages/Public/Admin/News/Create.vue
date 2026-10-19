<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'

import {
    Head,
    Link,
    useForm,
} from '@inertiajs/vue3'

import {
    ArrowLeft,
    Save,
    ImageIcon,
    Upload,
    Newspaper,
    CalendarDays,
    Activity,
    Trophy,
    Star,
    Eye,
    FileText,
} from 'lucide-vue-next'

import { ref, computed } from 'vue'


/*
|--------------------------------------------------------------------------
| FORM
|--------------------------------------------------------------------------
*/

const form = useForm({
    category: 'news',

    title: '',
    excerpt: '',
    content: '',

    thumbnail: null,

    published_at:
        new Date()
            .toISOString()
            .split('T')[0],

    is_featured: false,
    is_active: true,
})


/*
|--------------------------------------------------------------------------
| THUMBNAIL
|--------------------------------------------------------------------------
*/

const thumbnailPreview = ref(null)


const onThumbnailChange = (event) => {

    const file = event.target.files[0]

    if (!file) {
        return
    }

    form.thumbnail = file

    if (thumbnailPreview.value) {
        URL.revokeObjectURL(
            thumbnailPreview.value
        )
    }

    thumbnailPreview.value =
        URL.createObjectURL(file)
}


const removeThumbnail = () => {

    form.thumbnail = null

    if (thumbnailPreview.value) {

        URL.revokeObjectURL(
            thumbnailPreview.value
        )

    }

    thumbnailPreview.value = null
}


/*
|--------------------------------------------------------------------------
| CATEGORY
|--------------------------------------------------------------------------
*/

const categories = [
    {
        value: 'news',
        label: 'News',
        icon: Newspaper,
    },
    {
        value: 'event',
        label: 'Event',
        icon: CalendarDays,
    },
    {
        value: 'activity',
        label: 'Activity',
        icon: Activity,
    },
    {
        value: 'achievement',
        label: 'Achievement',
        icon: Trophy,
    },
]


const selectedCategory = computed(() => {

    return categories.find(
        item => item.value === form.category
    )

})


/*
|--------------------------------------------------------------------------
| SUBMIT
|--------------------------------------------------------------------------
*/

const submit = () => {

    form.post(
        route('admin.posts.store'),
        {
            forceFormData: true,
            preserveScroll: true,
        }
    )

}
</script>


<template>

    <Head title="Add New Post" />


    <AdminLayout>

        <div class="min-h-screen bg-slate-50">


            <!-- ====================================================== -->
            <!-- HEADER -->
            <!-- ====================================================== -->

            <div class="border-b border-slate-200 bg-white">

                <div class="px-6 py-6 lg:px-8">

                    <div
                        class="flex flex-col gap-5
                               lg:flex-row
                               lg:items-center
                               lg:justify-between"
                    >

                        <!-- LEFT -->

                        <div>

                            <div
                                class="mb-2 flex items-center
                                       gap-2 text-sm text-slate-400"
                            >

                                <Link
                                    :href="route('admin.posts.index')"
                                    class="hover:text-orange-500"
                                >
                                    News & Events
                                </Link>

                                <span>/</span>

                                <span class="text-orange-500">
                                    Add New
                                </span>

                            </div>


                            <div class="flex items-center gap-3">

                                <Link
                                    :href="route('admin.posts.index')"
                                    class="flex h-10 w-10
                                           items-center justify-center
                                           rounded-xl
                                           border border-slate-200
                                           text-slate-500
                                           transition
                                           hover:bg-slate-50
                                           hover:text-orange-500"
                                >
                                    <ArrowLeft class="h-5 w-5" />
                                </Link>


                                <div>

                                    <h1
                                        class="text-2xl font-bold
                                               text-slate-900"
                                    >
                                        Add New Post
                                    </h1>

                                    <p
                                        class="mt-1 text-sm
                                               text-slate-500"
                                    >
                                        Create news, event, activity
                                        or achievement content.
                                    </p>

                                </div>

                            </div>

                        </div>


                        <!-- SAVE -->

                        <div class="flex items-center gap-3">

                            <Link
                                :href="route('admin.posts.index')"
                                class="rounded-xl
                                       border border-slate-200
                                       bg-white
                                       px-5 py-3
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
                                class="inline-flex
                                       items-center gap-2
                                       rounded-xl
                                       bg-orange-500
                                       px-5 py-3
                                       text-sm font-semibold
                                       text-white
                                       transition
                                       hover:bg-orange-600
                                       disabled:cursor-not-allowed
                                       disabled:opacity-50"
                            >

                                <Save class="h-4 w-4" />

                                {{
                                    form.processing
                                        ? 'Publishing...'
                                        : 'Publish Post'
                                }}

                            </button>

                        </div>

                    </div>

                </div>

            </div>


            <!-- ====================================================== -->
            <!-- FORM -->
            <!-- ====================================================== -->

            <form
                @submit.prevent="submit"
                class="px-6 py-8 lg:px-8"
            >

                <div
                    class="grid gap-6
                           xl:grid-cols-12"
                >


                    <!-- ================================================== -->
                    <!-- LEFT COLUMN -->
                    <!-- ================================================== -->

                    <div
                        class="space-y-6
                               xl:col-span-8"
                    >


                        <!-- BASIC INFORMATION -->

                        <div class="admin-card">

                            <div class="card-header">

                                <div
                                    class="flex h-10 w-10
                                           items-center justify-center
                                           rounded-xl
                                           bg-orange-50
                                           text-orange-500"
                                >
                                    <FileText class="h-5 w-5" />
                                </div>


                                <div>

                                    <h2 class="card-title">
                                        Post Information
                                    </h2>

                                    <p class="card-description">
                                        Enter the title and short
                                        description for this post.
                                    </p>

                                </div>

                            </div>


                            <div class="space-y-6 p-6">


                                <!-- TITLE -->

                                <div>

                                    <div
                                        class="mb-2 flex
                                               items-center
                                               justify-between"
                                    >

                                        <label class="form-label !mb-0">
                                            Post Title
                                            <span class="text-red-500">*</span>
                                        </label>

                                        <span
                                            class="text-xs
                                                   text-slate-400"
                                        >
                                            {{ form.title.length }}/255
                                        </span>

                                    </div>


                                    <input
                                        v-model="form.title"
                                        type="text"
                                        maxlength="255"
                                        class="form-input"
                                        placeholder="Example: Students Win National Robotics Competition"
                                    />


                                    <p
                                        v-if="form.errors.title"
                                        class="form-error"
                                    >
                                        {{ form.errors.title }}
                                    </p>

                                </div>


                                <!-- EXCERPT -->

                                <div>

                                    <div
                                        class="mb-2 flex
                                               items-center
                                               justify-between"
                                    >

                                        <label class="form-label !mb-0">
                                            Short Description
                                        </label>

                                        <span
                                            class="text-xs
                                                   text-slate-400"
                                        >
                                            {{ form.excerpt.length }}/1000
                                        </span>

                                    </div>


                                    <textarea
                                        v-model="form.excerpt"
                                        rows="4"
                                        maxlength="1000"
                                        class="form-input resize-none"
                                        placeholder="Write a short description that will appear on the news card..."
                                    />


                                    <p
                                        class="mt-2 text-xs
                                               text-slate-400"
                                    >
                                        This description appears
                                        on the News listing page.
                                    </p>


                                    <p
                                        v-if="form.errors.excerpt"
                                        class="form-error"
                                    >
                                        {{ form.errors.excerpt }}
                                    </p>

                                </div>

                            </div>

                        </div>


                        <!-- ================================================== -->
                        <!-- CONTENT -->
                        <!-- ================================================== -->

                        <div class="admin-card">

                            <div class="card-header">

                                <div
                                    class="flex h-10 w-10
                                           items-center justify-center
                                           rounded-xl
                                           bg-orange-50
                                           text-orange-500"
                                >
                                    <Newspaper class="h-5 w-5" />
                                </div>


                                <div>

                                    <h2 class="card-title">
                                        Article Content
                                    </h2>

                                    <p class="card-description">
                                        Write the complete content
                                        displayed on the detail page.
                                    </p>

                                </div>

                            </div>


                            <div class="p-6">

                                <label class="form-label">
                                    Content
                                </label>


                                <textarea
                                    v-model="form.content"
                                    rows="18"
                                    class="form-input
                                           min-h-[420px]
                                           resize-y
                                           leading-7"
                                    placeholder="Write the article content here..."
                                />


                                <p
                                    v-if="form.errors.content"
                                    class="form-error"
                                >
                                    {{ form.errors.content }}
                                </p>

                            </div>

                        </div>

                    </div>


                    <!-- ================================================== -->
                    <!-- RIGHT COLUMN -->
                    <!-- ================================================== -->

                    <div
                        class="space-y-6
                               xl:col-span-4"
                    >


                        <!-- ================================================== -->
                        <!-- PUBLISH -->
                        <!-- ================================================== -->

                        <div class="admin-card">

                            <div
                                class="border-b
                                       border-slate-100
                                       px-5 py-4"
                            >

                                <h2 class="card-title">
                                    Publish Settings
                                </h2>

                            </div>


                            <div class="space-y-5 p-5">


                                <!-- CATEGORY -->

                                <div>

                                    <label class="form-label">
                                        Category
                                        <span class="text-red-500">*</span>
                                    </label>


                                    <div
                                        class="grid grid-cols-2
                                               gap-2"
                                    >

                                        <button
                                            v-for="item in categories"
                                            :key="item.value"
                                            type="button"
                                            @click="
                                                form.category =
                                                    item.value
                                            "
                                            class="flex
                                                   items-center
                                                   gap-2
                                                   rounded-xl
                                                   border
                                                   px-3 py-3
                                                   text-left
                                                   text-sm
                                                   font-medium
                                                   transition"
                                            :class="
                                                form.category === item.value
                                                    ? 'border-orange-400 bg-orange-50 text-orange-600 ring-2 ring-orange-100'
                                                    : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50'
                                            "
                                        >

                                            <component
                                                :is="item.icon"
                                                class="h-4 w-4
                                                       shrink-0"
                                            />

                                            {{ item.label }}

                                        </button>

                                    </div>


                                    <p
                                        v-if="form.errors.category"
                                        class="form-error"
                                    >
                                        {{ form.errors.category }}
                                    </p>

                                </div>


                                <!-- PUBLISHED DATE -->

                                <div>

                                    <label class="form-label">
                                        Published Date
                                    </label>


                                    <div class="relative">

                                        <CalendarDays
                                            class="absolute
                                                   left-4 top-1/2
                                                   h-4 w-4
                                                   -translate-y-1/2
                                                   text-slate-400"
                                        />

                                        <input
                                            v-model="form.published_at"
                                            type="date"
                                            class="form-input !pl-11"
                                        />

                                    </div>


                                    <p
                                        v-if="form.errors.published_at"
                                        class="form-error"
                                    >
                                        {{ form.errors.published_at }}
                                    </p>

                                </div>


                                <hr class="border-slate-100">


                                <!-- ACTIVE -->

                                <div
                                    class="flex items-center
                                           justify-between gap-4"
                                >

                                    <div
                                        class="flex items-center
                                               gap-3"
                                    >

                                        <div
                                            class="flex h-9 w-9
                                                   items-center
                                                   justify-center
                                                   rounded-lg
                                                   bg-emerald-50"
                                        >
                                            <Eye
                                                class="h-4 w-4
                                                       text-emerald-500"
                                            />
                                        </div>


                                        <div>

                                            <p
                                                class="text-sm
                                                       font-semibold
                                                       text-slate-700"
                                            >
                                                Active
                                            </p>

                                            <p
                                                class="text-xs
                                                       text-slate-400"
                                            >
                                                Display on website
                                            </p>

                                        </div>

                                    </div>


                                    <button
                                        type="button"
                                        @click="
                                            form.is_active =
                                                !form.is_active
                                        "
                                        class="toggle"
                                        :class="
                                            form.is_active
                                                ? 'bg-orange-500'
                                                : 'bg-slate-300'
                                        "
                                    >

                                        <span
                                            class="toggle-circle"
                                            :class="
                                                form.is_active
                                                    ? 'translate-x-5'
                                                    : 'translate-x-0'
                                            "
                                        />

                                    </button>

                                </div>


                                <!-- FEATURED -->

                                <div
                                    class="flex items-center
                                           justify-between gap-4"
                                >

                                    <div
                                        class="flex items-center
                                               gap-3"
                                    >

                                        <div
                                            class="flex h-9 w-9
                                                   items-center
                                                   justify-center
                                                   rounded-lg
                                                   bg-amber-50"
                                        >
                                            <Star
                                                class="h-4 w-4
                                                       text-amber-500"
                                            />
                                        </div>


                                        <div>

                                            <p
                                                class="text-sm
                                                       font-semibold
                                                       text-slate-700"
                                            >
                                                Featured
                                            </p>

                                            <p
                                                class="text-xs
                                                       text-slate-400"
                                            >
                                                Highlight this post
                                            </p>

                                        </div>

                                    </div>


                                    <button
                                        type="button"
                                        @click="
                                            form.is_featured =
                                                !form.is_featured
                                        "
                                        class="toggle"
                                        :class="
                                            form.is_featured
                                                ? 'bg-orange-500'
                                                : 'bg-slate-300'
                                        "
                                    >

                                        <span
                                            class="toggle-circle"
                                            :class="
                                                form.is_featured
                                                    ? 'translate-x-5'
                                                    : 'translate-x-0'
                                            "
                                        />

                                    </button>

                                </div>

                            </div>

                        </div>


                        <!-- ================================================== -->
                        <!-- THUMBNAIL -->
                        <!-- ================================================== -->

                        <div class="admin-card">

                            <div
                                class="border-b
                                       border-slate-100
                                       px-5 py-4"
                            >

                                <h2 class="card-title">
                                    Featured Image
                                </h2>

                                <p
                                    class="mt-1 text-xs
                                           text-slate-400"
                                >
                                    Image displayed on the
                                    news card.
                                </p>

                            </div>


                            <div class="p-5">


                                <!-- IMAGE -->

                                <div
                                    v-if="thumbnailPreview"
                                    class="overflow-hidden
                                           rounded-xl
                                           border
                                           border-slate-200"
                                >

                                    <div
                                        class="relative
                                               aspect-[16/10]"
                                    >

                                        <img
                                            :src="thumbnailPreview"
                                            class="h-full
                                                   w-full
                                                   object-cover"
                                        />


                                        <button
                                            type="button"
                                            @click="removeThumbnail"
                                            class="absolute
                                                   right-3 top-3
                                                   rounded-lg
                                                   bg-black/60
                                                   px-3 py-1.5
                                                   text-xs
                                                   font-medium
                                                   text-white
                                                   backdrop-blur-sm
                                                   hover:bg-red-500"
                                        >
                                            Remove
                                        </button>

                                    </div>

                                </div>


                                <!-- UPLOAD -->

                                <label
                                    v-else
                                    class="flex
                                           aspect-[16/10]
                                           cursor-pointer
                                           flex-col
                                           items-center
                                           justify-center
                                           rounded-xl
                                           border-2
                                           border-dashed
                                           border-slate-200
                                           bg-slate-50
                                           p-6
                                           text-center
                                           transition
                                           hover:border-orange-300
                                           hover:bg-orange-50/40"
                                >

                                    <div
                                        class="flex h-12 w-12
                                               items-center
                                               justify-center
                                               rounded-xl
                                               bg-white
                                               text-orange-500
                                               shadow-sm"
                                    >
                                        <Upload class="h-5 w-5" />
                                    </div>


                                    <p
                                        class="mt-3 text-sm
                                               font-semibold
                                               text-slate-700"
                                    >
                                        Upload Thumbnail
                                    </p>


                                    <p
                                        class="mt-1 text-xs
                                               text-slate-400"
                                    >
                                        PNG, JPG or WEBP
                                    </p>


                                    <input
                                        type="file"
                                        accept="image/png,image/jpeg,image/webp"
                                        class="hidden"
                                        @change="onThumbnailChange"
                                    />

                                </label>


                                <!-- CHANGE -->

                                <label
                                    v-if="thumbnailPreview"
                                    class="mt-3
                                           flex cursor-pointer
                                           items-center
                                           justify-center
                                           gap-2
                                           rounded-xl
                                           border
                                           border-slate-200
                                           px-4 py-2.5
                                           text-sm
                                           font-semibold
                                           text-slate-600
                                           transition
                                           hover:bg-slate-50
                                           hover:text-orange-500"
                                >

                                    <ImageIcon class="h-4 w-4" />

                                    Change Image


                                    <input
                                        type="file"
                                        accept="image/png,image/jpeg,image/webp"
                                        class="hidden"
                                        @change="onThumbnailChange"
                                    />

                                </label>


                                <p
                                    class="mt-3 text-xs
                                           leading-5
                                           text-slate-400"
                                >
                                    Recommended ratio 16:10.
                                    Maximum file size 5 MB.
                                </p>


                                <p
                                    v-if="form.errors.thumbnail"
                                    class="form-error"
                                >
                                    {{ form.errors.thumbnail }}
                                </p>

                            </div>

                        </div>


                        <!-- ================================================== -->
                        <!-- QUICK PREVIEW -->
                        <!-- ================================================== -->

                        <div class="admin-card">

                            <div
                                class="border-b
                                       border-slate-100
                                       px-5 py-4"
                            >

                                <h2 class="card-title">
                                    Card Preview
                                </h2>

                            </div>


                            <div class="p-5">

                                <div
                                    class="overflow-hidden
                                           rounded-xl
                                           border
                                           border-slate-200
                                           bg-white"
                                >

                                    <div
                                        class="relative
                                               aspect-[16/9]
                                               bg-slate-100"
                                    >

                                        <img
                                            v-if="thumbnailPreview"
                                            :src="thumbnailPreview"
                                            class="h-full
                                                   w-full
                                                   object-cover"
                                        />


                                        <div
                                            v-else
                                            class="flex
                                                   h-full
                                                   items-center
                                                   justify-center"
                                        >
                                            <ImageIcon
                                                class="h-8 w-8
                                                       text-slate-300"
                                            />
                                        </div>


                                        <span
                                            class="absolute
                                                   left-3 top-3
                                                   rounded-md
                                                   bg-white
                                                   px-2 py-1
                                                   text-[10px]
                                                   font-bold
                                                   uppercase
                                                   shadow-sm"
                                        >
                                            {{
                                                selectedCategory?.label
                                            }}
                                        </span>

                                    </div>


                                    <div class="p-4">

                                        <p
                                            class="text-xs
                                                   text-orange-500"
                                        >
                                            {{
                                                form.published_at
                                                || 'Published date'
                                            }}
                                        </p>


                                        <h3
                                            class="mt-2
                                                   font-bold
                                                   text-slate-800"
                                        >
                                            {{
                                                form.title
                                                || 'Post title'
                                            }}
                                        </h3>


                                        <p
                                            class="mt-2
                                                   line-clamp-3
                                                   text-xs
                                                   leading-5
                                                   text-slate-500"
                                        >
                                            {{
                                                form.excerpt
                                                || 'Short description will appear here.'
                                            }}
                                        </p>


                                        <p
                                            class="mt-4
                                                   text-xs
                                                   font-semibold
                                                   text-orange-500"
                                        >
                                            Read More →
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- ====================================================== -->
                <!-- BOTTOM SAVE -->
                <!-- ====================================================== -->

                <div
                    class="mt-6 flex
                           flex-col gap-4
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
                            class="text-sm
                                   font-semibold
                                   text-slate-700"
                        >
                            Ready to publish?
                        </p>

                        <p
                            class="mt-1 text-xs
                                   text-slate-400"
                        >
                            Make sure the title, category
                            and article content are correct.
                        </p>

                    </div>


                    <div class="flex gap-3">

                        <Link
                            :href="route('admin.posts.index')"
                            class="rounded-xl
                                   border border-slate-200
                                   px-5 py-2.5
                                   text-sm font-semibold
                                   text-slate-600
                                   hover:bg-slate-50"
                        >
                            Cancel
                        </Link>


                        <button
                            type="submit"
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
                                    ? 'Publishing...'
                                    : 'Publish Post'
                            }}

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </AdminLayout>

</template>


<style scoped>

.admin-card {
    @apply overflow-hidden
           rounded-2xl
           border border-slate-200
           bg-white
           shadow-sm;
}

.card-header {
    @apply flex items-center gap-3
           border-b border-slate-100
           px-6 py-5;
}

.card-title {
    @apply font-bold text-slate-900;
}

.card-description {
    @apply mt-1 text-sm text-slate-500;
}

.form-label {
    @apply mb-2 block
           text-sm font-semibold
           text-slate-700;
}

.form-input {
    @apply w-full
           rounded-xl
           border border-slate-200
           bg-white
           px-4 py-3
           text-sm
           text-slate-700
           outline-none
           transition
           placeholder:text-slate-400
           focus:border-orange-400
           focus:ring-4
           focus:ring-orange-100;
}

.form-error {
    @apply mt-2
           text-xs
           font-medium
           text-red-500;
}

.toggle {
    @apply relative
           h-6 w-11
           shrink-0
           rounded-full
           transition;
}

.toggle-circle {
    @apply absolute
           left-0.5 top-0.5
           h-5 w-5
           rounded-full
           bg-white
           shadow
           transition-transform;
}

</style>
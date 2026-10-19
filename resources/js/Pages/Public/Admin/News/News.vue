<script setup>

import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'

import {
    Head,
    Link,
    router
} from '@inertiajs/vue3'

import {
    Plus,
    Search,
    Pencil,
    Trash2,
    Newspaper,
    CalendarDays,
    Activity,
    Trophy,
    Eye,
    EyeOff,
} from 'lucide-vue-next'

import {
    ref,
    watch
} from 'vue'


const props = defineProps({

    posts: Object,

    filters: Object,

})


const search = ref(
    props.filters?.search ?? ''
)

const category = ref(
    props.filters?.category ?? 'all'
)

const status = ref(
    props.filters?.status ?? 'all'
)


let timeout = null


watch(
    [search, category, status],
    () => {

        clearTimeout(timeout)

        timeout = setTimeout(() => {

            router.get(
                route('admin.posts.index'),
                {
                    search:
                        search.value,

                    category:
                        category.value,

                    status:
                        status.value,
                },
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                }
            )

        }, 300)

    }
)


const deletePost = (post) => {

    if (
        !confirm(
            `Delete "${post.title}"?`
        )
    ) {
        return
    }

    router.delete(
        route(
            'admin.posts.destroy',
            post.id
        ),
        {
            preserveScroll: true,
        }
    )
}


const categoryClass = (value) => {

    const classes = {

        news:
            'bg-blue-50 text-blue-600',

        event:
            'bg-orange-50 text-orange-600',

        activity:
            'bg-purple-50 text-purple-600',

        achievement:
            'bg-emerald-50 text-emerald-600',

    }

    return classes[value] ??
        'bg-slate-100 text-slate-600'
}

</script>


<template>

    <Head title="News & Events" />


    <AdminLayout>

        <div class="min-h-screen bg-slate-50">


            <!-- HEADER -->

            <div
                class="border-b border-slate-200 bg-white"
            >

                <div
                    class="flex items-center
                           justify-between
                           px-8 py-6"
                >

                    <div>

                        <p
                            class="mb-1 text-sm
                                   text-slate-400"
                        >
                            Website Management /
                            News & Events
                        </p>


                        <h1
                            class="text-2xl
                                   font-bold
                                   text-slate-900"
                        >
                            News & Events
                        </h1>


                        <p
                            class="mt-1 text-sm
                                   text-slate-500"
                        >
                            Manage school news,
                            events, activities and
                            achievements.
                        </p>

                    </div>

                    <Link
                        :href="
                            route(
                                'admin.edit.post.header'
                            )
                        "
                        class="inline-flex
                               items-center gap-2
                               rounded-xl
                               bg-orange-500
                               px-5 py-3
                               text-sm
                               font-semibold
                               text-white
                               hover:bg-orange-600"
                    >

                        <Pencil class="h-4 w-4" />

                        Edit Header

                    </Link>

                    <Link
                        :href="
                            route(
                                'admin.posts.create'
                            )
                        "
                        class="inline-flex
                               items-center gap-2
                               rounded-xl
                               bg-orange-500
                               px-5 py-3
                               text-sm
                               font-semibold
                               text-white
                               hover:bg-orange-600"
                    >

                        <Plus class="h-4 w-4" />

                        Add New Post

                    </Link>


                </div>

            </div>


            <div class="p-8">


                <!-- SUCCESS -->

                <div
                    v-if="
                        $page.props.flash?.success
                    "
                    class="mb-6
                           rounded-xl
                           border
                           border-emerald-200
                           bg-emerald-50
                           px-5 py-4
                           text-sm
                           text-emerald-700"
                >
                    {{
                        $page.props.flash.success
                    }}
                </div>


                <!-- STATISTIC CARDS -->

                <div
                    class="mb-6 grid gap-4
                           md:grid-cols-4"
                >

                    <div class="stat-card">

                        <Newspaper
                            class="stat-icon"
                        />

                        <div>

                            <p class="stat-label">
                                News
                            </p>

                            <p class="stat-number">
                                Manage News
                            </p>

                        </div>

                    </div>


                    <div class="stat-card">

                        <CalendarDays
                            class="stat-icon"
                        />

                        <div>

                            <p class="stat-label">
                                Events
                            </p>

                            <p class="stat-number">
                                School Events
                            </p>

                        </div>

                    </div>


                    <div class="stat-card">

                        <Activity
                            class="stat-icon"
                        />

                        <div>

                            <p class="stat-label">
                                Activities
                            </p>

                            <p class="stat-number">
                                School Activities
                            </p>

                        </div>

                    </div>


                    <div class="stat-card">

                        <Trophy
                            class="stat-icon"
                        />

                        <div>

                            <p class="stat-label">
                                Achievements
                            </p>

                            <p class="stat-number">
                                Achievements
                            </p>

                        </div>

                    </div>

                </div>


                <!-- MAIN CARD -->

                <div
                    class="overflow-hidden
                           rounded-2xl
                           border
                           border-slate-200
                           bg-white
                           shadow-sm"
                >


                    <!-- FILTER -->

                    <div
                        class="flex flex-col
                               gap-4
                               border-b
                               border-slate-100
                               p-5
                               lg:flex-row"
                    >


                        <!-- SEARCH -->

                        <div
                            class="relative flex-1"
                        >

                            <Search
                                class="absolute
                                       left-4 top-1/2
                                       h-4 w-4
                                       -translate-y-1/2
                                       text-slate-400"
                            />


                            <input
                                v-model="search"
                                type="text"
                                placeholder="Search posts..."
                                class="form-input !pl-11"
                            />

                        </div>


                        <!-- CATEGORY -->

                        <select
                            v-model="category"
                            class="form-input
                                   lg:w-[210px]"
                        >

                            <option value="all">
                                All Categories
                            </option>

                            <option value="news">
                                News
                            </option>

                            <option value="event">
                                Events
                            </option>

                            <option value="activity">
                                Activities
                            </option>

                            <option value="achievement">
                                Achievements
                            </option>

                        </select>


                        <!-- STATUS -->

                        <select
                            v-model="status"
                            class="form-input
                                   lg:w-[180px]"
                        >

                            <option value="all">
                                All Status
                            </option>

                            <option value="active">
                                Active
                            </option>

                            <option value="inactive">
                                Inactive
                            </option>

                        </select>

                    </div>


                    <!-- TABLE -->

                    <div class="overflow-x-auto">

                        <table
                            class="w-full text-left"
                        >

                            <thead
                                class="bg-slate-50
                                       text-xs
                                       uppercase
                                       tracking-wide
                                       text-slate-500"
                            >

                                <tr>

                                    <th class="table-th">
                                        Post
                                    </th>

                                    <th class="table-th">
                                        Category
                                    </th>

                                    <th class="table-th">
                                        Published
                                    </th>

                                    <th class="table-th">
                                        Status
                                    </th>

                                    <th
                                        class="table-th
                                               text-right"
                                    >
                                        Action
                                    </th>

                                </tr>

                            </thead>


                            <tbody
                                class="divide-y
                                       divide-slate-100"
                            >

                                <tr
                                    v-for="
                                        post in posts.data
                                    "
                                    :key="post.id"
                                    class="hover:bg-slate-50/70"
                                >


                                    <!-- POST -->

                                    <td class="table-td">

                                        <div
                                            class="flex
                                                   items-center
                                                   gap-4"
                                        >

                                            <div
                                                class="h-16 w-24
                                                       shrink-0
                                                       overflow-hidden
                                                       rounded-lg
                                                       bg-slate-100"
                                            >

                                                <img
                                                    v-if="
                                                        post.thumbnail
                                                    "
                                                    :src="
                                                        `/storage/${post.thumbnail}`
                                                    "
                                                    class="h-full
                                                           w-full
                                                           object-cover"
                                                />

                                            </div>


                                            <div>

                                                <p
                                                    class="font-semibold
                                                           text-slate-800"
                                                >
                                                    {{ post.title }}
                                                </p>


                                                <p
                                                    class="mt-1
                                                           max-w-[350px]
                                                           truncate
                                                           text-xs
                                                           text-slate-400"
                                                >
                                                    {{
                                                        post.excerpt
                                                        || 'No excerpt'
                                                    }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>


                                    <!-- CATEGORY -->

                                    <td class="table-td">

                                        <span
                                            class="rounded-full
                                                   px-3 py-1
                                                   text-xs
                                                   font-semibold
                                                   capitalize"
                                            :class="
                                                categoryClass(
                                                    post.category
                                                )
                                            "
                                        >
                                            {{ post.category }}
                                        </span>

                                    </td>


                                    <!-- DATE -->

                                    <td
                                        class="table-td
                                               text-sm
                                               text-slate-500"
                                    >
                                        {{
                                            post.published_at
                                            ?? '-'
                                        }}
                                    </td>


                                    <!-- STATUS -->

                                    <td class="table-td">

                                        <div
                                            class="flex
                                                   items-center
                                                   gap-2"
                                        >

                                            <Eye
                                                v-if="
                                                    post.is_active
                                                "
                                                class="h-4 w-4
                                                       text-emerald-500"
                                            />

                                            <EyeOff
                                                v-else
                                                class="h-4 w-4
                                                       text-slate-400"
                                            />


                                            <span
                                                :class="
                                                    post.is_active
                                                        ? 'text-emerald-600'
                                                        : 'text-slate-400'
                                                "
                                                class="text-sm
                                                       font-medium"
                                            >
                                                {{
                                                    post.is_active
                                                        ? 'Active'
                                                        : 'Inactive'
                                                }}
                                            </span>

                                        </div>

                                    </td>


                                    <!-- ACTION -->

                                    <td
                                        class="table-td
                                               text-right"
                                    >

                                        <div
                                            class="flex
                                                   justify-end
                                                   gap-2"
                                        >
                                            <Link
                                                :href="
                                                    route(
                                                        'admin.news.show',
                                                        post.slug
                                                    )
                                                "
                                                class="action-button
                                                       hover:!bg-slate-100
                                                       hover:!text-slate-700"
                                            >
                                                View
                                            </Link>

                                            <Link
                                                :href="
                                                    route(
                                                        'admin.posts.edit',
                                                        post.id
                                                    )
                                                "
                                                class="action-button
                                                       hover:!bg-orange-50
                                                       hover:!text-orange-500"
                                            >

                                                <Pencil
                                                    class="h-4 w-4"
                                                />

                                            </Link>


                                            <button
                                                type="button"
                                                @click="
                                                    deletePost(post)
                                                "
                                                class="action-button
                                                       hover:!bg-red-50
                                                       hover:!text-red-500"
                                            >

                                                <Trash2
                                                    class="h-4 w-4"
                                                />

                                            </button>

                                        </div>

                                    </td>

                                </tr>


                                <!-- EMPTY -->

                                <tr
                                    v-if="
                                        posts.data.length === 0
                                    "
                                >

                                    <td
                                        colspan="5"
                                        class="py-16
                                               text-center"
                                    >

                                        <Newspaper
                                            class="mx-auto
                                                   h-10 w-10
                                                   text-slate-300"
                                        />

                                        <p
                                            class="mt-3
                                                   font-semibold
                                                   text-slate-600"
                                        >
                                            No posts found
                                        </p>

                                        <p
                                            class="mt-1
                                                   text-sm
                                                   text-slate-400"
                                        >
                                            Add your first news,
                                            event or activity.
                                        </p>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>


                    <!-- PAGINATION -->

                    <div
                        v-if="posts.links"
                        class="flex flex-wrap
                               justify-center gap-1
                               border-t
                               border-slate-100
                               p-5"
                    >

                        <template
                            v-for="
                                link in posts.links
                            "
                            :key="link.label"
                        >

                            <Link
                                v-if="link.url"
                                :href="link.url"
                                v-html="link.label"
                                class="rounded-lg
                                       border
                                       px-3 py-2
                                       text-sm"
                                :class="
                                    link.active
                                        ? 'border-orange-500 bg-orange-500 text-white'
                                        : 'border-slate-200 text-slate-500 hover:bg-slate-50'
                                "
                            />

                            <span
                                v-else
                                v-html="link.label"
                                class="rounded-lg
                                       border
                                       border-slate-100
                                       px-3 py-2
                                       text-sm
                                       text-slate-300"
                            />

                        </template>

                    </div>

                </div>

            </div>

        </div>

    </AdminLayout>

</template>


<style scoped>

.form-input {
    @apply w-full rounded-xl
           border border-slate-200
           bg-white
           px-4 py-3
           text-sm
           text-slate-700
           outline-none
           transition
           focus:border-orange-400
           focus:ring-4
           focus:ring-orange-100;
}

.table-th {
    @apply px-6 py-4 font-semibold;
}

.table-td {
    @apply px-6 py-4;
}

.action-button {
    @apply inline-flex
           h-9 w-9
           items-center
           justify-center
           rounded-lg
           text-slate-400
           transition
           hover:bg-slate-100
           hover:text-slate-700;
}

.stat-card {
    @apply flex items-center gap-4
           rounded-2xl
           border border-slate-200
           bg-white
           p-5 shadow-sm;
}

.stat-icon {
    @apply h-6 w-6 text-orange-500;
}

.stat-label {
    @apply text-xs text-slate-400;
}

.stat-number {
    @apply mt-1 text-sm font-bold text-slate-800;
}

</style>
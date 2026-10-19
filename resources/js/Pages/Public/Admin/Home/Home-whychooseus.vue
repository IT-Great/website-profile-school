<script setup>

import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'

import {
    Head,
    Link,
    useForm
} from '@inertiajs/vue3'

import {
    Plus,
    Trash2,
    Save,
    ChevronUp,
    ChevronDown,
    Eye,
    EyeOff,
    Globe2,
    UsersRound,
    Lightbulb,
    ShieldCheck,
    UserCheck,
    Monitor,
    BookOpen,
    GraduationCap,
    Sparkles,
} from 'lucide-vue-next'


const props = defineProps({

    setting: {
        type: Object,
        default: null,
    },

    items: {
        type: Array,
        default: () => [],
    }

})


/*
|--------------------------------------------------------------------------
| FORM
|--------------------------------------------------------------------------
*/

const form = useForm({

    badge:
        props.setting?.badge ??
        'WHY CHOOSE US',

    title:
        props.setting?.title ??
        'Excellence in Education',

    is_active:
        props.setting?.is_active ?? true,


    items: props.items.map(item => ({

        id: item.id,

        icon:
            item.icon ??
            'globe',

        title:
            item.title ??
            '',

        description:
            item.description ??
            '',

        is_active:
            Boolean(item.is_active),

    }))

})


/*
|--------------------------------------------------------------------------
| ICON OPTIONS
|--------------------------------------------------------------------------
*/

const iconOptions = [

    {
        value: 'globe',
        label: 'Globe',
        component: Globe2,
    },

    {
        value: 'users',
        label: 'Students / Class',
        component: UsersRound,
    },

    {
        value: 'lightbulb',
        label: 'Creative Learning',
        component: Lightbulb,
    },

    {
        value: 'shield',
        label: 'Safe Environment',
        component: ShieldCheck,
    },

    {
        value: 'teacher',
        label: 'Teacher',
        component: UserCheck,
    },

    {
        value: 'monitor',
        label: 'Digital Classroom',
        component: Monitor,
    },

    {
        value: 'book',
        label: 'Book',
        component: BookOpen,
    },

    {
        value: 'graduation',
        label: 'Graduation',
        component: GraduationCap,
    },

    {
        value: 'sparkles',
        label: 'Excellence',
        component: Sparkles,
    },

]


const getIcon = (name) => {

    const icon = iconOptions.find(
        item => item.value === name
    )

    return icon?.component ?? Sparkles

}


/*
|--------------------------------------------------------------------------
| ADD
|--------------------------------------------------------------------------
*/

const addItem = () => {

    form.items.push({

        id: null,

        icon: 'sparkles',

        title: '',

        description: '',

        is_active: true,

    })

}


/*
|--------------------------------------------------------------------------
| REMOVE
|--------------------------------------------------------------------------
*/

const removeItem = (index) => {

    if (
        !confirm(
            'Are you sure you want to remove this item?'
        )
    ) {
        return
    }

    form.items.splice(index, 1)

}


/*
|--------------------------------------------------------------------------
| ORDER
|--------------------------------------------------------------------------
*/

const moveUp = (index) => {

    if (index === 0) {
        return
    }

    const item = form.items[index]

    form.items.splice(index, 1)

    form.items.splice(
        index - 1,
        0,
        item
    )

}


const moveDown = (index) => {

    if (
        index ===
        form.items.length - 1
    ) {
        return
    }

    const item = form.items[index]

    form.items.splice(index, 1)

    form.items.splice(
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
            'admin.home.why-choose.update'
        ),
        {
            preserveScroll: true,
        }
    )

}

</script>


<template>

    <Head title="Why Choose Us" />


    <AdminLayout>

        <div class="min-h-screen bg-slate-50">


            <!-- ===================================================== -->
            <!-- HEADER -->
            <!-- ===================================================== -->

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
                                       gap-2 text-sm
                                       text-slate-400"
                            >

                                <Link
                                    :href="
                                        route(
                                            'dashboard'
                                        )
                                    "
                                    class="
                                        hover:text-orange-500
                                    "
                                >
                                    Dashboard
                                </Link>

                                <span>/</span>

                                <span>
                                    Homepage
                                </span>

                                <span>/</span>

                                <span
                                    class="
                                        font-medium
                                        text-orange-500
                                    "
                                >
                                    Why Choose Us
                                </span>

                            </div>


                            <h1
                                class="
                                    text-2xl
                                    font-bold
                                    text-slate-900
                                "
                            >
                                Why Choose Us
                            </h1>


                            <p
                                class="
                                    mt-1
                                    text-sm
                                    text-slate-500
                                "
                            >
                                Manage the reasons why parents
                                should choose Great Crystal School.
                            </p>

                        </div>


                        <div class="flex gap-3">

                            <button
                                type="button"
                                @click="addItem"
                                class="
                                    inline-flex
                                    items-center
                                    gap-2
                                    rounded-xl
                                    border
                                    border-orange-200
                                    bg-orange-50
                                    px-4
                                    py-3
                                    text-sm
                                    font-semibold
                                    text-orange-600
                                    hover:bg-orange-100
                                "
                            >

                                <Plus
                                    class="h-4 w-4"
                                />

                                Add Item

                            </button>


                            <button
                                type="button"
                                @click="submit"
                                :disabled="
                                    form.processing
                                "
                                class="
                                    inline-flex
                                    items-center
                                    gap-2
                                    rounded-xl
                                    bg-orange-500
                                    px-5
                                    py-3
                                    text-sm
                                    font-semibold
                                    text-white
                                    hover:bg-orange-600
                                    disabled:opacity-50
                                "
                            >

                                <Save
                                    class="h-4 w-4"
                                />

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


            <!-- ===================================================== -->
            <!-- CONTENT -->
            <!-- ===================================================== -->

            <div class="px-6 py-8 lg:px-8">


                <!-- SUCCESS -->

                <div
                    v-if="
                        $page.props.flash?.success
                    "
                    class="
                        mb-6
                        rounded-xl
                        border
                        border-emerald-200
                        bg-emerald-50
                        px-5 py-4
                        text-sm
                        font-medium
                        text-emerald-700
                    "
                >
                    {{
                        $page.props.flash.success
                    }}
                </div>


                <!-- ================================================= -->
                <!-- SECTION SETTINGS -->
                <!-- ================================================= -->

                <div
                    class="
                        mb-6
                        overflow-hidden
                        rounded-2xl
                        border
                        border-slate-200
                        bg-white
                        shadow-sm
                    "
                >

                    <div
                        class="
                            border-b
                            border-slate-100
                            px-6 py-5
                        "
                    >

                        <h2
                            class="
                                text-lg
                                font-bold
                                text-slate-900
                            "
                        >
                            Section Settings
                        </h2>

                        <p
                            class="
                                mt-1
                                text-sm
                                text-slate-500
                            "
                        >
                            Configure the heading of
                            this homepage section.
                        </p>

                    </div>


                    <div class="p-6">

                        <div
                            class="
                                grid
                                gap-5
                                lg:grid-cols-12
                            "
                        >

                            <!-- BADGE -->

                            <div class="lg:col-span-3">

                                <label class="form-label">
                                    Badge
                                </label>

                                <input
                                    v-model="form.badge"
                                    type="text"
                                    class="form-input"
                                    placeholder="WHY CHOOSE US"
                                />

                            </div>


                            <!-- TITLE -->

                            <div class="lg:col-span-6">

                                <label class="form-label">
                                    Section Title
                                </label>

                                <input
                                    v-model="form.title"
                                    type="text"
                                    class="form-input"
                                    placeholder="Excellence in Education"
                                />

                                <p
                                    v-if="
                                        form.errors.title
                                    "
                                    class="form-error"
                                >
                                    {{ form.errors.title }}
                                </p>

                            </div>


                            <!-- STATUS -->

                            <div class="lg:col-span-3">

                                <label class="form-label">
                                    Section Status
                                </label>


                                <button
                                    type="button"
                                    @click="
                                        form.is_active =
                                            !form.is_active
                                    "
                                    class="
                                        flex h-[46px]
                                        w-full
                                        items-center
                                        gap-3
                                        rounded-xl
                                        border
                                        border-slate-200
                                        px-4
                                    "
                                >

                                    <div
                                        class="
                                            relative
                                            h-6 w-11
                                            shrink-0
                                            rounded-full
                                            transition
                                        "
                                        :class="
                                            form.is_active
                                                ? 'bg-orange-500'
                                                : 'bg-slate-300'
                                        "
                                    >

                                        <span
                                            class="
                                                absolute
                                                top-0.5
                                                h-5 w-5
                                                rounded-full
                                                bg-white
                                                shadow
                                                transition-all
                                            "
                                            :class="
                                                form.is_active
                                                    ? 'left-[22px]'
                                                    : 'left-0.5'
                                            "
                                        />

                                    </div>


                                    <span
                                        class="
                                            text-sm
                                            font-semibold
                                            text-slate-700
                                        "
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


                <!-- ================================================= -->
                <!-- LIVE PREVIEW -->
                <!-- ================================================= -->

                <div
                    class="
                        mb-6
                        overflow-hidden
                        rounded-2xl
                        border
                        border-slate-200
                        bg-white
                        shadow-sm
                    "
                >

                    <div
                        class="
                            border-b
                            border-slate-100
                            px-6 py-4
                        "
                    >

                        <h2
                            class="
                                font-bold
                                text-slate-900
                            "
                        >
                            Section Preview
                        </h2>

                    </div>


                    <div
                        class="
                            overflow-x-auto
                            px-6
                            py-10
                        "
                    >

                        <!-- HEADING -->

                        <div class="text-center">

                            <p
                                class="
                                    text-xs
                                    font-bold
                                    uppercase
                                    tracking-[0.3em]
                                    text-orange-500
                                "
                            >
                                {{
                                    form.badge ||
                                    'WHY CHOOSE US'
                                }}
                            </p>


                            <h2
                                class="
                                    mt-3
                                    text-3xl
                                    font-bold
                                    text-slate-900
                                "
                            >
                                {{
                                    form.title ||
                                    'Excellence in Education'
                                }}
                            </h2>

                        </div>


                        <!-- PREVIEW ITEMS -->

                        <div
                            class="
                                mt-10
                                grid
                                min-w-[800px]
                                gap-6
                            "
                            :style="{
                                gridTemplateColumns:
                                    `repeat(${Math.min(
                                        Math.max(
                                            form.items.filter(
                                                item => item.is_active
                                            ).length,
                                            1
                                        ),
                                        6
                                    )}, minmax(0, 1fr))`
                            }"
                        >

                            <div
                                v-for="
                                    (item, index)
                                    in form.items.filter(
                                        item => item.is_active
                                    )
                                "
                                :key="index"
                                class="
                                    text-center
                                "
                            >

                                <component
                                    :is="
                                        getIcon(
                                            item.icon
                                        )
                                    "
                                    class="
                                        mx-auto
                                        h-8 w-8
                                        text-orange-500
                                    "
                                />


                                <h3
                                    class="
                                        mt-4
                                        font-bold
                                        leading-5
                                        text-slate-900
                                    "
                                >
                                    {{
                                        item.title ||
                                        'Feature Title'
                                    }}
                                </h3>


                                <p
                                    class="
                                        mt-3
                                        text-xs
                                        leading-5
                                        text-slate-500
                                    "
                                >
                                    {{
                                        item.description ||
                                        'Description'
                                    }}
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- ================================================= -->
                <!-- ITEMS -->
                <!-- ================================================= -->

                <div
                    class="
                        overflow-hidden
                        rounded-2xl
                        border
                        border-slate-200
                        bg-white
                        shadow-sm
                    "
                >

                    <div
                        class="
                            flex
                            items-center
                            justify-between
                            border-b
                            border-slate-100
                            px-6 py-5
                        "
                    >

                        <div>

                            <h2
                                class="
                                    text-lg
                                    font-bold
                                    text-slate-900
                                "
                            >
                                Why Choose Items
                            </h2>

                            <p
                                class="
                                    mt-1
                                    text-sm
                                    text-slate-500
                                "
                            >
                                {{
                                    form.items.length
                                }}
                                items
                            </p>

                        </div>


                        <button
                            type="button"
                            @click="addItem"
                            class="
                                inline-flex
                                items-center
                                gap-2
                                rounded-xl
                                bg-orange-50
                                px-4 py-2.5
                                text-sm
                                font-semibold
                                text-orange-600
                                hover:bg-orange-100
                            "
                        >

                            <Plus
                                class="h-4 w-4"
                            />

                            Add Item

                        </button>

                    </div>


                    <!-- EMPTY -->

                    <div
                        v-if="
                            form.items.length === 0
                        "
                        class="
                            px-6 py-16
                            text-center
                        "
                    >

                        <Sparkles
                            class="
                                mx-auto
                                h-10 w-10
                                text-orange-400
                            "
                        />

                        <h3
                            class="
                                mt-4
                                font-bold
                                text-slate-800
                            "
                        >
                            No items yet
                        </h3>

                        <p
                            class="
                                mt-2
                                text-sm
                                text-slate-400
                            "
                        >
                            Add your first Why Choose Us item.
                        </p>

                    </div>


                    <!-- LIST -->

                    <div
                        v-else
                        class="
                            divide-y
                            divide-slate-100
                        "
                    >

                        <div
                            v-for="
                                (item, index)
                                in form.items
                            "
                            :key="
                                item.id ?? index
                            "
                            class="p-6"
                        >

                            <div
                                class="
                                    grid
                                    gap-5
                                    xl:grid-cols-12
                                    xl:items-start
                                "
                            >


                                <!-- ICON PREVIEW -->

                                <div
                                    class="
                                        xl:col-span-1
                                    "
                                >

                                    <div
                                        class="
                                            flex h-14 w-14
                                            items-center
                                            justify-center
                                            rounded-xl
                                            bg-orange-50
                                            text-orange-500
                                        "
                                    >

                                        <component
                                            :is="
                                                getIcon(
                                                    item.icon
                                                )
                                            "
                                            class="
                                                h-7 w-7
                                            "
                                        />

                                    </div>

                                </div>


                                <!-- ICON -->

                                <div
                                    class="
                                        xl:col-span-2
                                    "
                                >

                                    <label class="form-label">
                                        Icon
                                    </label>


                                    <select
                                        v-model="
                                            item.icon
                                        "
                                        class="form-input"
                                    >

                                        <option
                                            v-for="
                                                icon
                                                in iconOptions
                                            "
                                            :key="
                                                icon.value
                                            "
                                            :value="
                                                icon.value
                                            "
                                        >
                                            {{ icon.label }}
                                        </option>

                                    </select>

                                </div>


                                <!-- TITLE -->

                                <div
                                    class="
                                        xl:col-span-3
                                    "
                                >

                                    <label class="form-label">
                                        Title
                                    </label>


                                    <input
                                        v-model="
                                            item.title
                                        "
                                        type="text"
                                        class="form-input"
                                        placeholder="
                                            International Curriculum
                                        "
                                    />


                                    <p
                                        v-if="
                                            form.errors[
                                                `items.${index}.title`
                                            ]
                                        "
                                        class="form-error"
                                    >
                                        {{
                                            form.errors[
                                                `items.${index}.title`
                                            ]
                                        }}
                                    </p>

                                </div>


                                <!-- DESCRIPTION -->

                                <div
                                    class="
                                        xl:col-span-4
                                    "
                                >

                                    <label class="form-label">
                                        Description
                                    </label>


                                    <textarea
                                        v-model="
                                            item.description
                                        "
                                        rows="2"
                                        class="
                                            form-input
                                            resize-none
                                        "
                                        placeholder="
                                            Globally recognized education standards.
                                        "
                                    />

                                </div>


                                <!-- ACTION -->

                                <div
                                    class="
                                        flex
                                        items-end
                                        gap-1
                                        pt-7
                                        xl:col-span-2
                                    "
                                >

                                    <button
                                        type="button"
                                        @click="
                                            moveUp(index)
                                        "
                                        :disabled="
                                            index === 0
                                        "
                                        class="
                                            action-button
                                        "
                                    >
                                        <ChevronUp
                                            class="h-4 w-4"
                                        />
                                    </button>


                                    <button
                                        type="button"
                                        @click="
                                            moveDown(index)
                                        "
                                        :disabled="
                                            index ===
                                            form.items.length - 1
                                        "
                                        class="
                                            action-button
                                        "
                                    >
                                        <ChevronDown
                                            class="h-4 w-4"
                                        />
                                    </button>


                                    <button
                                        type="button"
                                        @click="
                                            item.is_active =
                                                !item.is_active
                                        "
                                        class="
                                            action-button
                                        "
                                        :class="
                                            item.is_active
                                                ? '!text-emerald-500'
                                                : ''
                                        "
                                    >

                                        <Eye
                                            v-if="
                                                item.is_active
                                            "
                                            class="h-4 w-4"
                                        />

                                        <EyeOff
                                            v-else
                                            class="h-4 w-4"
                                        />

                                    </button>


                                    <button
                                        type="button"
                                        @click="
                                            removeItem(index)
                                        "
                                        class="
                                            action-button
                                            hover:!bg-red-50
                                            hover:!text-red-500
                                        "
                                    >

                                        <Trash2
                                            class="h-4 w-4"
                                        />

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- ================================================= -->
                <!-- BOTTOM SAVE -->
                <!-- ================================================= -->

                <div
                    class="
                        mt-6
                        flex
                        items-center
                        justify-between
                        rounded-2xl
                        border
                        border-slate-200
                        bg-white
                        px-6 py-5
                        shadow-sm
                    "
                >

                    <div>

                        <p
                            class="
                                text-sm
                                font-semibold
                                text-slate-700
                            "
                        >
                            Save Why Choose Us
                        </p>

                        <p
                            class="
                                mt-1
                                text-xs
                                text-slate-400
                            "
                        >
                            Items will be displayed
                            according to their order.
                        </p>

                    </div>


                    <button
                        type="button"
                        @click="submit"
                        :disabled="
                            form.processing
                        "
                        class="
                            inline-flex
                            items-center
                            gap-2
                            rounded-xl
                            bg-orange-500
                            px-5 py-2.5
                            text-sm
                            font-semibold
                            text-white
                            hover:bg-orange-600
                            disabled:opacity-50
                        "
                    >

                        <Save
                            class="h-4 w-4"
                        />

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

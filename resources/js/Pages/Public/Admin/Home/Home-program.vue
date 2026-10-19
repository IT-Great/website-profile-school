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
    GripVertical,
    GraduationCap,
    Baby,
    BookOpen,
    BriefcaseBusiness,
    Save,
    Eye,
    EyeOff,
    ArrowRight,
    ChevronUp,
    ChevronDown,
} from 'lucide-vue-next'


const props = defineProps({

    programs: {
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

    programs: props.programs.map(program => ({

        id: program.id,

        icon: program.icon ?? '',

        title: program.title ?? '',

        age_range: program.age_range ?? '',

        description: program.description ?? '',

        button_text:
            program.button_text ?? 'Learn More',

        button_url:
            program.button_url ?? '',

        is_active:
            Boolean(program.is_active),

    }))

})


/*
|--------------------------------------------------------------------------
| ADD PROGRAM
|--------------------------------------------------------------------------
*/

const addProgram = () => {

    form.programs.push({

        id: null,

        icon: 'graduation-cap',

        title: '',

        age_range: '',

        description: '',

        button_text: 'Learn More',

        button_url: '',

        is_active: true,

    })

}


/*
|--------------------------------------------------------------------------
| DELETE
|--------------------------------------------------------------------------
*/

const removeProgram = (index) => {

    if (
        !confirm(
            'Are you sure you want to remove this program?'
        )
    ) {
        return
    }

    form.programs.splice(index, 1)

}


/*
|--------------------------------------------------------------------------
| MOVE UP
|--------------------------------------------------------------------------
*/

const moveUp = (index) => {

    if (index === 0) {
        return
    }

    const item = form.programs[index]

    form.programs.splice(index, 1)

    form.programs.splice(
        index - 1,
        0,
        item
    )

}


/*
|--------------------------------------------------------------------------
| MOVE DOWN
|--------------------------------------------------------------------------
*/

const moveDown = (index) => {

    if (
        index ===
        form.programs.length - 1
    ) {
        return
    }

    const item = form.programs[index]

    form.programs.splice(index, 1)

    form.programs.splice(
        index + 1,
        0,
        item
    )

}


/*
|--------------------------------------------------------------------------
| ICON
|--------------------------------------------------------------------------
*/

const getIcon = (icon) => {

    const icons = {

        'baby': Baby,

        'book-open': BookOpen,

        'graduation-cap':
            GraduationCap,

        'briefcase':
            BriefcaseBusiness,

    }

    return icons[icon]
        ?? GraduationCap

}


/*
|--------------------------------------------------------------------------
| SUBMIT
|--------------------------------------------------------------------------
*/

const submit = () => {

    form.post(
        route(
            'admin.home.programs.update'
        ),
        {
            preserveScroll: true,
        }
    )

}

</script>


<template>

    <Head title="Homepage Programs" />


    <AdminLayout>

        <div class="min-h-screen bg-slate-50">


            <!-- ========================================================= -->
            <!-- HEADER -->
            <!-- ========================================================= -->

            <div
                class="border-b
                       border-slate-200
                       bg-white"
            >

                <div
                    class="px-6 py-6
                           lg:px-8"
                >

                    <div
                        class="flex flex-col
                               gap-4
                               md:flex-row
                               md:items-center
                               md:justify-between"
                    >

                        <div>

                            <!-- BREADCRUMB -->

                            <div
                                class="mb-2
                                       flex items-center
                                       gap-2
                                       text-sm
                                       text-slate-400"
                            >

                                <Link
                                    :href="
                                        route(
                                            'admin.home.programs.update'
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
                                    Programs
                                </span>

                            </div>


                            <h1
                                class="
                                    text-2xl
                                    font-bold
                                    text-slate-900
                                "
                            >
                                Homepage Programs
                            </h1>


                            <p
                                class="
                                    mt-1
                                    text-sm
                                    text-slate-500
                                "
                            >
                                Manage the academic programs displayed
                                on the homepage.
                            </p>

                        </div>


                        <!-- ACTION -->

                        <div
                            class="
                                flex
                                items-center
                                gap-3
                            "
                        >

                            <button
                                type="button"
                                @click="addProgram"
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
                                    transition
                                    hover:bg-orange-100
                                "
                            >

                                <Plus
                                    class="h-4 w-4"
                                />

                                Add Program

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
                                    transition
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


            <!-- ========================================================= -->
            <!-- CONTENT -->
            <!-- ========================================================= -->

            <div
                class="
                    px-6 py-8
                    lg:px-8
                "
            >


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
                        px-5
                        py-4
                        text-sm
                        font-medium
                        text-emerald-700
                    "
                >
                    {{
                        $page.props.flash.success
                    }}
                </div>


                <!-- ===================================================== -->
                <!-- EMPTY -->
                <!-- ===================================================== -->

                <div
                    v-if="
                        form.programs.length === 0
                    "
                    class="
                        rounded-2xl
                        border-2
                        border-dashed
                        border-slate-200
                        bg-white
                        px-6
                        py-20
                        text-center
                    "
                >

                    <div
                        class="
                            mx-auto
                            flex h-16 w-16
                            items-center
                            justify-center
                            rounded-full
                            bg-orange-50
                            text-orange-500
                        "
                    >

                        <GraduationCap
                            class="h-7 w-7"
                        />

                    </div>


                    <h2
                        class="
                            mt-4
                            text-lg
                            font-bold
                            text-slate-800
                        "
                    >
                        No Programs Yet
                    </h2>


                    <p
                        class="
                            mx-auto
                            mt-2
                            max-w-md
                            text-sm
                            text-slate-500
                        "
                    >
                        Add Preschool, Primary,
                        Secondary or another program
                        to display on the homepage.
                    </p>


                    <button
                        type="button"
                        @click="addProgram"
                        class="
                            mt-5
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
                        "
                    >

                        <Plus
                            class="h-4 w-4"
                        />

                        Add First Program

                    </button>

                </div>


                <!-- ===================================================== -->
                <!-- PROGRAM LIST -->
                <!-- ===================================================== -->

                <div
                    v-else
                    class="space-y-6"
                >

                    <div
                        v-for="
                            (program, index)
                            in form.programs
                        "
                        :key="
                            program.id ?? index
                        "
                        class="
                            overflow-hidden
                            rounded-2xl
                            border
                            border-slate-200
                            bg-white
                            shadow-sm
                        "
                    >


                        <!-- ============================================= -->
                        <!-- PROGRAM HEADER -->
                        <!-- ============================================= -->

                        <div
                            class="
                                flex flex-col
                                gap-4
                                border-b
                                border-slate-100
                                bg-slate-50/60
                                px-6
                                py-4
                                sm:flex-row
                                sm:items-center
                                sm:justify-between
                            "
                        >

                            <div
                                class="
                                    flex
                                    items-center
                                    gap-3
                                "
                            >

                                <div
                                    class="
                                        flex h-10 w-10
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
                                                program.icon
                                            )
                                        "
                                        class="h-5 w-5"
                                    />

                                </div>


                                <div>

                                    <div
                                        class="
                                            flex
                                            items-center
                                            gap-2
                                        "
                                    >

                                        <h2
                                            class="
                                                font-bold
                                                text-slate-900
                                            "
                                        >
                                            {{
                                                program.title ||
                                                'New Program'
                                            }}
                                        </h2>


                                        <span
                                            class="
                                                rounded-full
                                                px-2
                                                py-0.5
                                                text-[10px]
                                                font-bold
                                                uppercase
                                            "
                                            :class="
                                                program.is_active
                                                    ? 'bg-emerald-50 text-emerald-600'
                                                    : 'bg-slate-200 text-slate-500'
                                            "
                                        >
                                            {{
                                                program.is_active
                                                    ? 'Active'
                                                    : 'Hidden'
                                            }}
                                        </span>

                                    </div>


                                    <p
                                        class="
                                            mt-0.5
                                            text-xs
                                            text-slate-400
                                        "
                                    >
                                        Program
                                        {{ index + 1 }}
                                    </p>

                                </div>

                            </div>


                            <!-- TOOLS -->

                            <div
                                class="
                                    flex
                                    items-center
                                    gap-1
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
                                        rounded-lg
                                        p-2
                                        text-slate-400
                                        hover:bg-white
                                        hover:text-slate-700
                                        disabled:opacity-30
                                    "
                                >

                                    <ChevronUp
                                        class="h-5 w-5"
                                    />

                                </button>


                                <button
                                    type="button"
                                    @click="
                                        moveDown(index)
                                    "
                                    :disabled="
                                        index ===
                                        form.programs.length - 1
                                    "
                                    class="
                                        rounded-lg
                                        p-2
                                        text-slate-400
                                        hover:bg-white
                                        hover:text-slate-700
                                        disabled:opacity-30
                                    "
                                >

                                    <ChevronDown
                                        class="h-5 w-5"
                                    />

                                </button>


                                <div
                                    class="
                                        mx-2
                                        h-5
                                        border-l
                                        border-slate-200
                                    "
                                />


                                <button
                                    type="button"
                                    @click="
                                        program.is_active =
                                            !program.is_active
                                    "
                                    class="
                                        rounded-lg
                                        p-2
                                        transition
                                    "
                                    :class="
                                        program.is_active
                                            ? 'text-emerald-500 hover:bg-emerald-50'
                                            : 'text-slate-400 hover:bg-slate-100'
                                    "
                                    :title="
                                        program.is_active
                                            ? 'Hide program'
                                            : 'Show program'
                                    "
                                >

                                    <Eye
                                        v-if="
                                            program.is_active
                                        "
                                        class="h-5 w-5"
                                    />

                                    <EyeOff
                                        v-else
                                        class="h-5 w-5"
                                    />

                                </button>


                                <button
                                    type="button"
                                    @click="
                                        removeProgram(
                                            index
                                        )
                                    "
                                    class="
                                        rounded-lg
                                        p-2
                                        text-slate-400
                                        transition
                                        hover:bg-red-50
                                        hover:text-red-500
                                    "
                                >

                                    <Trash2
                                        class="h-5 w-5"
                                    />

                                </button>

                            </div>

                        </div>


                        <!-- ============================================= -->
                        <!-- FORM -->
                        <!-- ============================================= -->

                        <div class="p-6">

                            <div
                                class="
                                    grid
                                    gap-6
                                    xl:grid-cols-12
                                "
                            >


                                <!-- ===================================== -->
                                <!-- FORM LEFT -->
                                <!-- ===================================== -->

                                <div
                                    class="
                                        space-y-5
                                        xl:col-span-8
                                    "
                                >


                                    <div
                                        class="
                                            grid
                                            gap-5
                                            md:grid-cols-2
                                        "
                                    >


                                        <!-- TITLE -->

                                        <div>

                                            <label
                                                class="
                                                    form-label
                                                "
                                            >
                                                Program Name

                                                <span
                                                    class="
                                                        text-red-500
                                                    "
                                                >
                                                    *
                                                </span>

                                            </label>


                                            <input
                                                v-model="
                                                    program.title
                                                "
                                                type="text"
                                                class="
                                                    form-input
                                                "
                                                placeholder="
                                                    Preschool
                                                "
                                            />


                                            <p
                                                v-if="
                                                    form.errors[
                                                        `programs.${index}.title`
                                                    ]
                                                "
                                                class="
                                                    form-error
                                                "
                                            >
                                                {{
                                                    form.errors[
                                                        `programs.${index}.title`
                                                    ]
                                                }}
                                            </p>

                                        </div>


                                        <!-- AGE -->

                                        <div>

                                            <label
                                                class="
                                                    form-label
                                                "
                                            >
                                                Age Range
                                            </label>


                                            <input
                                                v-model="
                                                    program.age_range
                                                "
                                                type="text"
                                                class="
                                                    form-input
                                                "
                                                placeholder="
                                                    2 - 6 Years Old
                                                "
                                            />

                                        </div>

                                    </div>


                                    <!-- DESCRIPTION -->

                                    <div>

                                        <label
                                            class="
                                                form-label
                                            "
                                        >
                                            Description
                                        </label>


                                        <textarea
                                            v-model="
                                                program.description
                                            "
                                            rows="4"
                                            class="
                                                form-input
                                                resize-none
                                            "
                                            placeholder="
                                                A safe and joyful environment for early learners.
                                            "
                                        />

                                    </div>


                                    <!-- BUTTON -->

                                    <div
                                        class="
                                            grid
                                            gap-5
                                            md:grid-cols-2
                                        "
                                    >

                                        <div>

                                            <label
                                                class="
                                                    form-label
                                                "
                                            >
                                                Button Text
                                            </label>

                                            <input
                                                v-model="
                                                    program.button_text
                                                "
                                                class="
                                                    form-input
                                                "
                                                placeholder="
                                                    Learn More
                                                "
                                            />

                                        </div>


                                        <div>

                                            <label
                                                class="
                                                    form-label
                                                "
                                            >
                                                Button URL
                                            </label>

                                            <input
                                                v-model="
                                                    program.button_url
                                                "
                                                class="
                                                    form-input
                                                "
                                                placeholder="
                                                    /program/preschool
                                                "
                                            />

                                        </div>

                                    </div>


                                    <!-- ICON -->

                                    <div>

                                        <label
                                            class="
                                                form-label
                                            "
                                        >
                                            Icon
                                        </label>


                                        <select
                                            v-model="
                                                program.icon
                                            "
                                            class="
                                                form-input
                                            "
                                        >

                                            <option
                                                value="baby"
                                            >
                                                Preschool
                                            </option>

                                            <option
                                                value="book-open"
                                            >
                                                Book
                                            </option>

                                            <option
                                                value="graduation-cap"
                                            >
                                                Graduation Cap
                                            </option>

                                            <option
                                                value="briefcase"
                                            >
                                                Briefcase
                                            </option>

                                        </select>

                                    </div>

                                </div>


                                <!-- ===================================== -->
                                <!-- PREVIEW -->
                                <!-- ===================================== -->

                                <div
                                    class="
                                        xl:col-span-4
                                    "
                                >

                                    <label
                                        class="
                                            form-label
                                        "
                                    >
                                        Preview
                                    </label>


                                    <div
                                        class="
                                            flex
                                            min-h-[280px]
                                            flex-col
                                            items-center
                                            justify-center
                                            rounded-2xl
                                            border
                                            border-slate-200
                                            bg-slate-50
                                            p-6
                                            text-center
                                        "
                                    >


                                        <!-- ICON -->

                                        <div
                                            class="
                                                flex h-16 w-16
                                                items-center
                                                justify-center
                                                rounded-full
                                                bg-orange-100
                                                text-orange-500
                                            "
                                        >

                                            <component
                                                :is="
                                                    getIcon(
                                                        program.icon
                                                    )
                                                "
                                                class="
                                                    h-7 w-7
                                                "
                                            />

                                        </div>


                                        <!-- TITLE -->

                                        <h3
                                            class="
                                                mt-5
                                                text-lg
                                                font-bold
                                                text-slate-900
                                            "
                                        >
                                            {{
                                                program.title ||
                                                'Program Name'
                                            }}
                                        </h3>


                                        <!-- AGE -->

                                        <p
                                            class="
                                                mt-2
                                                text-sm
                                                text-slate-500
                                            "
                                        >
                                            {{
                                                program.age_range ||
                                                'Age Range'
                                            }}
                                        </p>


                                        <!-- DESC -->

                                        <p
                                            class="
                                                mt-4
                                                line-clamp-3
                                                text-sm
                                                leading-6
                                                text-slate-500
                                            "
                                        >
                                            {{
                                                program.description ||
                                                'Program description will appear here.'
                                            }}
                                        </p>


                                        <!-- BUTTON -->

                                        <div
                                            v-if="
                                                program.button_text
                                            "
                                            class="
                                                mt-5
                                                flex
                                                items-center
                                                gap-2
                                                text-sm
                                                font-semibold
                                                text-orange-500
                                            "
                                        >

                                            {{
                                                program.button_text
                                            }}

                                            <ArrowRight
                                                class="
                                                    h-4 w-4
                                                "
                                            />

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- ADD ANOTHER -->

                    <button
                        type="button"
                        @click="addProgram"
                        class="
                            flex w-full
                            items-center
                            justify-center
                            gap-2
                            rounded-2xl
                            border-2
                            border-dashed
                            border-slate-200
                            bg-white
                            px-5
                            py-5
                            text-sm
                            font-semibold
                            text-slate-500
                            transition
                            hover:border-orange-300
                            hover:bg-orange-50
                            hover:text-orange-500
                        "
                    >

                        <Plus
                            class="h-5 w-5"
                        />

                        Add Another Program

                    </button>

                </div>


                <!-- ===================================================== -->
                <!-- SAVE BOTTOM -->
                <!-- ===================================================== -->

                <div
                    v-if="
                        form.programs.length
                    "
                    class="
                        mt-6
                        flex
                        items-center
                        justify-between
                        rounded-2xl
                        border
                        border-slate-200
                        bg-white
                        px-6
                        py-5
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
                            {{ form.programs.length }}
                            programs
                        </p>

                        <p
                            class="
                                mt-1
                                text-xs
                                text-slate-400
                            "
                        >
                            Programs are displayed
                            according to the order above.
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
                            px-5
                            py-2.5
                            text-sm
                            font-semibold
                            text-white
                            transition
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

<script setup>
import { ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
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
    Pencil,
    Trophy,
    Utensils,
    X,
    Save,
} from 'lucide-vue-next';

import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';

/*
|--------------------------------------------------------------------------
| Icon Mapping
|--------------------------------------------------------------------------
*/

const iconMap = {
    LayoutGrid,
    Building2,
    BookOpen,
    FlaskConical,
    Gamepad2,
    ImagePlus,
    Monitor,
    Music,
    Trophy,
    Utensils,
};

const props = defineProps({
    facilities: Object,

    filters: {
        type: Object,
        default: () => ({
            search: '',
            status: '',
        }),
    },
});

const search = ref(props.filters.search ?? '');
const status = ref(props.filters.status ?? '');

let timeout = null;

const applyFilter = () => {

    clearTimeout(timeout);

    timeout = setTimeout(() => {

        router.get(
            route('admin.facilities.index'),
            {
                search: search.value,
                status: status.value,
            },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
            }
        );

    }, 300);
};

watch(search, applyFilter);
watch(status, applyFilter);

const deleteFacility = (facility) => {

    if (
        !confirm(
            `Delete "${facility.title}"?`
        )
    ) {
        return;
    }

    router.delete(
        route(
            'admin.facilities.destroy',
            facility.id
        ),
        {
            preserveScroll: true,
        }
    );
};
</script>


<template>

    <Head title="Facilities" />

    <AdminLayout>

        <div class="min-h-screen bg-slate-50">

            <!-- HEADER -->

            <div class="border-b border-slate-200 bg-white">

                <div class="flex items-center justify-between px-6 py-5">

                    <div>

                        <h1 class="text-xl font-bold text-slate-900">
                            Facilities
                        </h1>

                        <p class="mt-1 text-sm text-slate-500">
                            Manage school facilities displayed on the website.
                        </p>

                    </div>

                    <Link
                        :href="
                            route(
                                'admin.edit.facilities.header'
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
                        :href="route('admin.facilities.create')"
                        class="rounded-lg bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-600"
                    >
                        + Add Facility
                    </Link>

                </div>

            </div>


            <div class="p-6">

                <div class="mx-auto max-w-7xl">

                    <!-- FILTER -->

                    <div class="mb-6 rounded-xl border border-slate-200 bg-white p-4">

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                            <div class="md:col-span-2">

                                <input
                                    v-model="search"
                                    type="text"
                                    placeholder="Search facility..."
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                />

                            </div>

                            <select
                                v-model="status"
                                class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                            >
                                <option value="">
                                    All Status
                                </option>

                                <option value="1">
                                    Active
                                </option>

                                <option value="0">
                                    Inactive
                                </option>

                            </select>

                        </div>

                    </div>


                    <!-- CARDS -->

                    <div
                        v-if="facilities.data.length"
                        class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3"
                    >

                        <div
                            v-for="facility in facilities.data"
                            :key="facility.id"
                            class="group overflow-hidden rounded-xl border border-slate-200 bg-white transition hover:-translate-y-0.5 hover:shadow-md"
                        >

                            <!-- IMAGE -->

                            <div class="relative aspect-[16/8] overflow-hidden bg-slate-100">

                                <img
                                    v-if="facility.image"
                                    :src="`/storage/${facility.image}`"
                                    :alt="facility.title"
                                    class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                />

                                <div
                                    v-else
                                    class="flex h-full items-center justify-center text-slate-300"
                                >
                                    No Image
                                </div>


                                <!-- STATUS -->

                                <span
                                    class="absolute right-3 top-3 rounded-full px-2.5 py-1 text-xs font-semibold"
                                    :class="
                                        facility.status
                                            ? 'bg-green-100 text-green-700'
                                            : 'bg-slate-100 text-slate-500'
                                    "
                                >
                                    {{
                                        facility.status
                                            ? 'Active'
                                            : 'Inactive'
                                    }}
                                </span>

                            </div>


                            <!-- CONTENT -->

                            <div class="p-5">

                                <div class="flex items-start justify-between gap-3">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-orange-50 text-orange-500">
                                            <component
                                                v-if="facility.icon && iconMap[facility.icon]"
                                                :is="iconMap[facility.icon]"
                                                :size="20"
                                            />

                                            <span v-else>
                                                ▦
                                            </span>
                                        </div>

                                        <h2 class="font-semibold text-slate-900">
                                            {{ facility.title }} 
                                        </h2>

                                    </div>

                                </div>


                                <p class="mt-4 line-clamp-3 text-sm leading-6 text-slate-500">
                                    {{ facility.description }}
                                </p>


                                <!-- ACTIONS -->

                                <div class="mt-5 flex items-center justify-between border-t border-slate-100 pt-4">

                                    <span class="text-xs text-slate-400">
                                        Order: {{ facility.sort_order }}
                                    </span>

                                    <div class="flex items-center gap-2">

                                        <Link
                                            :href="route(
                                                'admin.facilities.edit',
                                                facility.id
                                            )"
                                            class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50"
                                        >
                                            Edit
                                        </Link>

                                        <button
                                            type="button"
                                            @click="deleteFacility(facility)"
                                            class="rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-100"
                                        >
                                            Delete
                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- EMPTY -->

                    <div
                        v-else
                        class="rounded-xl border border-dashed border-slate-300 bg-white py-20 text-center"
                    >

                        <div class="text-4xl">
                            🏫
                        </div>

                        <h3 class="mt-4 font-semibold text-slate-800">
                            No facilities found
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Start by adding your first facility.
                        </p>

                        <Link
                            :href="route('admin.facilities.create')"
                            class="mt-5 inline-block rounded-lg bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white"
                        >
                            Add Facility
                        </Link>

                    </div>


                    <!-- PAGINATION -->

                    <div
                        v-if="facilities.links?.length > 3"
                        class="mt-6 flex justify-center gap-1"
                    >

                        <template
                            v-for="(link, index) in facilities.links"
                            :key="index"
                        >

                            <Link
                                v-if="link.url"
                                :href="link.url"
                                preserve-scroll
                                class="rounded-lg px-3 py-2 text-sm"
                                :class="
                                    link.active
                                        ? 'bg-orange-500 text-white'
                                        : 'bg-white text-slate-600 hover:bg-slate-100'
                                "
                                v-html="link.label"
                            />

                        </template>

                    </div>

                </div>

            </div>

        </div>

    </AdminLayout>

</template>
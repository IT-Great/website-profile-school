<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';

const props = defineProps({
    alumni: Object,

    filters: {
        type: Object,
        default: () => ({}),
    },
});

const search = ref(
    props.filters.search ?? ''
);

const status = ref(
    props.filters.status ?? ''
);

let timer = null;

watch(
    [search, status],
    () => {

        clearTimeout(timer);

        timer = setTimeout(() => {

            router.get(
                route('admin.alumnis.index'),
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

    }
);

const deleteAlumni = (id) => {

    if (!confirm('Delete this alumni?')) {
        return;
    }

    router.delete(
        route('admin.alumnis.destroy', id),
        {
            preserveScroll: true,
        }
    );
};
</script>

<template>

    <Head title="Alumni" />

    <AdminLayout>

        <div class="min-h-screen bg-slate-50">

            <div class="border-b border-slate-200 bg-white px-6 py-5">

                <div class="flex items-center justify-between">

                    <div>
                        <h1 class="text-xl font-bold text-slate-900">
                            Alumni
                        </h1>

                        <p class="mt-1 text-sm text-slate-500">
                            Manage alumni profiles and stories.
                        </p>
                    </div>

                    <Link
                        :href="route('admin.alumnis.create')"
                        class="rounded-lg bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-orange-600"
                    >
                        + Add Alumni
                    </Link>

                </div>

            </div>


            <div class="p-6">

                <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                    <!-- FILTER -->

                    <div class="flex flex-col gap-3 border-b border-slate-200 p-5 md:flex-row">

                        <input
                            v-model="search"
                            type="text"
                            placeholder="Search alumni..."
                            class="flex-1 rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-orange-500"
                        />

                        <select
                            v-model="status"
                            class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-orange-500"
                        >
                            <option value="">
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

                        <table class="w-full">

                            <thead class="bg-slate-50">

                                <tr class="border-b border-slate-200 text-left">

                                    <th class="px-5 py-4 text-xs font-bold uppercase text-slate-500">
                                        Alumni
                                    </th>

                                    <th class="px-5 py-4 text-xs font-bold uppercase text-slate-500">
                                        Position
                                    </th>

                                    <th class="px-5 py-4 text-xs font-bold uppercase text-slate-500">
                                        Company
                                    </th>

                                    <th class="px-5 py-4 text-xs font-bold uppercase text-slate-500">
                                        Order
                                    </th>

                                    <th class="px-5 py-4 text-xs font-bold uppercase text-slate-500">
                                        Status
                                    </th>

                                    <th class="px-5 py-4 text-right text-xs font-bold uppercase text-slate-500">
                                        Action
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr
                                    v-for="item in alumni.data"
                                    :key="item.id"
                                    class="border-b border-slate-100 last:border-0"
                                >

                                    <td class="px-5 py-4">

                                        <div class="flex items-center gap-3">

                                            <img
                                                v-if="item.photo"
                                                :src="`/storage/${item.photo}`"
                                                class="h-11 w-11 rounded-full object-cover"
                                            />

                                            <div
                                                v-else
                                                class="flex h-11 w-11 items-center justify-center rounded-full bg-orange-50 font-bold text-orange-500"
                                            >
                                                {{ item.name?.charAt(0) }}
                                            </div>

                                            <div>

                                                <p class="font-semibold text-slate-800">
                                                    {{ item.name }}
                                                </p>

                                                <p class="text-xs text-slate-400">
                                                    ID #{{ item.id }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>

                                    <td class="px-5 py-4 text-sm text-slate-600">
                                        {{ item.position || '-' }}
                                    </td>

                                    <td class="px-5 py-4 text-sm text-slate-600">
                                        {{ item.company || '-' }}
                                    </td>

                                    <td class="px-5 py-4 text-sm text-slate-600">
                                        {{ item.sort_order }}
                                    </td>

                                    <td class="px-5 py-4">

                                        <span
                                            class="rounded-full px-2.5 py-1 text-xs font-semibold"
                                            :class="item.is_active
                                                ? 'bg-green-50 text-green-600'
                                                : 'bg-slate-100 text-slate-500'"
                                        >
                                            {{
                                                item.is_active
                                                    ? 'Active'
                                                    : 'Inactive'
                                            }}
                                        </span>

                                    </td>

                                    <td class="px-5 py-4">

                                        <div class="flex justify-end gap-2">

                                            <Link
                                                :href="route('admin.alumnis.edit', item.id)"
                                                class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50"
                                            >
                                                Edit
                                            </Link>

                                            <button
                                                type="button"
                                                @click="deleteAlumni(item.id)"
                                                class="rounded-lg border border-red-100 px-3 py-2 text-xs font-semibold text-red-500 hover:bg-red-50"
                                            >
                                                Delete
                                            </button>

                                        </div>

                                    </td>

                                </tr>

                                <tr v-if="!alumni.data.length">

                                    <td
                                        colspan="6"
                                        class="px-5 py-12 text-center text-sm text-slate-400"
                                    >
                                        No alumni found.
                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </AdminLayout>

</template>
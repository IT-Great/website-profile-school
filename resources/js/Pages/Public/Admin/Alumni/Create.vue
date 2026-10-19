<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';

const createItem = () => ({
    name: '',
    position: '',
    company: '',
    testimonial: '',
    photo: null,
    is_active: true,
});

const alumni = ref([
    createItem(),
]);

const previews = ref([
    null,
]);

const addAlumni = () => {
    alumni.value.push(createItem());
    previews.value.push(null);
};

const removeAlumni = (index) => {

    if (alumni.value.length === 1) {
        return;
    }

    alumni.value.splice(index, 1);
    previews.value.splice(index, 1);
};

const handlePhoto = (event, index) => {

    const file = event.target.files[0];

    if (!file) {
        return;
    }

    alumni.value[index].photo = file;

    previews.value[index] =
        URL.createObjectURL(file);
};

const form = useForm({
    alumni: [],
});

const submit = () => {

    form.alumni = alumni.value;

    form.post(
        route('admin.alumnis.store'),
        {
            forceFormData: true,
            preserveScroll: true,
        }
    );
};

</script>

<template>

    <Head title="Add Alumni" />

    <AdminLayout>

        <div class="min-h-screen bg-slate-50">

            <!-- HEADER -->

            <div class="border-b border-slate-200 bg-white">

                <div class="flex items-center justify-between px-6 py-5">

                    <div>

                        <h1 class="text-xl font-bold text-slate-900">
                            Add Alumni
                        </h1>

                        <p class="mt-1 text-sm text-slate-500">
                            Add multiple alumni profiles at once.
                        </p>

                    </div>

                    <div class="flex items-center gap-3">

                        <Link
                            :href="route('admin.alumnis.index')"
                            class="rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50"
                        >
                            Cancel
                        </Link>

                        <button
                            type="button"
                            @click="submit"
                            :disabled="form.processing"
                            class="rounded-lg bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-orange-600 disabled:opacity-50"
                        >
                            {{
                                form.processing
                                    ? 'Saving...'
                                    : `Save ${alumni.length} Alumni`
                            }}
                        </button>

                    </div>

                </div>

            </div>


            <!-- CONTENT -->

            <div class="p-6">

                <div class="mx-auto max-w-6xl space-y-5">

                    <!-- ALUMNI ITEMS -->

                    <div
                        v-for="(item, index) in alumni"
                        :key="index"
                        class="overflow-hidden rounded-xl border border-slate-200 bg-white"
                    >

                        <!-- CARD HEADER -->

                        <div class="flex items-center justify-between border-b border-slate-200 bg-slate-50 px-5 py-4">

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-9 w-9 items-center justify-center rounded-lg bg-orange-100 text-sm font-bold text-orange-600"
                                >
                                    {{ index + 1 }}
                                </div>

                                <div>

                                    <h2 class="text-sm font-bold text-slate-800">
                                        Alumni #{{ index + 1 }}
                                    </h2>

                                    <p class="text-xs text-slate-500">
                                        Alumni profile information
                                    </p>

                                </div>

                            </div>

                            <button
                                v-if="alumni.length > 1"
                                type="button"
                                @click="removeAlumni(index)"
                                class="rounded-lg px-3 py-2 text-xs font-semibold text-red-500 hover:bg-red-50"
                            >
                                Remove
                            </button>

                        </div>


                        <!-- BODY -->

                        <div class="grid grid-cols-1 gap-6 p-6 lg:grid-cols-4">

                            <!-- PHOTO -->

                            <div>

                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Photo
                                </label>

                                <input
                                    :id="`photo-${index}`"
                                    type="file"
                                    accept="image/jpeg,image/png,image/webp"
                                    class="hidden"
                                    @change="handlePhoto($event, index)"
                                />

                                <label
                                    :for="`photo-${index}`"
                                    class="flex aspect-square cursor-pointer items-center justify-center overflow-hidden rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 hover:border-orange-300 hover:bg-orange-50"
                                >

                                    <img
                                        v-if="previews[index]"
                                        :src="previews[index]"
                                        class="h-full w-full object-cover"
                                        alt="Alumni"
                                    />

                                    <div
                                        v-else
                                        class="text-center"
                                    >

                                        <div class="text-3xl text-orange-400">
                                            ↑
                                        </div>

                                        <p class="mt-2 text-xs font-semibold text-slate-600">
                                            Upload Photo
                                        </p>

                                        <p class="mt-1 text-[11px] text-slate-400">
                                            JPG, PNG, WEBP
                                        </p>

                                    </div>

                                </label>

                            </div>


                            <!-- INFORMATION -->

                            <div class="space-y-4 lg:col-span-3">

                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                                    <!-- NAME -->

                                    <div>

                                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                                            Name
                                        </label>

                                        <input
                                            v-model="item.name"
                                            type="text"
                                            placeholder="Shivani Bangia"
                                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                        />

                                    </div>


                                    <!-- POSITION -->

                                    <div>

                                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                                            Position
                                        </label>

                                        <input
                                            v-model="item.position"
                                            type="text"
                                            placeholder="Software Engineer"
                                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                        />

                                    </div>


                                    <!-- COMPANY -->

                                    <div>

                                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                                            Company
                                        </label>

                                        <input
                                            v-model="item.company"
                                            type="text"
                                            placeholder="Google"
                                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                        />

                                    </div>


                                    <!-- STATUS -->

                                    <div>

                                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                                            Status
                                        </label>

                                        <label class="flex h-[42px] cursor-pointer items-center gap-3 rounded-lg border border-slate-300 px-4">

                                            <input
                                                v-model="item.is_active"
                                                type="checkbox"
                                                class="h-4 w-4 rounded border-slate-300 text-orange-500 focus:ring-orange-500"
                                            />

                                            <span class="text-sm text-slate-700">
                                                Active
                                            </span>

                                        </label>

                                    </div>

                                </div>


                                <!-- TESTIMONIAL -->

                                <div>

                                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                                        Testimonial / Story
                                    </label>

                                    <textarea
                                        v-model="item.testimonial"
                                        rows="4"
                                        placeholder="Write the alumni story or testimonial..."
                                        class="w-full resize-none rounded-lg border border-slate-300 px-4 py-3 text-sm leading-6 outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                                    ></textarea>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- ADD MORE -->

                    <button
                        type="button"
                        @click="addAlumni"
                        class="flex w-full items-center justify-center gap-2 rounded-xl border-2 border-dashed border-orange-200 bg-orange-50/40 py-5 text-sm font-semibold text-orange-600 transition hover:border-orange-400 hover:bg-orange-50"
                    >

                        <span class="text-xl">
                            +
                        </span>

                        Add Another Alumni

                    </button>


                    <!-- BOTTOM SAVE -->

                    <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-white p-5">

                        <div>

                            <p class="text-sm font-semibold text-slate-800">
                                {{ alumni.length }} alumni ready to save
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                All alumni will be created together.
                            </p>

                        </div>

                        <button
                            type="button"
                            @click="submit"
                            :disabled="form.processing"
                            class="rounded-lg bg-orange-500 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-600 disabled:opacity-50"
                        >
                            Save All Alumni
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </AdminLayout>

</template>
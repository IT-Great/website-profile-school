
<script setup>
import { Head } from '@inertiajs/vue3'
import Form from './Form.vue'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'

defineProps({
    categories: {
        type: Array,
        default: () => ['Academic', 'Sports', 'Arts', 'Technology', 'Other'],
    },
    levels: {
        type: Array,
        default: () => ['School', 'City', 'Regional', 'National', 'International'],
    },
})
</script>

<template>
    <Head title="Tambah Prestasi Siswa" />
    <AdminLayout>
        <Form
            :categories="categories"
            :levels="levels"
        />
    </AdminLayout>
</template>

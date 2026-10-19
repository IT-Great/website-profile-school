<script setup>
import { ref} from 'vue'
import { usePage } from '@inertiajs/vue3'

import Sidebar from '@/Layouts/Admin/SidebarAdmin.vue'
import Navbar from '@/Layouts/Admin/NavbarAdmin.vue'

const page = usePage()

const sidebarCollapsed = ref(false)
</script>

<template>
    <div class="min-h-screen bg-slate-50">

        <Sidebar
            :collapsed="sidebarCollapsed"
        />

        <div
            class="transition-all duration-300"
            :class="sidebarCollapsed
                ? 'lg:ml-[88px]'
                : 'lg:ml-[260px]'"
        >

            <Navbar
                @toggle-sidebar="sidebarCollapsed = !sidebarCollapsed"
            />

            <main class="p-5 md:p-7">
                <slot />
            </main>

        </div>

    </div>
</template>
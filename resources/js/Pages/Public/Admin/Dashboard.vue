<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import { Head } from '@inertiajs/vue3'
import VueApexCharts from 'vue3-apexcharts'
import { Link } from '@inertiajs/vue3'

import {
    FileText,
    CalendarDays,
    Images,
    Mail,
    Users,
    ArrowRight,
    Plus,
    Settings,
    FolderOpen,
    Globe2,
    House,
    GraduationCap,
} from 'lucide-vue-next'


// ==========================================================
// STATISTICS
// ==========================================================

const statistics = [
    {
        title: 'TOTAL POSTS',
        value: 48,
        action: 'View all posts',
        icon: FileText,
        iconClass: 'text-orange-500',
        bgClass: 'bg-orange-100',
    },
    {
        title: 'TOTAL EVENTS',
        value: 15,
        action: 'View all events',
        icon: CalendarDays,
        iconClass: 'text-green-600',
        bgClass: 'bg-green-100',
    },
    {
        title: 'TOTAL GALLERIES',
        value: 24,
        action: 'View all galleries',
        icon: Images,
        iconClass: 'text-blue-600',
        bgClass: 'bg-blue-100',
    },
    {
        title: 'TOTAL MESSAGES',
        value: 12,
        action: 'View all messages',
        icon: Mail,
        iconClass: 'text-purple-600',
        bgClass: 'bg-purple-100',
    },
    {
        title: 'TOTAL USERS',
        value: 28,
        action: 'View all users',
        icon: Users,
        iconClass: 'text-amber-500',
        bgClass: 'bg-amber-100',
    },
]


// ==========================================================
// TRAFFIC CHART
// ==========================================================

const trafficSeries = [
    {
        name: 'Visitors',
        data: [
            850,
            1250,
            1650,
            2000,
            2650,
            3400,
            2700,
            2350,
            2400,
            2900,
            2850,
            2050,
        ],
    },
]

const trafficOptions = {
    chart: {
        type: 'area',
        toolbar: {
            show: false,
        },
        zoom: {
            enabled: false,
        },
    },

    dataLabels: {
        enabled: false,
    },

    stroke: {
        curve: 'smooth',
        width: 2,
    },

    colors: [
        '#ff6b00',
    ],

    fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.28,
            opacityTo: 0.02,
            stops: [
                0,
                100,
            ],
        },
    },

    grid: {
        borderColor: '#eeeeee',
        strokeDashArray: 4,
    },

    xaxis: {
        categories: [
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec',
            'Jan',
            'Feb',
            'Mar',
            'Apr',
        ],
    },

    yaxis: {
        labels: {
            formatter(value) {
                if (value >= 1000) {
                    return `${value / 1000}K`
                }

                return value
            },
        },
    },

    tooltip: {
        y: {
            formatter(value) {
                return `${value.toLocaleString()} visitors`
            },
        },
    },
}


// ==========================================================
// RECENT POSTS
// ==========================================================

const recentPosts = [
    {
        title: 'Christmas Celebration 2024 at Great Crystal School',
        category: 'Events',
        status: 'Published',
        date: '25 May 2024',
        image: '/storage/images/admin/posts/post-1.jpg',
    },
    {
        title: 'Science Fair 2024 – Young Innovators',
        category: 'Activity',
        status: 'Published',
        date: '23 May 2024',
        image: '/storage/images/admin/posts/post-2.jpg',
    },
    {
        title: 'Student Achievement in Mathematics Olympiad',
        category: 'Achievement',
        status: 'Published',
        date: '20 May 2024',
        image: '/storage/images/admin/posts/post-3.jpg',
    },
    {
        title: 'Field Trip to Surabaya Zoo',
        category: 'Activity',
        status: 'Published',
        date: '18 May 2024',
        image: '/storage/images/admin/posts/post-4.jpg',
    },
    {
        title: 'Great Crystal School Open House 2024',
        category: 'Events',
        status: 'Published',
        date: '15 May 2024',
        image: '/storage/images/admin/posts/post-5.jpg',
    },
]


// ==========================================================
// RECENT MESSAGES
// ==========================================================

const recentMessages = [
    {
        name: 'Budi Santoso',
        email: 'budi.santoso@gmail.com',
        subject: 'Information about Primary Program',
        message: 'Saya ingin mengetahui lebih lanjut tentang program Primary...',
        time: '10:30 AM',
        unread: true,
    },
    {
        name: 'Dewi Lestari',
        email: 'dewilestari@mail.com',
        subject: 'School Tour Inquiry',
        message: 'Apakah bisa menjadwalkan kunjungan sekolah untuk anak saya?',
        time: 'Yesterday',
        unread: true,
    },
    {
        name: 'Andi Wijaya',
        email: 'andiwijaya@mail.com',
        subject: 'Scholarship Information',
        message: 'Mohon informasi mengenai program beasiswa di sekolah ini.',
        time: '2 Days Ago',
        unread: false,
    },
    {
        name: 'Siti Nurhaliza',
        email: 'sitinurhaliza@mail.com',
        subject: 'Extracurricular Activities',
        message: 'Apa saja ekstrakurikuler yang tersedia di sekolah?',
        time: '3 Days Ago',
        unread: false,
    },
    {
        name: 'Rina Marlina',
        email: 'rinamarlina@mail.com',
        subject: 'Registration for New Student',
        message: 'Saya ingin mendaftar untuk tahun ajaran baru.',
        time: '4 Days Ago',
        unread: false,
    },
]


// ==========================================================
// QUICK ACTIONS
// ==========================================================

const quickActions = [
    {
        title: 'Add New Post',
        icon: FileText,
        iconClass: 'text-orange-500',
        href: '/dashboard-web-great-crystal-school/posts/create',
    },
    {
        title: 'Add New Event',
        icon: CalendarDays,
        iconClass: 'text-green-600',
        href: '/dashboard-web-great-crystal-school/events/create',
    },
    {
        title: 'Upload Gallery',
        icon: Images,
        iconClass: 'text-blue-600',
        href: '/dashboard-web-great-crystal-school/gallery/upload',
    },
    {
        title: 'Edit Homepage',
        icon: House,
        iconClass: 'text-purple-600',
        href: '/dashboard-web-great-crystal-school/homepage/edit',
    },
    {
        title: 'Manage Programs',
        icon: GraduationCap,
        iconClass: 'text-orange-500',
        href: '/dashboard-web-great-crystal-school/programs/manage',
    },
    {
        title: 'View Messages',
        icon: Mail,
        iconClass: 'text-amber-500',
        href: '/dashboard-web-great-crystal-school/messages',
    },
    {
        title: 'General Settings',
        icon: Settings,
        iconClass: 'text-indigo-500',
        href: '/dashboard-web-great-crystal-school/settings',
    },
    {
        title: 'Media Library',
        icon: FolderOpen,
        iconClass: 'text-orange-500',
        href: '/dashboard-web-great-crystal-school/media',
    },
    {
        title: 'View Website',
        icon: Globe2,
        iconClass: 'text-orange-600',
        href: '/',
    },
]
</script>


<template>
    <Head title="Dashboard" />
    
    <AdminLayout>

        <!-- ====================================================== -->
        <!-- PAGE HEADER -->
        <!-- ====================================================== -->

        <div
            class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6"
        >

            <div>

                <h1
                    class="text-2xl font-bold text-gray-900"
                >
                    Dashboard
                </h1>

                <p
                    class="text-sm text-gray-500 mt-1"
                >
                    Welcome back, Admin Sekolah!
                </p>

            </div>

            <div
                class="flex items-center gap-2 text-sm text-gray-500"
            >
                Home

                <span>
                    ›
                </span>

                <span class="text-gray-700">
                    Dashboard
                </span>
            </div>

        </div>


        <!-- ====================================================== -->
        <!-- STAT CARDS -->
        <!-- ====================================================== -->

        <div
            class="grid sm:grid-cols-2 xl:grid-cols-5 gap-4"
        >

            <div
                v-for="item in statistics"
                :key="item.title"
                class="bg-white rounded-xl border border-gray-200 p-5"
            >

                <div class="flex items-center gap-4">

                    <div
                        class="w-14 h-14 rounded-full flex items-center justify-center shrink-0"
                        :class="item.bgClass"
                    >

                        <component
                            :is="item.icon"
                            class="w-7 h-7"
                            :class="item.iconClass"
                        />

                    </div>


                    <div>

                        <p
                            class="text-xs text-gray-500"
                        >
                            {{ item.title }}
                        </p>

                        <p
                            class="text-2xl font-bold text-gray-900"
                        >
                            {{ item.value }}
                        </p>

                        <button
                            class="text-xs text-orange-500 hover:underline"
                        >
                            {{ item.action }}
                        </button>

                    </div>

                </div>

            </div>

        </div>


        <!-- ====================================================== -->
        <!-- TRAFFIC + POSTS -->
        <!-- ====================================================== -->

        <div
            class="grid xl:grid-cols-5 gap-5 mt-5"
        >

            <!-- Traffic -->

            <section
                class="xl:col-span-3 bg-white border border-gray-200 rounded-xl"
            >

                <div
                    class="flex items-center justify-between border-b border-gray-100 px-5 py-4"
                >

                    <div class="flex items-center gap-2">

                        <h2
                            class="font-semibold text-gray-900"
                        >
                            Website Traffic
                        </h2>

                        <span
                            class="text-xs text-gray-500"
                        >
                            (Last 12 Months)
                        </span>

                    </div>

                    <select
                        class="text-xs border border-gray-200 rounded-lg px-3 py-2"
                    >
                        <option>
                            Last 12 Months
                        </option>
                    </select>

                </div>


                <div class="p-4">

                    <VueApexCharts
                        type="area"
                        height="300"
                        :options="trafficOptions"
                        :series="trafficSeries"
                    />

                </div>

            </section>


            <!-- Recent Posts -->

            <section
                class="xl:col-span-2 bg-white border border-gray-200 rounded-xl"
            >

                <div
                    class="flex items-center justify-between border-b border-gray-100 px-5 py-4"
                >

                    <h2
                        class="font-semibold text-gray-900"
                    >
                        Recent Posts
                    </h2>

                    <button
                        class="text-xs border border-gray-200 rounded-lg px-3 py-2 hover:bg-gray-50"
                    >
                        View All
                    </button>

                </div>


                <div class="divide-y divide-gray-100">

                    <div
                        v-for="post in recentPosts"
                        :key="post.title"
                        class="flex items-center gap-3 px-5 py-3"
                    >

                        <img
                            :src="post.image"
                            class="w-20 h-12 object-cover rounded-lg shrink-0"
                        />


                        <div class="min-w-0 flex-1">

                            <p
                                class="text-sm font-medium text-gray-900 truncate"
                            >
                                {{ post.title }}
                            </p>

                            <span
                                class="inline-flex mt-1 text-[10px] px-2 py-1 rounded bg-orange-50 text-orange-500"
                            >
                                {{ post.category }}
                            </span>

                        </div>


                        <div
                            class="text-right shrink-0"
                        >

                            <p
                                class="text-xs text-green-600"
                            >
                                {{ post.status }}
                            </p>

                            <p
                                class="text-[11px] text-gray-500 mt-1"
                            >
                                {{ post.date }}
                            </p>

                        </div>

                    </div>

                </div>

            </section>

        </div>


        <!-- ====================================================== -->
        <!-- MESSAGES + QUICK ACTIONS -->
        <!-- ====================================================== -->

        <div
            class="grid xl:grid-cols-5 gap-5 mt-5"
        >

            <!-- Messages -->

            <section
                class="xl:col-span-3 bg-white border border-gray-200 rounded-xl"
            >

                <div
                    class="flex justify-between items-center border-b border-gray-100 px-5 py-4"
                >

                    <h2
                        class="font-semibold text-gray-900"
                    >
                        Recent Messages
                    </h2>

                    <button
                        class="text-xs border border-gray-200 rounded-lg px-3 py-2 hover:bg-gray-50"
                    >
                        View All
                    </button>

                </div>


                <div class="divide-y divide-gray-100">

                    <div
                        v-for="message in recentMessages"
                        :key="message.email"
                        class="grid md:grid-cols-[180px_1fr_100px] gap-4 px-5 py-3 items-center"
                    >

                        <div>

                            <p
                                class="text-sm font-medium text-gray-900"
                            >
                                {{ message.name }}
                            </p>

                            <p
                                class="text-xs text-gray-500"
                            >
                                {{ message.email }}
                            </p>

                        </div>


                        <div>

                            <p
                                class="text-sm font-medium text-gray-900"
                            >
                                {{ message.subject }}
                            </p>

                            <p
                                class="text-xs text-gray-500 truncate"
                            >
                                {{ message.message }}
                            </p>

                        </div>


                        <div class="text-right">

                            <p
                                class="text-xs text-gray-500"
                            >
                                {{ message.time }}
                            </p>

                            <span
                                v-if="message.unread"
                                class="inline-flex items-center gap-1 mt-2 text-xs text-orange-500"
                            >
                                <span
                                    class="w-2 h-2 rounded-full bg-orange-500"
                                ></span>

                                New
                            </span>

                            <span
                                v-else
                                class="inline-flex items-center gap-1 mt-2 text-xs text-green-600"
                            >
                                <span
                                    class="w-2 h-2 rounded-full bg-green-500"
                                ></span>

                                Read
                            </span>

                        </div>

                    </div>

                </div>

            </section>


            <!-- Quick Actions -->

            <section
                class="xl:col-span-2 bg-white border border-gray-200 rounded-xl"
            >

                <div
                    class="border-b border-gray-100 px-5 py-4"
                >
                    <h2
                        class="font-semibold text-gray-900"
                    >
                        Quick Actions
                    </h2>
                </div>


                <div
                    class="grid grid-cols-2 lg:grid-cols-3 gap-3 p-5"
                >

                    <Link
                        v-for="action in quickActions"
                        :key="action.title"
                        :href="action.href || '#'"
                        class="min-h-[110px] border border-gray-200 rounded-xl flex flex-col items-center justify-center gap-3 hover:border-orange-300 hover:shadow-sm transition"
                    >
                        <component
                            :is="action.icon"
                            class="w-7 h-7"
                            :class="action.iconClass"
                        />

                        <span class="text-xs text-center text-gray-700">
                            {{ action.title }}
                        </span>
                    </Link>

                </div>

            </section>

        </div>

    </AdminLayout>

</template>
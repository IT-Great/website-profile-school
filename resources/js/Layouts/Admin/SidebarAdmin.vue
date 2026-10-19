<script setup>
import { Link } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import {
    MapPin,
} from 'lucide-vue-next'

import {
    LayoutDashboard,
    Settings,
    House,
    FileText,
    GraduationCap,
    BookOpen,
    Building2,
    Images,
    CalendarDays,
    Trophy,
    UsersRound,
    UserRound,
    Image,
    Menu,
    FolderOpen,
    Mail,
    Users,
    ShieldCheck,
    History,
    ChevronRight,
    ChevronDown,
    CircleChevronLeft,
    Sparkles,
    ChartNoAxesColumnIncreasing,
    Info,
    Shapes,
    BadgeCheck,
    Megaphone,
    ContactRound,
} from 'lucide-vue-next'

const props = defineProps({
    collapsed: Boolean,
})

const openMenus = ref({
    homepage: true,
})

const websiteMenu = [
    {
        title: 'General Settings',
        icon: Settings,
        href: '/admin/settings',
    },

    {
        title: 'Homepage',
        icon: House,
        key: 'homepage',

        children: [
            {
                title: 'Hero',
                icon: Sparkles,
                href: route('admin.home.hero.edit'),
            },
            {
                title: 'Statistics',
                icon: ChartNoAxesColumnIncreasing,
                href: '/admin/home/statistics',
            },
            {
                title: 'About',
                icon: Info,
                href: route('admin.home.about.edit'),
            },
            {
                title: 'Programs',
                icon: Shapes,
                href: route('admin.home.programs.edit'),
            },
            {
                title: 'Why Choose Us',
                icon: BadgeCheck,
                href: route('admin.home.why-choose.edit'),
            },
            {
                title: 'Admission CTA',
                icon: Megaphone,
                href: route('admin.home.admission.edit'),
            },
            {
                title: 'Get in Touch',
                icon: MapPin,
                href: route('admin.home.get-in-touch.edit'),
            },
        ],
    },

    {
        title: 'Pages',
        icon: FileText,
        href: '/admin/pages',
    },
    {
        title: 'Programs',
        icon: GraduationCap,
        href: '/admin/programs',
    },
    {
        title: 'Curriculum',
        icon: BookOpen,
        href: route('admin.curriculum.index'),
    },
    {
        title: 'Facilities',
        icon: Building2,
        href: route('admin.facilities.index'),
    },
    {
        title: 'Galleries',
        icon: Images,
        href: route('admin.galleries.index'),
    },
    {
        title: 'News & Events',
        icon: CalendarDays,
        href: route('admin.posts.index'),
    },
    {
        title: 'Achievements',
        icon: Trophy,
        href: '',
    },
    {
        title: 'Alumni / Testimonials',
        icon: UsersRound,
        href: route('admin.alumnis.index'),
    },
    {
        title: 'Teachers',
        icon: UserRound,
        href: '/admin/teachers',
    },
    {
        title: 'Banners',
        icon: Image,
        href: '/admin/banners',
    },
    {
        title: 'Menus',
        icon: Menu,
        href: '/admin/menus',
    },
    {
        title: 'Media Library',
        icon: FolderOpen,
        href: '/admin/media',
    },
    {
        title: 'Contacts (Messages)',
        icon: Mail,
        href: '/admin/messages',
    },
]

const systemMenu = [
    {
        title: 'Users',
        icon: Users,
        href: '/admin/users',
    },
    {
        title: 'Roles & Permissions',
        icon: ShieldCheck,
        href: '/admin/roles',
    },
    {
        title: 'Activity Log',
        icon: History,
        href: '/admin/activity-log',
    },
]

const toggleMenu = (key) => {
    openMenus.value[key] = !openMenus.value[key]
}

const isActive = (href) => {
    if (!href) return false

    return $page.url === href
}
</script>

<template>
    <aside
        class="fixed left-0 top-0 z-50 hidden h-screen flex-col bg-[#211d1d] text-white transition-all duration-300 lg:flex"
        :class="collapsed ? 'w-[88px]' : 'w-[260px]'"
    >

        <!-- Logo -->
        <div
            class="flex h-20 items-center border-b border-white/10 px-5"
        >
            <img
                src="/storage/images/logo-school.png"
                class="h-10 object-contain"
                :class="collapsed ? 'w-10' : 'max-w-[190px]'"
            />
        </div>


        <!-- Menu -->
        <div class="flex-1 overflow-y-auto px-3 py-4">

            <!-- Dashboard -->
            <Link
                href="/dashboard"
                class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition"
                :class="
                    $page.url === '/dashboard'
                        ? 'bg-orange-500 text-white'
                        : 'text-gray-200 hover:bg-white/10'
                "
            >
                <LayoutDashboard class="h-5 w-5 shrink-0" />

                <span v-if="!collapsed">
                    Dashboard
                </span>
            </Link>


            <!-- Website Management -->
            <p
                v-if="!collapsed"
                class="px-3 pb-2 pt-6 text-[11px] uppercase tracking-wide text-gray-400"
            >
                Website Management
            </p>


            <div class="space-y-1">

                <template
                    v-for="item in websiteMenu"
                    :key="item.title"
                >

                    <!-- ========================================= -->
                    <!-- MENU WITHOUT CHILDREN -->
                    <!-- ========================================= -->

                    <Link
                        v-if="!item.children"
                        :href="item.href"
                        :class="[
                            'group flex items-center justify-between rounded-lg px-4 py-2.5 text-sm transition',

                            $page.url === item.href
                                ? 'bg-yellow-200 text-gray-900'
                                : 'text-gray-200 hover:bg-white/10'
                        ]"
                    >

                        <div class="flex items-center gap-3">

                            <component
                                :is="item.icon"
                                class="h-5 w-5 shrink-0"
                            />

                            <span v-if="!collapsed">
                                {{ item.title }}
                            </span>

                        </div>

                        <ChevronRight
                            v-if="!collapsed"
                            class="h-4 w-4"
                        />

                    </Link>


                    <!-- ========================================= -->
                    <!-- MENU WITH CHILDREN -->
                    <!-- ========================================= -->

                    <div v-else>

                        <!-- Parent -->
                        <button
                            type="button"
                            @click="toggleMenu(item.key)"
                            :class="[
                                'flex w-full items-center justify-between rounded-lg px-4 py-2.5 text-sm transition',

                                item.children.some(
                                    child => $page.url === child.href
                                )
                                    ? 'bg-white/10 text-white'
                                    : 'text-gray-200 hover:bg-white/10'
                            ]"
                        >

                            <div class="flex items-center gap-3">

                                <component
                                    :is="item.icon"
                                    class="h-5 w-5 shrink-0"
                                />

                                <span v-if="!collapsed">
                                    {{ item.title }}
                                </span>

                            </div>


                            <ChevronDown
                                v-if="!collapsed"
                                class="h-4 w-4 transition-transform duration-200"
                                :class="
                                    openMenus[item.key]
                                        ? 'rotate-180'
                                        : ''
                                "
                            />

                        </button>


                        <!-- Children -->
                        <div
                            v-if="
                                !collapsed &&
                                openMenus[item.key]
                            "
                            class="ml-5 mt-1 space-y-1 border-l border-white/10 pl-3"
                        >

                            <Link
                                v-for="child in item.children"
                                :key="child.title"
                                :href="child.href"
                                :class="[
                                    'group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition',

                                    $page.url === child.href
                                        ? 'bg-yellow-200 font-medium text-gray-900'
                                        : 'text-gray-400 hover:bg-white/10 hover:text-white'
                                ]"
                            >

                                <component
                                    :is="child.icon"
                                    class="h-4 w-4 shrink-0"
                                />

                                <span>
                                    {{ child.title }}
                                </span>

                            </Link>

                        </div>

                    </div>

                </template>

            </div>


            <!-- System -->
            <p
                v-if="!collapsed"
                class="px-3 pb-2 pt-6 text-[11px] uppercase tracking-wide text-gray-400"
            >
                System
            </p>


            <div class="space-y-1">

                <Link
                    v-for="item in systemMenu"
                    :key="item.title"
                    :href="item.href"
                    :class="[
                        'flex items-center justify-between rounded-lg px-4 py-2.5 text-sm transition',

                        $page.url === item.href
                            ? 'bg-yellow-200 text-gray-900'
                            : 'text-gray-200 hover:bg-white/10'
                    ]"
                >

                    <div class="flex items-center gap-3">

                        <component
                            :is="item.icon"
                            class="h-5 w-5 shrink-0"
                        />

                        <span v-if="!collapsed">
                            {{ item.title }}
                        </span>

                    </div>

                    <ChevronRight
                        v-if="!collapsed"
                        class="h-4 w-4"
                    />

                </Link>

            </div>

        </div>


        <!-- Collapse -->
        <button
            class="flex items-center gap-3 border-t border-white/10 px-5 py-5 text-sm text-gray-300 transition hover:text-white"
        >
            <CircleChevronLeft
                class="h-5 w-5"
            />

            <span v-if="!collapsed">
                Collapse Menu
            </span>
        </button>

    </aside>
</template>
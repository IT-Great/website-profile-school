<script setup>
import { Link } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue'
import {
    ChevronDown,
    Menu,
    X,
    ArrowRight,
} from 'lucide-vue-next'

const isScrolled = ref(false)
const mobileMenu = ref(false)
const mobileDropdown = ref(null)

const menus = [
    {
        title: 'Home',
        href: '/',
    },
    {
        title: 'About',
        children: [
            { title: 'About Us', href: '/about' },
            { title: 'Curriculum', href: '/curriculum' },
            { title: 'Facility', href: '/facility' },
            // { title: 'History', href: '/history' },
            {
                title: 'School & Student Achievements',
                href: '/achievements',
            },
            {
                title: 'Vision & Mission',
                href: '/vision-mission',
            },
            { title: 'Alumni', href: '/alumni' },
        ],
    },
    {
        title: 'Programs',
        children: [
            {
                title: 'Preschool',
                href: '/programs/preschool',
            },
            {
                title: 'Primary',
                href: '/programs/primary',
            },
            {
                title: 'Secondary',
                href: '/programs/secondary',
            },
        ],
    },
    {
        title: 'News',
        href: '/news',
    },
    {
        title: 'Gallery',
        href: '/gallery',
    },
    {
        title: 'Contact',
        href: '/contact',
    },
]

const handleScroll = () => {
    isScrolled.value = window.scrollY > 30
}

const toggleMobileMenu = () => {
    mobileMenu.value = !mobileMenu.value

    if (!mobileMenu.value) {
        mobileDropdown.value = null
    }
}

const toggleMobileDropdown = (title) => {
    mobileDropdown.value =
        mobileDropdown.value === title
            ? null
            : title
}

const closeMobileMenu = () => {
    mobileMenu.value = false
    mobileDropdown.value = null
}

onMounted(() => {
    handleScroll()

    window.addEventListener(
        'scroll',
        handleScroll,
        {
            passive: true,
        }
    )
})

onUnmounted(() => {
    window.removeEventListener(
        'scroll',
        handleScroll
    )
})
</script>


<template>

    <header
        class="fixed left-0 top-0 z-50 w-full transition-all duration-300"
        :class="
            isScrolled
                ? 'bg-white/95 shadow-lg backdrop-blur-md'
                : 'bg-transparent'
        "
    >

        <!-- ===================================================== -->
        <!-- NAVBAR -->
        <!-- ===================================================== -->

        <div
            class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 xl:px-10"
        >

            <div
                class="flex h-[72px] items-center justify-between gap-4 sm:h-20"
            >

                <!-- ================================================= -->
                <!-- LOGO -->
                <!-- ================================================= -->

                <Link
                    href="/"
                    class="flex min-w-0 shrink-0 items-center"
                    @click="closeMobileMenu"
                >

                    <img
                        src="/storage/images/logo-school.png"
                        alt="Great Crystal School and Course Center"
                        class="h-auto w-48 object-contain sm:w-56 md:w-60 xl:w-64"
                    />

                </Link>


                <!-- ================================================= -->
                <!-- DESKTOP NAVIGATION -->
                <!-- xl = desktop only -->
                <!-- ================================================= -->

                <nav
                    class="hidden items-center gap-5 xl:flex 2xl:gap-7"
                >

                    <div
                        v-for="menu in menus"
                        :key="menu.title"
                        class="group relative"
                    >

                        <!-- No Dropdown -->

                        <Link
                            v-if="!menu.children"
                            :href="menu.href"
                            class="flex items-center whitespace-nowrap text-sm font-medium transition"
                            :class="
                                isScrolled
                                    ? 'text-slate-700 hover:text-orange-500'
                                    : 'text-white hover:text-orange-300'
                            "
                        >

                            {{ menu.title }}

                        </Link>


                        <!-- Has Dropdown -->

                        <button
                            v-else
                            type="button"
                            class="flex items-center gap-1 whitespace-nowrap text-sm font-medium transition"
                            :class="
                                isScrolled
                                    ? 'text-slate-700 hover:text-orange-500'
                                    : 'text-white hover:text-orange-300'
                            "
                        >

                            {{ menu.title }}

                            <ChevronDown
                                :size="15"
                                class="transition-transform duration-200 group-hover:rotate-180"
                            />

                        </button>


                        <!-- Desktop Dropdown -->

                        <div
                            class="invisible absolute left-1/2 top-full z-50 w-72 -translate-x-1/2 pt-4 opacity-0 transition-all duration-200 group-hover:visible group-hover:opacity-100"
                        >

                            <div
                                class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-2xl"
                            >

                                <Link
                                    v-for="child in menu.children"
                                    :key="child.title"
                                    :href="child.href"
                                    class="block border-b border-slate-100 px-5 py-3.5 text-sm text-slate-700 transition last:border-0 hover:bg-orange-50 hover:pl-6 hover:text-orange-500"
                                >

                                    {{ child.title }}

                                </Link>

                            </div>

                        </div>

                    </div>

                </nav>


                <!-- ================================================= -->
                <!-- DESKTOP ENROLL -->
                <!-- ================================================= -->

                <Link
                    href="/enrollment"
                    class="hidden shrink-0 items-center gap-2 rounded-full bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600 xl:flex"
                >

                    Enroll Now

                    <ArrowRight :size="16" />

                </Link>


                <!-- ================================================= -->
                <!-- MOBILE / TABLET HAMBURGER -->
                <!-- ================================================= -->

                <button
                    type="button"
                    @click="toggleMobileMenu"
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl transition xl:hidden"
                    :class="
                        isScrolled
                            ? 'text-slate-800 hover:bg-slate-100'
                            : 'text-white hover:bg-white/10'
                    "
                    :aria-expanded="mobileMenu"
                    aria-label="Toggle navigation menu"
                >

                    <X
                        v-if="mobileMenu"
                        :size="25"
                    />

                    <Menu
                        v-else
                        :size="26"
                    />

                </button>

            </div>

        </div>


        <!-- ===================================================== -->
        <!-- MOBILE / TABLET MENU -->
        <!-- ===================================================== -->

        <div
            v-if="mobileMenu"
            class="border-t border-slate-200 bg-white shadow-xl xl:hidden"
        >

            <div
                class="mx-auto max-h-[calc(100vh-72px)] w-full max-w-7xl overflow-y-auto px-4 py-4 sm:px-6 lg:px-8"
            >

                <nav class="space-y-1">

                    <template
                        v-for="menu in menus"
                        :key="menu.title"
                    >

                        <!-- ============================== -->
                        <!-- Normal Link -->
                        <!-- ============================== -->

                        <Link
                            v-if="!menu.children"
                            :href="menu.href"
                            @click="closeMobileMenu"
                            class="flex items-center justify-between rounded-xl px-4 py-3.5 text-sm font-medium text-slate-700 transition hover:bg-orange-50 hover:text-orange-500"
                        >

                            <span>
                                {{ menu.title }}
                            </span>

                        </Link>


                        <!-- ============================== -->
                        <!-- Mobile Dropdown -->
                        <!-- ============================== -->

                        <div v-else>

                            <button
                                type="button"
                                @click="toggleMobileDropdown(menu.title)"
                                class="flex w-full items-center justify-between rounded-xl px-4 py-3.5 text-left text-sm font-medium text-slate-700 transition hover:bg-orange-50 hover:text-orange-500"
                                :aria-expanded="
                                    mobileDropdown === menu.title
                                "
                            >

                                <span>
                                    {{ menu.title }}
                                </span>

                                <ChevronDown
                                    :size="18"
                                    class="transition-transform duration-200"
                                    :class="
                                        mobileDropdown === menu.title
                                            ? 'rotate-180 text-orange-500'
                                            : ''
                                    "
                                />

                            </button>


                            <!-- Children -->

                            <div
                                v-if="mobileDropdown === menu.title"
                                class="mb-2 ml-3 border-l-2 border-orange-100 pl-3"
                            >

                                <Link
                                    v-for="child in menu.children"
                                    :key="child.title"
                                    :href="child.href"
                                    @click="closeMobileMenu"
                                    class="block rounded-lg px-4 py-3 text-sm text-slate-600 transition hover:bg-orange-50 hover:text-orange-500"
                                >

                                    {{ child.title }}

                                </Link>

                            </div>

                        </div>

                    </template>

                </nav>


                <!-- ========================================= -->
                <!-- MOBILE ENROLL -->
                <!-- ========================================= -->

                <div class="mt-4 border-t border-slate-100 pt-4">

                    <Link
                        href="/enrollment"
                        @click="closeMobileMenu"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-orange-500 px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-orange-600"
                    >

                        Enroll Now

                        <ArrowRight :size="17" />

                    </Link>

                </div>

            </div>

        </div>

    </header>

</template>
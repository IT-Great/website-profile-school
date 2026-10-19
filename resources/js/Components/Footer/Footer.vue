<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import {
    Facebook,
    Instagram,
    Youtube,
    MessageCircle,
    Menu,
    X,
    ChevronDown,
    ArrowRight,
} from 'lucide-vue-next'

const footerMenuOpen = ref(false)

const quickLinks = [
    { title: 'About Us', href: '/about' },
    { title: 'Programs', href: '/programs' },
    { title: 'News', href: '/news' },
    { title: 'Gallery', href: '/gallery' },
    { title: 'Contact', href: '/contact' },
]

const programs = [
    { title: 'Preschool', href: '/programs/preschool' },
    { title: 'Primary School', href: '/programs/primary' },
    { title: 'Secondary School', href: '/programs/secondary' },
]

const socialLinks = [
    {
        title: 'Facebook',
        href: 'https://www.facebook.com/greatsch.id/',
        icon: Facebook,
    },
    {
        title: 'Instagram',
        href: 'https://www.instagram.com/greatsch.id/',
        icon: Instagram,
    },
    {
        title: 'YouTube',
        href: 'https://www.youtube.com/@GreatCrystalSchool',
        icon: Youtube,
    },
    {
        title: 'WhatsApp',
        href: '#',
        icon: MessageCircle,
    },
]
</script>

<template>
    <footer class="border-t border-gray-100 bg-white text-gray-600">

        <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 xl:px-10">

            <!-- ================================================= -->
            <!-- MOBILE & TABLET HEADER -->
            <!-- ================================================= -->

            <div class="py-8 xl:hidden">

                <div class="flex items-center justify-between gap-4">

                    <!-- Logo -->
                    <Link
                        href="/"
                        class="min-w-0"
                        aria-label="Great Crystal School Home"
                    >
                        <img
                            src="/storage/images/logo-school.png"
                            alt="Great Crystal School and Course Center"
                            class="h-auto w-44 object-contain sm:w-56"
                        />
                    </Link>

                    <!-- Hamburger -->
                    <!-- <button
                        type="button"
                        @click="footerMenuOpen = !footerMenuOpen"
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-gray-200 text-gray-700 transition hover:border-orange-300 hover:bg-orange-50 hover:text-orange-500"
                        :aria-expanded="footerMenuOpen"
                        aria-label="Toggle footer menu"
                    >
                        <X
                            v-if="footerMenuOpen"
                            :size="23"
                        />

                        <Menu
                            v-else
                            :size="23"
                        />
                    </button> -->

                </div>

                <!-- Description -->
                <p class="mt-5 max-w-md text-sm leading-7 text-gray-500">
                    Great Crystal School and Course Center is committed to
                    excellence in education, character building, and preparing
                    students for a brighter future.
                </p>

                <!-- Toggle label -->
                <button
                    type="button"
                    @click="footerMenuOpen = !footerMenuOpen"
                    class="mt-6 flex w-full items-center justify-between rounded-xl border border-gray-200 px-4 py-3.5 text-sm font-semibold text-gray-800 transition hover:border-orange-200 hover:bg-orange-50"
                    :aria-expanded="footerMenuOpen"
                >
                    <span>
                        Explore More
                    </span>

                    <ChevronDown
                        :size="18"
                        class="transition-transform duration-200"
                        :class="footerMenuOpen ? 'rotate-180 text-orange-500' : ''"
                    />
                </button>

            </div>


            <!-- ================================================= -->
            <!-- MOBILE & TABLET COLLAPSIBLE MENU -->
            <!-- ================================================= -->

            <div
                v-if="footerMenuOpen"
                class="grid grid-cols-1 gap-8 border-t border-gray-100 py-8 sm:grid-cols-2 lg:grid-cols-3 xl:hidden"
            >

                <!-- Quick Links -->
                <div>
                    <h3 class="font-semibold text-gray-900">
                        Quick Links
                    </h3>

                    <ul class="mt-4 space-y-3 text-sm">

                        <li
                            v-for="item in quickLinks"
                            :key="item.href"
                        >
                            <Link
                                :href="item.href"
                                class="inline-flex items-center gap-2 transition hover:text-orange-500"
                            >
                                {{ item.title }}
                                <ArrowRight
                                    :size="13"
                                    class="opacity-0 transition group-hover:opacity-100"
                                />
                            </Link>
                        </li>

                    </ul>
                </div>


                <!-- Programs -->
                <div>
                    <h3 class="font-semibold text-gray-900">
                        Programs
                    </h3>

                    <ul class="mt-4 space-y-3 text-sm">

                        <li
                            v-for="item in programs"
                            :key="item.href"
                        >
                            <Link
                                :href="item.href"
                                class="transition hover:text-orange-500"
                            >
                                {{ item.title }}
                            </Link>
                        </li>

                    </ul>
                </div>


                <!-- Social Media -->
                <div>
                    <h3 class="font-semibold text-gray-900">
                        Follow Us
                    </h3>

                    <div class="mt-4 flex flex-wrap gap-3">

                        <a
                            v-for="social in socialLinks"
                            :key="social.title"
                            :href="social.href"
                            :aria-label="social.title"
                            :title="social.title"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 transition hover:border-orange-500 hover:bg-orange-500 hover:text-white"
                        >
                            <component
                                :is="social.icon"
                                :size="17"
                            />
                        </a>

                    </div>
                </div>

            </div>


            <!-- ================================================= -->
            <!-- DESKTOP FOOTER -->
            <!-- ================================================= -->

            <div
                class="hidden grid-cols-4 gap-8 py-10 xl:grid 2xl:gap-12"
            >

                <!-- Brand -->
                <div>

                    <Link
                        href="/"
                        class="inline-flex items-center"
                    >
                        <img
                            src="/storage/images/logo-school.png"
                            alt="Great Crystal School and Course Center"
                            class="h-auto w-60 object-contain"
                        />
                    </Link>

                    <p class="mt-5 max-w-xs text-sm leading-7 text-gray-500">
                        Great Crystal School and Course Center is committed to
                        excellence in education, character building, and
                        preparing students for a brighter future.
                    </p>

                </div>


                <!-- Quick Links -->
                <div>

                    <h3 class="font-semibold text-gray-900">
                        Quick Links
                    </h3>

                    <ul class="mt-5 space-y-3 text-sm">

                        <li
                            v-for="item in quickLinks"
                            :key="item.href"
                        >
                            <Link
                                :href="item.href"
                                class="transition hover:text-orange-500"
                            >
                                {{ item.title }}
                            </Link>
                        </li>

                    </ul>

                </div>


                <!-- Programs -->
                <div>

                    <h3 class="font-semibold text-gray-900">
                        Programs
                    </h3>

                    <ul class="mt-5 space-y-3 text-sm">

                        <li
                            v-for="item in programs"
                            :key="item.href"
                        >
                            <Link
                                :href="item.href"
                                class="transition hover:text-orange-500"
                            >
                                {{ item.title }}
                            </Link>
                        </li>

                    </ul>

                </div>


                <!-- Social -->
                <div>

                    <h3 class="font-semibold text-gray-900">
                        Follow Us
                    </h3>

                    <div class="mt-5 flex flex-wrap gap-3">

                        <a
                            v-for="social in socialLinks"
                            :key="social.title"
                            :href="social.href"
                            :aria-label="social.title"
                            :title="social.title"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 transition hover:border-orange-500 hover:bg-orange-500 hover:text-white"
                        >
                            <component
                                :is="social.icon"
                                :size="17"
                            />
                        </a>

                    </div>

                </div>

            </div>


            <!-- ================================================= -->
            <!-- COPYRIGHT -->
            <!-- ================================================= -->

            <div class="border-t border-gray-100 py-5">

                <p class="text-center text-xs leading-5 text-gray-400">
                    © {{ new Date().getFullYear() }}
                    Great Crystal School. All rights reserved.
                </p>

            </div>

        </div>

    </footer>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import {
    Menu,
    Globe2,
    Bell,
    ChevronDown,
    LogOut,
    UserRound,
} from 'lucide-vue-next'

defineEmits(['toggle-sidebar'])

const userMenuOpen = ref(false)
const isLoggingOut = ref(false)

const logout = () => {
    if (isLoggingOut.value) return

    isLoggingOut.value = true
    userMenuOpen.value = false

    router.post('/logout', {}, {
        onFinish: () => {
            isLoggingOut.value = false
        },
    })
}
</script>

<template>
    <header
        class="sticky top-0 z-40 h-20 border-b border-gray-200 bg-white"
    >
        <div
            class="flex h-full items-center justify-between px-3 sm:px-5 md:px-7"
        >
            <!-- Toggle Sidebar -->
            <button
                type="button"
                @click="$emit('toggle-sidebar')"
                aria-label="Toggle sidebar"
                class="rounded-lg p-2 transition hover:bg-gray-100"
            >
                <Menu class="h-6 w-6" />
            </button>

            <div class="flex items-center gap-2 sm:gap-4 md:gap-6">

                <!-- Language -->
                <button
                    type="button"
                    class="hidden items-center gap-2 text-sm text-gray-600 transition hover:text-orange-500 md:flex"
                >
                    <Globe2 class="h-5 w-5" />
                    English
                    <ChevronDown class="h-4 w-4" />
                </button>

                <!-- Notification -->
                <button
                    type="button"
                    aria-label="Notifications"
                    class="relative rounded-lg p-2 transition hover:bg-gray-100"
                >
                    <Bell class="h-5 w-5" />

                    <span
                        class="absolute right-0 top-0 flex h-4 w-4 items-center justify-center rounded-full bg-orange-500 text-[9px] text-white"
                    >
                        5
                    </span>
                </button>

                <!-- User Profile Dropdown -->
                <div class="relative">

                    <button
                        type="button"
                        @click="userMenuOpen = !userMenuOpen"
                        :aria-expanded="userMenuOpen"
                        aria-label="Open user menu"
                        class="flex items-center gap-2 rounded-xl p-1.5 transition hover:bg-gray-50 sm:gap-3"
                    >
                        <img
                            src="/storage/images/admin/admin.jpg"
                            alt="Admin profile"
                            class="h-9 w-9 rounded-full border border-gray-200 object-cover sm:h-10 sm:w-10"
                        />

                        <div class="hidden text-left md:block">
                            <p class="text-sm font-semibold text-gray-900">
                                Admin Sekolah
                            </p>

                            <p class="text-xs text-gray-500">
                                Super Admin
                            </p>
                        </div>

                        <ChevronDown
                            class="hidden h-4 w-4 text-gray-500 transition-transform md:block"
                            :class="{ 'rotate-180': userMenuOpen }"
                        />
                    </button>

                    <!-- Dropdown Menu -->
                    <Transition
                        enter-active-class="transition duration-150 ease-out"
                        enter-from-class="translate-y-1 opacity-0"
                        enter-to-class="translate-y-0 opacity-100"
                        leave-active-class="transition duration-100 ease-in"
                        leave-from-class="translate-y-0 opacity-100"
                        leave-to-class="translate-y-1 opacity-0"
                    >
                        <div
                            v-if="userMenuOpen"
                            class="absolute right-0 top-full z-50 mt-3 w-64 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-xl"
                        >
                            <!-- Profile Info -->
                            <div class="border-b border-gray-100 px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <img
                                        src="/storage/images/admin/admin.jpg"
                                        alt="Admin profile"
                                        class="h-11 w-11 rounded-full object-cover"
                                    />

                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-gray-900">
                                            Admin Sekolah
                                        </p>

                                        <p class="text-xs text-gray-500">
                                            Super Admin
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Logout -->
                            <div class="p-2">
                                <button
                                    type="button"
                                    @click="logout"
                                    :disabled="isLoggingOut"
                                    class="flex w-full items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium text-red-600 transition hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-60"
                                >
                                    <LogOut class="h-5 w-5" />

                                    <span>
                                        {{ isLoggingOut ? 'Logging out...' : 'Logout' }}
                                    </span>
                                </button>
                            </div>
                        </div>
                    </Transition>

                </div>

            </div>
        </div>
    </header>
</template>

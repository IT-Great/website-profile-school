
<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import {
    LockKeyhole,
    Mail,
    Eye,
    EyeOff,
    ArrowRight,
    ShieldCheck,
} from 'lucide-vue-next';

const showPassword = ref(false);

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login.store'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Admin Login" />

    <div class="min-h-screen bg-slate-50 lg:grid lg:grid-cols-2">

        <!-- Left: Brand panel -->
        <div
            class="relative hidden overflow-hidden bg-slate-900 lg:flex lg:flex-col lg:justify-between lg:p-10 xl:p-14"
        >
            <img
                src="/storage/images/program.png"
                alt=""
                class="absolute inset-0 h-full w-full object-cover opacity-35"
            />

            <div class="absolute inset-0 bg-gradient-to-br from-slate-950/90 via-slate-900/75 to-orange-950/60"></div>

            <div class="relative z-10">
                <a href="/" class="inline-flex items-center">
                    <img
                        src="/storage/images/logo-school.png"
                        alt="Great Crystal School"
                        class="w-64 object-contain"
                    />
                </a>
            </div>

            <div class="relative z-10 max-w-xl py-12">
                <span
                    class="inline-flex items-center rounded-full border border-orange-300/30 bg-orange-500/15 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-orange-300"
                >
                    School Administration
                </span>

                <h1 class="mt-6 text-4xl font-bold leading-tight text-white xl:text-5xl">
                    Welcome Back to
                    <span class="text-orange-400">
                        Great Crystal
                    </span>
                </h1>

                <p class="mt-5 max-w-lg text-base leading-8 text-slate-200">
                    Manage school content, news, alumni, facilities,
                    and website information from one central dashboard.
                </p>
            </div>

            <div class="relative z-10 flex items-center gap-2 text-sm text-slate-300">
                <ShieldCheck :size="18" class="text-orange-400" />
                Secure Administration Portal
            </div>
        </div>

        <!-- Right: Login form -->
        <div class="flex min-h-screen items-center justify-center px-5 py-10 sm:px-8 lg:px-10">
            <div class="w-full max-w-md">

                <!-- Mobile brand -->
                <div class="mb-10 text-center lg:hidden">
                    <a href="/" class="inline-flex">
                        <img
                            src="/storage/images/logo-school.png"
                            alt="Great Crystal School"
                            class="mx-auto w-56 object-contain"
                        />
                    </a>
                </div>

                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-orange-500">
                        Admin Portal
                    </p>

                    <h2 class="mt-3 text-3xl font-bold text-slate-900 sm:text-4xl">
                        Sign in
                    </h2>

                    <p class="mt-3 text-sm leading-6 text-slate-500">
                        Enter your administrator credentials to continue.
                    </p>
                </div>

                <form @submit.prevent="submit" class="mt-8 space-y-5">

                    <!-- Email -->
                    <div>
                        <label
                            for="email"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Email Address
                        </label>

                        <div class="relative">
                            <Mail
                                :size="19"
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"
                            />

                            <input
                                id="email"
                                v-model="form.email"
                                type="email"
                                autocomplete="username"
                                required
                                autofocus
                                placeholder="admin@example.com"
                                class="w-full rounded-xl border border-slate-200 bg-white py-3.5 pl-12 pr-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-orange-500 focus:ring-4 focus:ring-orange-100"
                                :class="{ 'border-red-400': form.errors.email }"
                            />
                        </div>

                        <p
                            v-if="form.errors.email"
                            class="mt-2 text-sm text-red-500"
                        >
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <!-- Password -->
                    <div>
                        <label
                            for="password"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Password
                        </label>

                        <div class="relative">
                            <LockKeyhole
                                :size="19"
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"
                            />

                            <input
                                id="password"
                                v-model="form.password"
                                :type="showPassword ? 'text' : 'password'"
                                autocomplete="current-password"
                                required
                                placeholder="Enter your password"
                                class="w-full rounded-xl border border-slate-200 bg-white py-3.5 pl-12 pr-12 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-orange-500 focus:ring-4 focus:ring-orange-100"
                            />

                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 transition hover:text-orange-500"
                                :aria-label="showPassword ? 'Hide password' : 'Show password'"
                            >
                                <EyeOff v-if="showPassword" :size="19" />
                                <Eye v-else :size="19" />
                            </button>
                        </div>

                        <p
                            v-if="form.errors.password"
                            class="mt-2 text-sm text-red-500"
                        >
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <!-- Remember me -->
                    <label class="flex cursor-pointer items-center gap-3">
                        <input
                            v-model="form.remember"
                            type="checkbox"
                            class="h-4 w-4 rounded border-slate-300 text-orange-500 focus:ring-orange-500"
                        />

                        <span class="text-sm text-slate-600">
                            Remember me
                        </span>
                    </label>

                    <!-- Submit -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-orange-500 px-5 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600 focus:outline-none focus:ring-4 focus:ring-orange-200 disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        <span>
                            {{ form.processing ? 'Signing in...' : 'Sign In to Dashboard' }}
                        </span>

                        <ArrowRight
                            v-if="!form.processing"
                            :size="18"
                        />
                    </button>

                    <p class="text-center text-xs leading-5 text-slate-400">
                        Authorized school administrators only.
                    </p>
                </form>

                <div class="mt-10 border-t border-slate-200 pt-5 text-center">
                    <a
                        href="/"
                        class="text-sm font-medium text-slate-500 transition hover:text-orange-500"
                    >
                        ← Back to school website
                    </a>
                </div>

            </div>
        </div>
    </div>
</template>

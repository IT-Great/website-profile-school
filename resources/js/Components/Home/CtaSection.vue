```vue
<script setup>
import { Link } from '@inertiajs/vue3'
import {
    ArrowRight,
    CalendarDays,
    GraduationCap,
    Users,
    Trophy,
    Calendar,
} from 'lucide-vue-next'

const statistics = [
    {
        title: 'Students',
        value: '1500+',
        icon: GraduationCap,
    },
    {
        title: 'Teachers',
        value: '120+',
        icon: Users,
    },
    {
        title: 'Achievements',
        value: '50+',
        icon: Trophy,
    },
    {
        title: 'Years Experience',
        value: '20+',
        icon: Calendar,
    },
]
</script>

<template>
    <section
        class="relative isolate overflow-hidden py-16 sm:py-20 md:py-24 lg:py-28 xl:py-32"
    >
        <!-- Background -->
        <div
            class="absolute inset-0 -z-20 bg-cover bg-center"
            style="background-image: url('https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=1800')"
            role="img"
            aria-label="Learning environment at school"
        ></div>

        <!-- Dark Overlay -->
        <div
            class="absolute inset-0 -z-10 bg-gradient-to-b from-black/75 via-black/65 to-black/80"
        ></div>

        <!-- Content Container -->
        <div
            class="mx-auto w-full max-w-[1600px] px-5 sm:px-8 md:px-10 lg:px-12 xl:px-16 2xl:px-20"
        >
            <!-- Admission Heading -->
            <div class="mx-auto max-w-5xl text-center text-white">
                <span
                    class="inline-block text-xs font-semibold uppercase tracking-[3px] text-orange-400 sm:text-sm sm:tracking-[5px] md:tracking-[6px]"
                >
                    Admissions Open
                </span>

                <h2
                    class="mx-auto mt-4 max-w-4xl text-3xl font-bold leading-tight tracking-tight sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl"
                >
                    Ready to Build a Bright Future?
                </h2>

                <p
                    class="mx-auto mt-5 max-w-3xl text-sm leading-7 text-gray-200 sm:mt-6 sm:text-base sm:leading-8 md:text-lg"
                >
                    Join a learning community where students grow academically,
                    creatively, and with strong character. Begin your child's
                    educational journey with Great Crystal School today.
                </p>

                <!-- Action Buttons -->
                <div
                    class="mt-8 flex flex-col items-stretch justify-center gap-3 sm:mt-9 sm:flex-row sm:flex-wrap sm:items-center sm:gap-4 md:mt-10"
                >
                    <Link
                        href="/admission"
                        class="inline-flex min-h-12 w-full items-center justify-center gap-3 rounded-xl bg-orange-500 px-6 py-3.5 text-sm font-semibold text-white transition duration-300 hover:bg-orange-600 sm:w-auto sm:px-7 md:min-h-14 md:px-8 md:text-base"
                    >
                        Apply Now

                        <ArrowRight class="h-5 w-5 shrink-0" />
                    </Link>

                    <Link
                        href="/contact"
                        class="inline-flex min-h-12 w-full items-center justify-center gap-3 rounded-xl border border-white/70 px-6 py-3.5 text-sm font-semibold text-white transition duration-300 hover:border-white hover:bg-white hover:text-gray-900 sm:w-auto sm:px-7 md:min-h-14 md:px-8 md:text-base"
                    >
                        <CalendarDays class="h-5 w-5 shrink-0" />

                        Schedule School Tour
                    </Link>
                </div>
            </div>

            <!-- Statistics -->
            <div
                class="mx-auto mt-10 grid w-full max-w-6xl grid-cols-2 gap-3 sm:mt-12 sm:gap-5 md:mt-14 md:gap-6 lg:mt-16 lg:grid-cols-4 lg:gap-5 xl:gap-7"
            >
                <div
                    v-for="item in statistics"
                    :key="item.title"
                    class="flex min-w-0 flex-col items-center justify-center rounded-2xl border border-white/20 bg-white/10 px-3 py-5 text-center shadow-lg backdrop-blur-md transition duration-300 hover:bg-white/15 sm:rounded-3xl sm:px-5 sm:py-7 md:px-6 md:py-8"
                >
                    <component
                        :is="item.icon"
                        class="h-7 w-7 text-orange-400 sm:h-8 sm:w-8 md:h-9 md:w-9"
                        :stroke-width="1.8"
                    />

                    <h3
                        class="mt-3 text-2xl font-bold leading-tight text-white sm:mt-4 sm:text-3xl md:text-4xl"
                    >
                        {{ item.value }}
                    </h3>

                    <p
                        class="mt-2 text-xs leading-5 text-gray-200 sm:text-sm md:text-base"
                    >
                        {{ item.title }}
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
```

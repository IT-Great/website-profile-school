```vue
<script setup>
import {
    Globe,
    Users,
    Lightbulb,
    ShieldCheck,
    UserCheck,
    Monitor,
} from 'lucide-vue-next'

const reasons = [
    {
        title: 'International',
        secondLine: 'Curriculum',
        description: 'Globally recognized education standards.',
        icon: Globe,
    },
    {
        title: 'Small Class',
        secondLine: 'Size',
        description: 'Personalized attention for every student.',
        icon: Users,
    },
    {
        title: 'Creative',
        secondLine: 'Learning',
        description: 'Innovative teaching for future success.',
        icon: Lightbulb,
    },
    {
        title: 'Safe & Supportive',
        secondLine: 'Environment',
        description: 'A secure place where children thrive.',
        icon: ShieldCheck,
    },
    {
        title: 'Qualified',
        secondLine: 'Teachers',
        description: 'Passionate educators who care.',
        icon: UserCheck,
    },
    {
        title: 'Digital',
        secondLine: 'Classroom',
        description: 'Technology integrated in everyday learning.',
        icon: Monitor,
    },
]
</script>

<template>
    <section
        class="bg-white py-12 sm:py-14 md:py-16 lg:py-20"
    >
        <div
            class="mx-auto w-full max-w-[1600px] px-5 sm:px-8 md:px-10 lg:px-12 xl:px-16 2xl:px-20"
        >
            <!-- Heading -->
            <div class="mb-10 text-center sm:mb-12 lg:mb-14">
                <span
                    class="text-xs font-semibold uppercase tracking-[3px] text-orange-500 sm:text-sm"
                >
                    Why Choose Us
                </span>

                <h2
                    class="mt-3 text-2xl font-bold leading-tight text-gray-900 sm:text-3xl md:text-4xl lg:text-5xl"
                >
                    Excellence in Education
                </h2>

                <p
                    class="mx-auto mt-4 max-w-2xl text-sm leading-6 text-gray-500 sm:text-base sm:leading-7"
                >
                    We provide an inspiring environment where every student
                    can discover their potential, develop their talents,
                    and prepare for a brighter future.
                </p>
            </div>

            <!-- Reasons Grid -->
            <div
                class="grid grid-cols-2 gap-x-5 gap-y-10 sm:grid-cols-2 sm:gap-x-8 sm:gap-y-12 md:grid-cols-3 lg:grid-cols-3 lg:gap-x-10 xl:grid-cols-6 xl:gap-x-6 2xl:gap-x-10"
            >
                <div
                    v-for="reason in reasons"
                    :key="reason.title"
                    class="group flex min-w-0 flex-col items-center text-center"
                >
                    <!-- Icon -->
                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-2xl bg-orange-50 transition duration-300 group-hover:-translate-y-1 group-hover:bg-orange-100 sm:h-16 sm:w-16"
                    >
                        <component
                            :is="reason.icon"
                            class="h-7 w-7 text-orange-500 transition duration-300 group-hover:scale-110 sm:h-8 sm:w-8"
                            :stroke-width="1.8"
                        />
                    </div>

                    <!-- Title -->
                    <h3
                        class="mt-4 text-sm font-bold leading-snug text-gray-900 sm:mt-5 sm:text-base lg:text-sm 2xl:text-base"
                    >
                        {{ reason.title }}
                        <span class="block">
                            {{ reason.secondLine }}
                        </span>
                    </h3>

                    <!-- Description -->
                    <p
                        class="mt-2 max-w-[220px] text-xs leading-5 text-gray-500 sm:text-sm sm:leading-6"
                    >
                        {{ reason.description }}
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
```

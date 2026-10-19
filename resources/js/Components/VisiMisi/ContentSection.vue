<script setup>
import {
    BookOpen,
    Lightbulb,
    Target,
    School,
    Gem,
    ShieldCheck,
    Trophy,
    Star,
    HeartHandshake,
    Users,
    Globe,
    Rocket,
} from 'lucide-vue-next'

const pillars = [
    {
        icon: BookOpen,
        title: 'Our Philosophy',
        description:
            'We believe that every child can grow, learn and can excel.',
    },
    {
        icon: Lightbulb,
        title: 'Our Vision',
        description:
            'Our vision is to nurture and bring out in every student, the best which is inherently within by maintaining a learner-centered environment.',
    },
    {
        icon: Target,
        title: 'Our Mission',
        description:
            'Our mission is to provide a multicultural, learner-centered school environment that fosters Academic Success, Personal Growth, Social Responsibility, Global Action, and a Life Long Love of Learning.',
    },
]

const motto = [
    {
        icon: Gem,
        highlight: 'Graciousness',
        text: ', will be practiced by our students and staff in their interactions with others',
    },
    {
        icon: ShieldCheck,
        highlight: 'Confidence',
        text: ', among our students will be developed to encourage them to face whatever challenge and solve their problems creatively and with self-confidence',
    },
    {
        icon: Trophy,
        highlight: 'Success',
        text: ', all our school programs and activities are organized and carried out with the aim of providing and creating opportunities for our students to experiences success in their individual ways, such experiences of success will encourage students to want to on making further achievements and to excel.',
    },
    {
        icon: Star,
        highlight: 'Perfection',
        text: ", Our school also develop students' talent and skill and not only focus on Academic",
    },
]

const values = [
    {
        icon: HeartHandshake,
        title: 'Academic Excellence',
        description:
            'We foster curiosity, critical thinking, and a love for learning.',
    },
    {
        icon: Users,
        title: 'Character Building',
        description:
            'We nurture integrity, respect, responsibility, and empathy.',
    },
    {
        icon: Globe,
        title: 'Global Perspective',
        description:
            'We prepare students to be open-minded and globally aware.',
    },
    {
        icon: HeartHandshake,
        title: 'Community & Service',
        description:
            'We encourage students to contribute positively to society.',
    },
    {
        icon: Rocket,
        title: 'Future Ready',
        description:
            'We equip students with skills, confidence, and resilience for the future.',
    },
]
</script>

<template>
    <section class="w-full overflow-hidden bg-white py-12 sm:py-16 lg:py-24">
        <div
            class="mx-auto w-full max-w-[1600px] px-4
                   sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-20"
        >
            <!-- Philosophy, Vision, Mission -->
            <div class="grid grid-cols-1 gap-5 sm:gap-6 md:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="pillar in pillars"
                    :key="pillar.title"
                    class="flex h-full flex-col items-center rounded-2xl
                           border border-gray-100 bg-white p-6 text-center
                           shadow-sm transition duration-300
                           hover:-translate-y-1 hover:border-orange-200
                           hover:shadow-md
                           sm:p-7 lg:p-8"
                >
                    <div
                        class="flex h-14 w-14 shrink-0 items-center justify-center
                               rounded-full bg-orange-100
                               sm:h-16 sm:w-16"
                    >
                        <component
                            :is="pillar.icon"
                            class="h-6 w-6 text-orange-500 sm:h-7 sm:w-7"
                            :stroke-width="1.8"
                        />
                    </div>

                    <h3
                        class="mt-4 text-lg font-bold text-gray-900 sm:mt-5 sm:text-xl"
                    >
                        {{ pillar.title }}
                    </h3>

                    <p
                        class="mt-3 max-w-md text-sm leading-6 text-gray-500
                               sm:leading-7"
                    >
                        {{ pillar.description }}
                    </p>

                    <div class="mt-5 h-0.5 w-8 shrink-0 rounded-full bg-orange-500 sm:mt-6"></div>
                </div>
            </div>

            <!-- School Motto -->
            <div class="mt-8 sm:mt-10 lg:mt-12">
                <div class="rounded-2xl bg-orange-50 p-3 sm:rounded-3xl sm:p-5 lg:p-8">
                    <!-- Motto Heading -->
                    <div class="text-center">
                        <div class="flex items-center justify-center gap-3 sm:gap-4">
                            <div class="h-px w-10 bg-orange-300 sm:w-16 lg:w-40"></div>

                            <School
                                class="h-7 w-7 shrink-0 text-orange-500 sm:h-9 sm:w-9"
                                :stroke-width="1.6"
                            />

                            <div class="h-px w-10 bg-orange-300 sm:w-16 lg:w-40"></div>
                        </div>

                        <h2
                            class="mt-4 text-2xl font-bold leading-tight text-gray-900
                                   sm:text-3xl lg:text-4xl"
                        >
                            Our School Motto
                        </h2>

                        <p class="mt-3 text-sm text-gray-500 sm:text-base">
                            Our school motto is as follows:
                        </p>
                    </div>

                    <!-- Motto List -->
                    <div
                        class="mx-auto mt-7 flex w-full max-w-4xl flex-col
                               gap-5 sm:mt-10 sm:gap-6"
                    >
                        <div
                            v-for="item in motto"
                            :key="item.highlight"
                            class="flex items-start gap-3 sm:gap-4"
                        >
                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center
                                       rounded-full bg-white sm:h-10 sm:w-10"
                            >
                                <component
                                    :is="item.icon"
                                    class="h-4 w-4 text-orange-500 sm:h-5 sm:w-5"
                                    :stroke-width="1.8"
                                />
                            </div>

                            <p
                                class="min-w-0 flex-1 break-words pt-1
                                       text-sm leading-6 text-gray-600
                                       sm:pt-1.5 sm:leading-7"
                            >
                                <span class="font-bold text-gray-900">
                                    {{ item.highlight }}
                                </span>{{ item.text }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Core Values -->
                <div class="mt-5 rounded-2xl bg-orange-50 p-4 sm:mt-6 sm:rounded-3xl sm:p-6 lg:p-8">
                    <div
                        class="grid grid-cols-1 gap-2
                               min-[420px]:grid-cols-2
                               lg:grid-cols-3
                               xl:grid-cols-5"
                    >
                        <div
                            v-for="value in values"
                            :key="value.title"
                            class="flex h-full flex-col items-center rounded-xl
                                   px-3 py-5 text-center
                                   transition duration-300 hover:bg-white/70
                                   sm:px-4 sm:py-6"
                        >
                            <component
                                :is="value.icon"
                                class="h-7 w-7 shrink-0 text-orange-500"
                                :stroke-width="1.8"
                            />

                            <h4
                                class="mt-3 text-sm font-bold leading-5 text-gray-900
                                       sm:text-base"
                            >
                                {{ value.title }}
                            </h4>

                            <p class="mt-2 max-w-xs text-xs leading-5 text-gray-500 sm:text-sm sm:leading-6">
                                {{ value.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
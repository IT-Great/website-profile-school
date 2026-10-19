<script setup>
import { Link } from '@inertiajs/vue3'
import {
    GraduationCap,
    Globe,
    Briefcase,
    Heart,
} from 'lucide-vue-next'

const alumni = [
    {
        name: 'Shivani Bangia',
        role: 'Software Engineer, Google',
        quote: 'Hello, My name is Shivani bangia. I am currently taking hospitality Management in IPBI Bali. I took IGCSE at Great Crystal School because I wanted to go to university earlier than most of my friends and during my study and preparation of IGCSE, the teachers always helped me when they saw me struggling, the always guided me and always wished me the best which motivated me to do good in my IGCSE The end result of my score were good and I am super grateful to get into a university at a young age and be able to experience being taught by such caring and nice teachers.',
        image: 'https://images.unsplash.com/photo-1633332755192-727a05c4013d?q=80&w=300',
    },
    {
        name: 'Michelle Tania',
        role: 'Medical Doctor, RS Siloam',
        quote: 'The caring teachers and supportive environment at GCS shaped me into who I am today.',
        image: 'https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=300',
    },
    {
        name: 'Kevin Wijaya',
        role: 'Business Analyst, Deloitte',
        quote: 'GCS taught me critical thinking, leadership, and the importance of teamwork.',
        image: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=300',
    },
    {
        name: 'Cindy Laurentia',
        role: 'Graphic Designer, Ogilvy',
        quote: 'The creative programs and encouragement from teachers helped me discover my passion.',
        image: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=300',
    },
    {
        name: 'Brian Alexander',
        role: 'Entrepreneur',
        quote: 'The entrepreneurial mindset I learned at GCS became the foundation of my journey.',
        image: 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=300',
    },
    {
        name: 'Amanda Putri',
        role: 'Lawyer, Makarim & Taira S.',
        quote: 'GCS prepared me to be disciplined, resilient, and ready to face real-world challenges.',
        image: 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?q=80&w=300',
    },
]

const stats = [
    { icon: GraduationCap, number: '1,200+', label: 'Alumni' },
    { icon: Globe, number: '25+', label: 'Countries' },
    { icon: Briefcase, number: '30+', label: 'Fields of Work' },
    { icon: Heart, number: 'One', label: 'Great Crystal Family' },
]
</script>

<template>
    <!-- Alumni Grid -->
    <section class="bg-white py-12 sm:py-14 lg:py-20">
        <div
            class="mx-auto w-full max-w-[1600px]
                   px-4 sm:px-6 md:px-8
                   lg:px-12 xl:px-16 2xl:px-20"
        >
            <!-- Heading -->
            <div class="mx-auto mb-8 max-w-3xl text-center sm:mb-12 lg:mb-14">
                <span
                    class="text-xs font-semibold uppercase tracking-[2px]
                           text-orange-500 sm:text-sm sm:tracking-[3px]"
                >
                    Our Alumni
                </span>

                <h2
                    class="mt-3 text-2xl font-bold leading-tight text-gray-900
                           sm:text-3xl lg:text-4xl"
                >
                    From Great Crystal to the World
                </h2>

                <p
                    class="mx-auto mt-3 max-w-2xl text-sm leading-7 text-gray-500
                           sm:text-base sm:leading-8"
                >
                    Our alumni are making a difference in diverse fields and
                    leading with confidence, character, and competence. Here
                    are their stories.
                </p>
            </div>

            <!-- Alumni Cards -->
            <div
                class="grid grid-cols-1 items-stretch gap-5
                       sm:grid-cols-2 sm:gap-6
                       lg:grid-cols-3 lg:gap-7
                       2xl:gap-8"
            >
                <article
                    v-for="person in alumni"
                    :key="person.name"
                    class="flex min-w-0 flex-col items-center rounded-2xl
                           border border-gray-100 bg-white p-5 text-center
                           transition duration-300
                           hover:-translate-y-1 hover:border-orange-100
                           hover:shadow-lg
                           sm:p-6 lg:p-7"
                >
                    <!-- Quote Icon -->
                    <svg
                        class="mb-3 h-7 w-7 shrink-0 text-orange-400"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        aria-hidden="true"
                    >
                        <path
                            d="M9.5 6C6.5 6 4 8.5 4 11.5c0 2.5 1.8 4.5 4 4.9-.2 1.3-1 2.3-2.2 2.8l.5 1.3c2.5-.8 4.2-2.9 4.2-6V11c0-2.8-2.2-5-5-5zm10 0c-3 0-5.5 2.5-5.5 5.5 0 2.5 1.8 4.5 4 4.9-.2 1.3-1 2.3-2.2 2.8l.5 1.3c2.5-.8 4.2-2.9 4.2-6V11c0-2.8-2.2-5-5-5z"
                        />
                    </svg>

                    <!-- Avatar -->
                    <img
                        :src="person.image"
                        :alt="`Photo of ${person.name}`"
                        loading="lazy"
                        class="h-16 w-16 shrink-0 rounded-full object-cover
                               ring-4 ring-orange-50 sm:h-20 sm:w-20"
                    />

                    <!-- Name -->
                    <h3
                        class="mt-4 text-base font-bold text-gray-900
                               sm:text-lg"
                    >
                        {{ person.name }}
                    </h3>

                    <!-- Role -->
                    <p class="mt-1 text-xs font-medium text-orange-600 sm:text-sm">
                        {{ person.role }}
                    </p>

                    <!-- Quote -->
                    <p
                        class="mt-4 text-sm leading-7 text-gray-500
                               sm:leading-7"
                    >
                        “{{ person.quote }}”
                    </p>
                </article>
            </div>

            <!-- Stats Bar -->
            <div
                class="mt-8 rounded-2xl bg-orange-50 p-5
                       sm:mt-10 sm:rounded-3xl sm:p-7
                       lg:mt-12 lg:p-8 xl:p-10"
            >
                <div
                    class="grid grid-cols-2 gap-x-3 gap-y-6
                           sm:gap-x-6 sm:gap-y-8
                           lg:grid-cols-4 lg:gap-6"
                >
                    <div
                        v-for="stat in stats"
                        :key="stat.label"
                        class="flex min-w-0 items-center justify-center gap-2
                               sm:gap-3 lg:justify-start"
                    >
                        <div
                            class="flex h-9 w-9 shrink-0 items-center
                                   justify-center rounded-full bg-orange-100
                                   sm:h-11 sm:w-11"
                        >
                            <component
                                :is="stat.icon"
                                class="h-4 w-4 text-orange-500 sm:h-5 sm:w-5"
                            />
                        </div>

                        <div class="min-w-0">
                            <p
                                class="text-lg font-bold leading-tight
                                       text-gray-900 sm:text-xl lg:text-2xl"
                            >
                                {{ stat.number }}
                            </p>

                            <p
                                class="mt-1 text-[11px] leading-4 text-gray-500
                                       sm:text-xs sm:leading-5"
                            >
                                {{ stat.label }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Alumni Video -->
    <section class="mb-12 bg-white py-8 sm:mb-16 sm:py-10 lg:mb-20 lg:py-12">
        <div
            class="mx-auto w-full max-w-[1600px]
                   px-4 text-center
                   sm:px-6 md:px-8
                   lg:px-12 xl:px-16 2xl:px-20"
        >
            <!-- Heading -->
            <span
                class="text-xs font-semibold uppercase tracking-[2px]
                       text-orange-500 sm:text-sm sm:tracking-[3px]"
            >
                Alumni Video
            </span>

            <h2
                class="mt-3 text-2xl font-bold leading-tight text-gray-900
                       sm:text-3xl lg:text-4xl"
            >
                A Message from Our Alumni
            </h2>

            <p
                class="mx-auto mt-3 max-w-xl text-sm leading-7 text-gray-500
                       sm:text-base sm:leading-8"
            >
                Watch this video and see how Great Crystal School shaped
                their journey and future.
            </p>

            <!-- Responsive Video Player -->
            <div class="mx-auto mt-7 w-full max-w-4xl sm:mt-9">
                <div
                    class="relative aspect-video w-full overflow-hidden
                           rounded-xl bg-gray-100 shadow-lg
                           sm:rounded-2xl"
                >
                    <iframe
                        src="https://player.vimeo.com/video/969429430?h=3c5007e5a7"
                        title="A Message from Great Crystal School Alumni"
                        class="absolute inset-0 h-full w-full"
                        allow="autoplay; fullscreen; picture-in-picture"
                        allowfullscreen
                        loading="lazy"
                    ></iframe>
                </div>
            </div>

            <!-- More Stories Button -->
            <Link
                href="/alumni"
                class="mx-auto mt-6 inline-flex min-h-12
                       max-w-full items-center justify-center gap-2
                       rounded-full border border-orange-300
                       px-5 py-3 text-center text-sm font-medium
                       text-orange-500 transition duration-300
                       hover:border-orange-500 hover:bg-orange-500
                       hover:text-white
                       sm:mt-8 sm:px-6 sm:text-base"
            >
                <span>See More Alumni Stories</span>

                <svg
                    class="h-4 w-4 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M17 8l4 4m0 0l-4 4m4-4H3"
                    />
                </svg>
            </Link>
        </div>
    </section>
</template>
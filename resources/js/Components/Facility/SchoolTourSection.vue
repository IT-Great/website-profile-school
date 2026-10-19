<script setup>
</script>

<template>
    <section class="bg-white py-5 sm:py-7 lg:py-10">
        <div
            class="mx-auto w-full max-w-[1600px]
                   px-4 sm:px-6 md:px-8
                   lg:px-12 xl:px-16 2xl:px-20"
        >
            <div
                class="relative grid grid-cols-1 overflow-hidden
                       rounded-2xl bg-orange-50
                       sm:rounded-3xl
                       lg:grid-cols-2"
            >
                <!-- Content -->
                <div
                    class="relative z-10 flex flex-col items-start
                           justify-center
                           px-5 py-8
                           sm:px-8 sm:py-10
                           md:px-10 md:py-12
                           lg:px-8 lg:py-10
                           xl:px-12 xl:py-12
                           2xl:px-16"
                >
                    <h2
                        class="max-w-xl text-2xl font-bold
                               leading-tight text-gray-900
                               sm:text-3xl
                               lg:text-3xl
                               xl:text-4xl"
                    >
                        A Place Where Students Feel Happy to Learn
                    </h2>

                    <p
                        class="mt-3 max-w-lg text-sm
                               leading-6 text-gray-500
                               sm:mt-4 sm:text-base sm:leading-7"
                    >
                        We believe that a great environment creates great
                        opportunities.
                    </p>

                    <a
                        href="/contact"
                        class="mt-5 inline-flex min-h-12
                               w-full items-center justify-center gap-2
                               rounded-full bg-orange-500
                               px-5 py-3 text-center
                               text-sm font-semibold text-white
                               transition duration-300
                               hover:bg-orange-600
                               focus-visible:outline-none
                               focus-visible:ring-2
                               focus-visible:ring-orange-400
                               focus-visible:ring-offset-2
                               sm:mt-6 sm:w-auto sm:px-6
                               sm:text-base"
                    >
                        <span>Take a School Tour</span>

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
                    </a>
                </div>

                <!-- Image -->
                <div
                    class="relative min-h-[220px]
                           sm:min-h-[300px]
                           md:min-h-[360px]
                           lg:min-h-0 lg:h-full"
                >
                    <img
                        src="/storage/images/field.png"
                        alt="Great Crystal School environment"
                        loading="lazy"
                        class="absolute inset-0 h-full w-full
                               object-cover object-center"
                    />

                    <!-- Gradient transition for desktop -->
                    <div
                        class="absolute inset-x-0 top-0 h-16
                               bg-gradient-to-b
                               from-orange-50/30 to-transparent
                               sm:h-20
                               lg:inset-y-0 lg:left-0 lg:right-auto
                               lg:h-auto lg:w-28
                               lg:bg-gradient-to-r
                               lg:from-orange-50
                               lg:to-transparent"
                    ></div>
                </div>
            </div>
        </div>
    </section>
</template>
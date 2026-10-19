<script setup>
</script>

<template>
    <section class="bg-white py-10 sm:py-12 lg:py-16">
        <div
            class="mx-auto w-full max-w-[1600px]
                   px-4 sm:px-6 md:px-8
                   lg:px-12 xl:px-16 2xl:px-20"
        >
            <div
                class="grid grid-cols-1 items-center gap-8
                       sm:gap-10 lg:grid-cols-2 lg:gap-12
                       xl:gap-16"
            >
                <!-- Content -->
                <div class="min-w-0 text-center lg:text-left">
                    <span
                        class="text-xs font-semibold uppercase
                               tracking-[2px] text-orange-500
                               sm:text-sm sm:tracking-[3px]"
                    >
                        Accreditation
                    </span>

                    <h2
                        class="mt-3 text-2xl font-bold leading-tight
                               text-gray-900 sm:text-3xl
                               lg:text-3xl xl:text-4xl"
                    >
                        Trusted. Recognized. Accredited.
                    </h2>

                    <p
                        class="mx-auto mt-4 max-w-xl text-sm leading-7
                               text-gray-500 sm:text-base sm:leading-8
                               lg:mx-0"
                    >
                        Great Crystal School is accredited by the Ministry of
                        Education and Culture as a Satuan Pendidikan Kerjasama
                        (SPK) and recognized for implementing a UK-based
                        curriculum with high standards of learning.
                    </p>
                </div>

                <!-- Accreditation Logos -->
                <div
                    class="flex flex-wrap items-center justify-center
                           gap-5 sm:gap-8 lg:justify-end xl:gap-10"
                >
                    <img
                        src="/storage/images/pemkot-sby.png"
                        alt="Surabaya City Government"
                        loading="lazy"
                        class="h-20 w-auto max-w-[42%] object-contain
                               sm:h-24 md:h-28
                               lg:h-24 xl:h-32"
                    />

                    <img
                        src="/storage/images/pearson.png"
                        alt="Pearson Education"
                        loading="lazy"
                        class="h-20 w-auto max-w-[48%] object-contain
                               sm:h-24 md:h-28
                               lg:h-24 xl:h-32"
                    />
                </div>
            </div>
        </div>
    </section>
</template>
<script setup>
import {
    Mail,
    Phone,
    MessageCircle,
    Clock3,
} from 'lucide-vue-next'

const contacts = [
    {
        label: 'Email',
        value: 'admin@great.sch.id',
        icon: Mail,
    },
    {
        label: 'Phone',
        value: '031-7348825',
        icon: Phone,
    },
    {
        label: 'WhatsApp',
        value: '+62 813-3252-5678',
        icon: MessageCircle,
    },
    {
        label: 'Office Hours',
        value: 'Mon - Fri : 08.00 - 17.00',
        icon: Clock3,
    },
]
</script>

<template>
    <section class="bg-white py-6 sm:py-8 lg:py-12">
        <!-- Responsive Container -->
        <div
            class="mx-auto w-full max-w-[1600px] px-4 sm:px-6 md:px-8 lg:px-10 xl:px-14 2xl:px-20"
        >
            <!-- Contact Card -->
            <div
                class="grid grid-cols-1 overflow-hidden rounded-2xl shadow-lg sm:rounded-3xl lg:grid-cols-[1.5fr_1fr] xl:grid-cols-[2fr_1fr_1fr]"
            >
                <!-- Google Maps -->
                <div
                    class="relative h-64 min-w-0 sm:h-80 md:h-96 lg:h-full lg:min-h-[400px] xl:min-h-[420px]"
                >
                    <iframe
                        class="absolute inset-0 h-full w-full border-0"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Great Crystal School Location"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5142.905108971342!2d112.69419699999999!3d-7.278740300000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fd00011263eb%3A0x7858d11b0885a9f6!2sGreat%20Crystal%20School!5e1!3m2!1sen!2sid!4v1783910877836!5m2!1sen!2sid"
                    ></iframe>
                </div>

                <!-- Contact Information -->
                <div
                    class="flex min-w-0 flex-col justify-center bg-orange-50 px-5 py-7 sm:px-8 sm:py-9 md:px-10 lg:px-6 lg:py-8 xl:px-8 2xl:px-10"
                >
                    <h2
                        class="text-xl font-bold text-gray-900 sm:text-2xl lg:text-xl xl:text-2xl"
                    >
                        Get in Touch
                    </h2>

                    <div class="mt-5 space-y-5 sm:mt-6 sm:space-y-6">
                        <div
                            v-for="contact in contacts"
                            :key="contact.label"
                            class="flex min-w-0 items-start gap-3"
                        >
                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white shadow-sm"
                            >
                                <component
                                    :is="contact.icon"
                                    class="h-5 w-5 text-orange-500"
                                    :stroke-width="1.8"
                                />
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-xs text-gray-500 sm:text-sm">
                                    {{ contact.label }}
                                </p>

                                <p
                                    class="mt-1 break-words text-sm font-medium leading-6 text-gray-900 sm:text-base"
                                >
                                    {{ contact.value }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- School Photo -->
                <div
                    class="relative h-64 min-w-0 overflow-hidden sm:h-80 md:h-96 lg:h-full lg:min-h-[400px] xl:min-h-[420px]"
                >
                    <img
                        src="/storage/images/program.png"
                        alt="Great Crystal School"
                        loading="lazy"
                        class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 hover:scale-105"
                    />
                </div>
            </div>
        </div>
    </section>
</template>
<script setup>
import { ref } from 'vue'
import {
    Mail,
    MessageCircle,
    Phone,
    Instagram,
    MessageSquare,
    School,
    Calendar,
    Users,
    ArrowRight,
} from 'lucide-vue-next'

const channels = [
    { icon: Mail, label: 'Email', value: 'admin@great.sch.id' },
    { icon: MessageCircle, label: 'WhatsApp', value: '+62 813-3252-5678' },
    { icon: Phone, label: 'Phone', value: '031-7348825' },
    { icon: Instagram, label: 'Instagram', value: '@great.sch.id' },
    { icon: MessageSquare, label: 'Live Chat', value: '08.00 – 17.00 (Monday – Friday)' },
]

const quickInfo = [
    { icon: School, title: 'Visit Our School', description: "We'd love to welcome you to our campus!" },
    { icon: Calendar, title: 'Schedule a Tour', description: 'Book a campus tour and see our facilities.' },
    { icon: Users, title: 'Admission Inquiry', description: 'Our team is ready to assist you with enrollment.' },
]

const form = ref({
    name: '',
    email: '',
    subject: '',
    message: '',
})

const errors = ref({})
const isSubmitting = ref(false)
const submitStatus = ref(null) // null | 'success' | 'error'

const validate = () => {
    const newErrors = {}

    if (!form.value.name.trim()) {
        newErrors.name = 'Name is required.'
    }

    if (!form.value.email.trim()) {
        newErrors.email = 'Email is required.'
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.value.email)) {
        newErrors.email = 'Please enter a valid email address.'
    }

    if (!form.value.subject.trim()) {
        newErrors.subject = 'Subject is required.'
    }

    errors.value = newErrors
    return Object.keys(newErrors).length === 0
}

const submitForm = async () => {
    submitStatus.value = null

    if (!validate()) return

    isSubmitting.value = true

    try {
        // Ganti dengan endpoint backend asli, contoh:
        // await axios.post('/contact', form.value)

        await new Promise(resolve => setTimeout(resolve, 1000))

        submitStatus.value = 'success'
        form.value = { name: '', email: '', subject: '', message: '' }
        errors.value = {}
    } catch (error) {
        submitStatus.value = 'error'
    } finally {
        isSubmitting.value = false
    }
}
</script>

<template>

<section class="py-16 bg-white">

    <div class="max-w-6xl mx-auto px-6">

        <div class="grid lg:grid-cols-2 gap-8 items-start">

            <!-- Get In Touch -->

            <div class="rounded-2xl border border-gray-100 p-8">

                <h2 class="text-2xl font-bold text-gray-900">

                    Get In Touch

                </h2>

                <div class="w-10 h-1 bg-orange-500 rounded-full mt-2"></div>

                <p class="text-gray-500 mt-4 leading-6">

                    Have questions or need more information about our
                    school? Contact us through any of the following
                    channels.

                </p>

                <div class="flex flex-col mt-6">

                    <div
                        v-for="(channel, index) in channels"
                        :key="channel.label"
                        class="flex items-center gap-4 py-4"
                        :class="index !== channels.length - 1 ? 'border-b border-gray-100' : ''">

                        <div class="w-11 h-11 rounded-full bg-orange-500 flex items-center justify-center shrink-0">

                            <component :is="channel.icon" class="w-5 h-5 text-white" />

                        </div>

                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ channel.label }}</p>
                            <p class="text-sm text-orange-500 mt-0.5">{{ channel.value }}</p>
                        </div>

                    </div>

                </div>

                <!-- Illustration Card -->

                <div class="mt-4 rounded-xl border border-gray-100 p-5 flex items-center gap-5">

                    <svg class="w-16 h-16 text-orange-400 shrink-0" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 50V30l8-6 8 6v20M24 38h8M28 30v-8M22 22h12M18 50h28M12 46l4-8M52 46l-4-8" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M28 12h4l2 4h-8z" />
                    </svg>

                    <div>
                        <p class="text-sm text-gray-600 leading-5">

                            We are here to help and guide you every step
                            of the way.

                        </p>

                        <p class="text-sm font-semibold text-orange-500 mt-1">

                            Let's connect!

                        </p>
                    </div>

                </div>

            </div>

            <!-- Send Us a Message -->

            <div class="rounded-2xl border border-gray-100 p-8">

                <h2 class="text-2xl font-bold text-gray-900">

                    Send Us a Message

                </h2>

                <div class="w-10 h-1 bg-orange-500 rounded-full mt-2"></div>

                <form @submit.prevent="submitForm" class="flex flex-col gap-5 mt-6" novalidate>

                    <!-- Name -->

                    <div>

                        <label class="text-sm font-medium text-gray-700">

                            Your Name <span class="text-orange-500">*</span>

                        </label>

                        <input
                            v-model="form.name"
                            type="text"
                            placeholder="Enter your name"
                            class="w-full mt-2 px-4 py-2.5 rounded-lg border text-sm focus:outline-none focus:border-orange-400"
                            :class="errors.name ? 'border-red-300' : 'border-gray-200'"
                        >

                        <p v-if="errors.name" class="text-xs text-red-500 mt-1">

                            {{ errors.name }}

                        </p>

                    </div>

                    <!-- Email -->

                    <div>

                        <label class="text-sm font-medium text-gray-700">

                            Your Email <span class="text-orange-500">*</span>

                        </label>

                        <input
                            v-model="form.email"
                            type="email"
                            placeholder="Enter your email"
                            class="w-full mt-2 px-4 py-2.5 rounded-lg border text-sm focus:outline-none focus:border-orange-400"
                            :class="errors.email ? 'border-red-300' : 'border-gray-200'"
                        >

                        <p v-if="errors.email" class="text-xs text-red-500 mt-1">

                            {{ errors.email }}

                        </p>

                    </div>

                    <!-- Subject -->

                    <div>

                        <label class="text-sm font-medium text-gray-700">

                            Subject <span class="text-orange-500">*</span>

                        </label>

                        <input
                            v-model="form.subject"
                            type="text"
                            placeholder="Enter subject"
                            class="w-full mt-2 px-4 py-2.5 rounded-lg border text-sm focus:outline-none focus:border-orange-400"
                            :class="errors.subject ? 'border-red-300' : 'border-gray-200'"
                        >

                        <p v-if="errors.subject" class="text-xs text-red-500 mt-1">

                            {{ errors.subject }}

                        </p>

                    </div>

                    <!-- Message -->

                    <div>

                        <label class="text-sm font-medium text-gray-700">

                            Your Message (optional)

                        </label>

                        <textarea
                            v-model="form.message"
                            rows="5"
                            placeholder="Type your message here..."
                            class="w-full mt-2 px-4 py-2.5 rounded-lg border border-gray-200 text-sm resize-none focus:outline-none focus:border-orange-400"
                        ></textarea>

                    </div>

                    <button
                        type="submit"
                        :disabled="isSubmitting"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full bg-orange-500 text-white font-medium hover:bg-orange-600 transition disabled:opacity-60 disabled:cursor-not-allowed">

                        {{ isSubmitting ? 'Sending...' : 'Send Message' }}

                        <ArrowRight v-if="!isSubmitting" class="w-4 h-4" />

                    </button>

                    <p v-if="submitStatus === 'success'" class="text-sm text-green-600">

                        Your message has been sent. We'll get back to you soon.

                    </p>

                    <p v-if="submitStatus === 'error'" class="text-sm text-red-500">

                        Something went wrong. Please try again.

                    </p>

                    <p class="text-xs text-gray-400">

                        <span class="text-orange-500">*</span> We will respond to your message as soon as possible.

                    </p>

                </form>

            </div>

        </div>

        <!-- Our Location -->

        <div class="text-center mt-16 mb-8">

            <h2 class="text-2xl lg:text-3xl font-bold text-gray-900">

                Our Location

            </h2>

            <div class="w-10 h-1 bg-orange-500 rounded-full mx-auto mt-2"></div>

        </div>

        <div class="rounded-2xl overflow-hidden shadow-lg h-[420px]">

            <iframe
                class="w-full h-full"
                loading="lazy"
                allowfullscreen
                referrerpolicy="no-referrer-when-downgrade"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5142.905108971342!2d112.69419699999999!3d-7.278740300000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fd00011263eb%3A0x7858d11b0885a9f6!2sGreat%20Crystal%20School!5e1!3m2!1sen!2sid!4v1783910877836!5m2!1sen!2sid">
            </iframe>

        </div>

        <!-- Quick Info Strip -->

        <div class="mt-8 rounded-3xl bg-orange-50 p-8">

            <div class="grid sm:grid-cols-3 gap-8">

                <div
                    v-for="info in quickInfo"
                    :key="info.title"
                    class="flex items-center gap-4">

                    <div class="w-14 h-14 rounded-full bg-white flex items-center justify-center shrink-0">

                        <component :is="info.icon" class="w-6 h-6 text-orange-500" :stroke-width="1.8" />

                    </div>

                    <div>
                        <p class="font-bold text-gray-900 text-sm">{{ info.title }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ info.description }}</p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

</template>
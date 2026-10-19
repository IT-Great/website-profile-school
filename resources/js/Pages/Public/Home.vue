<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'

import HeroSection from '@/Components/Home/HeroSection.vue'
import StatisticsSection from '@/Components/Home/StatisticsSection.vue'
import AboutSection from '@/Components/Home/AboutSection.vue'
import ProgramsSection from '@/Components/Home/ProgramsSection.vue'
import WhyChooseSection from '@/Components/Home/WhyChooseSection.vue'
import NewsSection from '@/Components/Home/NewsSection.vue'
import GalerySection from '@/Components/Home/GalerySection.vue'
import CtaSection from '@/Components/Home/CtaSection.vue'
import ContactSection from '@/Components/Home/ContactSection.vue'
import { Head } from '@inertiajs/vue3'

</script>

<template>

<Head title="Home" />

<GuestLayout>

    <HeroSection/>

    <StatisticsSection/>

    <AboutSection/>

    <ProgramsSection/>

    <WhyChooseSection/>

    <NewsSection/>

    <GalerySection/>

    <CtaSection/>

    <ContactSection/>

</GuestLayout>

</template>
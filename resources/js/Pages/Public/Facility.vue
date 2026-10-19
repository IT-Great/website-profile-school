<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'

import HeroSection from '@/Components/Facility/HeroSection.vue'
import IntroSection from '@/Components/Facility/IntroSection.vue'
import FacilitiesSection from '@/Components/Facility/FacilitiesSection.vue'
import SchoolTourSection from '@/Components/Facility/SchoolTourSection.vue'
import { Head } from '@inertiajs/vue3'
</script>

<template>

<GuestLayout>

    <HeroSection/>

    <IntroSection/>

    <FacilitiesSection/>

    <SchoolTourSection/>

</GuestLayout>

</template>
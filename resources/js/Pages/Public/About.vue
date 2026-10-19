<script setup>
    import GuestLayout from '@/Layouts/GuestLayout.vue'

    import HeroSection from '@/Components/About/HeroSection.vue'
    import Explain from '@/Components/About/Explain.vue'
    import ProgramsSection from '@/Components/About/ProgramsSection.vue'
    import Accreditation from '@/Components/About/Accreditation.vue'
    import History from '@/Components/History/HistorySection.vue'

    import { Head } from '@inertiajs/vue3'
</script>

<template>

<Head title="About" />

<GuestLayout>

    <HeroSection/>

    <Explain/>

    <ProgramsSection/>

    <Accreditation/>

    <History/>

</GuestLayout>

</template>
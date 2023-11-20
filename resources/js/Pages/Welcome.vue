<script setup>
import NavBar from '../Landing Page/components/NavBar.vue'
import Footer from '../Landing Page/components/Footer.vue';
import Gallery from '../Landing Page/components/sections/Gallery.vue';
import ContactUs from '../Landing Page/components/sections/ContactUs.vue';
import Hero from '../Landing Page/components/sections/Hero.vue';
import AboutUs from '../Landing Page/components/sections/AboutUs.vue';
import Pricing from '../Landing Page/components/sections/Pricing.vue';
import { Head } from '@inertiajs/vue3';
import FlashMessage from '@/Components/Flash.vue';
defineProps({
    isLogin:{
        type:Object,
    },
    gym:{
        type:Object,
    },
    plans:{
        type:Object,
    },
    
});

</script>

<template>
    <div class="bg-gray-900">
        <Head title="Welcome" />
        <NavBar :isLogin="isLogin"/>
        <Hero id="home" :key="0"/>
        <AboutUs id="nosotros" :key="1"/>
        <Gallery id="galeria" :key="2"/>
        <Pricing id="precios" :plans="plans" class="mt-6" :key="3"/>
        <ContactUs id="contactanos" :gym="gym" :key="4"/>
        <Footer :key="5"/>
        <flash-message />
    </div>
</template>
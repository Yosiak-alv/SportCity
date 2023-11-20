<script setup>
    // Import Swiper Vue.js components
    import { Swiper, SwiperSlide } from 'swiper/vue';
  
    // Import Swiper styles
    import 'swiper/css';
  
    import 'swiper/css/effect-cards';
  
    // import required modules
    import { EffectCards } from 'swiper/modules';
 
    /* const photos = [
        '/src/assets/img/photo18.jpg',
        '/src/assets/img/photo21.jpg',
        '/src/assets/img/photo22.jpg'
    ]; */
</script>
<template>
    <swiper
      :effect="'cards'"
      :grabCursor="true"
      :modules="[EffectCards]"
      class="hero-swiper"
    >
      <swiper-slide >
        <img class="object-cover object-center rounded" alt="hero" src="/storage/img/welcome-page/img/photo18.jpg">
      </swiper-slide>
      <swiper-slide >
        <img class="object-cover object-center rounded" alt="hero" src="/storage/img/welcome-page/img/photo27.jpg">
      </swiper-slide>
      <swiper-slide>
        <img class="object-cover object-center rounded" alt="hero" src="/storage/img/welcome-page/img/photo22.jpg">
      </swiper-slide>
      <swiper-slide>
        <img class="object-cover object-center rounded" alt="hero" src="/storage/img/welcome-page/img/photo25.jpg">
      </swiper-slide>
      <swiper-slide>
        <img class="object-cover object-center rounded" alt="hero" src="/storage/img/welcome-page/img/photo19.jpg">
      </swiper-slide>
      <swiper-slide>
        <img class="object-cover object-center rounded" alt="hero" src="/storage/img/welcome-page/img/photo23.jpg">
      </swiper-slide>
      
    </swiper>
</template>

  
<script setup>
import {ref} from 'vue';
import SliderCard from '../SlideCard.vue';
</script>

<style>
    .hero{
        background-image: linear-gradient(to bottom, rgba(31, 41, 55, 0.90) 0%,rgba(22, 30, 45, 0.53)),
        url('/storage/img/welcome-page/img/back-opt4.jpg');
    }
</style>

<template>
    <section class="text-gray-400 bg-gray-900 body-font hero">
<!--         <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center" ref="targetEl"> -->
        <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center" >
            <div class="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center" >
                <h2 id="0" class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl text-gray-200 space-y-3">SportCity
                    <span class="bg-green-600 rounded-md "> <br class="hidden lg:inline-block">Adaptive Fitness Center </span>
                </h2>
                <p  
                    class="max-w-2xl mb-6 font-light  lg:mb-8 md:text-lg lg:text-xl text-gray-300">
                    Enjoy your first class for free.
                    We adapt to your needs and enhance your ability. 
                </p>
            </div>
            <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6">
                <SliderCard/>    
            </div>
        </div>   
    </section>
    
</template>


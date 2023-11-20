<script setup>
const props = defineProps({
    plans:{
        type:Object,
    },
    
});
</script>

<template>
    <section class="bg-gray-900 ">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
            <div class="mx-auto max-w-screen-md text-center mb-8 lg:mb-12">
                <h2 id="3" class="mb-4 text-4xl tracking-tight font-extrabold text-white">Competitive <span class="bg-green-600 rounded-md">Pricing</span> </h2>
                <p class="mb-5 font-light sm:text-xl text-gray-400">
                    Visit us today to explore our membership options, experience the real workout and take the 
                    first step towards a healthier, happier life. Your adventure is about to begin.
                </p>
            </div>
            <div class="space-y-8 lg:grid lg:grid-cols-2 sm:gap-6 xl:gap-10 lg:space-y-0"><!-- space-y-8 lg:grid lg:grid-cols-3 sm:gap-6 xl:gap-10 lg:space-y-0 -->
                <!-- Pricing Card -->
                <div v-for="plan in plans" :key="plan.id" >
                    <div class="flex flex-col p-6 mx-auto max-w-lg text-center rounded-lg border shadow border-gray-600 xl:p-8 bg-gray-800 text-white">
                        <h3 class="mb-4 text-2xl font-semibold">{{plan.name}}</h3>
                        <p class="font-light sm:text-lg text-gray-400">{{plan.description}}</p>
                        <div class="flex justify-center items-baseline my-8">
                            <span class="mr-2 text-5xl font-extrabold">${{plan.price}}</span>
                            <span class="text-gray-400">/{{plan.duration}}</span>
                        </div>
                        <!-- List -->
                        <ul role="list" class="mb-8 space-y-4 text-left" v-for="detail in plan.details" >
                            <li class="flex items-center space-x-3">
                                <!-- Icon -->
                                <svg class="flex-shrink-0 w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                <span>{{ detail.detail }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
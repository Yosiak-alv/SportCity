<script setup>
    import { Head, Link,useForm } from '@inertiajs/vue3';
    import InputError from '@/Components/InputError.vue';
    const form = useForm({
        name:'',
        email:'',
    });
    const sendEmail = () => {
        form.post(route('contact_us.sendEmail'),{
            preserveScroll: true,
            preserveState: false,
            onFinish: () => form.reset(),}
        );
    }
    const props  = defineProps({
        gym:{
            type:Object,
        },
    });
</script>

<template>
    <section class="text-gray-400 bg-gray-900 body-font relative">
        <div class="container px-5 py-24 mx-auto flex sm:flex-nowrap flex-wrap">
            <div class="lg:w-2/3 md:w-1/2 bg-gray-900 rounded-lg overflow-hidden sm:mr-10 p-10 flex items-end justify-start relative">
            <iframe width="100%" height="100%" title="map" class="absolute inset-0" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2304.6707810504504!2d-89.72409581788433!3d13.71973352676797!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f62b7f9be265a6f%3A0x3042ce0be8540748!2sSport%20City!5e0!3m2!1ses!2ssv!4v1692140753216!5m2!1ses!2ssv" style="filter: grayscale(1) contrast(1.2) opacity(0.16);"></iframe>
            <div class="bg-gray-900 relative flex flex-wrap py-6 rounded shadow-md">
                <div class="lg:w-1/2 px-6">
                    
                    <h2  class="text-white text-xs font-extrabold tracking-tight">ADDRESS</h2>
                    <p class="mt-1 font-light sm:text-lg" v-if="gym != null" >{{gym?.address ?? 'Gym Current Unvailable'}}</p>
                    </div>
                    <div class="lg:w-1/2 px-6 mt-4 lg:mt-0">
                        <h2 class="text-white text-xs font-extrabold tracking-tight">EMAIL</h2>
                        <a class="text-green-400 leading-relaxed font-light sm:text-lg">{{gym?.email ?? ''}}</a>
                        <h2 class="text-white text-xs font-extrabold tracking-tight mt-1">PHONE</h2>
                        <p class="leading-relaxed font-light sm:text-lg">{{gym?.phone ?? ''}}</p>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/3 md:w-1/2 flex flex-col md:ml-auto w-full md:py-8 mt-8 md:mt-0">
                <h2 id="4" class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl text-gray-200">Contact us</h2>
                <p class="mb-5 font-light sm:text-lg text-gray-400">Let's stay in touch.</p>
                <form  @submit.prevent="sendEmail()">
                    <div class="relative mb-4">
                        <label for="name" class="leading-7 text-sm text-gray-400">Name</label>
                        <input v-model="form.name" type="text" id="name" name="name" class="w-full bg-gray-800 rounded border border-gray-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-900 text-base outline-none text-gray-100 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div class="relative mb-4">
                        <label for="email" class="leading-7 text-sm text-gray-400">Email</label>
                        <input v-model="form.email" type="email" id="email" name="email" class="w-full bg-gray-800 rounded border border-gray-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-900 text-base outline-none text-gray-100 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                    <button :disabled="form.processing" 
                    class="text-white bg-green-500 border-0 py-2 px-6 focus:outline-none hover:bg-green-600 rounded text-lg">Submit</button>
                    <p class="text-xs text-gray-400 text-opacity-90 mt-3">Start your fitness journey today and get healthy.</p>
                </form>
            </div>
        </div>
    </section>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import { Head ,usePage} from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
const props = defineProps([
    'clients',
    'coaches',
    'users',
    'plans' ,
    'suscriptions', 
    'purchases',
    'training_sessions', 
    'exercises' ,
    'gyms',
    'products', 
]);
//role things
const roles = ref(usePage().props.auth.user_roles);

const getRoles = (data) => {
    return roles.value.find((role) =>
        role.toLowerCase().includes(data)
    ) ? true : false;
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class=" mx-auto sm:px-6 lg:px-8 space-y-6 py-12">
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <div class=" mx-auto sm:px-6 lg:px-8 space-y-6 h-full">
                        <div class="bg-green-600 overflow-hidden shadow-sm sm:rounded-lg text-gray-100">
                            <div class="flex flex-row">
                                <div class="flex justify-end items-center">
                                    <div class="p-2">
                                        <div class="text-center inline text-2xl">
                                            Clients : {{props.clients}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <div class=" mx-auto sm:px-6 lg:px-8 space-y-6 h-full">
                            <div class="bg-green-600 overflow-hidden shadow-sm sm:rounded-lg text-gray-100">
                                <div class="flex flex-row">
                                <!--    <div>
                                        <img src="/storage/img/icon-clients.png" class="rounded">
                                    </div> -->
                                    <div class="flex justify-start items-center">
                                        <div class="w-full p-2">
                                            <div class="text-center inline text-2xl">
                                                Coaches : {{props.coaches}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <div class=" mx-auto sm:px-6 lg:px-8 space-y-6 h-full">
                            <div class="bg-green-600 overflow-hidden shadow-sm sm:rounded-lg text-gray-100">
                                <div class="flex flex-row">
                                <!--    <div>
                                        <img src="/storage/img/icon-clients.png" class="rounded">
                                    </div> -->
                                    <div class="flex justify-start items-center">
                                        <div class="w-full p-2">
                                            <div class="text-center inline text-2xl">
                                                Suscriptions : ${{props.suscriptions}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <div class=" mx-auto sm:px-6 lg:px-8 space-y-6 h-full">
                            <div class="bg-green-600 overflow-hidden shadow-sm sm:rounded-lg text-gray-100">
                                <div class="flex flex-row">
                                <!--    <div>
                                        <img src="/storage/img/icon-clients.png" class="rounded">
                                    </div> -->
                                    <div class="flex justify-start items-center">
                                        <div class="w-full p-2">
                                            <div class="text-center inline text-2xl">
                                                Purchases : ${{props.purchases}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <div class=" mx-auto sm:px-6 lg:px-8 space-y-6 h-full">
                            <div class="bg-green-600 overflow-hidden shadow-sm sm:rounded-lg text-gray-100">
                                <div class="flex flex-row">
                                <!--    <div>
                                        <img src="/storage/img/icon-clients.png" class="rounded">
                                    </div> -->
                                    <div class="flex justify-start items-center">
                                        <div class="w-full p-2">
                                            <div class="text-center inline text-2xl">
                                                Sessions : {{props.training_sessions}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <div class=" mx-auto sm:px-6 lg:px-8 space-y-6 h-full">
                            <div class="bg-green-600 overflow-hidden shadow-sm sm:rounded-lg text-gray-100">
                                <div class="flex flex-row">
                                <!--    <div>
                                        <img src="/storage/img/icon-clients.png" class="rounded">
                                    </div> -->
                                    <div class="flex justify-start items-center">
                                        <div class="w-full p-2">
                                            <div class="text-center inline text-2xl">
                                                Exercises : {{props.exercises}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <div class=" mx-auto sm:px-6 lg:px-8 space-y-6 h-full">
                            <div class="bg-green-600 overflow-hidden shadow-sm sm:rounded-lg text-gray-100">
                                <div class="flex flex-row">
                                <!--    <div>
                                        <img src="/storage/img/icon-clients.png" class="rounded">
                                    </div> -->
                                    <div class="flex justify-start items-center">
                                        <div class="w-full p-2">
                                            <div class="text-center inline text-2xl">
                                                Plans : {{props.plans}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div v-if="getRoles('administrator') || getRoles('manager')">
                        <div class=" mx-auto sm:px-6 lg:px-8 space-y-6 h-full">
                            <div class="bg-green-600 overflow-hidden shadow-sm sm:rounded-lg text-gray-100">
                                <div class="flex flex-row">
                                <!--    <div>
                                        <img src="/storage/img/icon-clients.png" class="rounded">
                                    </div> -->
                                    <div class="flex justify-start items-center">
                                        <div class="w-full p-2">
                                            <div class="text-center inline text-2xl">
                                                Gyms : {{props.gyms}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div v-if="getRoles('administrator') || getRoles('manager')">
                        <div class=" mx-auto sm:px-6 lg:px-8 space-y-6 h-full">
                            <div class="bg-green-600 overflow-hidden shadow-sm sm:rounded-lg text-gray-100">
                                <div class="flex flex-row">
                                <!--    <div>
                                        <img src="/storage/img/icon-clients.png" class="rounded">
                                    </div> -->
                                    <div class="flex justify-start items-center">
                                        <div class="w-full p-2">
                                            <div class="text-center inline text-2xl">
                                                Users : {{props.users}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>          
        </div>
    </AuthenticatedLayout>
</template>

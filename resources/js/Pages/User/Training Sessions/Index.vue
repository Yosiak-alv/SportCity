<script setup>
import Card from '@/Components/Card.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link, router, usePage} from '@inertiajs/vue3';
import {ref, watch, onMounted} from "vue";
import $ from 'jquery';
import DataTable from 'datatables.net-dt';
import {debounce} from "lodash";
import Paginate from '@/Components/Paginate.vue';

const props = defineProps({
    training_sessions:{
        type:Object,
        required:true
    },
    exercises:{
        type:Object,
        required:true
    },
    filters:{
        type:Object
    },
});

const search = ref(props.filters.search);
//search Handling
watch(search, debounce((value) => {
    router.get(route('training-sessions.index'), {search:value}, { preserveState:true , replace:true ,preserveScroll:true});
},500));

const permissions = ref(usePage().props.auth.user_role_permissions);

const getPermission = (data) => {
    return permissions.value.find((permission) =>
        permission.toLowerCase().includes(data)
    ) ? true : false;
}

const shortDescript = (description) => {
    return description.substring(0, 30) + '...';
}

//Exercises
onMounted(() => {
    $('#exercises').DataTable({
        /* pageLength : 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']], */
    });
});
</script>
<style>
    @import 'datatables.net-dt';
    #exercises_length select {
        background: rgb(31, 41, 55);
        color: #eee;
    }
    .exercises_length{
        margin-bottom: 10px;
    }
    #exercises_length{
        margin-bottom: 10px;
    }
</style>
<template>
    <Head title="Training Sessions" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Training Sessions</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="flex justify-between mt-5">
                    <div>
                        <div class="relative w-full ml-6">
                            <div class="flex flex-row space-x-2">
                                <div>
                                    <div class="absolute inset-y-0 left-29  flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                    </div>
                                    <input type="text" id="search" v-model="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" placeholder="Search" required>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="mr-6">
                        <Link 
                            :href="route('training-sessions.create')" 
                            method="get" as="button"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                            v-if="getPermission('create training session')"
                        >
                            Create Training Session
                        </Link>
                        
                    </div>
                </div>
                <div>
                    <div v-if="props.training_sessions.data.length != 0">        
                        <div class="grid grid-cols-4 mx-auto max-w-7xl">
                            <Card v-for="training_session in props.training_sessions.data" class="text-base p-2">
                                <div class="w-full p-2 ">
                                    <div class="text-center inline text-4xl">
                                        <div v-if="getPermission('show training session')">
                                            <Link as="button" :href="route('training-sessions.show',training_session.id)" class="hover:underline">
                                                {{ training_session.name }}
                                            </Link>
                                        </div>
                                        <div v-else>
                                            {{ training_session.name }}
                                        </div>
                                       
                                    </div>
                                    <div class="my-1.5 text-center">
                                        <span class="font-semibold text-center">Description:</span> {{shortDescript(training_session.description)}}
                                    </div>
                                    <div class="my-1.5 text-center">
                                        <span class="font-semibold">Duration:</span> {{ training_session.duration }}
                                    </div>
                                    <span class="font-semibold">Starts At:</span> {{ training_session.starts_at }}
                                    <br>
                                    <span class="font-semibold">Ends At:</span> {{ training_session.finish_at }}
                                </div>
                            </Card>
                        </div>
                        <Paginate :links="props.training_sessions.links" class="mb-6"/>
                    </div>
                    <div v-else>
                        <Card class="mb-8">
                            <div class=" border-gray-400 flex flex-col margin-b mb-4">
                                <div >
                                    <h2 class="text-4xl font-bold ml-8 mt-3">
                                        No Training Sessions was found, but you can create new ones.
                                    </h2>
                                </div>  
                            </div>
                        </Card>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="py-9">
            <Card class="max-w-7xl" v-if="props.exercises.length != 0">
                <header class="flex justify-between mt-4">
                    <div>
                        <h2 class="text-4xl font-bold ml-5 mt-3 ">
                            Exercises
                        </h2>
                    </div>
                    <div>
                        <Link 
                            :href="route('exercises.create')"
                            method="get" as="button"
                            class=" mr-4 mt-5 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                            v-if="getPermission('create exercise')"
                        >
                            Create Exercise
                        </Link>
                    </div>
                </header>
            
                <div class="p-6">
                    <table id="exercises" class="mb-4 rounded-lg w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">Instructions</th>
                                <th scope="col" class="px-6 py-3">Created At</th>
                                <th scope="col" class="px-6 py-3">Updated At</th>
                                <th scope="col" class="px-6 py-3">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="exercise in props.exercises" :key="exercise.id" class="hover:bg-gray-500  bg-white border-b dark:bg-gray-700 dark:border-gray-900">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white ">
                                    {{exercise.name}}
                                </th>
                                <td class="px-6 py-4">
                                    {{shortDescript(exercise.instructions)}}
                                </td>
                                <td class="px-6 py-4 ">
                                    {{exercise.created_at}}
                                </td>
                                <td class="px-6 py-4 ">
                                    {{exercise.updated_at}}
                                </td>
                                <td class="px-6 py-4 ">
                                    <div class="flex space-x-4">
                                        <Link 
                                            method="get" as="button"
                                            class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
                                            :href="route('exercises.show',exercise.id)"
                                            v-if="getPermission('show exercise')"
                                        >
                                            Show
                                        </Link>                              
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </Card>
            <Card v-else class="mb-8">
                <div class=" border-gray-400 flex flex-col margin-b mb-4">
                    <div >
                        <h2 class="text-4xl font-bold ml-8 mt-3">
                            No Exercises was found, but you can created new ones.
                        </h2>
                    </div>
                    <div>
                        <Link 
                            :href="route('exercises.create')"
                            method="get" as="button"
                            class=" ml-8 mt-3 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                            v-if="getPermission('create exercise')"
                        >
                            Create Exercise
                        </Link>
                    </div>
                </div>
            </Card>
        </div>
    
    </AuthenticatedLayout> 
</template>
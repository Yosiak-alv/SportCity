<script setup>
import Card from '@/Components/Card.vue';
import { Link, router, usePage} from '@inertiajs/vue3';
import {ref, watch} from "vue";
import {debounce} from "lodash";
import Paginate from '@/Components/Paginate.vue';


const props = defineProps({
    clientId:{
        type:Number,
        required:true
    },
    trainingSessions:{
        type:Object,
        required:true
    },
    filters:{
        type:Object
    },
    deleted:{
        type:Boolean,
        required:false,
        default:false,
    }
});

const search = ref(props.filters.search);
//search Handling
watch(search, debounce((value) => {
    router.get(route('clients.show',{id:props.clientId}), {search:value}, { preserveState:true , replace:true ,preserveScroll:true});
},500));

const shortDescript = (description) => {
    return description.substring(0, 30) + '...';
}

const permissions = ref(usePage().props.auth.user_role_permissions);

const getPermission = (data) => {
    return permissions.value.find((permission) =>
        permission.toLowerCase().includes(data)
    ) ? true : false;
}
</script>

<template>
    <div v-if="props.trainingSessions.data.length != 0">

        <div class="max-w-7xl mx-auto text-center my-4 text-gray-900 dark:text-gray-100">
            <h2 class="text-3xl font-semibold">Training Sessions</h2>
        </div>
        <div>
            <Card class="max-w-7xl mb-5">
                <div class="flex justify-between p-2">
                    <div>
                        <div class=" relative">
                            <div class="absolute inset-y-0 left-29  flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                            </div>
                            <input type="text" id="search" v-model="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" placeholder="Search">
                        </div>
                    </div>
                    <div>
                        <Link 
                            :href="route('clients.assignAttendanceTrainingSessions',{client:props.clientId})"
                            method="get" as="button"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                            v-if="props.deleted == false && getPermission('assign client training_sessions')"
                        >
                            Assign Training Sessions
                        </Link>
                    </div>
                </div>
            
            </Card>
        
        </div>
        <div class="grid grid-cols-4 mx-auto max-w-7xl">
            <Card v-for="training_session in props.trainingSessions.data" class="text-base p-2">
                <div class="w-full p-2 ">
                    <div class="text-center">
                        <Link as="button"  :href="route('clients.showAttendanceTrainingSession',{client:props.clientId,id:training_session.id})" 
                            class="inline text-4xl hover:underline">
                            {{training_session.id}},{{ training_session.name }},{{ training_session.pivot.client_id}}
                        </Link>
                    </div>
                    <div class="my-1.5 text-center">
                        <span class="font-semibold text-center">Description:</span> {{shortDescript(training_session.description)}}
                    </div>
                    <div class="my-1.5 text-center">
                        <span class="font-semibold">Duration:</span> {{ training_session.duration }}
                    </div>
                    <span class="font-semibold ">Starts At:</span> {{ training_session.starts_at }}
                    <br>
                    <span class="font-semibold">Ends At:</span> {{ training_session.finish_at }}
                </div>
            </Card>
        </div>
        <Paginate :links="props.trainingSessions.links" class="mb-6"/>
    </div>
    <div v-else>
        <div class="max-w-7xl mx-auto text-center my-4 text-gray-900 dark:text-gray-100">
            <h2 class="text-3xl font-semibold">Training Sessions</h2>
        </div>

        <Card class="mb-8">
            <div class=" border-gray-400 flex flex-col margin-b mb-4">
                <div >
                    <h2 class="text-4xl font-bold ml-8 mt-3">
                        No Training Sessions was found, but you can assign new ones.
                    </h2>
                </div>
                <div class="mt-4 ml-8">
                    <Link 
                        :href="route('clients.assignAttendanceTrainingSessions',{client:props.clientId})"
                        method="get" as="button"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                        v-if="props.deleted == false && getPermission('assign client training_sessions')"
                    >
                        Assign Training Sessions
                    </Link>
                </div>
            </div>
        </Card>
    
    </div>
   
</template>
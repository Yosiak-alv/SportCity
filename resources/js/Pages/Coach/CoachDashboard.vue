<script setup>
import AuthenticatedCoachLayout from '@/Layouts/AuthenticatedCoachLayout.vue';
import Card from '@/Components/Card.vue';
import { Head,Link, router, usePage,useForm} from '@inertiajs/vue3';
import {ref, watch, onMounted} from "vue";
import {debounce} from "lodash";
import Paginate from '@/Components/Paginate.vue';

const props = defineProps({
    coach: {
        type: Object,
        required: true,
    },
    coach_training_sessions:{
        type: Object,
        required: true,
    },
    filters:{
        type:Object
    },
    
});

const form = useForm({
    search: props.filters.search,
});

watch(form, debounce(() => {
    router.get(route('coach.dashboard'), {search:form.search}, { preserveState:true , replace:true ,preserveScroll:true});
},500));

const shortDescript = (description) => {
    return description.substring(0, 30) + '...';
}
</script>

<template>
    <Head title="Home - Coach" />

    <AuthenticatedCoachLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">You're logged in!</h2>
        </template>

        <div class="py-9">
            <Card class="max-w-7xl">
                <div class="grid grid-cols-3 gap-4 p-6 items-center">
                    <div class="col-span-1">
                        <div class="ml-8">
                            <img src="/storage/img/coach.png" class="rounded w-40 ">
                        </div>
                    </div>
                    <div class="col-span-2">
                        <span class="inline text-5xl h-fit">{{ coach.name }}, {{coach.lastname}}</span>
                        <div class="mt-2 text-lg">
                            <br>
                            <span class="font-semibold">Phone:</span> {{ coach.phone }}
                            <br>
                            <span class="font-semibold">Address:</span> {{ coach.address }}
                            <br>
                            <span class="font-semibold">Email:</span> {{ coach.email }}
                            <br>
                            <span class="font-semibold">Gym:</span> {{ coach.gym.name }}
                            <br>
                            <span class="font-semibold">Gym Address:</span> {{coach.gym.department.name}}, {{ coach.gym.address }}
                            <br>
                            <span v-if="props.coach.deleted_at" class="font-semibold">Deleted at:</span> {{props.coach.deleted_at}}
                        </div>
                    </div>
                </div>
            </Card>
        </div>

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
                                    <input type="text" id="search" v-model="form.search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" placeholder="Search" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div v-if="props.coach_training_sessions.data.length != 0">        
                        <div class="grid grid-cols-4 mx-auto max-w-7xl">
                            <Card v-for="training_session in props.coach_training_sessions.data" class="text-base p-2">
                                <div class="w-full p-2">
                                    <div class="text-center">
                                        <div class="inline text-3xl font-semibold ">
                                            <Link as="button" :href="route('coach.training_sessions.show',training_session.id)" class="hover:underline">
                                                {{ training_session.name }}
                                            </Link>
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
                        <Paginate :links="props.coach_training_sessions.links" class="mb-6"/>
                    </div>
                    <div v-else>
                        <Card class="mb-8">
                            <div class=" border-gray-400 flex flex-col margin-b mb-4">
                                <div >
                                    <h2 class="text-4xl font-bold ml-8 mt-3">
                                        No Training Sessions assign to you
                                    </h2>
                                </div>  
                            </div>
                        </Card>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedCoachLayout>
</template>

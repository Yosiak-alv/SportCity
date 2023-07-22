<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link, router,useForm,usePage} from '@inertiajs/vue3';
import {ref} from "vue";
import Card from '@/Components/Card.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    training_sessions:{
        type:Object,
        required:true
    },
    client:{
        type:Object,
        required:true
    }
});
const shortDescript = (description) => {
    return description.substring(0, 30) + '...';
}
const form = useForm({
    client_id:props.client.id,
    training_session_id: [],
    attendance_date: []
});
</script>

<template>
    <Head title="Training Sessions"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Assign a Training Sessions</h2>
        </template>

        <div class="py-12">
            <Card class="max-w-7xl" v-if="props.training_sessions.length != 0">
                <header class="mb-3 p-2 ml-3 mt-3">
                    <div class="flex justify-between">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Client : {{props.client.name}}, {{props.client.lastname}}</h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                In this section you can Assign one or more training sessions for a client...
                            </p>
                        </div>
                    </div>
                </header>

                <div class="overflow-y-auto " style="height: 40rem;">
                    <form @submit.prevent="form.post(route('clients.storeAttendanceTrainingSession',{client:props.client.id}))" class="p-5">
                        <div class="grid grid-cols-2 gap-4 ">
                            <div v-for="training_session in props.training_sessions" :key="training_session.id">
                                <div class="flex flex-col mb-4">
                                    <div class="flex items-center space-x-3">
                                        <input :value="training_session.id" v-model="form.training_session_id" id="training_session_id" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <InputLabel for="training_session_id" :value="training_session.name"/> 
                                        <InputError class="mt-2" :message="form.errors.training_session_id" />
                                        
                                    </div>
                                    <Card class="max-w-7xl mb-5 block w-full">
                                        <div class="w-full p-2 bg-gray-700">
                                            <div class="text-center">
                                                <p class="inline text-4xl">
                                                    {{training_session.id}},{{ training_session.name }}
                                                </p>
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
                            </div>
                        </div>                   
                        <div class="flex items-center gap-4">
                            <PrimaryButton :disabled="form.processing">Assign</PrimaryButton>
                        </div>
                    </form>
                </div>
            </Card>
            <Card v-else>
                <div class=" border-gray-400 flex flex-col margin-b mb-4">
                    <div >
                        <h2 class="text-4xl font-bold ml-8 mt-3">
                            No Training Sessions Avalible.
                        </h2>
                    </div>
                    <div>
                        <Link 
                            :href="route('clients.show',props.client.id)"
                            method="get" as="button"
                            class=" ml-8 mt-3 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                        >
                            Return Back
                        </Link>
                    </div>
                </div>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>
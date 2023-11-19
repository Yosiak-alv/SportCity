<script setup>
import AuthenticatedClientLayout from '@/Layouts/AuthenticatedClientLayout.vue';
import Card from '@/Components/Card.vue';
import { Head,Link, router, usePage, useForm} from '@inertiajs/vue3';
import {ref} from "vue";
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
const props = defineProps({
    client_attendace_training_session:{
        type:Object,
        required:true
    },
    training_session_coaches:{
        type:Object,
        required:true
    },
    training_session_exercises:{
        type:Object,
        required:true
    }
});

</script>

<template>
    <Head title="Client Attendace"/>
    <AuthenticatedClientLayout >
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Client Training Session</h2>
        </template>

        <div class="py-12">
            <Card class="max-w-7xl spacing-y-6">
                <div class="grid grid-cols-3 gap-2 p-5 items-center" >
                    <div>
                        <div class="ml-8">
                            <img src="/storage/img/calendar.png" class="rounded w-40 ">
                        </div>
                    </div>
                    <div class="mt-2 text-lg">
                        <br>
                        <div v-if="props.client_attendace_training_session.pivot.attendance_date">
                            <span class="font-semibold mt-1 ">Attendace Date:</span> {{props.client_attendace_training_session.pivot.attendance_date}}
                        </div>
                    </div>
                    <div class="mt-2 text-lg">
                        <span class="font-semibold">Description:</span> {{ props.client_attendace_training_session.description }}
                        <br>
                        <span class="font-semibold">Duration:</span> {{ props.client_attendace_training_session.duration }}
                        <br>
                        <span class="font-semibold">Starts At:</span> {{ props.client_attendace_training_session.starts_at }}
                        <br>
                        <span class="font-semibold">Ends At:</span> {{ props.client_attendace_training_session.finish_at }}
                        <br>
                    </div>
                </div>
            </Card>
        </div>
        
        <div class="py-9">
            <div class="grid grid-flow-row-dense grid-cols-4 grid-rows-1 auto-cols-max">
                <div class="col-span-2">
                    <Card>
                        <div class="p-6">
                        <div class="ml-8">
                            <div >
                                <h2 class="text-4xl font-bold ml-2 mt-3 border-b border-gray-400">
                                    Coaches
                                </h2>
                            </div>
                            <div class="overflow-y-scroll" style="height: 30rem;" >
                                <div v-if="props.training_session_coaches.length != 0 ">
                                    <div class="text-base p-4" v-for="training_session_coach in props.training_session_coaches">
                                        <div class="w-full text-justify ">
                                            <h3 class="inline text-3xl">
                                                {{ training_session_coach.name }}, {{training_session_coach.lastname}}
                                            </h3>
                                            <div class="my-1.5">
                                                <span class="font-semibold">Contact: </span> {{training_session_coach.email}}
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div v-else>
                                    <h3 class="inline text-2xl">
                                        No Coaches Assigned
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    </Card>
                </div>
                <div class="col-span-2">
                    <Card>
                        <div class="p-6">
                            <div class="ml-8">
                                <div >
                                    <h2 class="text-4xl font-bold ml-2 mt-3 border-b border-gray-400">
                                        Exercises
                                    </h2>
                                </div>
                                <div class="overflow-y-scroll" style="height: 30rem;" >
                                    <div v-if="props.training_session_exercises.length != 0">
                                        <div class="text-base p-4" v-for="training_session_exercise in props.training_session_exercises">
                                            <div class="w-full text-justify ">
                                                <h3 class="inline text-3xl">
                                                    {{training_session_exercise.name }} X {{ training_session_exercise.pivot.repetitions }}
                                                </h3>
                                                <div class="my-1.5">
                                                    <span class="font-semibold ">Demonstration: </span> {{training_session_exercise.demonstration_url}}
                                                </div>
                                                <div class="my-1.5">
                                                    <span class="font-semibold ">Intructions: </span> {{training_session_exercise.instructions}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <h3 class="inline text-2xl">
                                            No Exercises Assigned
                                        </h3>
                                    </div> 
                                </div>   
                            </div>
                        </div>
                    </Card>
                </div>
            </div>
        </div>
    </AuthenticatedClientLayout >
</template>
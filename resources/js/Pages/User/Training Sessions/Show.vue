<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Components/Card.vue';
import { Head, Link, router, usePage, useForm} from '@inertiajs/vue3';
import {ref} from "vue";
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
const props = defineProps({
    training_session:{
        type:Object,
        required:true
    },
});

const permissions = ref(usePage().props.auth.user_role_permissions);

const getPermission = (data) => {
    return permissions.value.find((permission) =>
        permission.toLowerCase().includes(data)
    ) ? true : false;
}

const edit = (id) => {
    router.get(route('training-sessions.edit',id));
};

//---Modal Section Delete Training Session----
const confirmingDeletion = ref(false);
    
const confirmDeletion = () => {
    confirmingDeletion.value = true;
};

const closeModal = () => {
    confirmingDeletion.value = false;
};

const destroyTrainingSession = () => {
    router.delete(route('training-sessions.destroy',props.training_session.id),{
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => closeModal(),
    });
}

//---Modal Section Delete All Clients----
const confirmingClientDeletion = ref(false);
    
const confirmClientDeletion = () => {
    confirmingClientDeletion.value = true;
};

const closeClientModal = () => {
    confirmingClientDeletion.value = false;
};

const disassociateAllClients = () => {
    router.delete(route('training-sessions.disassociateAllClients',props.training_session.id),{
        preserveScroll: true,
        onSuccess: () => closeClientModal(),
        onError: () => closeClientModal(),
    });
}
//---Modal Section Delete All Coach----
const confirmingCoachDeletion = ref(false);
    
const confirmCoachDeletion = () => {
    confirmingCoachDeletion.value = true;
};

const closeCoachModal = () => {
    confirmingCoachDeletion.value = false;
};

const disassociateAllCoach = () => {
    router.delete(route('training-sessions.disassociateAllCoaches',props.training_session.id),{
        preserveScroll: true,
        onSuccess: () => closeCoachModal(),
        onError: () => closeCoachModal(),
    });
}
//---Modal Section Delete All Coach----
const confirmingExerciseDeletion = ref(false);
    
const confirmExerciseDeletion = () => {
    confirmingExerciseDeletion.value = true;
};

const closeExerciseModal = () => {
    confirmingExerciseDeletion.value = false;
};

const disassociateAllExercise = () => {
    router.delete(route('training-sessions.disassociateAllExercises',props.training_session.id),{
        preserveScroll: true,
        onSuccess: () => closeExerciseModal(),
        onError: () => closeExerciseModal(),
    });
}
</script>

<template>
    <Head title="Training Session Show"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Training Session Details</h2>
        </template>

        <div class="py-12">
            <Card class="max-w-7xl spacing-y-6">
                <div class="grid grid-cols-3 gap-2 p-5 items-center" >
                    <div>
                        <div class="ml-12">
                            <svg fill="#000000" class="flex-shrink-0 ml-2 w-32 h-32 fill-gray-400" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 428.636 428.636" xml:space="preserve" stroke="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path id="XMLID_908_" d="M89.838,150.039c0,5.247-4.253,9.5-9.5,9.5H41.071c-5.247,0-9.5-4.253-9.5-9.5s4.253-9.5,9.5-9.5h39.267 C85.585,140.539,89.838,144.792,89.838,150.039z M292.56,159.539h39.269c5.247,0,9.5-4.253,9.5-9.5s-4.253-9.5-9.5-9.5H292.56 c-5.247,0-9.5,4.253-9.5,9.5S287.313,159.539,292.56,159.539z M96.384,198.216h-71.36c-2.52,0-4.936-1.001-6.718-2.782 L2.783,179.909C1.001,178.127,0,175.711,0,173.191V50.627c0-2.52,1.001-4.936,2.783-6.718l15.524-15.524 c1.782-1.781,4.198-2.782,6.718-2.782h71.36c2.52,0,4.936,1.001,6.717,2.782l15.524,15.524c1.782,1.782,2.783,4.198,2.783,6.718 v26.18H251.49v-26.18c0-2.52,1.001-4.936,2.782-6.718l15.524-15.524c1.782-1.781,4.198-2.782,6.718-2.782h71.359 c2.52,0,4.936,1.001,6.718,2.782l15.524,15.524c1.782,1.781,2.783,4.198,2.783,6.718v122.564c0,2.52-1.001,4.937-2.783,6.718 l-15.524,15.524c-1.782,1.781-4.198,2.782-6.718,2.782h-71.359c-2.52,0-4.936-1.001-6.718-2.782l-15.524-15.524 c-1.781-1.782-2.782-4.198-2.782-6.718v-26.18H121.409v26.18c0,2.52-1.001,4.936-2.783,6.718l-15.524,15.524 C101.32,197.215,98.904,198.216,96.384,198.216z M270.49,169.257l9.959,9.959h63.49l9.96-9.96V54.562l-9.96-9.96h-63.49 l-9.959,9.959V169.257z M121.409,128.011h16.522v-10.595c0-5.247,4.253-9.5,9.5-9.5s9.5,4.253,9.5,9.5v10.595h14.444v-10.595 c0-5.247,4.253-9.5,9.5-9.5s9.5,4.253,9.5,9.5v10.595h14.442v-10.595c0-5.247,4.253-9.5,9.5-9.5c5.247,0,9.5,4.253,9.5,9.5v10.595 h27.673V95.806H121.409V128.011z M92.449,179.216l9.959-9.959V54.561l-9.959-9.959h-63.49L19,54.562v114.694l9.959,9.959H92.449z M428.636,255.445V378.01c0,2.52-1.001,4.937-2.783,6.718l-15.526,15.524c-1.781,1.781-4.197,2.782-6.717,2.782h-71.358 c-2.52,0-4.936-1.001-6.718-2.782l-15.524-15.524c-1.781-1.782-2.782-4.198-2.782-6.718v-26.18H177.146v26.18 c0,2.52-1.001,4.936-2.782,6.718l-15.525,15.524c-1.781,1.781-4.198,2.782-6.717,2.782H80.76c-2.52,0-4.937-1.001-6.718-2.783 L58.52,384.726c-1.782-1.781-2.782-4.197-2.782-6.717V255.445c0-2.52,1-4.936,2.782-6.717l15.522-15.524 c1.781-1.782,4.198-2.783,6.718-2.783h71.362c2.52,0,4.936,1.001,6.717,2.782l15.525,15.524c1.781,1.782,2.782,4.198,2.782,6.718 v26.18h130.081v-26.18c0-2.52,1.001-4.936,2.782-6.718l15.524-15.524c1.782-1.781,4.198-2.782,6.718-2.782h71.358 c2.52,0,4.936,1.001,6.717,2.782l15.526,15.524C427.635,250.509,428.636,252.926,428.636,255.445z M158.146,259.38l-9.959-9.959 H84.695l-9.958,9.959v114.695l9.958,9.959h63.492l9.959-9.959V259.38z M307.227,300.625H177.146v32.205h16.522v-10.595 c0-5.247,4.253-9.5,9.5-9.5s9.5,4.253,9.5,9.5v10.595h14.443v-10.595c0-5.247,4.253-9.5,9.5-9.5s9.5,4.253,9.5,9.5v10.595h14.442 v-10.595c0-5.247,4.253-9.5,9.5-9.5s9.5,4.253,9.5,9.5v10.595h27.674V300.625z M409.636,259.381l-9.961-9.96h-63.489l-9.959,9.959 v114.695l9.959,9.959h63.489l9.961-9.96V259.381z M387.565,345.356h-39.269c-5.247,0-9.5,4.253-9.5,9.5s4.253,9.5,9.5,9.5h39.269 c5.247,0,9.5-4.253,9.5-9.5S392.812,345.356,387.565,345.356z M136.076,345.356H96.808c-5.247,0-9.5,4.253-9.5,9.5 s4.253,9.5,9.5,9.5h39.268c5.247,0,9.5-4.253,9.5-9.5S141.322,345.356,136.076,345.356z"></path> </g></svg>
                        </div>
                    </div>
                    <div class="ml-12 mt-2 text-lg">
                        <span class="inline text-4xl h-fit">{{ props.training_session.name }}</span>
                        <br>
                        <span class="font-semibold">Description:</span> {{ props.training_session.description }}
                        <br>
                        <span class="font-semibold">Duration:</span> {{ props.training_session.duration }}
                        <br>
                        <span class="font-semibold">Starts At:</span> {{ props.training_session.starts_at }}
                        <br>
                        <span class="font-semibold">Ends At:</span> {{ props.training_session.finish_at }}
                        <br>
                    </div>
                    <div>
                        <div class=" flex flex-col items-center mr-8">
                            <PrimaryButton class="" @click="edit(training_session.id)" v-if="getPermission('edit training session')">
                                Edit Training Session  
                            </PrimaryButton>
                            <DangerButton class="mt-2" @click="confirmDeletion()" v-if="getPermission('delete training session')">
                                Delete Training Session
                            </DangerButton>
                        </div>
                    </div>
                    
                </div>
            </Card>
        </div>
        
        <div class="py-9">
            <div class="grid grid-flow-row-dense grid-cols-6 grid-rows-1 auto-cols-max">
                <div class="col-span-2">
                    <Card>
                        <div class="p-6">
                            <div class="ml-3">
                                <div class="flex justify-between border-b border-gray-400">
                                    <div>
                                        <h2 class="text-3xl font-bold ml-2 mt-3 ">
                                            Clients
                                        </h2>
                                    </div>
                                    <div>
                                        <DangerButton class="mt-2" @click="confirmClientDeletion()" v-if="props.training_session.attendances_clients != 0 && getPermission('delete training session')">
                                            Disassociate all
                                        </DangerButton>
                                    </div>
                                </div>
                                <div class="overflow-y-scroll" style="height: 30rem;" v-if="props.training_session.attendances_clients != 0">
                                    <div class="text-base p-4" v-for="training_session_client in props.training_session.attendances_clients">
                                        <div class="w-full text-justify ">
                                            <h3 class="inline text-3xl">
                                                {{ training_session_client.name }}, {{training_session_client.lastname}}
                                            </h3>
                                            <div class="my-1.5">
                                                <span class="font-semibold">attendance Date: </span> {{training_session_client.pivot.attendance_date}}
                                            </div>
                                            <div class="my-1.5">
                                                <span class="font-semibold">Contact: </span> {{training_session_client.email}}
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div v-else>
                                    <div class="my-1.5">
                                        <span class="font-semibold">No Clients Assign to this training session</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </Card>
                </div>
                <div class="col-span-2">
                    <Card>
                        <div class="p-6 ml-3">
                            <div class="flex justify-between border-b border-gray-400">
                                <div>
                                    <h2 class="text-3xl font-bold ml-2 mt-3">
                                        Coaches
                                    </h2>
                                </div>
                                <div>
                                    <DangerButton class="mt-2" @click="confirmCoachDeletion()" v-if="props.training_session.training_sessions_coaches != 0 && getPermission('delete training session')">
                                        Disassociate all
                                    </DangerButton>
                                </div>
                            </div>
                            <div class="ml-3" v-if="props.training_session.training_sessions_coaches != 0 ">
                                <div class="overflow-y-scroll" style="height: 30rem;" >
                                    <div class="text-base p-4" v-for="training_session_coach in props.training_session.training_sessions_coaches">
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
                            </div>
                            <div v-else>
                                <div class="my-1.5">
                                    <span class="font-semibold">No Coaches Assign to this training session</span>
                                </div>
                            </div>
                        </div>
                    </Card>
                </div>
                <div class="col-span-2">
                    <Card>
                        <div class="p-6">
                            <div class="ml-3">
                                <div class="flex justify-between border-b border-gray-400">
                                    <div>
                                        <h2 class="text-3xl font-bold ml-2 mt-3">
                                            Exercises
                                        </h2>
                                    </div>
                                    <div>
                                        <DangerButton class="mt-2" @click="confirmExerciseDeletion()" v-if="props.training_session.training_sessions_exercises != 0 && getPermission('delete training session')">
                                            Disassociate all
                                        </DangerButton>
                                    </div>
                                </div>
                               
                                <div class="overflow-y-scroll" style="height: 30rem;" v-if="props.training_session.training_sessions_exercises != 0" >
                                    <div class="text-base p-4" v-for="training_session_exercise in props.training_session.training_sessions_exercises">
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
                                    <div class="my-1.5">
                                        <span class="font-semibold">No Exercises Assigned to this training session</span>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </Card>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <Modal :show="confirmingDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Are you sure you want to delete this Training Session ?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                If you delete it, the record will PERMANENT DELETED, are you sure you want to delete it?
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    @click="destroyTrainingSession()"
                >
                    Confirm
                </DangerButton>
            </div>
        </div>
    </Modal>

    <Modal :show="confirmingClientDeletion" @close="closeClientModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Are you sure you want to Disassociate all Clients ?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                If you Disassociate, all Client records of this training Session will me eliminated, are you sure?
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeClientModal"> Cancel </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    @click="disassociateAllClients()"
                >
                    Confirm
                </DangerButton>
            </div>
        </div>
    </Modal>
    <Modal :show="confirmingCoachDeletion" @close="closeCoachModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Are you sure you want to Disassociate all Coaches ?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                If you Disassociate, all Coaches records of this Training Session will me eliminated, are you sure?
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeCoachModal"> Cancel </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    @click="disassociateAllCoach()"
                >
                    Confirm
                </DangerButton>
            </div>
        </div>
    </Modal>
    <Modal :show="confirmingExerciseDeletion" @close="closeExerciseModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Are you sure you want to Disassociate all Exercises ?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                If you Disassociate, all Exercises records of this Training Session will me eliminated, are you sure?
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeExerciseModal"> Cancel </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    @click="disassociateAllExercise()"
                >
                    Confirm
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
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
    client:{
        type:Object,
        required:true
    },
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

//---Modal Section DEATTACH----
const confirmingTrainingSessionDeletion = ref(false);
const confirmTrainingSessionDeletion = () => {
    confirmingTrainingSessionDeletion.value = true;
};

const closeModal = () => {
    confirmingTrainingSessionDeletion.value = false;
};
const destroy = () => {
    router.delete(route('clients.destroyAttendanceTrainingSession',{client:props.client.id, id: props.client_attendace_training_session.id }),{
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => closeModal(),
    });
}

// --Modal SECTION register date --
const confirmingAttendanceDateRegistration = ref(false);
const attendance_date_input = ref(null);

const form = useForm({
    attendance_date: props.client_attendace_training_session.pivot.attendance_date ?? '',
});

const confirmAttendanceDateRegistration = () => {
    confirmingAttendanceDateRegistration.value = true;
};

const closeModalRegistration = () => {
    confirmingAttendanceDateRegistration.value = false;
};

const registerAttendance = () => {
    form.patch(route('clients.registerAttendanceDate',{client:props.client.id, id:props.client_attendace_training_session.id}), {
        preserveScroll: true,
        onSuccess: () => closeModalRegistration(),
        onError: () => attendance_date_input.value.focus(),
    });
};


</script>

<template>
    <Head title="Client Attendace"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Client Training Session</h2>
        </template>

        <div class="py-12">
            <Card class="max-w-7xl spacing-y-6">
                <div class="flex justify-end">
                    <div class="mt-4 mr-4">
                        <DangerButton @click="confirmTrainingSessionDeletion()">
                            Dissociate Training Session
                        </DangerButton>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-2 p-5 items-center" >
                    <div>
                        <div class="ml-8">
                            <img src="/storage/img/calendar.png" class="rounded w-40 ">
                        </div>
                    </div>
                    <div class="mt-2 text-lg">
                        <span class="inline text-5xl h-fit">{{ props.client_attendace_training_session.name }}</span>
                        <br>
                        <div v-if="props.client_attendace_training_session.pivot.attendance_date">
                            <span class="font-semibold mt-1 ">Attendace Date:</span> {{props.client_attendace_training_session.pivot.attendance_date}}
                        </div>
                        <SecondaryButton @click="confirmAttendanceDateRegistration()" class="mt-2">
                            {{props.client_attendace_training_session.pivot.attendance_date ? 'Update Attendance' : 'Register Attendance'}}
                        </SecondaryButton>

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
                                    <div class="text-base p-4" v-for="training_session_exercise in props.training_session_exercises">
                                        <div class="w-full text-justify ">
                                            <h3 class="inline text-3xl">
                                                {{training_session_exercise.name }} X {{ training_session_exercise.pivot.repetitions }}
                                            </h3>
                                            <div class="my-1.5">
                                                <span class="font-semibold ">Intructions: </span> {{training_session_exercise.pivot.instructions}}
                                            </div>
                                        </div>
                                    </div> 
                                </div>   
                            </div>
                        </div>
                    </Card>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <Modal :show="confirmingTrainingSessionDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Are you sure you want to delete this Client ?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                If you Dissociate this training session to this client, the record will be DELETED, but you can Associated again if you want, are you sure?
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    @click="destroy()"
                >
                    Confirm
                </DangerButton>
            </div>
        </div>
    </Modal>

    <Modal :show="confirmingAttendanceDateRegistration" @close="closeModalRegistration" class="">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Select the Date and Time the Client Attended the Training Session
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                In this section you can record the time and date in which the client attended the training session, 
                remember that the date must be in the range of the start and end times of said session.
            </p>

            <div class="mt-6">
                <InputLabel for="attendance_date" value="Attendance Date" class="sr-only" />

                <input 
                    id="attendance_date"
                    ref="attendance_date_input"
                    v-model="form.attendance_date"
                    type="datetime-local"
                    class="mt-1 block w-3/4 rounded-md"
                >

                <InputError :message="form.errors.attendance_date" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModalRegistration"> Cancel </SecondaryButton>

                <PrimaryButton
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="registerAttendance"
                >
                    Register
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
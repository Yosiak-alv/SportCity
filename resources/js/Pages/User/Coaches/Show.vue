<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { Head,Link, router, usePage} from '@inertiajs/vue3';
import {ref, watch} from "vue";
import Card from '@/Components/Card.vue';
import CoachTrainingSessionsIndex from './Partials/Training_Sessions/CoachTrainingSessionsIndex.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import TrashedMessage from '@/Components/TrashedMessage.vue';

const props = defineProps({
    coach:{
        type:Object,
        required:true
    },
    coach_training_sessions:{
        type:Object,
        required:true
    },
    filters:{
        type:Object,
        required:true
    }  
});

const edit = (id) => {
    router.get(route('coaches.edit',{id:id}))
};


//---Modal Section---- falta
const confirmingDeletion = ref(false);
    
const confirmDeletion = () => {
    confirmingDeletion.value = true;
};

const closeModal = () => {
    confirmingDeletion.value = false;
};

const deleteCoach = () => {
    router.delete(route('coaches.destroy',{id:props.coach.id}),{
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => closeModal(),
    });
};

//restores link
const restore = () => {
    router.post(route('coaches.restore',props.coach.id));
};

const permissions = ref(usePage().props.auth.user_role_permissions);

const getPermission = (data) => {
    return permissions.value.find((permission) =>
        permission.toLowerCase().includes(data)
    ) ? true : false;
}
</script>

<template>
    <Head title="Coach Show" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Coach details</h2>
        </template>
        <div class="mt-6">
            <TrashedMessage  v-if="props.coach.deleted_at != null" @restore="restore" :permission="getPermission('restore coach')">This Coach has been deleted. </TrashedMessage>  
        </div>

        <div class="py-12">
            <Card class="max-w-7xl">
                <div class="flex justify-between items-center ">
                    <div class="flex justify-start items-center p-6">
                        <div class="ml-8">
                            <img src="/storage/img/coach.png" class="rounded w-40 ">
                        </div>
                        
                        <div class="ml-12">
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
                    
                    <div class=" flex flex-col justify-center items-center mr-8">
                        <PrimaryButton class="w-full" @click="edit(coach.id)" v-if="!props.coach.deleted_at && getPermission('edit coach')">
                            Edit Coach
                        </PrimaryButton>
                        <DangerButton class="mt-2 w-full" @click="confirmDeletion()" v-if="!props.coach.deleted_at && getPermission('delete coach')">
                            Delete Coach
                        </DangerButton>
                    </div>
                </div>
            </Card>
        </div>

        <div class="py-9">
            <CoachTrainingSessionsIndex  :coachId="props.coach.id" :trainingSessions="props.coach_training_sessions" 
            :filters="props.filters" :deleted="props.coach.deleted_at == null ? false:true"/>
        </div>
    </AuthenticatedLayout>

    <Modal :show="confirmingDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Are you sure you want to delete this Coach ?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                If you delete it, the record will always remain in the system with INACTIVE STATUS, consider
                that other records that use this will appear empty, waiting to be edited or restored
                of this record.
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    @click="deleteCoach()"
                >
                    Confirm
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { Head,Link, router, usePage} from '@inertiajs/vue3';
import {ref, watch} from "vue";
import Card from '@/Components/Card.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import TrashedMessage from '@/Components/TrashedMessage.vue';

const props = defineProps({
    exercise:{
        type:Object,
        required:true
    },
});

const edit = () => {
    router.get(route('exercises.edit',props.exercise.id));
};


//---Modal Section---- falta
const confirmingDeletion = ref(false);
    
const confirmDeletion = () => {
    confirmingDeletion.value = true;
};

const closeModal = () => {
    confirmingDeletion.value = false;
};

const deleteExercise = () => {
    router.delete(route('exercises.destroy',{id:props.exercise.id}),{
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => closeModal(),
    });
};

const permissions = ref(usePage().props.auth.user_role_permissions);

const getPermission = (data) => {
    return permissions.value.find((permission) =>
        permission.toLowerCase().includes(data)
    ) ? true : false;
}
</script>

<template>
    <Head title="Exercise Show" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Exercise details</h2>
        </template>
    

        <div class="py-12">
            <Card class="max-w-7xl">
                <div class="grid grid-cols-4 gap-4 p-6 items-center">
                  
                    <div class="col-span-1 ml-8">
                        <img src="/storage/img/exercise.png" class="rounded w-40 ">
                    </div>
                        
                    <div class="col-span-2 ml-12">
                        <span class="inline text-5xl h-fit">{{exercise.name}}</span>
                        <div class="mt-2 text-lg">
                            <span class="font-semibold">Demostration:</span> {{ exercise.demonstration_url }}
                            <br>
                            <span class="font-semibold">Instructions:</span> {{ exercise.instructions}}
                            <br>
                            <span class="font-semibold">Created At:</span> {{ exercise.created_at }}
                            <br>
                            <span class="font-semibold">Updated At:</span> {{ exercise.updated_at}}
                        </div>
                    </div>
                    
                    
                    <div class="col-span-1 justify-items-center ml-12">
                        <div>
                            <PrimaryButton class="" @click="edit()" v-if="getPermission('edit exercise')">
                                Edit Exercise
                            </PrimaryButton>
                        </div>
                        <div>
                            <DangerButton class="mt-2" @click="confirmDeletion()" v-if="getPermission('delete exercise')">
                                Delete Exercise
                            </DangerButton>
                        </div>
                    </div>
                </div>
            </Card>
        </div>
    </AuthenticatedLayout>

    <Modal :show="confirmingDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Are you sure you want to delete this Exercise ?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                If you delete it, the record will PERMANENT DELETED, this action will delete all his 
                relationships also, are you sure you want to delete it?
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    @click="deleteExercise()"
                >
                    Confirm
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { Head,Link, router, usePage} from '@inertiajs/vue3';
import {ref, watch} from "vue";
import Card from '@/Components/Card.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';


const props = defineProps({
    plan:{
        type:Object,
        required:true
    },
});

const edit = () => {
    router.get(route('plans.edit',props.plan.id));
};


//---Modal Section---- falta
const confirmingDeletion = ref(false);
    
const confirmDeletion = () => {
    confirmingDeletion.value = true;
};

const closeModal = () => {
    confirmingDeletion.value = false;
};

const deletePlan = () => {
    router.delete(route('plans.destroy',{id:props.plan.id}),{
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
    <Head title="Plan Show" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Plan details</h2>
        </template>
    

        <div class="py-12">
            <Card class="max-w-7xl">
                <div class="grid grid-cols-4 gap-4 p-6 items-center">
                  
                    <div class="col-span-1 ml-8">
                        <img src="/storage/img/plan.jpg" class="rounded w-40">
                    </div>
                        
                    <div class="col-span-2 ml-12">
                        <span class="inline text-5xl h-fit">{{plan.name}}</span>
                        <div class="mt-2 text-lg">
                            <span class="font-semibold">Price:</span> {{ plan.price }}
                        </div>
                    </div>
                    
                    
                    <div class="col-span-1 justify-items-center ml-12">
                        <div>
                            <PrimaryButton class="" @click="edit()" v-if="getPermission('edit plan')">
                                Edit Plan
                            </PrimaryButton>
                        </div>
                        <div>
                            <DangerButton class="mt-2" @click="confirmDeletion()" v-if="getPermission('delete plan')">
                                Delete Plan
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
                Are you sure you want to delete this Plan ?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                If you delete it, the record will PERMANENT DELETED, this action will delete all his 
                relationships also, are you sure you want to delete it?
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    @click="deletePlan()"
                >
                    Confirm
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
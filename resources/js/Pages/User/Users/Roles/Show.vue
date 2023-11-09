<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { Head,Link, router, usePage,useForm} from '@inertiajs/vue3';
import {ref, watch,nextTick} from "vue";
import {debounce} from "lodash";
import Card from '@/Components/Card.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import TrashedMessage from '@/Components/TrashedMessage.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    role:{
        type:Object,
        required:true

    },
});


const edit = () => {
    router.get(route('roles.edit',{id:props.role.id}))
};

//---Modal Section----
const confirmingDeletion = ref(false);
    
const confirmDeletion = () => {
    confirmingDeletion.value = true;
};

const closeModal = () => {
    confirmingDeletion.value = false;
};

const deleteRole = () => {
    router.delete(route('roles.destroy',{id:props.role.id}),{
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => closeModal(),
    });
};
//role things
const roles = ref(usePage().props.auth.user_roles);

const getRoles = (data) => {
    return roles.value.find((role) =>
        role.toLowerCase().includes(data)
    ) ? true : false;
}

</script>

<template>
    <Head title="Role Show" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Role details</h2>
        </template>

        <div class="py-12">
            <Card class="max-w-7xl">
                <div class="grid grid-cols-4 gap-4 p-6 items-center">
                    <div class="col-span-1">
                        <img src="/storage/img/human.png" class="rounded w-40 ">
                    </div>
                    <div class="col-span-2">
                        <span class="inline text-5xl h-fit">{{ role.name }}</span>
                        <div class="mt-2 text-lg">
                            <span class="font-semibold">Created at:</span> {{ role.created_at}}
                            <br>
                            <span class="font-semibold">Updated at:</span> {{ role.updated_at }}
                        </div>
                    </div>
                    <div class="col-span-1 justify-items-center">
                        <div>
                            <PrimaryButton class="ml-8  " @click="edit()" v-if="getRoles('administrator')">
                                Edit Role
                            </PrimaryButton>
                        </div>
                        <div>
                            <DangerButton class="ml-8 mt-2" @click="confirmDeletion()" v-if="getRoles('administrator')">
                                Delete Role
                            </DangerButton>
                        </div>
                       
                    </div>
                </div>
            </Card>
        </div>

        <div class="py-2">
            <div class="max-w-7xl mx-auto text-center my-4 text-gray-900 dark:text-gray-100">
                <h2 class="text-3xl font-semibold">Permissions</h2>
            </div>

            <div class="mt-4">
                <div class="flex justify-center">
                    <Card class="max-w-7xl">
                        <div class="overflow-y-scroll" style="height: 20rem;">
                            <div v-for="permission in props.role.permissions">
                                <div class="flex flex-col mb-2">
                                    <div class="text-base p-6">
                                        <div class="w-full text-justify ">
                                            <h3 class="inline text-2xl">
                                                {{permission.name}}
                                            </h3>
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
    


    <Modal :show="confirmingDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Are you sure you want to delete this Role ?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                If you Disassociate, all user records of this associated to this role will be set to null, are you sure?
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    @click="deleteRole()"
                >
                    Confirm
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
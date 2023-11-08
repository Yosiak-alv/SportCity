<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { Head,Link, router, usePage, useForm} from '@inertiajs/vue3';
import {ref, watch,nextTick} from "vue";
import Card from '@/Components/Card.vue';

import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TrashedMessage from '@/Components/TrashedMessage.vue';

const props = defineProps({
    gym:{
        type:Object,
        required:true
    },
});

const edit = () => {
    router.get(route('gyms.edit',{id: props.gym.id}))
};

//---Modal Section---- falta
const confirmingDeletion = ref(false);
    
const confirmDeletion = () => {
    confirmingDeletion.value = true;
};

const closeModal = () => {
    confirmingDeletion.value = false;
};

const deleteGym = () => {
    router.delete(route('gyms.destroy',{id:props.gym.id}),{
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => closeModal(),
    });
};

//restores link
const restore = () => {
    router.post(route('gyms.restore',props.gym.id));
};

const permissions = ref(usePage().props.auth.user_role_permissions);

const getPermission = (data) => {
    return permissions.value.find((permission) =>
        permission.toLowerCase().includes(data)
    ) ? true : false;
}
</script>

<template>
    <Head title="Gym Show" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Gym Details</h2>
        </template>
        <div class="mt-6">
            <TrashedMessage  v-if="props.gym.deleted_at != null" @restore="restore" :permission="getPermission('restore gym')">This Gym has been deleted. </TrashedMessage>  
        </div>
        <div class="py-12">
            <Card class="max-w-7xl">
                <div class="grid grid-cols-4 gap-4 p-6 items-center">
                    <div class="col-span-1">
                        <div class="ml-8">
                            <img src="/storage/img/gym.png" class="rounded w-40 ">
                        </div>
                    </div>
                    <div class="col-span-2">
                        <span class="inline text-5xl h-fit">{{ gym.name }}</span>
                        <div class="mt-2 text-lg">
                            <span class="font-semibold">Phone:</span> {{ gym.phone }}
                            <br>
                            <span class="font-semibold">Address:</span> {{ gym.address }}
                            <br>
                            <span class="font-semibold">Email:</span> {{ gym.email }}
                            <br>
                            <span class="font-semibold">Department: </span> {{gym.department.name}}
                            <br>
                            <span v-if="props.gym.deleted_at" class="font-semibold">Deleted at:</span> {{props.gym.deleted_at}}
                        </div>
                    </div>
                    <div class="col-span-1 justify-items-center">
                        <div>
                            <PrimaryButton class="ml-8" @click="edit()" v-if="!props.gym.deleted_at && getPermission('edit gym')">
                                Edit Gym
                            </PrimaryButton>
                        </div>
                        <div>
                            <DangerButton class="mt-2 ml-8" @click="confirmDeletion()" v-if="!props.gym.deleted_at && getPermission('delete gym')">
                                Delete Gym
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
                Are you sure you want to delete this Gym ?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                If you delete it, the record will always remain in the system with INACTIVE STATUS, consider
                that other records like users related to this gym will not able to log in to the system. Are you sure you want to delete it?
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    @click="deleteGym()"
                >
                    Confirm
                </DangerButton>
            </div>
        </div>
    </Modal>

</template>
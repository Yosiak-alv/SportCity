<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { Head,Link, router, usePage} from '@inertiajs/vue3';
import {ref, computed} from "vue";
import Card from '@/Components/Card.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Paginate from '@/Components/Paginate.vue';
import Modal from '@/Components/Modal.vue';
import TrashedMessage from '@/Components/TrashedMessage.vue';

import ClientSystemIndex from '@/Pages/User/User_Client/Partials/Client_system/ClientSystemIndex.vue';
import ClientSuscriptionIndex from './Partials/Client_Suscription/ClientSuscriptionIndex.vue';
const props = defineProps({
    client:{
        type:Object,
        required:true

    }
});

const edit = (id) => {
    router.get(route('clients.edit',{id:id}))
};

//---Modal Section----
const confirmingClientDeletion = ref(false);
    
const confirmClientDeletion = () => {
    confirmingClientDeletion.value = true;
};

const closeModal = () => {
    confirmingClientDeletion.value = false;
};

const deleteClient = () => {
    router.delete(route('clients.destroy',{id:props.client.id}),{
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => closeModal(),
    });
};

//restores link

const restore = () => {
    router.post(route('clients.restore',props.client.id));
};
const permissions = ref(usePage().props.auth.user_role_permissions);

const getPermission = (data) => {
    return permissions.value.find((permission) =>
        permission.toLowerCase().includes(data)
    ) ? true : false;
}

</script>

<template>
    <Head title="Clients" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Client details</h2>
        </template>
        <div class="mt-6">
            <TrashedMessage  v-if="props.client.deleted_at != null" @restore="restore" :permission="getPermission('restore client')">This client has been deleted. </TrashedMessage>  
        </div>

        <div class="py-12">
            <Card>
                <div class="flex justify-between items-center ">
                    <div class="flex justify-start items-center p-6">
                        <div class="ml-8">
                            <img src="/storage/img/human.png" class="rounded w-40 ">
                        </div>
                        
                        <div class="ml-12">
                            <span class="inline text-5xl h-fit">{{ client.name }}, {{client.lastname}}</span>
                            <div class="mt-2 text-lg">
                                <span class="font-semibold">Genre:</span> {{ client.genre }}
                                <br>
                                <span class="font-semibold">Phone:</span> {{ client.phone }}
                                <br>
                                <span class="font-semibold">Address:</span> {{ client.address }}
                                <br>
                                <span class="font-semibold">Email:</span> {{ client.email }}
                                <br>
                                <span class="font-semibold">Birth Date:</span> {{ client.birth_date }}
                                <br>
                                <span class="font-semibold">Height:</span> {{ client.height }}
                                <br>
                                <span class="font-semibold">Weight:</span> {{ client.weight }}
                                <br>
                                <span class="font-semibold">Gym:</span> {{ client.gym.name }}
                                <br>
                                <span class="font-semibold">Gym Address:</span> {{client.gym.department.name}}, {{ client.gym.address }}
                                <br>
                                <span v-if="props.client.deleted_at" class="font-semibold">Deleted at:</span> {{props.client.deleted_at}}
                            </div>
                        </div>
                    </div>
                    
                    <div class=" flex flex-col justify-center items-center mr-8">
                        <PrimaryButton class="w-full" @click="edit(client.id)" v-if="!props.client.deleted_at && getPermission('edit client')">
                            Edit Client
                        </PrimaryButton>
                        <DangerButton class="mt-2 w-full" @click="confirmClientDeletion()" v-if="!props.client.deleted_at && getPermission('delete client')">
                            Delete Client
                        </DangerButton>
                    </div>
                </div>
            </Card>
        </div>

        <div class="max-w-7xl mx-auto text-center my-4 text-gray-900 dark:text-gray-100">
            <h2 class="text-3xl font-semibold">Relationships</h2>
        </div>
        <div class="grid grid-flow-row-dense grid-cols-3 grid-rows-3 auto-cols-max">
            <div class="row-span-3">
                <ClientSystemIndex :clientId="props.client.id" :system_client="props.client.system_client" :deleted="props.client.deleted_at == null ? false:true"/>
                
            </div>
            <div class="col-span-2">
                <ClientSuscriptionIndex :clientId="props.client.id" :suscriptions="props.client.suscriptions" :deleted="props.client.deleted_at == null ? false:true"/>
            </div>
            <div class="col-span-2">
            </div>
            <div class="col-span-2">
            </div>

        </div>
        
        
    </AuthenticatedLayout>
    


    <Modal :show="confirmingClientDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Are you sure you want to delete this Client ?
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
                    @click="deleteClient"
                >
                    Confirm
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
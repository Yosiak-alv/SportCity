<script setup>
import Card from '@/Components/Card.vue';
import Table from '@/Components/Table.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { Link, router, usePage} from '@inertiajs/vue3';
import {ref, computed} from "vue";
const props = defineProps({
    clientId:{
        type:Number,
        required:true
    },
    suscriptions:{
        type:Object,
        required:true
    },
    deleted:{
        type:Boolean,
        required:false,
        default:false,
    }
});

const permissions = ref(usePage().props.auth.user_role_permissions);

const getPermission = (data) => {
    return permissions.value.find((permission) =>
        permission.toLowerCase().includes(data)
    ) ? true : false;
}
const selectedSuscription = ref(0);
// MODAL SECTION

//---Modal Section----
const confirmingSuscriptionDeletion = ref(false);
    
const confirmSuscriptionDeletion = (id) => {
    confirmingSuscriptionDeletion.value = true;
    selectedSuscription.value = id;
};

const closeModal = () => {
    confirmingSuscriptionDeletion.value = false;
};
const destroy = () => {
    router.delete(route('clients.destroySuscription',{client:props.clientId, id: selectedSuscription.value }),{
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => closeModal(),
    });
}


</script>

<template>
     <Card class="mb-8" v-if="props.suscriptions.length != 0">
        <header class="flex justify-between margin-b mb-4 mt-4">
           <div>
                <h2 class="text-4xl font-bold ml-5 mt-3 ">
                    Suscriptions
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 ml-5 ">
                    All suscriptions of the client ..
                </p>
           </div>
            <div>
                <Link 
                    :href="route('clients.createSuscription',props.clientId)"
                    method="get" as="button"
                    class=" mr-4 mt-5 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                    v-if="props.deleted == false && getPermission('create client suscription')"
                >
                    Create Suscription
                </Link>
            </div>
        </header>
       
        <div class="p-2">
            <Table class="mb-4 rounded-lg bg-gray-700 ">
                <slot name="heading" >
                    <th scope="col" class="px-6 py-3">
                        Name Plan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Price
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Transaction
                    </th>
                    <th scope="col" class="px-6 py-3">
                        End at
                    </th>
                    
                </slot>
                <slot>
                    <tr v-for="suscription in props.suscriptions" :key="suscription.id" class="hover:bg-gray-500  bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white ">
                            {{suscription.plan.name}}
                        </th>
                        <td class="px-6 py-4">
                            {{suscription.plan.price}}
                            
                        </td>
                        <td class="px-6 py-4 ">
                            {{suscription.transaction}}
                            
                        </td>
                        <td class="px-6 py-4 ">
                            {{suscription.ends_at}}
                            
                        </td>
                        <td class="px-6 py-4 ">
                            <div class="flex space-x-4">
                                <Link 
                                method="get" as="button"
                                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
                                :href="route('clients.editSuscription',{client:props.clientId,id:suscription.id})"
                                v-if="!props.deleted && getPermission('update client suscription')"
                                >
                                    Edit
                                </Link>
                                <DangerButton 
                                    class="" @click="confirmSuscriptionDeletion(suscription.id)" v-if="!props.deleted && getPermission('delete client suscription')">
                                    Delete
                                </DangerButton>
                            </div>
                        </td>
                        
                    </tr>
                </slot>
            </Table>
        </div>
    </Card>
    <Card v-else class="mb-8">
        <div class=" border-gray-400 flex flex-col margin-b mb-4">
            <div >
                <h2 class="text-4xl font-bold ml-8 mt-3">
                    No Suscriptions was found, but you can created new ones.
                </h2>
            </div>
            <div>
                <Link 
                    :href="route('clients.createSuscription',props.clientId)"
                    method="get" as="button"
                    class=" ml-8 mt-3 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                    v-if="props.deleted == false && getPermission('create client suscription')"
                >
                    Create Suscription
                </Link>
            </div>
        </div>
    </Card>


    <Modal :show="confirmingSuscriptionDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Are you sure you want to delete this Client ?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                If you delete it, the record will be PERMANENT DELETED, so be carefull if you want to deleted, are you sure?
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

</template>
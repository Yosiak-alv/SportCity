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
    product:{
        type:Object,
        required:true
    },
});

const edit = (id) => {
    router.get(route('products.edit',{id:id}))
};


//---Modal Section---- falta
const confirmingProductDeletion = ref(false);
    
const confirmProductDeletion = () => {
    confirmingProductDeletion.value = true;
};

const closeModal = () => {
    confirmingProductDeletion.value = false;
};

const deleteProduct = () => {
    router.delete(route('products.destroy',{id:props.product.id}),{
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => closeModal(),
    });
};

//restores link
const restore = () => {
    router.post(route('products.restore',props.product.id));
};

const permissions = ref(usePage().props.auth.user_role_permissions);

const getPermission = (data) => {
    return permissions.value.find((permission) =>
        permission.toLowerCase().includes(data)
    ) ? true : false;
}
</script>

<template>
    <Head title="Product Show" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Product details</h2>
        </template>
        <div class="mt-6">
            <TrashedMessage  v-if="props.product.deleted_at != null" @restore="restore" :permission="getPermission('restore product')">This Product has been deleted. </TrashedMessage>  
        </div>

        <div class="py-12">
            <Card class="max-w-7xl">
                <div class="flex justify-between items-center ">
                    <div class="flex justify-start items-center p-6">
                        <div class="ml-8">
                            <img src="/storage/img/product.png" class="rounded w-40 ">
                        </div>
                        
                        <div class="ml-12">
                            <span class="inline text-5xl h-fit">{{product.name}}</span>
                            <div class="mt-2 text-lg">
                                <span class="font-semibold">Description:</span> {{ product.description }}
                                <br>
                                <span class="font-semibold">Unit Price:</span> {{ product.unit_price }}
                                <br>
                                <span class="font-semibold">Quantity:</span> {{ product.quantity }}
                                <br>
                                <span class="font-semibold">Created At:</span> {{ product.created_at }}
                                <br>
                                <span class="font-semibold">Updated At:</span> {{ product.updated_at}}
                                <br>
                                <span class="font-semibold">Gym:</span> <span :class="{'text-red-600 dark:text-red-400' : product.gym == null}">
                                {{ product.gym?.name ?? 'Current Gym Deleted'}} </span>
                                <br>
                                <span class="font-semibold">Gym Address:</span> {{product.gym?.department.name ?? ''}}, {{ product.gym?.address  ?? ''}}
                                <br>
                                <span v-if="props.product.deleted_at" class="font-semibold">Deleted at:</span> {{props.product.deleted_at}}
                            </div>
                        </div>
                    </div>
                    
                    <div class=" flex flex-col justify-center items-center mr-8">
                        <PrimaryButton class="w-full" @click="edit(product.id)" v-if="!props.product.deleted_at && getPermission('edit product')">
                            Edit Product
                        </PrimaryButton>
                        <DangerButton class="mt-2 w-full" @click="confirmProductDeletion()" v-if="!props.product.deleted_at && getPermission('delete product')">
                            Delete Product
                        </DangerButton>
                    </div>
                </div>
            </Card>
        </div>
    </AuthenticatedLayout>

    <Modal :show="confirmingProductDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Are you sure you want to delete this Product ?
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
                    @click="deleteProduct"
                >
                    Confirm
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
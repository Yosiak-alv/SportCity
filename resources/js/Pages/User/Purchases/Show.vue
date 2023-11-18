<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Components/Card.vue';
import { Head,Link, router, usePage, useForm} from '@inertiajs/vue3';
import {ref} from "vue";
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
const props = defineProps({
    purchase:{
        type:Object,
        required:true
    },
});
/* const productDeleted = ref(false);
const productIsDeleted = (product) => {
    return product == null ? productDeleted.value = true: productDeleted.value = false;
}
 */
const permissions = ref(usePage().props.auth.user_role_permissions);

const getPermission = (data) => {
    return permissions.value.find((permission) =>
        permission.toLowerCase().includes(data)
    ) ? true : false;
}

//---Modal Section CANCEL----
const confirmingDeletion = ref(false);
    
const confirmDeletion = () => {
    confirmingDeletion.value = true;
};

const closeModal = () => {
    confirmingDeletion.value = false;
};

const cancelPurchase = () => {
    router.patch(route('purchases.cancelPurchase',{id: props.purchase.id }),{
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => closeModal(),
    });
}
</script>

<template>
    <Head title="Show Purchase"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Purchase Details</h2>
        </template>

        <div class="py-12">
            
            <Card class="max-w-7xl spacing-y-6">
                
                <div class="max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto my-2 sm:my-10">
                    <!-- Grid -->
                    <div class="mb-5 pb-5 flex justify-between items-center border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Purchase - Invoice # {{props.purchase.id}}</h2>
                        </div>
                        <div class="inline-flex gap-x-2">
                            <span class="text-red-400 text-3xl" v-if="props.purchase.canceled">
                                CANCELED 
                            </span>
                            <a
                                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
                                :href="route('purchases.purchaseInvoice', {id: props.purchase.id})" 
                                v-if="props.purchase.canceled == false && props.purchase.client != null"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-invoice" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                    <path d="M9 7l1 0"></path>
                                    <path d="M9 13l6 0"></path>
                                    <path d="M13 17l2 0"></path>
                                </svg>PDF
                            </a>
                            
                            <div v-if="props.purchase.client != null && getPermission('cancel client purchase')">
                                <DangerButton @click="confirmDeletion()" v-show="props.purchase.canceled == false">
                                    <div class="flex space-x-4">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M18 6l-12 12"></path>
                                                <path d="M6 6l12 12"></path>
                                            </svg>
                                        </div>
                                        <div class="mt-1">
                                            <p>Cancel Purchase</p>
                                        </div>
                                    </div>
                                </DangerButton>
                            </div>
                        </div>
                    </div>
                    <!-- End Grid -->

                    <!-- Grid -->
                    <div class="grid md:grid-cols-2 gap-3">
                        <div>
                        <div class="grid space-y-3">
                            <dl class="grid sm:flex gap-x-3 text-sm">
                                <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                    Billing details:
                                </dt>
                                <dd class="font-medium text-gray-800 dark:text-gray-200" :class="{'text-red-600 dark:text-red-400' : purchase.client == null}">
                                    <span class="block font-semibold">{{props.purchase.client?.name ?? 'Client Deleted'}}, {{props.purchase.client?.lastname}}</span>
                                    <span class="not-italic font-normal">{{props.purchase.client?.dui}}</span><br>
                                    <span class="not-italic font-normal">{{props.purchase.client?.email}}</span><br>
                                    <span class="not-italic font-normal">{{props.purchase.client?.phone}}</span><br>
                                </dd>
                            </dl>

                            <dl class="grid sm:flex gap-x-3 text-sm">
                            <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                Payment Method:
                            </dt>
                            <dd class="font-medium text-gray-800 dark:text-gray-200">
                                <span class="block font-semibold">Cash/Transfer</span><br>
                                <span class="not-italic font-normal">USD - Dollar</span><br>
                            </dd>
                            </dl>
                            
                        </div>
                        </div>
                        <!-- Col -->

                        <div>
                        <div class="grid space-y-3">
                            <dl class="grid sm:flex gap-x-3 text-sm">
                            <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                Invoice number:
                            </dt>
                            <dd class="font-medium text-gray-800 dark:text-gray-200">
                                {{props.purchase.id}}
                            </dd>
                            </dl>

                            <dl class="grid sm:flex gap-x-3 text-sm">
                            <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                Currency:
                            </dt>
                            <dd class="font-medium text-gray-800 dark:text-gray-200">
                                USD - US Dollar
                            </dd>
                            </dl>

                            <dl class="grid sm:flex gap-x-3 text-sm">
                            <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                Due date:
                            </dt>
                            <dd class="font-medium text-gray-800 dark:text-gray-200">
                                {{props.purchase.created_at}}
                            </dd>
                            </dl>
                        </div>
                        </div>
                        <!-- Col -->
                    </div>
                    <!-- End Grid -->

                    <!-- Table -->

                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 rounded-lg bg-gray-700" >
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 rounded-l-lg">
                                    Product
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Item Count
                                </th>
                                <th scope="col" class="px-6 py-3 ">
                                    Unit Price 
                                </th>
                                <th scope="col" class="px-6 py-3 rounded-r-lg">
                                    Item Total
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-gray-800" v-for="purchase_item in props.purchase.purchase_items" :key="purchase_item.id">
                                <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap "
                                :class="{'text-red-400' : purchase_item.product == null }" >
                                    {{ purchase_item.product?.name ?? 'Product Deleted'}}
                                </th>
                                <td class="px-6 py-4">
                                    {{ purchase_item.quantity }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ purchase_item.unit_price }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ purchase_item.item_total }}
                                </td>
                            </tr>
                            
                        </tbody>
                        <tfoot>
                            <tr class="font-semibold text-gray-900 dark:text-white">
                                <th scope="row" class="px-6 py-3 text-base">Total</th>
                                <td class="px-6 py-3">{{props.purchase.item_count}}</td>
                                <td class="px-6 py-3"></td>

                                <td class="px-6 py-3">{{props.purchase.sub_total}}</td>
                            </tr>
                        </tfoot>
                    </table>
                    <!-- End Table -->

                    <!-- Flex -->
                    <div class="mt-8 flex sm:justify-end">
                        <div class="w-full max-w-2xl sm:text-right space-y-2">
                        <!-- Grid -->
                        <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                            <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                            <dt class="col-span-3 text-gray-500">SubTotal:</dt>
                            <dd class="col-span-2 font-medium text-gray-800 dark:text-gray-200">${{props.purchase.sub_total}}</dd>
                            </dl>
                            <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                            <dt class="col-span-3 text-gray-500">Taxes:</dt>
                            <dd class="col-span-2 font-medium text-gray-800 dark:text-gray-200">${{props.purchase.taxes}}</dd>
                            </dl>
                            <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                            <dt class="col-span-3 text-gray-500">Total:</dt>
                            <dd class="col-span-2 font-medium text-gray-800 dark:text-gray-200">${{props.purchase.total}}</dd>
                            </dl>
                        </div>
                        <!-- End Grid -->
                        </div>
                    </div>
                    <!-- End Flex -->
                </div>
                <!-- End Invoice -->
            </Card>
        </div>
    </AuthenticatedLayout>
    <Modal :show="confirmingDeletion" @close="closeModal()">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Are you sure you want to Cancel this Purchase ?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                If you Cancel it, the purchase will be canceled and said act cannot be reversed, are you sure?
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal()"> Cancel </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    @click="cancelPurchase()"
                >
                    Confirm
                </DangerButton>
            </div>
        </div>
    </Modal>
    
</template>
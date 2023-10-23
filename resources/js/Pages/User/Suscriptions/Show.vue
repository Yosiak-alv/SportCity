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
    suscription:{
        type:Object,
        required:true
    },

});


const permissions = ref(usePage().props.auth.user_role_permissions);

const getPermission = (data) => {
    return permissions.value.find((permission) =>
        permission.toLowerCase().includes(data)
    ) ? true : false;
}

//cancel modal 
const confirmingCancelSuscription = ref(false);

const confirmCancelSuscription = () => {
    confirmingCancelSuscription.value = true;
};

const closeModalCancelSuscription = () => {
    confirmingCancelSuscription.value = false;
};

const CancelSuscription = () => {
    router.patch(route('suscriptions.cancelSuscription',props.suscription.id), {
        preserveScroll: true,
        onSuccess: () => closeModalCancelSuscription(),
        onError: () => closeModalCancelSuscription(),
    });
};

</script>

<template>
    <Head title="Suscription"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Suscription Details</h2>
        </template>

        <div class="py-12">
            <Card class="max-w-7xl spacing-y-6">
                <div class="max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto my-2 sm:my-10">
                    <!-- Grid -->
                    <div class="mb-5 pb-5 flex justify-between items-center border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Suscription - Invoice # {{props.suscription.id}}</h2>
                        </div>
                        <div class="inline-flex gap-x-2">
                            <span class="text-red-400 text-3xl" v-if="props.suscription.canceled">
                                CANCELED
                            </span>
                            <a
                                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
                                :href="route('suscriptions.suscriptionInvoice',props.suscription.id)"
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
                            <div v-if="getPermission('edit suscription')">
                                <PrimaryButton @click="router.get(route('suscriptions.edit',props.suscription.id))" v-show="props.suscription.canceled == false">
                                    <div class="flex space-x-4">
                                        <div class="mt-1">
                                            <p>edit Suscription</p>
                                        </div>
                                    </div>
                                </PrimaryButton>
                            </div>
                            <div v-if="getPermission('cancel suscription')">
                                <DangerButton @click="confirmCancelSuscription()" v-show="props.suscription.canceled == false">
                                    <div class="flex space-x-4">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M18 6l-12 12"></path>
                                                <path d="M6 6l12 12"></path>
                                            </svg>
                                        </div>
                                        <div class="mt-1">
                                            <p>Cancel Suscription</p>
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
                                <dd class="font-medium text-gray-800 dark:text-gray-200">
                                    <span class="block font-semibold">{{props.suscription.client.name}}, {{props.suscription.client.lastname}}</span>
                                    <span class="not-italic font-normal">{{props.suscription.client.dui}}</span><br>
                                    <span class="not-italic font-normal">{{props.suscription.client.email}}</span><br>
                                    <span class="not-italic font-normal">{{props.suscription.client.phone}}</span><br>
                                    <address class="not-italic font-normal">
                                        {{props.suscription.client.address}}<br>
                                    </address>
                                </dd>
                            </dl>

                            <dl class="grid sm:flex gap-x-3 text-sm">
                            <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                Payment Method:
                            </dt>
                            <dd class="font-medium text-gray-800 dark:text-gray-200">
                                <span class="block font-semibold">Cash</span><br>
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
                                {{props.suscription.id}}
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
                                {{props.suscription.created_at}}
                            </dd>
                            </dl>
                        </div>
                        </div>
                        <!-- Col -->
                    </div>
                    <!-- End Grid -->

                    <!-- Table -->
                    <div class="mt-6 border border-gray-200 p-4 rounded-lg space-y-4 dark:border-gray-700">
                        <div class="hidden sm:grid sm:grid-cols-5">
                        <div class="sm:col-span-2 text-xs font-medium text-gray-500 uppercase">Item</div>
                        <div class="text-left text-xs font-medium text-gray-500 uppercase">Qty</div>
                        <div class="text-right text-xs font-medium text-gray-500 uppercase">Amount</div>
                        </div>

                        <div class="hidden sm:block border-b border-gray-200 dark:border-gray-700"></div>

                        <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
                        <div class="col-span-full sm:col-span-2">
                            <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">Item</h5>
                            <p class="font-medium text-gray-800 dark:text-gray-200">{{props.suscription.plan.name}}</p>
                        </div>
                        <div>
                            <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">Qty</h5>
                            <p class="text-gray-800 dark:text-gray-200">1</p>
                        </div>
                        
                        <div>
                            <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">Amount</h5>
                            <p class="sm:text-right text-gray-800 dark:text-gray-200">{{props.suscription.plan.price}}</p>
                        </div>
                        </div>

                        <div class="sm:hidden border-b border-gray-200 dark:border-gray-700"></div>
                    </div>
                    <!-- End Table -->

                    <!-- Flex -->
                    <div class="mt-8 flex sm:justify-end">
                        <div class="w-full max-w-2xl sm:text-right space-y-2">
                        <!-- Grid -->
                        <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                            <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                            <dt class="col-span-3 text-gray-500">SubTotal:</dt>
                            <dd class="col-span-2 font-medium text-gray-800 dark:text-gray-200">${{props.suscription.plan.price}}</dd>
                            </dl>

                            <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                            <dt class="col-span-3 text-gray-500">Total:</dt>
                            <dd class="col-span-2 font-medium text-gray-800 dark:text-gray-200">${{props.suscription.plan.price}}</dd>
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
    <Modal :show="confirmingCancelSuscription" @close="closeModalCancelSuscription">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Are you sure you want to Cancel this Client Suscription?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                If you Cancel it, the subscription will be canceled and said act cannot be reversed, are you sure?
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModalCancelSuscription"> Cancel </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    @click="CancelSuscription()"
                >
                    Confirm
                </DangerButton>
            </div>
        </div>
    </Modal>
    
</template>
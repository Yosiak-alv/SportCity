<script setup>
import AuthenticatedClientLayout from '@/Layouts/AuthenticatedClientLayout.vue';
import Card from '@/Components/Card.vue';
import { Head,Link, router, usePage, useForm} from '@inertiajs/vue3';
import {ref} from "vue";

const props = defineProps({
    suscription:{
        type:Object,
        required:true
    },
});

</script>

<template>
    <Head title="Client Suscription"/>
    <AuthenticatedClientLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Client Suscription</h2>
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
                                :href="route('client.suscriptions.invoice',props.suscription.id)"
                                v-if="!props.suscription.canceled"
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
                                    <span class="block font-semibold">{{usePage().props.auth.user.name}}, {{usePage().props.auth.user.lastname}}</span>
                                    <span class="not-italic font-normal">{{usePage().props.auth.user.dui}}</span><br>
                                    <span class="not-italic font-normal">{{usePage().props.auth.user.email}}</span><br>
                                    <span class="not-italic font-normal">{{usePage().props.auth.user.phone}}</span><br>
                                    <address class="not-italic font-normal">
                                        {{usePage().props.auth.user.address}}<br>
                                    </address>
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
    </AuthenticatedClientLayout>
</template>
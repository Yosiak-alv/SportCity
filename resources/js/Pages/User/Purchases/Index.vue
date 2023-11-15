<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Table from '@/Components/Table.vue';
import { Head,Link,usePage,router,useForm } from '@inertiajs/vue3';
import {ref, watch} from "vue";
import {debounce} from "lodash";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

import Paginate from '@/Components/Paginate.vue';
const props = defineProps({
    purchases:{
        type:Object,
    },
    filters:{
        type:Object,
        required:true
    }
});

const form = useForm({
    search: props.filters.search,
});

//search Handling
watch(form, debounce(() => {
    router.get('/purchases', {search:form.search }, { preserveState:true , replace:true });
},500));

const permissions = ref(usePage().props.auth.user_role_permissions);

const getPermission = (data) => {
    return permissions.value.find((permission) =>
        permission.toLowerCase().includes(data)
    ) ? true : false;
}

</script>

<template>
    <Head title="Purchases" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Purchases</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="grid grid-cols-1 py-1">
                        <div class="flex justify-between mt-5">
                            <div>
                                <div class="relative w-full ml-6">
                                    <div class="flex flex-row space-x-2">                                      
                                        <div>
                                            <div class="absolute inset-y-0 left-29  flex items-center pl-3 pointer-events-none">
                                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                            </div>
                                            <input type="text" id="search" v-model="form.search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" placeholder="Search" required>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                            <div class="mr-6">
                                <Link 
                                    :href="route('purchases.create')" 
                                    method="get" as="button"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                    v-if="getPermission('create purchase')"
                                >
                                    Create new Purchase
                                </Link>
                                
                            </div>
                        </div>
                    </div>
                    <div class="p-5 bg">
                        <Table class="rounded-lg bg-gray-700">
                            <slot name="heading" >
                                <th scope="col" class="px-6 py-3">Id</th>
                                <th scope="col" class="px-6 py-3">Item Count</th>
                                <th scope="col" class="px-6 py-3">SubTotal</th>
                                <th scope="col" class="px-6 py-3">Taxes</th>
                                <th scope="col" class="px-6 py-3">Total</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only"></span>
                                </th>    
                            </slot>
                            <slot>
                                <tr v-for="purchase in props.purchases.data" :key="purchase.id" class="hover:bg-gray-500  bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white ">
                                        {{purchase.id}}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{purchase.item_count}}
                                    </td>
                                    <td class="px-6 py-4 ">
                                        {{purchase.sub_total}}
                                    </td>
                                    <td class="px-6 py-4 ">
                                        {{purchase.taxes}}
                                    </td>
                                    <td class="px-6 py-4 ">
                                        {{purchase.total}}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-2.5 w-2.5 rounded-full mr-2" :class="purchase.canceled ? 'bg-red-500':'bg-green-500'"></div>{{purchase.canceled == false ? 'OK':'Canceled'}}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 ">
                                        <div class="flex space-x-4">
                                            <Link 
                                            method="get" as="button"
                                            class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
                                            :href="route('purchases.show',purchase.id)"
                                            >
                                                Show
                                            </Link>                              
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="props.purchases.data.length === 0">
                                    <td class="px-6 py-4 font-medium text-gray-200 whitespace-nowrap" colspan="4">No Purchases found.</td>
                                </tr>
                            </slot>
                        </Table>
                    </div>
                    <Paginate :links="props.purchases.links" class="mb-6"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
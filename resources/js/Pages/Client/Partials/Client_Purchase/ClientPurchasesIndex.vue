<script setup>
import Card from '@/Components/Card.vue';

import { Link, router, usePage} from '@inertiajs/vue3';
import {onMounted,ref, computed} from "vue";
import $ from 'jquery';
import DataTable from 'datatables.net-dt';
 
onMounted(() => {
    $('#purchases').DataTable({
        /* pageLength : 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']], */
    });
});
const props = defineProps({
    purchases:{
        type:Object,
        required:true
    },
});

</script>
<style>
    @import 'datatables.net-dt';
    #purchases_length select {
        background: rgb(31, 41, 55);
        color: #eee;
    }
    .purchases_length{
        margin-bottom: 10px;
    }
    
</style>
<template>
     <Card class="mb-8" v-if="props.purchases.length != 0">
        <header class="flex justify-between margin-b mb-4 mt-4">
           <div>
                <h2 class="text-4xl font-bold ml-5 mt-3 ">
                    Purchases
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 ml-5 ">
                    All purchases of the client ...
                </p>
           </div>
        </header>
       
        <div class="p-2">
            <table id="purchases" class="mb-4 rounded-lg w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Id</th>
                        <th scope="col" class="px-6 py-3">Item Count</th>
                        <th scope="col" class="px-6 py-3">SubTotal</th>
                        <th scope="col" class="px-6 py-3">Taxes</th>
                        <th scope="col" class="px-6 py-3">Total</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="purchase in props.purchases" :key="purchase.id" class="hover:bg-gray-500  bg-white border-b dark:bg-gray-700 dark:border-gray-900">
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
                                <div class="h-2.5 w-2.5 rounded-full mr-2" :class="purchase.canceled ? 'bg-red-500':'bg-green-500'"></div>{{purchase.canceled == false ? 'Completed':'Canceled'}}
                            </div>
                        </td>
                        <td class="px-6 py-4 ">
                            <div class="flex space-x-4">
                                <Link 
                                method="get" as="button"
                                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
                                :href="route('client.purchases.show',{purchase:purchase.id})"
                                >
                                    Show
                                </Link>                              
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </Card>
    <Card v-else class="mb-8">
        <div class=" border-gray-400 flex flex-col margin-b mb-4">
            <div >
                <h2 class="text-4xl font-bold ml-8 mt-3">
                    No Purchases was found, but you can created new ones.
                </h2>
            </div>
        </div>
    </Card>
</template>
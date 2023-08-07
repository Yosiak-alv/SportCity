<script setup>
import Card from '@/Components/Card.vue';
import {onMounted,ref, computed} from "vue";
import $ from 'jquery';
import DataTable from 'datatables.net-dt';
 
onMounted(() => {
    $('#cash-transactions').DataTable();
});
const props = defineProps({
    cashTransactions:{
        type:Object,
        required:true
    },
    deleted:{
        type:Boolean,
        required:false,
        default:false,
    }
});

</script>
<style>
    @import 'datatables.net-dt';
    #cash-transactions_length select {
        background: rgb(31, 41, 55);
        color: #eee;
    }
    #cash-transactions_length{
        margin-bottom: 10px;
    }
    
</style>
<template>
     <Card class="mb-8" v-if="props.cashTransactions.length != 0">
        <header class="flex justify-between margin-b mb-4 mt-4">
           <div>
                <h2 class="text-4xl font-bold ml-5 mt-3 ">
                    Cash Transactions
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 ml-5 ">
                    All Cash Transactions of the client ..
                </p>
           </div>
        </header>
       
        <div class="p-2">
            <table id="cash-transactions" class="mb-4 rounded-lg w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Amount</th>
                        <th scope="col" class="px-6 py-3">Message</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Created At</th>
                        <th scope="col" class="px-6 py-3">Updated At</th>

                    </tr>
                </thead>
                <tbody>
                    <tr v-for="cashTransaction in props.cashTransactions" :key="cashTransaction.id" class="hover:bg-gray-500  bg-white border-b dark:bg-gray-700 dark:border-gray-900">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white ">
                            {{cashTransaction.id}}
                        </th>
                        <td class="px-6 py-4 ">
                            {{cashTransaction.monto}}
                        </td>
                        <td class="px-6 py-4 ">
                            {{cashTransaction.mensaje}}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-2.5 w-2.5 rounded-full mr-2" :class="cashTransaction.canceled ? 'bg-red-500':'bg-green-500'"></div>{{cashTransaction.canceled == false ? 'Completed':'Canceled'}}
                            </div>
                        </td>
                        <td class="px-6 py-4 ">
                            {{cashTransaction.created_at}}
                        </td>
                        <td class="px-6 py-4 ">
                            {{cashTransaction.updated_at}}
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
                    No Cash Transaction detected
                </h2>
            </div>
        </div>
    </Card>
</template>
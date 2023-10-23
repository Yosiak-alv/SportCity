<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Table from '@/Components/Table.vue';
import { Head,Link,usePage,router,useForm } from '@inertiajs/vue3';
import {ref, watch, onMounted} from "vue";
import {debounce} from "lodash";
import Card from '@/Components/Card.vue';
import $ from 'jquery';
import DataTable from 'datatables.net-dt';
import Paginate from '@/Components/Paginate.vue';

const props = defineProps({
    suscriptions:{
        type:Object,
        required:true
    },
    filters:{
        type:Object,
        required:true
    },
    plans:{
        type:Object,
        required:true
    },
});
const form = useForm({
    search: props.filters.search,
});

//search Handling
watch(form, debounce(() => {
    router.get('/suscriptions', {search:form.search}, { preserveState:true , replace:true });
},500));

const permissions = ref(usePage().props.auth.user_role_permissions);

const getPermission = (data) => {
    return permissions.value.find((permission) =>
        permission.toLowerCase().includes(data)
    ) ? true : false;
}
//plans
onMounted(() => {
    $('#plans').DataTable({
        /* pageLength : 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']], */
    });
});
</script>
<style>
    @import 'datatables.net-dt';
    #plans_length select {
        background: rgb(31, 41, 55);
        color: #eee;
    }
    .plans_length{
        margin-bottom: 10px;
    }
    #plans_length{
        margin-bottom: 10px;
    }
</style>
<template>
    <Head title="Suscriptions" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Suscriptions</h2>
        </template>

        <div class="py-12">
            <Card class="max-w-7xl">
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
                                :href="route('suscriptions.create')" 
                                method="get" as="button"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                v-if="getPermission('create suscription')"
                            >
                                Create new Suscription
                            </Link>
                            
                        </div>
                    </div>
                   
                    <div class="p-5 bg">
                        <Table class="rounded-lg bg-gray-700">
                            <slot name="heading" >
                                <th scope="col" class="px-6 py-3">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Client Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Plan Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Ends_at
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only"></span>
                                </th>    
                            </slot>
                            <slot>
                                <tr v-for="suscription in props.suscriptions.data" :key="suscription.id" class="hover:bg-gray-500  bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white ">
                                        <div v-if="getPermission('show suscription')">
                                            <Link class="flex items-center" :href="route('suscriptions.show',{id:suscription.id})">
                                                {{suscription.id}}
                                            </Link>
                                        </div>
                                        <div v-else>
                                            {{suscription.id}}
                                        </div>
                                    </th>
                                    <td class="px-6 py-4">
                                        <div v-if="getPermission('show suscription')">
                                            <Link  :href="route('suscriptions.show',{id:suscription.id})">
                                                {{suscription.client.name}}
                                            </Link>
                                        </div>
                                        <div v-else>
                                            {{suscription.client.name}}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div v-if="getPermission('show suscription')">
                                            <Link  :href="route('suscriptions.show',{id:suscription.id})">
                                                {{suscription.plan.name}}
                                            </Link>
                                        </div>
                                        <div v-else>
                                            {{suscription.plan.name}}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div v-if="getPermission('show suscription')">
                                            <Link :href="route('suscriptions.show',{id:suscription.id})">
                                                {{suscription.plan.price}}
                                            </Link>
                                        </div>
                                        <div v-else>
                                            {{suscription.plan.price}}
                                        </div>
                                        
                                    </td>
                                    <td class="px-6 py-4 ">
                                        <div v-if="getPermission('show suscription')">
                                            <Link :href="route('suscriptions.show',{id:suscription.id})">
                                                <div class="flex items-center">
                                                    <div class="h-2.5 w-2.5 rounded-full mr-2" :class="suscription.canceled ? 'bg-red-500':'bg-green-500'">
                                                    </div>{{suscription.canceled == false ? 'Active':'Canceled'}}
                                                </div>
                                            </Link>
                                        </div>
                                        <div v-else>
                                            <div class="flex items-center">
                                                <div class="h-2.5 w-2.5 rounded-full mr-2" :class="suscription.canceled ? 'bg-red-500':'bg-green-500'">
                                                </div>{{suscription.canceled == false ? 'Active':'Canceled'}}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div v-if="getPermission('show suscription')">
                                            <Link :href="route('suscriptions.show',{id:suscription.id})">
                                                {{suscription.ends_at}}
                                            </Link>
                                        </div>
                                        <div v-else>
                                            {{suscription.ends_at}}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div v-if="getPermission('show suscription')">
                                            <Link :href="route('suscriptions.show', {id:suscription.id})">
                                                <svg fill="none" class="block w-6 h-6 "  stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"></path>
                                                </svg>
                                            </Link>
                                        </div>
                                    </td>
                                </tr>
                            </slot>
                        </Table>
                    </div>
                    <Paginate :links="props.suscriptions.links" class="mb-6"/>
                </div>
            </Card>
           
        </div>

        <div class="py-9">
            <Card class="max-w-7xl" v-if="props.plans.length != 0">
                <header class="flex justify-between mt-4">
                    <div>
                        <h2 class="text-4xl font-bold ml-5 mt-3 ">
                            Plans
                        </h2>
                    </div>
                    <div>
                        <Link 
                            :href="route('plans.create')"
                            method="get" as="button"
                            class=" mr-4 mt-5 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                            v-if="getPermission('create plan')"
                        >
                            Create Plan
                        </Link>
                    </div>
                </header>
            
                <div class="p-6">
                    <table id="plans" class="mb-4 rounded-lg w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">ID</th>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">Price</th>
                                <th scope="col" class="px-6 py-3">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="plan in props.plans" :key="plan.id" class="hover:bg-gray-500  bg-white border-b dark:bg-gray-700 dark:border-gray-900">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white ">
                                    {{plan.id}}
                                </th>
                                <td class="px-6 py-4">
                                    {{plan.name}}
                                </td>
                                <td class="px-6 py-4 ">
                                    {{plan.price}}
                                </td>
                                <td class="px-6 py-4 ">
                                    <div class="flex space-x-4">
                                        <Link 
                                            method="get" as="button"
                                            class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
                                            :href="route('plans.show',plan.id)"
                                            v-if="getPermission('show plan')"
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
                            No Plan was found, but you can created new ones.
                        </h2>
                    </div>
                    <div>
                        <Link 
                            :href="route('plans.create')"
                            method="get" as="button"
                            class=" ml-8 mt-3 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                            v-if="getPermission('create plan')"
                        >
                            Create Plan
                        </Link>
                    </div>
                </div>
            </Card>
        </div>
    
    </AuthenticatedLayout>
</template>
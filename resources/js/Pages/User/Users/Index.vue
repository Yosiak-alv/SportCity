<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Table from '@/Components/Table.vue';
import Card from '@/Components/Card.vue';
import { Head,Link,usePage,router,useForm } from '@inertiajs/vue3';
import {ref, watch, onMounted} from "vue";
import $ from 'jquery';
import DataTable from 'datatables.net-dt';
import {debounce} from "lodash";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Paginate from '@/Components/Paginate.vue';
const props = defineProps({
    users:{
        type:Object,

    },
    roles:{
        type:Object,
        required:true
    },
    filters:{
        type:Object,
        required:true
    }
});
const form = useForm({
    search: props.filters.search,
    trashed:props.filters.trashed
});

//search Handling
watch(form, debounce(() => {
    router.get('/users', {search:form.search , trashed:form.trashed}, { preserveState:true , replace:true });
},500));

const permissions = ref(usePage().props.auth.user_role_permissions);

const getPermission = (data) => {
    return permissions.value.find((permission) =>
        permission.toLowerCase().includes(data)
    ) ? true : false;
}
//role things
const roles = ref(usePage().props.auth.user_roles);

const getRoles = (data) => {
    return roles.value.find((role) =>
        role.toLowerCase().includes(data)
    ) ? true : false;
}
//Roles
onMounted(() => {
    $('#roles').DataTable({
        /* pageLength : 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']], */
    });
});
</script>
<style>
    @import 'datatables.net-dt';
    #roles_length select {
        background: rgb(31, 41, 55);
        color: #eee;
    }
    .roles_length{
        margin-bottom: 10px;
    }
    #roles_length{
        margin-bottom: 10px;
    }
</style>
<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Users</h2>
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
                                            <div class="mr-4 w-full max-w-md">
                                                <select v-model="form.trashed" id="trashed" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500">
                                                    <option :value="null" />
                                                    <option value="with">With Trashed</option>
                                                    <option value="only">Only Trashed</option>
                                                </select>
                                            </div>
                                        </div>
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
                                    :href="route('users.create')" 
                                    method="get" as="button"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                    v-if="getPermission('create user')"
                                >
                                    Create new User
                                </Link>
                                
                            </div>
                        </div>
                    </div>
                    <div class="p-5 bg">
                        <Table class="rounded-lg bg-gray-700">
                            <slot name="heading" >
                                <th scope="col" class="px-6 py-3">
                                    Dui
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Lastname
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Roles
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only"></span>
                                </th>    
                            </slot>
                            <slot>
                                <tr v-for="user in props.users.data" :key="user.id" class="hover:bg-gray-500  bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white ">
                                        <div v-if="getPermission('show user')">
                                            <Link class="flex items-center" :href="route('users.show',{id:user.id})">
                                                {{user.dui}}
                                                <svg fill="none" v-if="user.deleted_at" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                                </svg>
                                            </Link>
                                        </div>
                                        <div v-else>
                                            {{user.dui}}
                                        </div>
                                    </th>
                                    <td class="px-6 py-4">
                                        <div v-if="getPermission('show user')">
                                            <Link  :href="route('users.show',{id:user.id})">
                                                {{user.name}}
                                            </Link>
                                        </div>
                                        <div v-else>
                                            {{user.name}}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div v-if="getPermission('show user')">
                                            <Link :href="route('users.show',{id:user.id})">
                                                {{user.lastname}}
                                            </Link>
                                        </div>
                                        <div v-else>
                                            {{user.lastname}}
                                        </div>
                                        
                                    </td>
                                    <td class="px-6 py-4">
                                        <div v-if="getPermission('show user')">
                                            <Link :href="route('users.show',{id:user.id})">
                                                <div v-for="role in user.roles">
                                                    {{role?.name}}<br>
                                                </div>
                                            </Link>
                                        </div>
                                        <div v-else>
                                            <div v-for="role in user.roles">
                                                {{role?.name}}<br>
                                            </div>
                                        </div>
                                        
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div v-if="getPermission('show user')">
                                            <Link :href="route('users.show',{id:user.id})">
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
                   <Paginate :links="props.users.links" class="mb-6"/>
                </div>
            </div>
        </div>

        <div class="py-4">
            <Card class="max-w-7xl">
                <header class="flex justify-between mt-4">
                    <div>
                        <h2 class="text-4xl font-bold ml-5 mt-3">
                            Roles
                        </h2>
                    </div>
                    <div>
                        <Link 
                            :href="route('roles.create')"
                            method="get" as="button"
                            class=" mr-4 mt-5 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                            v-if="getRoles('administrator')"
                        >
                            Create Role
                        </Link>
                    </div>
                </header>
            
                <div class="p-6">
                    <table id="roles" class="mb-4 rounded-lg w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">Guard Name</th>
                                <th scope="col" class="px-6 py-3">Created At</th>
                                <th scope="col" class="px-6 py-3">Updated At</th>
                                <th scope="col" class="px-6 py-3">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="role in props.roles" :key="role.id" class="hover:bg-gray-500  bg-white border-b dark:bg-gray-700 dark:border-gray-900">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white ">
                                    {{role.name}}
                                </th>
                                <td class="px-6 py-4">
                                    {{role.guard_name}}
                                </td>
                                <td class="px-6 py-4 ">
                                    {{role.created_at}}
                                </td>
                                <td class="px-6 py-4 ">
                                    {{role.updated_at}}
                                </td>
                                <td class="px-6 py-4 ">
                                    <div class="flex space-x-4">
                                        <Link 
                                            method="get" as="button"
                                            class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
                                            :href="route('roles.show',role.id)"
                                            v-if="getRoles('administrator')"
                                        >
                                            Show
                                        </Link>                              
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="props.roles.length === 0">
                                <td class="px-6 py-4 font-medium text-gray-200 whitespace-nowrap" colspan="4">No Roles found.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </Card>
        </div>
    </AuthenticatedLayout>
        
</template>
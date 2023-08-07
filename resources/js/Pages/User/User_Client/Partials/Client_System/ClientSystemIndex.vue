<script setup>
import Card from '@/Components/Card.vue';
import { Link, router, usePage} from '@inertiajs/vue3';
import {ref, computed} from "vue";
const props = defineProps({
    clientId:{
        type:Number,
        required:true
    },
    system_client:{
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
</script>

<template>
     <Card class="mb-8" v-if="props.system_client.length != 0">
        <div class="border-b border-gray-400 flex justify-between margin-b mb-4">
            <div >
                <h2 class="text-4xl font-bold ml-2 mt-3">
                    System Client
                </h2>
            </div>
            <div>
                <Link 
                    :href="route('clients.edit_system',props.clientId)"
                    method="get" as="button"
                    class=" mr-2 mt-3 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                    v-if="props.deleted == false && getPermission('edit client_system')"
                >
                    Edit Client System
                </Link>
            </div>
            
        </div>
        <div class="overflow-y-scroll">
            <div class="text-base p-4" v-for="system in props.system_client">
                <div class="w-full text-justify ">
                    <h3 class="inline text-3xl">
                        {{system.name}}
                    </h3>
                    <div class="my-1.5">
                        <span class="font-semibold">Condition: </span> {{system.pivot.condition}}
                    </div>
                </div>
            </div>    
        </div>
    </Card>
    <Card v-else class="mb-8">
        <div class=" border-gray-400 flex flex-col margin-b mb-4">
            <div >
                <h2 class="text-4xl font-bold ml-8 mt-3">
                    No System was found, but you can created.
                </h2>
            </div>
            <div>
                <Link 
                    :href="route('clients.create_system',props.clientId)"
                    method="get" as="button"
                    class=" ml-8 mt-3 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                    v-if="props.deleted == false && getPermission('create client_system')"
                >
                    Create Client System
                </Link>
            </div>
        </div>
    </Card>

</template>
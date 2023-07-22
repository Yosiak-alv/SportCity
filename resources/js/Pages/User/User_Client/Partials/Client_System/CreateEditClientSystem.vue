<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link, router,useForm,usePage} from '@inertiajs/vue3';
import {ref} from "vue";
import Card from '@/Components/Card.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import TextArea from '@/Components/TextArea.vue';

const props = defineProps({
    client:{
        type:Object,
        required:true
    },
    systems:{
        type:Object,
        required:true
    },
    selected_client_systems:{
        type:Object
    },
    select_client_system_conditions:{
        type:Object
    }

});

const form = useForm({
    client_id: props.client.id,
    system_id: props.selected_client_systems ?? [],
    condition: props.select_client_system_conditions ?? []
});

const store = () => {
    form.post(route('clients.store_system',props.client.id));
};

const update = () => {
    form.patch(route('clients.update_system',props.client.id));
};

const destroy = () => {
    router.delete(route('clients.destroy_system',props.client.id));
}

const permissions = ref(usePage().props.auth.user_role_permissions);

const getPermission = (data) => {
    return permissions.value.find((permission) =>
        permission.toLowerCase().includes(data)
    ) ? true : false;
}
</script>

<template>
    <Head title="Client System" />
        
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ props.selected_client_systems == null ? 'Create a New System for a Client': 'Edit a System of a Client'}}</h2>
        </template>

        <div class="py-12">
            <Card class="max-w-7xl">
                <header class="mb-3 p-2 ml-3 mt-3">
                    <div class="flex justify-between">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Client : {{props.client.name}}, {{props.client.lastname}}</h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                In this section you can edit or create a system for a client...
                            </p>
                        </div>
                        <div>
                            <DangerButton @click="destroy()" v-if="getPermission('delete client_system') && props.selected_client_systems != null">
                                Delete Client System
                            </DangerButton>
                        </div>
                    </div>
                    
                    
                </header>
                <div class="overflow-y-auto " style="height: 40rem;">
                    <form @submit.prevent="( props.select_client_system_conditions == null ? store():update() )" class="grid grid-cols-2 gap-4 p-5">
                        <div v-for="system in props.systems" :key="system.id">
                            <div class="flex flex-col mb-4">
                                <div class="flex items-center space-x-3">
                                    <input :value="system.id" v-model="form.system_id" id="system_id" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <InputLabel for="condition" :value="system.name"/> 
                                    <InputError class="mt-2" :message="form.errors.system_id" />
                                    
                                </div>
                                <textarea 
                                    id="condition" 
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-green-500 dark:focus:border-green-600 focus:ring-green-500 dark:focus:ring-green-600 rounded-md shadow-sm"
                                    v-model="form.condition[system.id]"
                                    rows="3"
                                    autocomplete="condition">
                                </textarea>
                                
                                <InputError class="mt-2" :message="form.errors.condition" />
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <PrimaryButton :disabled="form.processing">{{props.selected_client_systems == null ? 'Create' : 'Update'}}</PrimaryButton>
                        </div>
                    </form>
                   
                </div>
            </Card> 
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { Head,Link, router, usePage, useForm} from '@inertiajs/vue3';
import {ref, watch ,nextTick} from "vue";
import {debounce} from "lodash";
import Card from '@/Components/Card.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import TrashedMessage from '@/Components/TrashedMessage.vue';

import ClientSystemIndex from './Partials/Client_System/ClientSystemIndex.vue';
import ClientSuscriptionIndex from './Partials/Client_Suscription/ClientSuscriptionIndex.vue';
import ClientTrainingSessionsIndex from './Partials/Client_TrainingSessions/ClientTrainingSessionsIndex.vue';
import ClientPurchasesIndex from './Partials/Client_Purchase/ClientPurchasesIndex.vue';

const props = defineProps({
    client:{
        type:Object,
        required:true

    },
    client_attendance_training_sessions:{
        type:Object,
        required:true
    },
    filters:{
        type:Object,
        required:true
    }
});

const edit = (id) => {
    router.get(route('clients.edit',{id:id}))
};

//---Modal Section----
const confirmingClientDeletion = ref(false);
    
const confirmClientDeletion = () => {
    confirmingClientDeletion.value = true;
};

const closeModal = () => {
    confirmingClientDeletion.value = false;
};

const deleteClient = () => {
    router.delete(route('clients.destroy',{id:props.client.id}),{
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => closeModal(),
    });
};

//---Modal Password Section----
const passwordInput = ref(null);
const form = useForm({
    password: '',
    password_confirmation: '',
});

const confirmingPasswordEdition = ref(false);
    
const confirmPasswordEdition = () => {
    confirmingPasswordEdition.value = true;
    nextTick(() => passwordInput.value.focus());
};

const closePasswordModal = () => {
    confirmingPasswordEdition.value = false;
    form.reset();
};

const updatePassword = () => {
    form.patch(route('clients.updatePassword', props.client.id), {
        preserveScroll: true,
        onSuccess: () => closePasswordModal(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
        },
        onFinish: () => form.reset(),
    });
};

//restores link

const restore = () => {
    router.post(route('clients.restore',props.client.id));
};
const permissions = ref(usePage().props.auth.user_role_permissions);

const getPermission = (data) => {
    return permissions.value.find((permission) =>
        permission.toLowerCase().includes(data)
    ) ? true : false;
}

</script>

<template>
    <Head title="Clients Show" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Client details</h2>
        </template>
        <div class="mt-6">
            <TrashedMessage  v-if="props.client.deleted_at != null" @restore="restore" :permission="getPermission('restore client')">This client has been deleted. </TrashedMessage>  
        </div>

        <div class="py-12">
            <Card class="max-w-7xl">
                <div class="grid grid-cols-4 gap-4 p-6 items-center">
                    <div class="col-span-1">
                        <div class="ml-8">
                            <img src="/storage/img/human.png" class="rounded w-40 ">
                        </div>
                    </div>
                    <div class="col-span-2">
                        <span class="inline text-5xl h-fit">{{ client.name }}, {{client.lastname}}</span>
                        <div class="mt-2 text-lg">
                            <span class="font-semibold">Genre:</span> {{ client.genre }}
                            <br>
                            <span class="font-semibold">Phone:</span> {{ client.phone }}
                            <br>
                            <span class="font-semibold">Address:</span> {{ client.address }}
                            <br>
                            <span class="font-semibold">Email:</span> {{ client.email }}
                            <br>
                            <span class="font-semibold">Birth Date:</span> {{ client.birth_date }}
                            <br>
                            <span class="font-semibold">Height:</span> {{ client.height }}
                            <br>
                            <span class="font-semibold">Weight:</span> {{ client.weight }}
                            <br>
                            <span class="font-semibold">Gym:</span> {{ client.gym.name }}
                            <br>
                            <span class="font-semibold">Gym Address:</span> {{client.gym.department.name}}, {{ client.gym.address }}
                            <br>
                            <span v-if="props.client.deleted_at" class="font-semibold">Deleted at:</span> {{props.client.deleted_at}}
                        </div>
                    </div>
                    <div class="col-span-1 justify-items-center">
                        <div>
                            <PrimaryButton class="ml-8" @click="edit(client.id)" v-if="!props.client.deleted_at && getPermission('edit client')">
                                Edit Client
                            </PrimaryButton>
                        </div>
                        <div>
                            <SecondaryButton class="ml-8 mt-2" @click="confirmPasswordEdition()" v-if="!props.client.deleted_at && getPermission('update client password')">
                                Update Password
                            </SecondaryButton>
                        </div>
                        <div>
                            <DangerButton class="mt-2 ml-8" @click="confirmClientDeletion()" v-if="!props.client.deleted_at && getPermission('delete client')">
                                Delete Client
                            </DangerButton>
                        </div>
                    </div>
                </div>
            </Card>
        </div>

        <div class="py-9">
            <ClientTrainingSessionsIndex  :clientId="props.client.id" :trainingSessions="props.client_attendance_training_sessions" :filters="props.filters" :deleted="props.client.deleted_at == null ? false:true"/>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div class="row-span-2">
                <ClientSystemIndex :clientId="props.client.id" :system_client="props.client.system_client" :deleted="props.client.deleted_at == null ? false:true"/>
            </div>
           
            <div class="col-span-2">
                <ClientSuscriptionIndex :clientId="props.client.id" :suscriptions="props.client.suscriptions" :deleted="props.client.deleted_at == null ? false:true"/>                
            </div>

            <div class="col-span-2">
                <ClientPurchasesIndex :clientId="props.client.id" :purchases="props.client.purchases" :deleted="props.client.deleted_at == null ? false:true"/>
            </div>
        </div>

        <!-- <div class="grid grid-flow-row-dense grid-cols-3 grid-rows-3 auto-cols-max">
            <div class="row-span-3">
                <ClientSystemIndex :clientId="props.client.id" :system_client="props.client.system_client" :deleted="props.client.deleted_at == null ? false:true"/>
                
            </div>
            <div class="col-span-2">
                <ClientSuscriptionIndex :clientId="props.client.id" :suscriptions="props.client.suscriptions" :deleted="props.client.deleted_at == null ? false:true"/>
            </div>
            <div class="col-span-2">
                <ClientPurchasesIndex :clientId="props.client.id" :purchases="props.client.purchases" :deleted="props.client.deleted_at == null ? false:true"/>
            </div>
        </div> -->
    </AuthenticatedLayout>
    


    <Modal :show="confirmingClientDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Are you sure you want to delete this Client ?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                If you delete it, the record will always remain in the system with INACTIVE STATUS, consider
                that other records that use this will appear empty, waiting to be edited or restored
                of this record.
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    @click="deleteClient"
                >
                    Confirm
                </DangerButton>
            </div>
        </div>
    </Modal>

    <Modal :show="confirmingPasswordEdition" @close="closePasswordModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Are you sure you want to update this Client Password?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Once the password has been updated, the client in question must use the 
                password that was updated, be sure before updating.
            </p>

            <div class="mt-6">
                <InputLabel for="password" value="Password" class="sr-only" />

                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="Password"
                />
            </div>
            <div class="mt-6">
            <InputLabel for="password_confirmation" value="Confirm Password"  class="sr-only" />

            <TextInput
                id="password_confirmation"
                v-model="form.password_confirmation"
                type="password"
                class="mt-1 block w-3/4"
                placeholder="Confirm_Password"
            />

            <InputError :message="form.errors.password" class="mt-2" />
        </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closePasswordModal"> Cancel </SecondaryButton>

                <PrimaryButton
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="updatePassword()"
                >
                    Update Password
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
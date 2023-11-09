<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { Head,Link, router, usePage,useForm} from '@inertiajs/vue3';
import {ref, watch,nextTick} from "vue";
import {debounce} from "lodash";
import Card from '@/Components/Card.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import TrashedMessage from '@/Components/TrashedMessage.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    user:{
        type:Object,
        required:true

    },
});


const edit = () => {
    router.get(route('users.edit',{id:props.user.id}))
};

//---Modal Section----
const confirmingDeletion = ref(false);
    
const confirmDeletion = () => {
    confirmingDeletion.value = true;
};

const closeModal = () => {
    confirmingDeletion.value = false;
};

const deleteUser = () => {
    router.delete(route('users.destroy',{id:props.user.id}),{
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
    form.patch(route('users.updatePassword', props.user.id), {
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
    router.post(route('users.restore',props.user.id));
};

const permissions = ref(usePage().props.auth.user_role_permissions);

const getPermission = (data) => {
    return permissions.value.find((permission) =>
        permission.toLowerCase().includes(data)
    ) ? true : false;
}

</script>

<template>
    <Head title="User Show" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">User details</h2>
        </template>
        <div class="mt-6">
            <TrashedMessage  v-if="props.user.deleted_at != null" @restore="restore" :permission="getPermission('restore user')">This user has been deleted. </TrashedMessage>  
        </div>

        <div class="py-12">
            <Card class="max-w-7xl">
                <div class="grid grid-cols-4 gap-4 p-6 items-center">
                    <div class="col-span-1">
                        <img src="/storage/img/human.png" class="rounded w-40 ">
                    </div>
                    <div class="col-span-2">
                        <span class="inline text-5xl h-fit">{{ user.name }}, {{user.lastname}}</span>
                        <div class="mt-2 text-lg">
                            <span class="font-semibold">Phone:</span> {{ user.phone }}
                            <br>
                            <span class="font-semibold">Email:</span> {{ user.email }}
                            <br>
                            <span class="font-semibold">Gym:</span> <span :class="{'text-red-600 dark:text-red-400' : user.gym == null}">
                            {{ user.gym?.name ?? 'Current Gym Deleted'}} </span>
                            <br>
                            <span class="font-semibold">Gym Address:</span> {{user.gym?.department.name ?? ''}}, {{ user.gym?.address ?? ''}}
                            <br>
                            <span v-if="props.user.deleted_at" class="font-semibold">Deleted at:</span> {{props.user.deleted_at}}
                        </div>
                    </div>
                    <div class="col-span-1 justify-items-center">
                        <div>
                            <PrimaryButton class="ml-8  " @click="edit()" v-if="!props.user.deleted_at && getPermission('edit user')">
                                Edit User
                            </PrimaryButton>
                        </div>
                        <div>
                            <SecondaryButton class="ml-8 mt-2" @click="confirmPasswordEdition()" v-if="!props.user.deleted_at && getPermission('update user password')">
                                Update Password
                            </SecondaryButton>
                        </div>
                        <div v-if="usePage().props.auth.user.id != props.user.id">
                            <DangerButton class="ml-8 mt-2" @click="confirmDeletion()" v-if="!props.user.deleted_at && getPermission('delete user')">
                                Delete User
                            </DangerButton>
                        </div>
                       
                    </div>
                </div>
            </Card>
        </div>

        <div class="py-2">
            <div class="max-w-7xl mx-auto text-center my-4 text-gray-900 dark:text-gray-100" :class="{'text-red-600 dark:text-red-400' : props.user.roles.length == 0}">
                <h2 class="text-3xl font-semibold">{{user.roles.length == 0 ? 'Current Role Deleted !!!' : 'Role Permissions'}}</h2>
            </div>

            <div class="mt-4">
                <div class="flex justify-center" v-if="props.user.roles.length != 0">
                    <div v-for="role in props.user.roles" :key="role.id">
                        <div class="flex flex-col mb-4">
                            <Card class="">
                                <div class="border-b border-gray-400 flex justify-between margin-b mb-4">
                                    <h2 class="text-4xl font-bold ml-2 mt-3 p-5">
                                        {{role.name}}
                                    </h2>
                                </div>
                                <div class="overflow-y-scroll" style="height: 20rem;">
                                    <div class="text-base p-4" v-for="role_permission in role.permissions">
                                        <div class="w-full text-justify ">
                                            <h3 class="ml-8 inline text-2xl">
                                                {{role_permission.name}}
                                            </h3>
                                        </div>
                                    </div>    
                                </div>
                            </Card>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
    


    <Modal :show="confirmingDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Are you sure you want to delete this User ?
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
                    @click="deleteUser()"
                >
                    Confirm
                </DangerButton>
            </div>
        </div>
    </Modal>
    <Modal :show="confirmingPasswordEdition" @close="closePasswordModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Are you sure you want to update this user Password?
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Once the password has been updated, the user in question must use the 
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
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { Head,Link, router, usePage, useForm} from '@inertiajs/vue3';
import {ref, watch,nextTick} from "vue";
import Card from '@/Components/Card.vue';
import CoachTrainingSessionsIndex from './Partials/Training_Sessions/CoachTrainingSessionsIndex.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TrashedMessage from '@/Components/TrashedMessage.vue';

const props = defineProps({
    coach:{
        type:Object,
        required:true
    },
    coach_training_sessions:{
        type:Object,
        required:true
    },
    filters:{
        type:Object,
        required:true
    }  
});

const edit = (id) => {
    router.get(route('coaches.edit',{id:id}))
};


//---Modal Section---- falta
const confirmingDeletion = ref(false);
    
const confirmDeletion = () => {
    confirmingDeletion.value = true;
};

const closeModal = () => {
    confirmingDeletion.value = false;
};

const deleteCoach = () => {
    router.delete(route('coaches.destroy',{id:props.coach.id}),{
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
    form.patch(route('coaches.updatePassword', props.coach.id), {
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
    router.post(route('coaches.restore',props.coach.id));
};

const permissions = ref(usePage().props.auth.user_role_permissions);

const getPermission = (data) => {
    return permissions.value.find((permission) =>
        permission.toLowerCase().includes(data)
    ) ? true : false;
}
</script>

<template>
    <Head title="Coach Show" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Coach details</h2>
        </template>
        <div class="mt-6">
            <TrashedMessage  v-if="props.coach.deleted_at != null" @restore="restore" :permission="getPermission('restore coach')">This Coach has been deleted. </TrashedMessage>  
        </div>
        <div class="py-12">
            <Card class="max-w-7xl">
                <div class="grid grid-cols-4 gap-4 p-6 items-center">
                    <div class="col-span-1">
                        <div class="ml-8">
                            <img src="/storage/img/coach.png" class="rounded w-40 ">
                        </div>
                    </div>
                    <div class="col-span-2">
                        <span class="inline text-5xl h-fit">{{ coach.name }}, {{coach.lastname}}</span>
                        <div class="mt-2 text-lg">
                            <br>
                            <span class="font-semibold">Phone:</span> {{ coach.phone }}
                            <br>
                            <span class="font-semibold">Address:</span> {{ coach.address }}
                            <br>
                            <span class="font-semibold">Email:</span> {{ coach.email }}
                            <br>
                            <span class="font-semibold">Gym:</span> {{ coach.gym.name }}
                            <br>
                            <span class="font-semibold">Gym Address:</span> {{coach.gym.department.name}}, {{ coach.gym.address }}
                            <br>
                            <span v-if="props.coach.deleted_at" class="font-semibold">Deleted at:</span> {{props.coach.deleted_at}}
                        </div>
                    </div>
                    <div class="col-span-1 justify-items-center">
                        <div>
                            <PrimaryButton class="ml-8" @click="edit(coach.id)" v-if="!props.coach.deleted_at && getPermission('edit coach')">
                                Edit Coach
                            </PrimaryButton>
                        </div>
                        <div>
                            <SecondaryButton class="ml-8 mt-2" @click="confirmPasswordEdition()" v-if="!props.coach.deleted_at && getPermission('update coach password')">
                                Update Password
                            </SecondaryButton>
                        </div>
                        <div>
                            <DangerButton class="mt-2 ml-8" @click="confirmDeletion()" v-if="!props.coach.deleted_at && getPermission('delete coach')">
                                Delete Coach
                            </DangerButton>
                        </div>
                       
                    </div>
                </div>
            </Card>
        </div>

        <div class="py-9">
            <CoachTrainingSessionsIndex  :coachId="props.coach.id" :trainingSessions="props.coach_training_sessions" 
            :filters="props.filters" :deleted="props.coach.deleted_at == null ? false:true"/>
        </div>
    </AuthenticatedLayout>

    <Modal :show="confirmingDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Are you sure you want to delete this Coach ?
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
                    @click="deleteCoach()"
                >
                    Confirm
                </DangerButton>
            </div>
        </div>
    </Modal>

    <Modal :show="confirmingPasswordEdition" @close="closePasswordModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Are you sure you want to update this Coach Password?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Once the password has been updated, the coach in question must use the 
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
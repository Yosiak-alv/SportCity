<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link, router,useForm} from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import DateInput from '@/Components/DateInput.vue';
const props = defineProps({
    role:{
        type:Object,
        required:false
    },
    selected_permissions:{
        type:Object,
        required:false
    },
    permissions:{
        type:Object,
        required:true
    },

});

const form = useForm({
    id: props.role?.id ?? '',
    name:props.role?.name ?? '',
    permissions_id: props.selected_permissions ?? [],

});

const store = () => {
    form.post(route('roles.store'));
};

const update = () => {
    form.patch(route('roles.update',{id: form.id}));
};
</script>

<template>
    <Head title="Roles" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ props.role == null ? 'Create a New Role': 'Edit Role'}}</h2>
        </template>

        <div class="py-12">
            <Card class="max-w-7xl mt-6 space-y-6">
                <form @submit.prevent="(props.role == null ? store(): update())" class="grid grid-cols-2 gap-4 p-6">
                    <div>
                        <div class="mt-1">
                            <InputLabel for="name" value="Name" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-1/2"
                                v-model="form.name"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
                    </div>
                    <div>
                        <div class="mt-1">
                            <div class="border-b border-gray-400 flex justify-between margin-b mb-4">
                                <h2 class="text-2xl font-bold mt-3 ">
                                    Permissions
                                </h2>
                            </div>
                            <div class="overflow-y-auto " style="height: 20rem;">
                                <div v-for="permission in props.permissions" :key="permission.id">
                                    <div class="flex flex-col mb-4 ml-4">
                                        <div class="flex items-center space-x-3">
                                            <input :value="permission.id" v-model="form.permissions_id" id="permissions_id" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <InputLabel for="permissions_id" :value="permission.name"/> 
                                            <InputError class="mt-2" :message="form.errors.permissions_id" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <PrimaryButton :disabled="form.processing">{{props.role == null ? 'Create' : 'Update'}}</PrimaryButton>
                    </div>
                </form>
            </Card>
        </div>
    </AuthenticatedLayout>

</template>
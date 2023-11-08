<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link, router,useForm} from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';

const props = defineProps({
    gym:{
        type:Object,
        required:false
    },
    departments:{
        type:Object,
        required:true
    }
});

const form = useForm({
    id: props.gym?.id ?? '',
    name:props.gym?.name ?? '',
    phone: props.gym?.phone ?? '',
    address: props.gym?.address ?? '',
    email: props.gym?.email ?? '',
    department_id: props.gym?.department_id ?? '',
});

const store = () => {
    form.post(route('gyms.store'));
};

const update = (id) => {
    form.patch(route('gyms.update',{id:id}));
};
</script>

<template>
    <Head title="Gyms" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ props.gym == null ? 'Create a New Gymh': 'Edit Gym'}}</h2>
        </template>

        <div class="py-12">
            <Card class="max-w-7xl mt-6 space-y-6">
                <form @submit.prevent="(props.gym == null ? store(): update(form.id))" class="grid grid-cols-2 gap-4 p-6">
                    <div>
                        <div class="mt-1">
                            <InputLabel for="name" value="Name" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
                        <div class="mt-1">
                            <InputLabel for="email" value="Email" />

                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                required
                                autocomplete="email"
                            />

                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                        <div class="mt-1">
                            <InputLabel for="department_id" value="Department" />
                            <select 
                                id="department_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                v-model="form.department_id"
                                required
                            >
                                <option v-for="department in props.departments" :value="department.id" :key="department.id">
                                    {{department.name}}
                                </option>
                            </select>

                            <InputError class="mt-2" :message="form.errors.department_id" />
                        </div>
                    </div>
                    <div>
                        <div class="">
                            <InputLabel for="address" value="Address" />

                            <TextArea
                                id="address"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.address"
                                rows="4"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.address" />
                        </div>    
                        <div class="mt-1">
                            <InputLabel for="phone" value="Phone" />

                            <TextInput
                                id="phone"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.phone"
                                required
                                autocomplete="phone"
                            />

                            <InputError class="mt-2" :message="form.errors.phone" />
                        </div>
                        
                    </div>
                    <div class="flex items-center gap-4">
                        <PrimaryButton :disabled="form.processing">{{props.gym == null ? 'Create' : 'Update'}}</PrimaryButton>
                    </div>
                </form>
            </Card>
        </div>
    </AuthenticatedLayout>

</template>
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
    coach:{
        type:Object,
        required:false
    },
    gyms:{
        type:Object,
        required:true
    }
});

const form = useForm({
    id: props.coach?.id ?? '',
    dui: props.coach?.dui ?? '',
    name:props.coach?.name ?? '',
    lastname: props.coach?.lastname ?? '',
    phone: props.coach?.phone ?? '',
    address: props.coach?.address ?? '',
    email: props.coach?.email ?? '',
    gym_id: props.coach?.gym_id ?? '',

});

const store = () => {
    form.post(route('coaches.store'));
};

const update = (id) => {
    form.patch(route('coaches.update',{id:id}));
};
</script>

<template>
    <Head title="Coaches" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ props.coach == null ? 'Create a New Coach': 'Edit Coach'}}</h2>
        </template>

        <div class="py-12">
            <Card class="max-w-7xl mt-6 space-y-6">
                <form @submit.prevent="(props.coach == null ? store(): update(form.id))" class="grid grid-cols-2 gap-4 p-6">
                    <div>
                        <div>
                            <InputLabel for="dui" value="Dui" />

                            <TextInput
                                id="dui"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.dui"
                                required
                                autofocus
                                autocomplete="dui"
                            />

                            <InputError class="mt-2" :message="form.errors.dui" />
                        </div>
                        <div class="mt-1">
                            <InputLabel for="name" value="Name" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autocomplete="name"
                            />

                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
                        <div class="mt-1">
                            <InputLabel for="lastname" value="Lastname" />

                            <TextInput
                                id="lastname"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.lastname"
                                required
                                autocomplete="lastname"
                            />

                            <InputError class="mt-2" :message="form.errors.lastname" />
                        </div>
                       
                        <div class="mt-1">
                            <InputLabel for="gym_id" value="Gym" />
                            <select 
                                id="gym_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                v-model="form.gym_id"
                                required
                            >
                                <option v-for="gym in props.gyms" :value="gym.id" :key="gym.id">
                                    {{gym.name}}
                                </option>
                            </select>

                            <InputError class="mt-2" :message="form.errors.gym_id" />
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
                                required
                                autocomplete="address"
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
                    </div>
                    <div class="flex items-center gap-4">
                        <PrimaryButton :disabled="form.processing">{{props.coach == null ? 'Create' : 'Update'}}</PrimaryButton>
                    </div>
                </form>
            </Card>
        </div>
    </AuthenticatedLayout>

</template>
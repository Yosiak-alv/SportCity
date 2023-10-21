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
    user:{
        type:Object,
        required:false
    },
    gyms:{
        type:Object,
        required:true
    }
});

const form = useForm({
    id: props.user?.id ?? '',
    dui: props.user?.dui ?? '',
    name:props.user?.name ?? '',
    lastname: props.user?.lastname ?? '',
    phone: props.user?.phone ?? '',
    email: props.user?.email ?? '',
    gym_id: props.user?.gym_id ?? '',
    password: props.user?.password ,
});

const store = () => {
    form.post(route('users.store'));
};

const update = (id) => {
    form.patch(route('users.update',{id:id}));
};
</script>

<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ props.user == null ? 'Create a New User': 'Edit User'}}</h2>
        </template>

        <div class="py-12">
            <Card class="max-w-7xl mt-6 space-y-6">
                <form @submit.prevent="(props.user == null ? store(): update(form.id))" class="grid grid-cols-2 gap-4 p-6">
                    <div>
                        <div>
                            <InputLabel for="dui" value="Dui" />

                            <TextInput
                                id="dui"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.dui"
                                required
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
                        <div class="mt-1">
                            <InputLabel for="phone" value="Phone" />

                            <TextInput
                                id="phone"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.phone"
                                required
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
                            />

                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                        <div class="mt-1" v-if="props.user == null">
                            <InputLabel for="password" value="Password:" />

                            <TextInput
                                id="password"
                                type="password"
                                class="mt-1 block w-full"
                                v-model="form.password"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <PrimaryButton :disabled="form.processing">{{props.user == null ? 'Create' : 'Update'}}</PrimaryButton>
                    </div>
                </form>
            </Card>
        </div>
    </AuthenticatedLayout>

</template>
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
    client:{
        type:Object,
        required:false
    },
    gyms:{
        type:Object,
        required:true
    }
});

const form = useForm({
    id: props.client?.id ?? '',
    dui: props.client?.dui ?? '',
    name:props.client?.name ?? '',
    lastname: props.client?.lastname ?? '',
    genre: props.client?.genre ?? '',
    phone: props.client?.phone ?? '',
    address: props.client?.address ?? '',
    birth_date: props.client?.birth_date ?? '',
    height: props.client?.height ?? '0',
    weight: props.client?.weight ?? '0',
    email: props.client?.email ?? '',
    gym_id: props.client?.gym_id ?? '',

    //password: props.client?.password ?? '',
});

const store = () => {
    form.post(route('clients.store'));
};

const update = (id) => {
    form.patch(route('clients.update',{id:id}));
};
</script>

<template>
    <Head title="Clients" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ props.client == null ? 'Create a New Client': 'Edit Client'}}</h2>
        </template>

        <div class="py-12">
            <Card class="max-w-7xl mt-6 space-y-6">
                <form @submit.prevent="(props.client == null ? store(): update(form.id))" class="grid grid-cols-2 gap-4 p-6">
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
                            <InputLabel for="genre" value="Genre" />
                            <select 
                                id="genre"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                v-model="form.genre"
                                required
                            >
                                <option  v-for="value in [{'id':'H','name':'Men'},{'id':'M','name':'Woman'}]" :value="value.id"  :key="value.id">
                                    {{value.name}}
                                </option>
                            </select>
                            
                            <InputError class="mt-2" :message="form.errors.genre" />
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
                        <div class="mt-1">
                            <InputLabel for="birth_date" value="Birth Date" />
                            <DateInput
                                id="birth_date"  
                                class="mt-1 block w-full"
                                v-model="form.birth_date"
                                required
                                autocomplete="birth_date" 
                            />
                        
                            <InputError class="mt-2" :message="form.errors.birth_date" />
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
                            <InputLabel for="height" value="Height" />

                            <TextInput
                                id="height"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.height"
                                required
                                
                            />

                            <InputError class="mt-2" :message="form.errors.height" />
                        </div>
                        <div class="mt-1">
                            <InputLabel for="weight" value="Weight" />

                            <TextInput
                                id="weight"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.weight"
                                required
                                autocomplete="weight"
                            />

                            <InputError class="mt-2" :message="form.errors.weight" />
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
                        <PrimaryButton :disabled="form.processing">{{props.client == null ? 'Create' : 'Update'}}</PrimaryButton>
                    </div>
                </form>
            </Card>
        </div>
    </AuthenticatedLayout>

</template>
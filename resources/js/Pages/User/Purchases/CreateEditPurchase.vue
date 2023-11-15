<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link, router,useForm,usePage} from '@inertiajs/vue3';
import {ref} from "vue";
import Card from '@/Components/Card.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    products:{
        type:Object,
        required:true
    },
    clients:{
        type:Object,
        required:true
    },
    gyms:{
        type:Object,
        required:true
    }
});
const shortDescript = (description) => {
    return description.substring(0, 30) + '...';
}
const form = useForm({
    client_id: '',
    product_id: [],
    quantity: [],
    gym_id: '',
});
//role things
const roles = ref(usePage().props.auth.user_roles);

const getRoles = (data) => {
    return roles.value.find((role) =>
        role.toLowerCase().includes(data)
    ) ? true : false;
}

</script>

<template>
    <Head title="Purchase"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create a new Purchase for a Client</h2>
        </template>

        <div class="py-12">
            <Card class="max-w-7xl" v-if="props.products.length != 0">
            
                <div >
                    <form @submit.prevent="form.post(route('purchases.store'))" class="p-5">
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div v-if="getRoles('administrator') || getRoles('manager')">
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
                            <div>
                                <InputLabel for="client_id" value="Client" />
                                <select 
                                    id="gym_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                    v-model="form.client_id"
                                    required
                                >
                                    <option v-for="client in props.clients" :value="client.id" :key="client.id">
                                        {{client.name}} , {{client.gym.name}}
                                    </option>
                                </select>

                                <InputError class="mt-2" :message="form.errors.client_id" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2 overflow-y-auto" style="height: 40rem;">
                            <div v-for="product in props.products" :key="product.id">
                                <div class="flex flex-col mb-4 ">
                                    <div class="flex items-center space-x-3 ml-8">
                                        <input :value="product.id" v-model="form.product_id" id="product_id" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <InputLabel for="product_id" :value="product.name"/>
                                        <InputError class="mt-2" :message="form.errors.product_id" />
                                        
                                    </div>
                                    <div class="flex items-center space-x-3 ml-8">
                                        <InputLabel for="quantity" value="Quantity: "/> 
                                        <TextInput
                                            id="quantity"
                                            type="number"
                                            :min="1"
                                            :max="product.quantity"
                                            class="mt-1 mb-3"
                                            v-model="form.quantity[product.id]"
                                            autocomplete="quantity"
                                        />
                                        <InputError class="mt-2" :message="form.errors.quantity" />
                                    </div>
                                    <Card class="max-w-7xl mb-5 block w-full">
                                        <div class="w-full p-2 bg-gray-700">
                                            <div class="text-center">
                                                <p class="inline text-3xl">
                                                    {{ product.name }},<br> {{product.gym.name}}
                                                </p>
                                            </div>
                                            <div class="my-1.5 text-center">
                                                <span class="font-semibold text-center">Description:</span> {{shortDescript(product.description)}}
                                            </div>
                                            <div class="my-1.5 text-center">
                                                <span class="font-semibold">Price:</span> {{ product.unit_price }}
                                            </div>
                                            <div class="my-1.5 text-center">
                                                <span class="font-semibold">Quantity:</span> {{ product.quantity }}
                                            </div>
                                        </div>
                                    </Card> 
                                </div>
                            </div>
                        </div>                   
                        <div class="flex items-center gap-4 ml-8 mt-4">
                            <PrimaryButton :disabled="form.processing">Create Purchase</PrimaryButton>
                        </div>
                    </form>
                </div>
            </Card>
            <Card v-else>
                <div class=" border-gray-400 flex flex-col margin-b mb-4">
                    <div >
                        <h2 class="text-4xl font-bold ml-8 mt-3">
                            No Products Avalible.
                        </h2>
                    </div>
                    <div>
                        <Link 
                            :href="route('purchases.index')"
                            method="get" as="button"
                            class=" ml-8 mt-3 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                        >
                            Return Back
                        </Link>
                    </div>
                </div>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>
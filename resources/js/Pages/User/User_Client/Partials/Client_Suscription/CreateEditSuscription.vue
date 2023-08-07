<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link, router,useForm,usePage} from '@inertiajs/vue3';
import {ref} from "vue";
import Card from '@/Components/Card.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import DateInput from '@/Components/DateInput.vue';

const props = defineProps({
    client:{
        type:Object,
        required:true
    },
    plans:{
        type:Object,
        required:true
    },
    suscription:{
        type:Object,
        required:false
    },

});
//const selected = ref(null);
const form = useForm({
    id: props.suscription?.id ?? '',
    client_id: props.suscription?.client_id ?? props.client.id ,
    plan_id: props.suscription?.plan_id ?? '',
    transaction: '',
    card_number : '',
    exp_date: '',
    cvv: '',

});

const store = () => {
    form.post(route('clients.storeSuscription',props.client.id));
};

const update = () => {
    form.patch(route('clients.updateSuscription',{client: props.client.id, id: props.suscription.id}));
};
</script>

<template>
    <Head title="Client Suscription" />
        
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ props.selected_client_systems == null ? 'Create a New Suscription': 'Edit a Suscription'}}</h2>
        </template>

        <div class="py-12">
            <Card class="max-w-7xl">
                <header class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Client : {{props.client.name}}, {{props.client.lastname}}</h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        In this section you can edit or create a suscription for a client...
                    </p>
                </header>
                <div class="space-y-6">
                    <form @submit.prevent="( props.suscription == null ? store():update() )" class="flex flex-col p-6">
                        <div>
                            <div>
                                <InputLabel for="plan" value="Plan" />
                                <select 
                                    id="plan"
                                    class="mt-1 block w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500  p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                    v-model="form.plan_id"
                                    
                                >
                                    <option  v-for="plan in props.plans" :value="plan.id"  :key="plan.id">
                                        {{plan.name}} , ${{ plan.price }}
                                    </option>
                                </select>
                                
                                <InputError class="mt-2" :message="form.errors.plan_id" />
                            </div>
                            
                        </div>
                        
                        <div>
                            <div v-if="props.suscription == null">
                                <!--pago de tarjeta o cash-->
                                <h3 class="mt-2 mb-3 font-semibold text-gray-900 dark:text-white">Type of Transaction: </h3>
                                <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                        <div class="flex items-center pl-3">
                                            <input id="horizontal-list-radio-license" type="radio" v-model="form.transaction" value="Card" name="list-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="horizontal-list-radio-license" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Card Transaction </label>
                                        </div>
                                    </li>
                                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                        <div class="flex items-center pl-3">
                                            <input id="horizontal-list-radio-id" type="radio" v-model="form.transaction" value="Cash" name="list-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="horizontal-list-radio-id" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Cash Transaction</label>
                                        </div>
                                    </li>
                                    
                                </ul>
                                <InputError class="mt-2" :message="form.errors.transaction" />

                                <div class="p-3" v-show="form.transaction == 'Card'">
                                    <div>
                                        <InputLabel for="card_number" value="Card Number" />

                                        <TextInput
                                            id="card_number"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.card_number"
                                        />

                                        <InputError class="mt-2" :message="form.errors.card_number" />
                                    </div>
                                    <div class="mt-1 grid grid-cols-2 gap-4">
                                        <div>
                                            <InputLabel for="exp_date" value="Expiration Date" />

                                            <DateInput
                                                id="exp_date"  
                                                class="mt-1 block w-full"
                                                v-model="form.exp_date"
                                            />

                                            <InputError class="mt-2" :message="form.errors.exp_date" />
                                        </div>
                                        <div>
                                            <InputLabel for="cvv" value="CVV" />

                                            <TextInput
                                                id="cvv"
                                                type="number"
                                                class="mt-1 block w-full"
                                                min="0"
                                                v-model="form.cvv"
                                            /> 
                                            <InputError class="mt-2" :message="form.errors.cvv" />

                                        </div>
                                    </div>
                                </div>  
                                <div v-show="form.transaction == 'Cash'">
                                </div>

                            </div>
                            <div v-else>
                            </div>
                        </div>                        

                        <div class="flex items-center gap-4 mt-3">
                            <PrimaryButton :disabled="form.processing">{{props.suscription == null ? 'Create' : 'Update'}}</PrimaryButton>
                        </div>
                    </form>
                   
                </div>
            </Card> 
        </div>
    </AuthenticatedLayout>
</template>
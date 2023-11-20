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
    suscription:{
        type:Object,
        required:false
    },
    plans:{
        type:Object,
        required:true
    },
    clients:{
        type:Object,
        required:true
    }
});

const form = useForm({
    id: props.suscription?.id ?? '',
    client_id:props.suscription?.client_id ?? '',
    plan_id: props.suscription?.plan_id ?? '',
});

const store = () => {
    form.post(route('suscriptions.store'));
};

const update = (id) => {
    form.patch(route('suscriptions.update',{id:id}));
};
</script>

<template>
    <Head title="Suscriptions" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ props.suscription == null ? 'Create a New Suscription': 'Edit Suscription'}}</h2>
        </template>

        <div class="py-12">
            <Card class="max-w-7xl mt-6 space-y-6">
                <form @submit.prevent="(props.suscription == null ? store(): update(form.id))" class="grid grid-cols-1 p-6">
                    <div>
                        <div class="mt-1">
                            <InputLabel for="client_id" value="Clients" />

                            <select 
                                id="plan_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                v-model="form.client_id" 
                                required
                            >
                                <option v-for="client in props.clients" :value="client.id" :key="client.id">
                                    {{client.name}}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.client_id" />
                        </div>
                        <div class="mt-1">
                            <InputLabel for="plan_id" value="Plans" />

                            <select 
                                id="plan_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                v-model="form.plan_id" 
                                required
                            >
                                <option v-for="plan in props.plans" :value="plan.id" :key="plan.id">
                                    {{plan.name}} , ${{plan.price}}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.plan_id" />
                        </div>
                    </div>
                    <div class="flex items-center gap-4 mt-4">
                        <PrimaryButton :disabled="form.processing">{{props.suscription == null ? 'Create' : 'Update'}}</PrimaryButton>
                    </div>
                </form>
            </Card>
        </div>
    </AuthenticatedLayout>

</template>
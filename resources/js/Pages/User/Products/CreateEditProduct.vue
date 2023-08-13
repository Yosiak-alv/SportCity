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
    product:{
        type:Object,
        required:false
    },
    gyms:{
        type:Object,
        required:true
    }
});

const form = useForm({
    id: props.product?.id ?? '',
    name:props.product?.name ?? '',
    description: props.product?.description ?? '',
    unit_price: props.product?.unit_price ?? '',
    quantity: props.product?.quantity ?? '',
    gym_id: props.product?.gym_id ?? '',
});

const store = () => {
    form.post(route('products.store'));
};

const update = (id) => {
    form.patch(route('products.update',{id:id}));
};
</script>

<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ props.client == null ? 'Create a New Product': 'Edit a Product'}}</h2>
        </template>

        <div class="py-12">
            <Card class="max-w-7xl mt-6 space-y-6">
                <form @submit.prevent="(props.product == null ? store(): update(form.id))" class="grid grid-cols-2 gap-4 p-6">
                    <div>
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
                            <InputLabel for="description" value="Description" />

                            <TextArea
                                id="description"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.description"
                                required
                                autocomplete="description"
                            />

                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>
                        <div class="mt-1">
                            <InputLabel for="unit_price" value="Unit Price" />

                            <TextInput
                                id="unit_price"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.unit_price"
                                step="0.01"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.unit_price" />
                        </div>
                        
                       
                    </div>
                    <div>
                        <div class="">
                            <InputLabel for="quantity" value="Quantity" />

                            <TextInput
                                id="quantity"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.quantity"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.quantity" />
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
                                    {{gym.name}} , {{gym.department.name}}
                                </option>
                            </select>

                            <InputError class="mt-2" :message="form.errors.gym_id" />
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <PrimaryButton :disabled="form.processing">{{props.product == null ? 'Create' : 'Update'}}</PrimaryButton>
                    </div>
                </form>
            </Card>
        </div>
    </AuthenticatedLayout>

</template>
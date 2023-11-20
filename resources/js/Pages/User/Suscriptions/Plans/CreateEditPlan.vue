<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link, router,useForm} from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';

const props = defineProps({
    plan:{
        type:Object,
        required:false
    },
});

const form = useForm({
    id: props.plan?.id ?? '',
    name:props.plan?.name ?? '',
    description: props.plan?.description ?? '',
    duration: props.plan?.duration ?? '',
    price: props.plan?.price ?? '',
    details: props.plan?.details ?? [{detail:''}],
});
const addDetail = () => {
    form.details.push({ detail: '' });
}
const removeDetail = (index) => {
    form.details.splice(index, 1);
}

const store = () => {
    form.post(route('plans.store'));
};

const update = (id) => {
    form.patch(route('plans.update',{id:id}));
};
const getError = (key) => {
      // Check if the key exists in the form errors, if yes, return the error message
      return form.errors[key] ? form.errors[key] : null;
    };
</script>

<template>
    <Head title="Plan" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ props.plan == null ? 'Create a New Plan': 'Edit Plan'}}</h2>
        </template>

        <div class="py-12">
            <Card class="max-w-7xl mt-6 space-y-6">
                <form @submit.prevent="(props.plan == null ? store(): update(form.id))" class="p-6">
                    <div class="grid grid-cols-2 gap-4">
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
                                <InputLabel for="description" value="Description" />

                                <TextArea
                                    id="description"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.description"
                                    required
                                    rows="5"
                                />

                                <InputError class="mt-2" :message="form.errors.description" />
                            </div>    
                        
                        </div>
                        <div>
                            <div class="mt-1">
                                <InputLabel for="price" value="Price" />

                                <TextInput
                                    id="price"
                                    type="number"
                                    class="mt-1 block"
                                    :min="1"
                                    v-model="form.price"
                                    step="0.01"                                
                                    required
                                />

                                <InputError class="mt-2" :message="form.errors.price" />
                            </div>
                            <div class="mt-1">
                                <InputLabel for="duration" value="Duration" />
                                <select 
                                    id="duration"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                    v-model="form.duration"
                                    required
                                >
                                    <option  v-for="value in [{'name':'Month'},{'name':'Day'}]" :value="value.name"  :key="value.name">
                                        {{value.name}}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.duration" />
                            </div>
                        </div>
                    </div>
                   <div class="mt-2">
                        <SecondaryButton @click="addDetail()" class="mb-2">
                            Add new Detail
                        </SecondaryButton>
                        <div v-for="(detail, index) in form.details" :key="index" class="space-x-4">
                            <InputLabel for="detail" value="Detail" />
                            <TextInput
                                id="detail"
                                type="text"
                                class="mt-1 w-3/4"
                                v-model="detail.detail"                             
                            />
                            <DangerButton @click="removeDetail(index)" v-if="form.details.length > 1 " >
                                Remove
                            </DangerButton>
                            <InputError class="mt-2" :message="getError(`details.${index}.detail`)" />
                        </div>
                    </div>
                    <div class="flex items-center gap-4 mt-4">
                        <PrimaryButton :disabled="form.processing">{{props.plan == null ? 'Create' : 'Update'}}</PrimaryButton>
                    </div>
                </form>
            </Card>
        </div>
    </AuthenticatedLayout>

</template>
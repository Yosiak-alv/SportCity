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
    plan:{
        type:Object,
        required:false
    },
});

const form = useForm({
    id: props.plan?.id ?? '',
    name:props.plan?.name ?? '',
    price: props.plan?.price ?? '',
});

const store = () => {
    form.post(route('plans.store'));
};

const update = (id) => {
    form.patch(route('plans.update',{id:id}));
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
                <form @submit.prevent="(props.plan == null ? store(): update(form.id))" class="grid grid-cols-1 p-6">
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
                    </div>
                    <div class="flex items-center gap-4 mt-4">
                        <PrimaryButton :disabled="form.processing">{{props.plan == null ? 'Create' : 'Update'}}</PrimaryButton>
                    </div>
                </form>
            </Card>
        </div>
    </AuthenticatedLayout>

</template>
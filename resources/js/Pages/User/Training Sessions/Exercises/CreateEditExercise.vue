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
    exercise:{
        type:Object,
        required:false
    },
});

const form = useForm({
    id: props.exercise?.id ?? '',
    name:props.exercise?.name ?? '',
    demonstration_url: props.exercise?.demonstration_url ?? '',
    instructions: props.exercise?.instructions ?? '',
});

const store = () => {
    form.post(route('exercises.store'));
};

const update = (id) => {
    form.patch(route('exercises.update',{id:id}));
};
</script>

<template>
    <Head title="Exercise" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ props.exercise == null ? 'Create a New Exercise': 'Edit Exercise'}}</h2>
        </template>

        <div class="py-12">
            <Card class="max-w-7xl mt-6 space-y-6">
                <form @submit.prevent="(props.exercise == null ? store(): update(form.id))" class="grid grid-cols-1 p-6">
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
                            <InputLabel for="demostration_url" value="Demostration Url" />

                            <TextInput
                                id="demostration_url"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.demonstration_url"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.demonstration_url" />
                        </div>
                        
                        <div class="mt-1">
                            <InputLabel for="instructions" value="Instructions" />

                            <TextArea
                                id="instructions"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.instructions"
                                rows="3"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.instructions" />
                        </div>
                    </div>
                    <div class="flex items-center gap-4 mt-4">
                        <PrimaryButton :disabled="form.processing">{{props.exercise == null ? 'Create' : 'Update'}}</PrimaryButton>
                    </div>
                </form>
            </Card>
        </div>
    </AuthenticatedLayout>

</template>
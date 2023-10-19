<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link, router,useForm} from '@inertiajs/vue3';
import { computed } from 'vue';
import Card from '@/Components/Card.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import DateInput from '@/Components/DateInput.vue';
import Multiselect from '@suadelabs/vue3-multiselect'

const props = defineProps({
    training_session:{
        type:Object,
        required:false
    },
    selected_coaches:{
        type:Object,
        required:false
    },
    selected_clients:{
        type:Object,
        required:false
    },
    selected_clients_attendance:{
        type:Object,
        required:false
    },
    selected_exercises:{
        type:Object,
        required:false
    },
    selected_exercises_reps:{
        type:Object,
        required:false
    },
    coaches:{
        type:Object,
        required:true
    },
    clients:{
        type:Object,
        required:true
    },
    exercises:{
        type:Object,
        required:true
    },
});

const form = useForm({
    id: props.training_session?.id ?? '',
    name:props.training_session?.name ?? '',
    description: props.training_session?.description ?? '',
    duration: props.training_session?.duration ?? '',
    starts_at: props.training_session?.starts_at ?? '',
    finish_at: props.training_session?.finish_at ?? '',

    //coaches
    coach_id : props.selected_coaches ?? [],
    //clients
    client_id : props.selected_clients ?? [],
    attendance_date : props.selected_clients_attendance ?? [],
    //exercises
    exercise_id : props.selected_exercises ?? [],
    repetitions : props.selected_exercises_reps ?? [],

});
// Create a computed property to clean the array
const cleaned_attendance_date = computed(() => form.attendance_date.filter(item => item !== null));
form.defaults({
        name: 'attendance_date',
        email: cleaned_attendance_date,
    })
const store = () => {
    
    form.post(route('training-sessions.store'),{});
};

const update = (id) => {
    form.patch(route('training-sessions.update',{id:id}));
};
</script>
<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>
<template>
    <Head title="Training Sessions" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ props.training_session == null ? 'Create New Training Session': 'Edit Training Session'}}</h2>
        </template>

        <div class="py-12">
            <Card class="max-w-7xl mt-6 space-y-6">
                <form @submit.prevent="(props.training_session == null ? store(): update(form.id))" >
                    <div class="grid grid-cols-2 gap-4 p-6">
                        <div>
                            <div class="mt-1">
                                <InputLabel for="name" value="Name" />

                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"

                                />

                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>
                            <div class="mt-1">
                                <InputLabel for="description" value="Description:" />

                                <TextArea
                                    id="description"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.description"
                                    rows="7"
                                />

                                <InputError class="mt-2" :message="form.errors.description" />
                            </div>                  
                        </div>
                        <div>
                            <div class="mt-1">
                                <InputLabel for="duration" value="Duration:" />

                                <TextInput
                                    id="duration"
                                    type="number"
                                    class="mt-1 block w-full"
                                    v-model="form.duration"
                                    step="0.01"

                                />

                                <InputError class="mt-2" :message="form.errors.duration" />
                            </div>  
                            <div class="mt-1">
                                <InputLabel for="starts_at" value="Starts At: (Ex: YYYY-MM-DD hh:mm:ss)" />
                                <TextInput
                                    id="starts_at" 
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.starts_at"

                                />
                            
                                <InputError class="mt-2" :message="form.errors.starts_at" />
                            </div>  
                            <div class="mt-1">
                                <InputLabel for="finish_at" value="Finish At: (Ex: YYYY-MM-DD hh:mm:ss)" />
                                <TextInput
                                    id="finish_at"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.finish_at"

                                />
                                
                                <InputError class="mt-2" :message="form.errors.finish_at" />
                            </div>    
                            <div class="mt-1">
                                <InputLabel for="coach_id" value="Coaches:" />
                               <!--  <multiselect
                                    v-model="form.coach_id" 
                                    :options="props.coaches"
                                    :multiple="true"
                                    :close-on-select="true"
                                    placeholder="Pick some"
                                    :preserve-search="true" 
                                    label="name" 
                                    track-by="id"

                                > </multiselect>-->
                                <select multiple
                                    id="gym_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                    v-model="form.coach_id" 
                                    required
                                >
                                    <option v-for="coach in props.coaches" :value="coach.id" :key="coach.id">
                                        {{coach.name}} 
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.coach_id" />
                            </div>    
                        </div>
                    </div>
                   
                    <div class="grid grid-cols-2 gap-4 p-6">
                        <div>
                            <h2 class="text-3xl font-bold ml-8 mb-4 border-b border-gray-400">
                                Clients
                            </h2>
                            <div class="overflow-y-auto " style="height: 40rem;">
                                <div v-for="client in props.clients" :key="client.id">
                                    <div class="flex flex-col mb-4 ">
                                        <div class="flex items-center space-x-3 ml-8">
                                            <input :value="client.id" v-model="form.client_id" id="client_id" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <InputLabel for="client_id" :value="client.name"/>
                                            <InputError class="mt-2" :message="form.errors.client_id" />
                                            
                                        </div>
                                        <div class="flex items-center space-x-3 ml-8">
                                            <InputLabel for="attendance_date" value="Attendance Date: "/> 
                                            <input 
                                                id="attendance_date"
                                                v-model="form.attendance_date[client.id]"
                                                type="datetime-local"
                                                class="mt-1 block w-auto bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                            >

                                            <InputError class="mt-2" :message="form.errors.attendance_date" />
                                        </div>
                                    </div>
                        
                                </div>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold ml-8 mb-4 border-b border-gray-400">
                                Exercises
                            </h2>
                            <div class="overflow-y-auto " style="height: 40rem;">
                                <div v-for="exercise in props.exercises" :key="exercise.id">
                                    <div class="flex flex-col mb-4 ">
                                        <div class="flex items-center space-x-3 ml-8">
                                            <input :value="exercise.id" v-model="form.exercise_id" id="client_id" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <InputLabel for="client_id" :value="exercise.name"/>
                                            <InputError class="mt-2" :message="form.errors.exercise_id" />
                                            
                                        </div>
                                        <div class="flex items-center space-x-3 ml-8">
                                            <InputLabel for="repetitions" value="Repetitions: "/> 
                                            <TextInput
                                                id="repetitions"
                                                type="number"
                                                class="mt-1 block"
                                                :min="1"
                                                v-model="form.repetitions[exercise.id]"
                                                step="0.01"

                                            />
                                            <InputError class="mt-2" :message="form.errors.repetitions" />
                                        </div>
                                    </div>
                        
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 ml-8 mb-4">
                        <PrimaryButton :disabled="form.processing">{{props.training_session == null ? 'Create' : 'Update'}}</PrimaryButton>
                    </div>
                </form>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>
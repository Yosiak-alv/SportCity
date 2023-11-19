<script setup>
import AuthenticatedClientLayout from '@/Layouts/AuthenticatedClientLayout.vue';

import { Head,Link, router, usePage, useForm} from '@inertiajs/vue3';
import {ref, watch ,nextTick} from "vue";

import Card from '@/Components/Card.vue';

import ClientSystemIndex from './Partials/Client_System/ClientSystemIndex.vue';
import ClientSuscriptionIndex from './Partials/Client_Suscription/ClientSuscriptionIndex.vue';
import ClientTrainingSessionsIndex from './Partials/Client_TrainingSessions/ClientTrainingSessionsIndex.vue';
import ClientPurchasesIndex from './Partials/Client_Purchase/ClientPurchasesIndex.vue';

const props = defineProps({
    client:{
        type:Object,
        required:true

    },
    client_attendance_training_sessions:{
        type:Object,
        required:true
    },
    filters:{
        type:Object,
        required:true
    }
});

</script>

<template>
    <Head title="Dashboard Show" />

    <AuthenticatedClientLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">You're logged in!</h2>
        </template>

        <div class="py-12">
            <Card class="max-w-7xl">
                <div class="grid grid-cols-3 gap-4 p-6 items-center">
                    <div class="col-span-1">
                        <div class="ml-8">
                            <img src="/storage/img/human.png" class="rounded w-40 ">
                        </div>
                    </div>
                    <div class="col-span-2">
                        <span class="inline text-5xl h-fit">{{ client.name }}, {{client.lastname}}</span>
                        <div class="mt-2 text-lg">
                            <span class="font-semibold">Genre:</span> {{ client.genre }}
                            <br>
                            <span class="font-semibold">Phone:</span> {{ client.phone }}
                            <br>
                            <span class="font-semibold">Address:</span> {{ client.address }}
                            <br>
                            <span class="font-semibold">Email:</span> {{ client.email }}
                            <br>
                            <span class="font-semibold">Birth Date:</span> {{ client.birth_date }}
                            <br>
                            <span class="font-semibold">Height:</span> {{ client.height }}
                            <br>
                            <span class="font-semibold">Weight:</span> {{ client.weight }}
                            <br>
                            <span class="font-semibold">Gym:</span> <span :class="{'text-red-600 dark:text-red-400' : client.gym == null}">{{ client.gym?.name ?? 'Current Gym Deleted' }}</span>
                            <br>
                            <span class="font-semibold">Gym Address:</span> {{client.gym?.department.name ?? ''}}, {{ client.gym?.address ?? '' }}
                            <br>
                            <span v-if="props.client.deleted_at" class="font-semibold">Deleted at:</span> {{props.client.deleted_at}}
                        </div>
                    </div>
                </div>
            </Card>
        </div>

        <div class="py-9">
            <ClientTrainingSessionsIndex  :trainingSessions="props.client_attendance_training_sessions" :filters="props.filters"/>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div class="row-span-2">
                <ClientSystemIndex :system_client="props.client.system_client"/>
            </div>
           
            <div class="col-span-2">
                <ClientSuscriptionIndex :suscriptions="props.client.suscriptions" />                
            </div>

            <div class="col-span-2">
                <ClientPurchasesIndex :purchases="props.client.purchases"/>
            </div>
        </div>

        <!-- <div class="grid grid-flow-row-dense grid-cols-3 grid-rows-3 auto-cols-max">
            <div class="row-span-3">
                <ClientSystemIndex :clientId="props.client.id" :system_client="props.client.system_client" :deleted="props.client.deleted_at == null ? false:true"/>
                
            </div>
            <div class="col-span-2">
                <ClientSuscriptionIndex :clientId="props.client.id" :suscriptions="props.client.suscriptions" :deleted="props.client.deleted_at == null ? false:true"/>
            </div>
            <div class="col-span-2">
                <ClientPurchasesIndex :clientId="props.client.id" :purchases="props.client.purchases" :deleted="props.client.deleted_at == null ? false:true"/>
            </div>
        </div> -->
    </AuthenticatedClientLayout>
</template>

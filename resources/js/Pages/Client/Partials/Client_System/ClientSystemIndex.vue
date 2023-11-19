<script setup>
import Card from '@/Components/Card.vue';
import { Link, router, usePage} from '@inertiajs/vue3';
import {ref, computed} from "vue";
const props = defineProps({
    system_client:{
        type:Object,
        required:true
    }
});

</script>

<template>
     <Card class="mb-8" v-if="props.system_client.length != 0">
        <div class="border-b border-gray-400 flex justify-between margin-b mb-4">
            <div >
                <h2 class="text-4xl font-bold ml-2 mt-3">
                    System Client
                </h2>
            </div>
        </div>
        <div class="overflow-y-scroll">
            <div class="text-base p-4" v-for="system in props.system_client">
                <div class="w-full text-justify ">
                    <h3 class="inline text-3xl">
                        {{system.name}}
                    </h3>
                    <div class="my-1.5">
                        <span class="font-semibold">Condition: </span> {{system.pivot.condition}}
                    </div>
                </div>
            </div>    
        </div>
    </Card>
    <Card v-else class="mb-8">
        <div class=" border-gray-400 flex flex-col margin-b mb-4">
            <div>
                <h2 class="text-4xl font-bold ml-8 mt-3">
                    No System was found, but you can created.
                </h2>
            </div>
        </div>
    </Card>
</template>
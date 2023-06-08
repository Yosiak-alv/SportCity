<script setup>
import { Link } from "@inertiajs/vue3";
import {computed, ref} from "vue";
const props = defineProps({
    links:{
        type:Array,
        required:true
    }
});

</script>

<template>
    <div v-if="links.length > 1" class="grid justify-items-center">
        <div class="flex flex-wrap mt-8 ">
            <template v-for="(link, index) in links">
                <div
                    v-if="link.url === null"
                    class=" mb-1 mr-1 px-4 py-3 leading-tight border border-gray-700 text-white dark:bg-gray-800 rounded"
                    v-html="link.label"
                />
                <Link
                    v-else 
                    :href="link.url ?? ''"
                    class="mb-1 mr-1 px-4 py-3 leading-tight border border-gray-700  text-white hover:bg-gray-500 rounded"
                    :class="{
                        'bg-gray-700': link.active
                    }"
                    v-html="link.label" preserve-scroll>
                </Link>
              
            </template>
        </div>
    </div>
</template>



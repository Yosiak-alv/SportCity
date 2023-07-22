<script setup>

defineProps({
    id:{
        type:String,
        required:false,
        default:''
    }
});
</script>
<template>

    <div class="bg-grayC-400 relative overflow-x-auto shadow-xl sm:rounded-xl shadow-grayC-500">
        <table :id="id" class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="">
                   <slot name="heading"/>
                </tr>
            </thead>
            <tbody>
                <slot/>
            </tbody>
        </table>
    </div>

</template>
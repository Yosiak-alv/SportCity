<script setup>
  defineProps({
    permission:{
      type:Boolean,
      default:false
    }
  });
    defineEmits(['restore']);
</script>  

<template>
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 h-full">
    <div class="flex items-center justify-between p-4 bg-yellow-400 rounded ">
      <div class="flex items-center">
        <svg fill="none"  stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
        </svg>
        <div class="text-yellow-800 text-sm font-medium">
          <slot />
        </div>
      </div>
      <button v-if="permission" class="text-yellow-800 hover:underline text-sm"  type="button" @click="$emit('restore')">Restore</button>
    </div>
  </div>
    
  </template>

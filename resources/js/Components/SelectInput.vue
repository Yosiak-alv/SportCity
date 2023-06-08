<script setup>
import { useSlots, ref, computed } from 'vue';

defineProps(['modelValue']);
defineEmits(['update:modelValue']);

const options = ref([]);

const getOptionsFromVNodes = (vnodes) => {
  [...vnodes[0].children].forEach(vnode => {
    options.value.push(vnode);
  });
};

getOptionsFromVNodes(useSlots().default());

const selected = computed(() => {

});
</script>

<template>
    <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
            :value="modelValue"
            @change="$emit('update:modelValue', $event.target.value)"
            multiple>
            <slot/>
    </select>
</template>

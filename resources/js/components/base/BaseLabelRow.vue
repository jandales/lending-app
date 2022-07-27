<template>
      <div class="flex justify-between">
            <label for="" class="block text-sm font-[500] text-gray-700 mb-2">{{props.name}}</label>
            <span class="text-sm font-bold capitalize">{{ props.value }}</span>
        </div>
</template>

<script setup>
const props = defineProps({
    name : {
        type: String,
        default : 'label name'
    },
    value : {
        type: [String, Number],
        default : null
    }
})
</script>
<template>
      <div class="flex gap-8">
            <div class="min-w-[120px]">
                <label for="" class="block text-sm font-[500] text-gray-700 mb-2">{{props.name}}</label>
            </div>            
            <span  class="text-sm font-bold capitalize " :class="{ 
                'bg-green-500 rounded-md p-1 px-2 text-white' : props.backgroundColor == 'success',
                'bg-blue-500 rounded-md p-2 px-2 text-white' : props.backgroundColor == 'info',
                'bg-rose-500 rounded-md p-2 px-2 text-white' : props.backgroundColor == 'danger',                    
                 }" >
                {{ props.value }}
            </span>
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
    },
    backgroundColor : {
        type: String,
        default: 'default'
    },  
})
</script>
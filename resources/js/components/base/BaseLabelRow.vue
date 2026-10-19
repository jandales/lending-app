<template>
      <div class="flex gap-8">
            <div class="min-w-[120px] flex items-center">
                <label for="" class="block text-sm font-[500] text-slate-700 mb-2">{{props.name}}</label>
            </div>            
            <span  class="text-sm font-bold capitalize " :class="{ 
                'text-emerald-600 rounded-md' : props.backgroundColor == 'success',
                'text-brand-600  rounded-md' : props.backgroundColor == 'info',
                'text-rose-600  rounded-md' : props.backgroundColor == 'danger',                    
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
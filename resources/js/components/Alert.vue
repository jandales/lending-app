<template>
    <div v-if="props.alert != null" class="rounded-lg py-3.5 px-4 mb-4 text-sm font-medium border" :class="{
        'bg-emerald-50 text-emerald-700 border-emerald-100':props.alert == 'success',
        'bg-red-50 text-red-700 border-red-100' : props.alert == 'danger',
        'bg-amber-50 text-amber-700 border-amber-100' : props.alert == 'warning',
         }"
         role="alert">
                {{ props.message }}
    </div>
</template>
<script setup>
    const props = defineProps({
        alert : {
            type: String,
      
        },
        message : {
            type : String,            
        }
    });

   

</script>

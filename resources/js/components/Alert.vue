<template>
    <div v-if="props.alert != null" class="  rounded-lg py-5 px-6 mb-4 text-base" :class="{
        'bg-green-100 text-green-700':props.alert == 'success',
        'bg-red-100 text-red-700' : props.alert == 'danger',
        'bg-yellow-100 text-yellow-700' : props.alert == 'warning',
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
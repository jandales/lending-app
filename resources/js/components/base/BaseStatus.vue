<script setup>
    const props = defineProps({
        status : String,
        default : null,
    });

   

    const getStyle = () => {

        switch(props.status) {
            case  'paid' :
                return  'bg-green-500';
            case  'void' :
                return  'bg-rose-500';
            case 'rejected' : 
                return  'bg-rose-500';
            case 'failed' : 
                return  'bg-rose-500';
            case 'pending' : 
                return  'bg-yellow-100 !text-gray-500';
            default : 
                return  'bg-blue-500'
        }

    }
</script>
<template>
    <span  class=" text-xs px-2 py-1 rounded-md text-white capitalize" :class="getStyle()">
        {{ status }}
    </span>
     
</template>
<script setup>
    const props = defineProps({
        status : String,
        default : null,
    });

   

    const getStyle = () => {

        switch(props.status) {
            case  'paid' :
                return  'bg-emerald-50 text-emerald-700 border-emerald-100';
            case  'void' :
                return  'bg-rose-50 text-rose-700 border-rose-100';
            case 'rejected' : 
                return  'bg-rose-50 text-rose-700 border-rose-100';
            case 'failed' : 
                return  'bg-rose-50 text-rose-700 border-rose-100';
            case 'pending' : 
                return  'bg-amber-50 text-amber-700 border-amber-100';
            default : 
                return  'bg-brand-50 text-brand-700 border-brand-100'
        }

    }
</script>
<template>
    <span  class="text-xs px-3 py-1 rounded-full font-semibold capitalize border" :class="getStyle()">
        {{ status }}
    </span>
     
</template>

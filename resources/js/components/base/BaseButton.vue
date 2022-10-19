<template>
     <button                
        type="button"
        data-mdb-ripple="true"
        data-mdb-ripple-color="light"
        class="btn-primary"
        v-bind="$attrs"
        >
        <div v-if="isLoading" class="spinner-border animate-spin inline-block w-4 h-4 border-4 rounded-full" role="status">
                <span class="visually-hidden">Loading...</span>
        </div>                    
        <label v-else for="">{{name}}</label> 
        <slot name="icon">

        </slot>
    </button>
</template>

<script setup>
    const props = defineProps({
        isLoading : {
            type : Boolean,
            default : false,
        },
        name : {
            type : String,
            default : null, 
        }
    });
</script>
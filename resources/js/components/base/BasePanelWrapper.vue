<script setup>
    const props = defineProps({
        title : String,
    });
</script>
<template>
    <div class="border  w-full bg-white rounded-md">
        <div class="flex  p-4 justify-between items-center">
            <h1 class="capitalize">{{ title }}</h1> 
            <slot name="action">
            </slot>            
        </div>
        <slot name="filter"></slot>
        <slot name="body">
        </slot>
    </div>
</template>
<template>
    <div class="flex justify-between items-center ">
        <h1 class="text-xl">{{ title }}</h1>
    </div>  
</template>
<script setup>
 const props =  defineProps({
        title : String
    })
</script>
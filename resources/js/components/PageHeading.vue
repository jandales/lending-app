<template>
    <div class="flex justify-between items-center mb-1">
        <h1 class="text-xl font-semibold text-slate-800 tracking-tight">{{ title }}</h1>
    </div>  
</template>
<script setup>
 const props =  defineProps({
        title : String
    })
</script>

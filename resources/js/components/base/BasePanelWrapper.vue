<script setup>
    const props = defineProps({
        title : String,
    });
</script>
<template>
    <div class="w-full bg-white rounded-3xl shadow-card border border-white overflow-hidden">
        <div class="flex px-6 py-5 justify-between items-center">
            <h1 class="capitalize text-lg font-bold text-slate-800 tracking-tight">{{ title }}</h1>
            <slot name="action">
            </slot>
        </div>
        <slot name="filter"></slot>
        <div class="border-t border-slate-100">
            <slot name="body">
            </slot>
        </div>
    </div>
</template>

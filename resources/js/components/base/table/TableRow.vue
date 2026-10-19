<script setup>

const props = defineProps({body : {
    type : Boolean,
    default : false
}});

const styles = props.body === false 
    ? null 
    : 'bg-white border-b border-slate-50 transition duration-150 ease-in-out hover:bg-slate-50/70 last:border-b-0';

</script>
<template>
    <tr v-bind="$attrs" :class="styles">
        <slot></slot>
    </tr>
</template>
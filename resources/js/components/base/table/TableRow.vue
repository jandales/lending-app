<script setup>

const props = defineProps({body : {
    type : Boolean,
    default : false
}});

const styles = props.body === false 
    ? null 
    : 'bg-white border-b transition duration-300 ease-in-out  hover:bg-gray-100';

</script>
<template>
    <tr v-bind="$attrs" :class="styles">
        <slot></slot>
    </tr>
</template>
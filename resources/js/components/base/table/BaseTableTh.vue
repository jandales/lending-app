<script setup>
    defineEmits(['selectAll'])

    const selectAll = () => {
        
     }

</script>
<template>
    <th  v-bind="$attrs">
       <slot></slot>
    </th>
</template>
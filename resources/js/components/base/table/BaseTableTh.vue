<script setup>
    defineEmits(['selectAll'])

    const selectAll = () => {
        
     }

</script>
<template>
    <th  class="bg-slate-100" v-bind="$attrs">
       <slot></slot>
    </th>
</template>
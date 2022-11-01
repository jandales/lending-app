<script setup>
    const props = defineProps({
        activity: Object,
    })

    const emit = defineEmits(['show'])

    const show = () => {
        emit('show', props.activity)
    }
</script>
<template>
     <div class="flex items-center ml-auto"> 
        <svg @click="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500 hover:text-gray-700">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
        </svg>
    </div>
</template>
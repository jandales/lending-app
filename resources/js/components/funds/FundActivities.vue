<script setup>
import ActivityRow from './activity/ActivityRow.vue';
    const props = defineProps({activities : Array})
    const emit = defineEmits(['showActivity']);

    const show = (activity) => {
        emit('showActivity', activity);
    }
</script>

<template>
    <div v-if="activities && activities.length > 0" class="w-full">
        <h1 class="block mb-4">Recent Activity</h1>
        <ul class="rounded-lg">
            <ActivityRow v-for="activity in activities" :activity="activity" @show="show" />
        </ul>
    </div>
    
</template>
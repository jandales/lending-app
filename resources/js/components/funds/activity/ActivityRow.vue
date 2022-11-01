<script setup>
import Avatar from './ActivityAvatar.vue'
import ActivityDetail from './ActivityDetail.vue';
import ActivityAction from './ActivityAction.vue';
    const props = defineProps({
        activity: Object,
    })

    const emit = defineEmits(['show'])

    const show = () => {
        emit('show',props.activity)
    }

</script>
<template>
    <li  class="bg-white border border-b-0 
            first:rounded-t-lg   
            last:rounded-b-lg
            last:border-b
            w-full p-4">
            <div class="w-full">
                <div class="flex">
                   <Avatar :user="activity.user" />      
                   <ActivityDetail :activity="activity" />
                   <ActivityAction :activity="activity" @show="show" />
                </div>
            </div>
    </li>
</template>
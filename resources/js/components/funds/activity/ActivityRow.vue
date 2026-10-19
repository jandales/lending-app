<script setup>
import Avatar from './ActivityAvatar.vue'
import ActivityDetail from './ActivityDetail.vue';
import ActivityAction from './ActivityAction.vue';
import useFormatter from '../../../composable/helper/formater'

const { moneyFormatter } = useFormatter();

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
                <div class="flex items-center gap-4">
                   <Avatar :user="activity.user" />      
                   <ActivityDetail :activity="activity" />
                   <div class="ml-auto flex items-center gap-4 shrink-0">
                       <span
                         class="text-sm font-semibold tabular-nums"
                         :class="activity.action === 'deposit' ? 'text-emerald-600' : 'text-rose-600'"
                       >
                         {{ activity.action === 'deposit' ? '+' : '-' }}{{ moneyFormatter(Math.abs(activity.amount)) }}
                       </span>
                       <ActivityAction :activity="activity" @show="show" />
                   </div>
                </div>
            </div>
    </li>
</template>

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

    const isDeposit = () => props.activity.action === 'deposit'

    const runningBalance = () => {
        if (props.activity.running_balance != null) {
            return Number(props.activity.running_balance)
        }
        const last = Number(props.activity.last_capital_amount || 0)
        const amount = Math.abs(Number(props.activity.amount || 0))
        return isDeposit() ? last + amount : last - amount
    }

</script>
<template>
    <li  class="bg-white border-b border-slate-100 last:border-b-0 w-full p-4">
            <div class="w-full">
                <div class="flex items-center gap-4">
                   <Avatar :user="activity.user" />      
                   <ActivityDetail :activity="activity" />
                   <div class="ml-auto flex items-center gap-6 shrink-0">
                       <div class="text-right">
                           <span
                             class="block text-sm font-semibold tabular-nums"
                             :class="isDeposit() ? 'text-emerald-600' : 'text-rose-600'"
                           >
                             {{ isDeposit() ? '+' : '-' }}{{ moneyFormatter(Math.abs(activity.amount)) }}
                           </span>
                           <span class="block text-xs text-slate-400 mt-0.5 tabular-nums">
                             Bal {{ moneyFormatter(runningBalance()) }}
                           </span>
                       </div>
                       <ActivityAction :activity="activity" @show="show" />
                   </div>
                </div>
            </div>
    </li>
</template>

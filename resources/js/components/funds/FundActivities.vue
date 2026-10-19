<script setup>
import { computed, ref } from 'vue';
import ActivityRow from './activity/ActivityRow.vue';
import useFormatter from '../../composable/helper/formater';
import useExport from '../../composable/exports/loans';

const { moneyFormatter } = useFormatter();
const { exportFundActivities } = useExport();

    const props = defineProps({
        activities : Array,
        currentCapital: {
            type: [Number, String],
            default: null,
        },
    })
    const emit = defineEmits(['showActivity']);
    const isExporting = ref(false);

    const show = (activity) => {
        emit('showActivity', activity);
    }

    const runningTotal = computed(() => {
        if (props.currentCapital != null && props.currentCapital !== '') {
            return Number(props.currentCapital);
        }
        if (!props.activities?.length) return 0;
        const newest = props.activities[0];
        return Number(newest.running_balance ?? 0);
    })

    const exportHandle = async () => {
        if (isExporting.value) return;
        isExporting.value = true;
        try {
            await exportFundActivities();
        } finally {
            isExporting.value = false;
        }
    }
</script>

<template>
    <div v-if="activities && activities.length > 0" class="w-full">
        <div class="flex items-center justify-between mb-4 gap-3">
            <h1 class="text-lg font-bold text-slate-800 tracking-tight">Running Balance</h1>
            <div class="flex items-center gap-3">
                <span class="text-sm font-semibold text-slate-700 tabular-nums">
                    Total {{ moneyFormatter(runningTotal) }}
                </span>
                <button
                    type="button"
                    @click="exportHandle"
                    :disabled="isExporting"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium text-slate-600 border border-slate-200 bg-white hover:bg-slate-50 hover:text-brand-700 transition disabled:opacity-60"
                    title="Export to Excel"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    {{ isExporting ? 'Exporting…' : 'Export' }}
                </button>
            </div>
        </div>
        <ul class="rounded-lg overflow-hidden border border-slate-200/80 bg-white shadow-card">
            <ActivityRow v-for="activity in activities" :key="activity.id" :activity="activity" @show="show" />
        </ul>
    </div>
    
</template>

<script setup>

import { ref, defineAsyncComponent, onMounted } from 'vue';
import useFormatter from '../../composable/helper/formater';
import BaseButton from '../base/BaseButton.vue'
import FundActivities from './FundActivities.vue';

import useFund from '../../composable/fund';

const { moneyFormatter } = useFormatter()
const { getFund, fund, isLoading } = useFund();


const modalState = ref(false);
const isDeductState = ref(false);
const isShow = ref(false);
const activity = ref();
const FundModal = defineAsyncComponent(() => import('./FundActionModal.vue'));
const FundShowModal = defineAsyncComponent(() => import('./FundShowModal.vue'));

const handleModalState = () => { 
    modalState.value = modalState.value === true 
        ? false
        : true;   
}

const handleAddState = () => {
    isDeductState.value = false;
    handleModalState()
}

const handleDeductState = () => {  
    isDeductState.value = true;
    handleModalState()
}

const handleUpdateFundValue = (value) => {
    fund.value = value;
}

const handleShowActivity = (data = null) => {
   
    isShow.value = isShow.value === false 
        ? true 
        : false;

    if (isShow.value === false) return;  

    activity.value = data;   
}



onMounted(getFund);
</script>
<template>
    <div v-if="fund" class="flex flex-col gap-8">
            
            <div class="flex gap-8">
                <div class="w-1/2 bg-white p-6 rounded-3xl shadow-card border border-white">
                    <div class="flex justify-between">
                            <h1 class="text-sm font-medium text-slate-400">Initial capital</h1>                  
                    </div>
                    <div class="pt-3">
                            <h1 class="text-3xl font-bold tracking-tight text-slate-800">{{  moneyFormatter(fund.initial_capital) }}</h1>
                    </div>                    
                </div>
                <div class="w-1/2 relative overflow-hidden brand-gradient p-6 rounded-3xl shadow-float text-white">
                    <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-white/10"></div>
                    <div class="relative flex justify-between">
                            <h1 class="text-sm font-medium text-white/80">Current capital</h1>                  
                    </div>
                    <div class="relative pt-3 mb-5">
                            <h1 class="text-3xl font-bold tracking-tight">{{  moneyFormatter(fund.current_capital) }}</h1>
                    </div>
                    <div class="relative flex gap-3">
                            <BaseButton 
                                @click="handleAddState" 
                                name="Add Fund"
                                class="!bg-none !bg-white !text-brand-700 !shadow-soft hover:!bg-white/90"
                            />
                            <BaseButton 
                                @click="handleDeductState" 
                                name="Deduct Fund"
                                class="!bg-none !bg-white/15 !text-white !border !border-white/40 !shadow-none hover:!bg-white/25"
                            />
                    </div>
                </div>
            </div>

            <div class="w-full">               
                <FundActivities :activities="fund.activities" @showActivity="handleShowActivity"/>
            </div>
    </div>

<Teleport to="body">
    <FundModal 
    v-if="modalState"
    :isDeductState="isDeductState"
    @updateFund="handleUpdateFundValue"
    @close="handleModalState" />

    <FundShowModal
        v-if="isShow"
        :data="activity"      
        @close="handleShowActivity"
    />
    
</Teleport>



</template>
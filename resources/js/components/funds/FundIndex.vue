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
const activity = ref({});
const FundModal = defineAsyncComponent(() => import('./FundActionModal.vue'));
const FundShowModal = defineAsyncComponent(() => import('./FundShowModal.vue'));

const handleModalState = () => { 
    modalState.value = modalState.value === true ? false : true;
    isShow.value = false;
  
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

const showActivity = (activity) => {
    activity.value = activity;
    isShow.value = true;
}

onMounted(getFund);
</script>
<template>
    <div v-if="fund" class="flex flex-col gap-8">
            <div class="w-full  border  bg-white p-4 rounded-md">
               <div class="flex justify-between">
                    <h1>Capital</h1>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                    </svg>
               </div>
               <div class="p-4">
                    <h1 class="text-[3rem]">{{  moneyFormatter(fund.current_capital) }}</h1>
               </div>
               <div class="flex gap-4">
                    <BaseButton 
                        @click="handleAddState" 
                        name="Add Fund"
                    />
                    <BaseButton 
                        @click="handleDeductState" 
                        name="Deduct Fund"
                        class="btn-danger"
                    />
               </div>
            </div>

            <div class="w-full">               
                <FundActivities :activities="fund.activities" @showActivity="showActivity"/>
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
        @close="handleModalState"
    />
</Teleport>



</template>
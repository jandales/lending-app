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
                <div class="w-1/2  border  bg-white p-4 rounded-md">
                    <div class="flex justify-between">
                            <h1>Initial Capital</h1>                  
                    </div>
                    <div class="p-4">
                            <h1 class="text-[3rem]">{{  moneyFormatter(fund.initial_capital) }}</h1>
                    </div>                    
                </div>
                <div class="w-1/2  border  bg-white p-4 rounded-md">
                    <div class="flex justify-between">
                            <h1>Current Capital</h1>                  
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
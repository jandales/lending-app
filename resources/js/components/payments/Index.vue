<template>
<BasePanelWrapper :title="'List of Payments'">
  <template #action>
    <BaseButton 
      v-if="selectAllState" 
      @click="deleteSeleted" 
      name="Delete"   
    />
  </template>
  <template #body>
      <BaseTableWrapper>
          <BaseTable>
              <BaseTableHead>
                  <BaseTableRow>                   
                      <BaseTableTh>Loan Number</BaseTableTh>
                      <BaseTableTh>Customer</BaseTableTh>
                      <BaseTableTh>Amount</BaseTableTh>
                      <BaseTableTh>Date of payment</BaseTableTh>                      
                      <BaseTableTh>Status</BaseTableTh>
                  </BaseTableRow>
              </BaseTableHead>
              <BaseTableBody v-if="filteredPayments.length > 0">
                <BaseTableRow  :body="true" v-for="(payment, index) in filteredPayments" :key="index">
                  <BaseTd>
                      <RouterLink :to="{ name : 'loans.details' , params : { id : payment.loan.id } }" class="text-sky-500">
                        {{ payment.loan.number }}
                      </RouterLink>       
                  </BaseTd>
                  <BaseTd>
                      <router-link :to="{name: 'borrowers.details', params : { id :  payment.borrower.id }}" class="text-sky-500">
                        <BaseAvatar
                          :image="payment.borrower.avatar"
                          :name="payment.borrower.name"
                        />              
                      </router-link>   
                  </BaseTd>
                  <BaseTd>
                      {{ payment.amount }}
                  </BaseTd>
                  <BaseTd>
                      {{ payment.created_at }}
                  </BaseTd>
                  <BaseTd>
                    <span  
                      class="bg-green-500 text-xs px-2 py-1 rounded-md text-white capitalize"
                      :class="{'!bg-rose-500' : payment.status == 'void' }"
                      >
                     {{ payment.status }}
                  </span>
                  </BaseTd>
                </BaseTableRow>
              </BaseTableBody>
          </BaseTable>
          <BaseTableSpinner v-if="isLoading" />
      </BaseTableWrapper>
  </template>
</BasePanelWrapper>

 
</template>
<script setup>

import BasePanelWrapper from '../base/BasePanelWrapper.vue'
import BaseAvatar from '../base/BaseAvatar.vue'
import BaseTableWrapper from '../base/table/BaseTableWrapper.vue'
import BaseTable from '../base/table/BaseTable.vue'
import BaseTableHead from '../base/table/BaseTableHead.vue'
import BaseTableRow from '../base/table/TableRow.vue'
import BaseTableTh from '../base/table/BaseTableTh.vue'
import BaseTableBody from '../base/table/BaseTableBody.vue'
import BaseTd from '../base/table/BaseTd.vue'
import BaseButton from '../base/BaseButton.vue'
import BaseTableSpinner from '../base/table/BaseTableSpinner.vue'


import usePayments from '../../composable/payments';
import useFormatter from '../../composable/helper/formater'
import { onMounted, ref, computed } from 'vue';

const listId = ref([]);
const selectAllState = ref(false);

const { getPayments, removePayment, payments, isLoading } = usePayments();
const { moneyFormatter } = useFormatter();

const voidPayment = async(id)=> {

      await removePayment(id);

      await getPayments();

}

const deleteSeleted  = () => {

    listId.value.forEach(id => { 

        removePayment(id);

    })  

}

const selectAll = () => {   

    selectAllState.value = selectAllState.value == true ? false : true;

    listId.value = []

    if(selectAllState.value == true){ 

        payments.value.forEach(payment => {

            listId.value.push(payment.id)

        })        

        return;
        
    }

    listId.value = []
    
}

onMounted(getPayments)

const filteredPayments = computed(() => {
    return payments.value.map(payment => {
        payment.amount = moneyFormatter(payment.amount)
        return payment;
    });
});


</script>
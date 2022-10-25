<template>
    <div class="w-full flex mb-6 justify-between">
        <div class="flex items-center justify-center">
              <div class="xl:w-52">
                <BaseSearch v-model="keyword"/>                     
              </div>
        </div>   
        <div class="flex gap-2">
        <BaseDropDown  :options="paymentStatus" :title="'status'" :value="filterName"  @click-action="handleFilter" />
        <BaseDropDown :options="paymentSorting" :title="'Sort'" :value="sortName"  @click-action="handleSort" />
  </div>
</div>
<BasePanelWrapper :title="title">
  <template #action>
        <router-link 
            :to="{ name : 'payments.create' }"
            class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
            Create Payment
        </router-link>  
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
                      <BaseStatus v-if="payment" :status="payment.status"/>
                  </BaseTd>
                </BaseTableRow>
              </BaseTableBody>

                <!-- show if no record  found -->
              <BaseTableRow v-if="!isLoading && filteredPayments.length === 0">
                  <BaseTd   colspan="8" class="text-center font-semibold">No Record Found</BaseTd>
              </BaseTableRow>   

          </BaseTable>
          <Pagination v-if="pagination.last_page > 1" :pagination="pagination" @page-change="pageChange" />
          <BaseTableSpinner v-if="isLoading" />
      </BaseTableWrapper>
  </template>
</BasePanelWrapper>

 <Teleport to="body">
  <PaymentCreateModal />
 </Teleport>
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
import BaseTableSpinner from '../base/table/BaseTableSpinner.vue'
import Pagination from '../Pagination.vue';
import BaseSearch from '../base/BaseSearch.vue'
import BaseDropDown from '../base/BaseDropDown1.vue';

import useStatus from '../../composable/status';
import useSorting from '../../composable/sorting';
import usePayments from '../../composable/payments';
import useFormatter from '../../composable/helper/formater'


import { onMounted, ref, computed, watch, defineAsyncComponent } from 'vue';

const BaseStatus = defineAsyncComponent(() => import('../base/BaseStatus.vue'))


const title = ref('Payments')
const keyword = ref(null)
const filterName = ref(null)
const filter = ref(null)
const sortName = ref(null)
const sort = ref(null);


const { paymentStatus } = useStatus();
const  { paymentSorting } = useSorting();
const { getPayments, removePayment, payments, paymentSearch, pagination, isLoading } = usePayments();
const { moneyFormatter } = useFormatter();

const voidPayment = async(id)=> {
      await removePayment(id);
      await getPayments();
}


onMounted(getPayments)

const pageChange = (page) => {
  page = page.split("=")[1];
  getPayments(page);
} 

const handleFilter = async (status) => {
    filterName.value = status.name;
    filter.value = status.value;  
    await getPayments(1, filter.value);  
}

const handleSort = async (payload) => {
    sortName.value = payload.displayName;
    sort.value = payload;
    await getPayments(1, filter.value, sort.value);
}

const filteredPayments = computed(() => {
    return payments.value.map(payment => {
        payment.amount = moneyFormatter(payment.amount)
        return payment;
    });
});

watch(keyword, async (value) => {

  if (value.length > 2) {
    await paymentSearch(value)
    return;
  }

  await getPayments();
  
})

</script>
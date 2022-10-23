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
import Pagination from '../Pagination.vue';
import BaseSearch from '../base/BaseSearch.vue'
import BaseDropDown from '../base/BaseDropDown1.vue';

import useStatus from '../../composable/status';
import useSorting from '../../composable/sorting';
import usePayments from '../../composable/payments';
import useFormatter from '../../composable/helper/formater'
import { onMounted, ref, computed, watch } from 'vue';

const listId = ref([])
const selectAllState = ref(false)
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

const deleteSeleted  = () => {
    listId.value.forEach(id => { 
        removePayment(id);
    }); 
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
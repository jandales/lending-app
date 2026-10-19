<template>
    <div class="w-full mb-5 bg-white rounded-3xl shadow-card border border-white p-2">
        <ul class="flex flex-wrap gap-1 p-1 rounded-full bg-slate-100/80">
          <li
              v-for="tab in loanTypeTabs"
              :key="tab.value"
              @click="handleFilterLoanType(tab.value)"
              class="cursor-pointer text-sm font-medium px-5 py-2 rounded-full transition duration-200 select-none"
              :class="loanType === tab.value
                ? 'bg-white text-brand-700 shadow-soft'
                : 'text-slate-400 hover:text-slate-600'">
            {{ tab.label }}
          </li>
        </ul>
    </div>
    <div class="w-full flex mb-6 justify-between items-center gap-4">
        <div class="flex items-center flex-1 max-w-sm">
                <BaseSearch v-model="keyword"/>
        </div>
        <div class="flex gap-2 shrink-0">
        <BaseDropDown :options="loanStatus"  :title="'Status'" :value="filterName"  @click-action="handleFilter" />
        <BaseDropDown :options="loanSorting" :title="'Sort'"   :value="sortName"    @click-action="handleSorting" />
  </div>
</div>
<BasePanelWrapper :title="'Loans'">
      <template #action>
          <router-link 
            :to="{name : 'loans.create'}"
            class="btn-primary">
            Create Loan
          </router-link>  
      </template>
      <template #body>
          <BaseTableWrapper >
             <BaseTable>
                <BaseTableHead>
                    <BaseTableRow>                    
                      <BaseTableTh class="text-left">Loan Number</BaseTableTh>
                      <BaseTableTh>Borrower</BaseTableTh> 
                      <BaseTableTh>Type</BaseTableTh>    
                      <BaseTableTh>Total Amount</BaseTableTh>      
                      <BaseTableTh>Date</BaseTableTh>                 
                      <BaseTableTh>Status</BaseTableTh>
                      <BaseTableTh class="text-center">Action</BaseTableTh>
                    </BaseTableRow>                   
                </BaseTableHead>
                <BaseTableBody v-if="loans.length > 0"  >
                  <BaseTableRow :body="true" v-for="loan in loans">                     
                      <BaseTd>
                        <router-link :to="{name: 'loans.details', params : { id :  loan.id }}" class="text-brand-600">
                           {{loan.loan_number}}
                        </router-link> 
                      </BaseTd>
                      <BaseTd>
                        <router-link :to="{name: 'borrowers.details', params : { id :  loan.borrower.id }}" class="text-brand-600">
                            <BaseAvatar
                              :image="loan.borrower.avatar"
                              :name="loan.borrower.name"
                            /> 
                        </router-link> 
                      </BaseTd>            
                      <BaseTd class="capitalize"> {{ loan.type }} </BaseTd>                            
                      <BaseTd> {{ moneyFormatter(loan.total_amount) }} </BaseTd>
                      <BaseTd> {{ loan.created_at }} </BaseTd> 
                      <BaseTd>                          
                          <BaseStatus v-if="loan.status" :status="loan.status" />  
                      </BaseTd>
                      <BaseTd>
                          <div class="flex justify-end gap-2 mr-4">                                   
                              <router-link :to="{name : 'loans.details' , params : {id : loan.id} }" class="btn-icon-info">
                                  <BaseIconEdit/>
                              </router-link>
                              <BaseButton v-if="isAdmin && loan.status != 'paid'" @click="destroy(loan.id)" class="btn-icon-danger">
                                <template #icon>
                                  <BaseIconDelete/>
                                </template>
                              </BaseButton>
                        </div>
                      </BaseTd>
                  </BaseTableRow>                  
                </BaseTableBody>
                <BaseTableRow v-if="!isLoading && loans.length === 0">
                    <BaseTd   colspan="8" class="text-center font-semibold">No Record Found</BaseTd>
                </BaseTableRow>
            </BaseTable>
            <Pagination v-if="pagination.last_page > 1" :pagination="pagination" @page-change=pageChange />
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
import Pagination from '../Pagination.vue'
import BaseSearch from '../base/BaseSearch.vue'
import BaseDropDown from '../base/BaseDropDown1.vue'
import BaseIconDelete from '../base/icons/BaseIconDelete.vue'
import BaseIconEdit from '../base/icons/BaseIconEdit.vue'

import useLoans from '../../composable/loans'
import useUser from '../../composable/user'
import useSorting from '../../composable/sorting';
import useStatus from '../../composable/status';
import useFormatter from '../../composable/helper/formater'



import { ref, onMounted, computed, watch, defineAsyncComponent } from 'vue'
const BaseStatus = defineAsyncComponent(() => import('../base/BaseStatus.vue'))
const { getLoans, destroyLoan, loanSearch, loans, isLoading, pagination } =  useLoans()
const {checkUserRole, isAdmin } = useUser()
const { moneyFormatter } = useFormatter()
const { loanSorting } = useSorting();
const { loanStatus } = useStatus();

const filterName = ref(null)
const filter = ref(null)
const sortName = ref(null)
const sort = ref(Object)
const keyword = ref(null)
const loanType = ref('all');

const loanTypeTabs = [
  { label: 'All', value: 'all' },
  { label: 'Monthly', value: 'monthly' },
  { label: '15Days', value: '15days' },
  { label: 'Weekly', value: 'weekly' },
  { label: 'Daily', value: 'daily' },
]

const typeParam = () => loanType.value === 'all' ? null : loanType.value

const destroy = async (id) => {
    await destroyLoan(id)
    await getLoans(1, typeParam(), filter.value, sort.value)
}

const handleFilter = (status) => {
  filterName.value = status.name
  filter.value = status.value
  getLoans(1, typeParam(), filter.value, sort.value)
}

const handleSorting = (payload) => {
  sortName.value = payload.displayName
  sort.value = payload.value
  getLoans(1, typeParam(), filter.value, sort.value)
}

const handleFilterLoanType = (status) => {
    loanType.value = status
    getLoans(1, typeParam(), filter.value, sort.value)
}


const pageChange = (page) => {
  page = page.split("=")[1]
  getLoans(page, typeParam(), filter.value, sort.value)
}

onMounted(() => getLoans(1, typeParam()))

onMounted(checkUserRole)

watch(keyword, async(value) => {
  if ( value && value.length > 2 ){ 
     await loanSearch(value, typeParam());
     return;
  }
 await getLoans(1, typeParam(), filter.value, sort.value);
})


</script>
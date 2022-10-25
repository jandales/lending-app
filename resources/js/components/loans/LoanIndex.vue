<template>
    <div class="w-full mb-6">
        <ul class="flex gap-8 border-b">
          <li class="text-gray-400 py-2 cursor-pointer text-sm" 
              :class="{'!text-sky-500 border-b-2 border-sky-500' : loanType == 'monthly'}">
            <span @click="handleFilterLoanType('monthly')">Monthly</span>
          </li>
          <li class="text-gray-400  cursor-pointer py-2 text-sm" 
              :class="{'!text-sky-500 border-b-2 border-sky-500' : loanType == '15days'}">
            <span @click="handleFilterLoanType('15days')">15Days</span>
          </li >
          <li class="text-gray-400  cursor-pointer py-2 text-sm" 
              :class="{'!text-sky-500 border-b-2 border-sky-500' : loanType == 'weekly'}">
            <span @click="handleFilterLoanType('weekly')">Weekly</span>
          </li>
          <li  class="text-gray-400  cursor-pointer py-2 text-sm" 
              :class="{'!text-sky-500 border-b-2 border-sky-500 ' : loanType == 'daily'}" >
            <span @click="handleFilterLoanType('daily')">Daily</span>
          </li>
        </ul>
    </div>
    <div class="w-full flex mb-6 justify-between">
        <div class="flex items-center justify-center">
              <div class="xl:w-52">
                <BaseSearch v-model="keyword"/>                     
              </div>
        </div>   
        <div class="flex gap-2">
        <BaseDropDown :options="loanStatus"  :title="'Status'" :value="filterName"  @click-action="handleFilter" />
        <BaseDropDown :options="loanSorting" :title="'Sort'"   :value="sortName"    @click-action="handleSorting" />
  </div>
</div>
<BasePanelWrapper :title="'Loans'">
      <template #action>
          <router-link 
            :to="{name : 'loans.create'}"
            class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
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
                        <router-link :to="{name: 'borrowers.details', params : { id :  loan.borrower.id }}" class="text-sky-500">
                           {{loan.loan_number}}
                        </router-link> 
                      </BaseTd>
                      <BaseTd>
                        <router-link :to="{name: 'borrowers.details', params : { id :  loan.borrower.id }}" class="text-sky-500">
                            <BaseAvatar
                              :image="loan.borrower.avatar"
                              :name="loan.borrower.name"
                            /> 
                        </router-link> 
                      </BaseTd>            
                      <BaseTd class="capitalize"> {{ loanType }} </BaseTd>                            
                      <BaseTd> {{ moneyFormatter(loan.total_amount) }} </BaseTd>
                      <BaseTd> {{ loan.created_at }} </BaseTd> 
                      <BaseTd>                          
                          <BaseStatus v-if="loan.status" :status="loan.status" />  
                      </BaseTd>
                      <BaseTd>
                          <div class="flex justify-end gap-4 mr-4 ">                                   
                              <router-link :to="{name : 'loans.details' , params : {id : loan.id} }" type="button" class="btn-icon-info">
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
const loanType = ref('monthly');


const destroy = async (id) => {
    await destroyLoan(id)
    await getLoans()
}

const handleFilter = (status) => {
  filterName.value = status.name
  filter.value = status.value
  getLoans(1, loanType.value, filter.value)
}

const handleSorting = (payload) => {
  sortName.value = payload.displayName
  sort.value = payload.value
  getLoans(1, loanType.value, filter.value, sort.value)
}

const handleFilterLoanType = (status) => {
    loanType.value = status
    getLoans(1, loanType.value)
}


const pageChange = (page) => {
  page = page.split("=")[1]
  getLoans(page, loanType.value)
}

onMounted(getLoans(1, loanType.value))

onMounted(checkUserRole)

watch(keyword, async(value) => {
  if ( value.length > 2 ){ 
     await loanSearch(value, loanType.value);
     return;
  }
 await getLoans(1, loanType.value);
})


</script>
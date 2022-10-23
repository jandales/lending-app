<template>
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
                      <BaseTableTh>
                        <div class="flex justify-center">
                            <div class="form-check px-2">
                              <input  @change="selectAll()"  type="checkbox"  id="flexCheckIndeterminate" >
                            </div>
                        </div>
                      </BaseTableTh>
                      <BaseTableTh>Loan Number</BaseTableTh>
                      <BaseTableTh>Borrower</BaseTableTh>    
                      <BaseTableTh>Total Amount</BaseTableTh>      
                      <BaseTableTh>Date</BaseTableTh>                 
                      <BaseTableTh>Status</BaseTableTh>
                      <BaseTableTh class="text-center">Action</BaseTableTh>
                    </BaseTableRow>                   
                </BaseTableHead>
                <BaseTableBody v-if="loans.length > 0"  >
                  <BaseTableRow :body="true" v-for="loan in loans">
                      <BaseTd>
                        <div class="flex justify-center">
                          <div class="form-check">
                            <input  type="checkbox"  :value="loan.id" v-model="selected" id="flexCheckIndeterminate">
                          </div>
                        </div>  
                      </BaseTd>
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
                      <BaseTd> {{ moneyFormatter(loan.total_amount) }} </BaseTd>
                      <BaseTd> {{ loan.created_at }} </BaseTd> 
                      <BaseTd> 
                          <span v-if="loan.status == 'paid'" class="bg-green-500 text-xs px-2 py-1 rounded-md text-white capitalize">
                            {{ loan.status }}
                          </span>
                          <span v-else-if="loan.status == 'void'"  class="bg-rose-500 text-xs px-2 py-1 rounded-md text-white capitalize">
                            {{ loan.status }}
                          </span>
                          <span v-else-if="loan.status == 'rejected'"  class="bg-rose-500 text-xs px-2 py-1 rounded-md text-white capitalize">
                            {{ loan.status }}
                          </span>
                          <span v-else class="bg-blue-500 text-xs px-2 py-1 rounded-md text-white capitalize">
                            {{ loan.status }}
                          </span>      
                      </BaseTd>
                      <BaseTd>
                          <div class="flex justify-end gap-4 mr-4 ">                                   
                              <router-link :to="{name : 'loans.details' , params : {id : loan.id} }" type="button" class="btn-icon-info">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                              </router-link>
                              <BaseButton v-if="isAdmin && loan.status != 'paid'" @click="destroy(loan.id)" class="btn-icon-danger">
                                <template #icon>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
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

import useLoans from '../../composable/loans'
import useUser from '../../composable/user'
import useSorting from '../../composable/sorting';
import useStatus from '../../composable/status';
import useFormatter from '../../composable/helper/formater'

import { ref, onMounted, computed, watch } from 'vue'

const { getLoans, destroyLoan, loanSearch, loans, isLoading, pagination } =  useLoans()
const {checkUserRole, isAdmin } = useUser()
const { moneyFormatter } = useFormatter()
const { loanSorting } = useSorting();
const { loanStatus } = useStatus();

const selected = ref([])
const selectAllState = ref(false)
const filterName = ref(null)
const filter = ref(null)
const sortName = ref(null)
const sort = ref(Object)
const keyword = ref(null)

const selectAll = () => {   
      selectAllState.value = selectAllState.value == true ? false : true
      selected.value = []

      if (selectAllState.value == true) { 
          loans.value.forEach(type => {
              selected.value.push(type.id)
          })       
          return;
      }

      selected.value = []      
}

const deleteSeleted  =  () => {
    selected.value.forEach(id => { 
        destroy(id);
    })    
}
const destroy = async (id) => {
    await destroyLoan(id)
    await getLoans()
}

const handleFilter = (status) => {
  filterName.value = status.name
  filter.value = status.value
  getLoans(1, filter.value)
}

const handleSorting = (payload) => {
  sortName.value = payload.displayName
  sort.value = payload.value
  getLoans(1, filter.value, sort.value)
}


const pageChange = (page) => {
  page = page.split("=")[1]
  getLoans(page)
}

onMounted(getLoans)

onMounted(checkUserRole)

watch(keyword, async(value) => {
  if ( value.length > 2 ){ 
     await loanSearch(value);
     return;
  }
 await getLoans();
})


</script>
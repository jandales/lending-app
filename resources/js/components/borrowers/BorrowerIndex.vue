<template>
  <div class="w-full flex mb-6 justify-between">
        <div class="flex items-center justify-center">
              <div class="xl:w-52">
                <BaseSearch v-model="keyword"/>                     
              </div>
        </div>   
        <div class="flex gap-2">
        <BaseDropDown  :options="borrowerStatus" :title="'status'" :value="filterName"  @click-action="handleFilter" />
        <BaseDropDown :options="sorting" :title="'Sort'" :value="sortName"  @click-action="handleSort" />
  </div>
</div>

<BasePanelWrapper :title="'List of borrowers'">
    <template #action>
          <router-link  v-if="!selectAllState && selected.length < 2"
                :to="{name : 'borrowers.create'}"
                class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                Create Borrower
          </router-link>  

          <BaseButton v-else
              @click="deleteSeleted"
              class="btn-danger"
              name="Delete"
          />             
    </template>
    <template #body>
      <BaseTableWrapper>
        <BaseTable>
            <BaseTableHead>
              <BaseTableRow>
                  <BaseTableTh class="w-[50px]">
                      <div class="flex justify-center">
                          <div class="form-check px-2">
                            <input  @change="selectAll()"  type="checkbox"  id="flexCheckIndeterminate" >
                          </div>
                      </div>
                  </BaseTableTh>
                  <BaseTableTh>Name</BaseTableTh>
                  <BaseTableTh>Phone</BaseTableTh>
                  <BaseTableTh>Email</BaseTableTh>  
                  <BaseTableTh>Status</BaseTableTh>                    
                  <BaseTableTh class="text-center">Action</BaseTableTh>   
              </BaseTableRow>             
            </BaseTableHead>            
            <BaseTableBody>             
                    
              <BaseTableRow  :body="true"  v-for="(borrower, index) in borrowers" :key="index">
                <BaseTd>
                  <div class="flex justify-center">
                      <div class="form-check">
                        <input  type="checkbox" :value="borrower.id" v-model="selected" id="flexCheckIndeterminate">
                      </div>
                  </div>  
                </BaseTd>
                <BaseTd>
                  <router-link :to="{name: 'borrowers.details', params : { id :  borrower.id } }" class="text-sky-500">
                      <BaseAvatar :image="borrower.avatar" :name="borrower.name" />
                  </router-link>  
                </BaseTd>
                <BaseTd>{{ borrower.phone }}</BaseTd>
                <BaseTd> {{ borrower.email }}</BaseTd> 
                <BaseTd class="capitalize text-green-500" :class="{ '!text-rose-500 ' : borrower.status != 'active' } "> {{ borrower.status }}</BaseTd>              
                <BaseTd>
                    <div class="flex justify-end gap-4 mr-4">                                   
                        <router-link :to="{name : 'borrowers.edit' , params : {id : borrower.id} }" class="btn-icon-info">
                        <BaseIconEdit/>
                      </router-link>
                        <BaseButton 
                        @click="deleteBorrower(borrower.id)" 
                        class="btn-icon-danger">
                        <template #icon>
                            <BaseIconDelete />
                        </template>
                      </BaseButton>
                    </div>
                </BaseTd>
              </BaseTableRow>                          
            </BaseTableBody>  
            <!-- show if no record  found -->
            <BaseTableRow v-if="!isLoading && borrowers.length === 0">
                    <BaseTd   colspan="8" class="text-center font-semibold">No Record Found</BaseTd>
            </BaseTableRow>        
        </BaseTable>  
        <Pagination v-if="pagination.last_page > 1" :pagination="pagination" @page-change=pageChange />
        <BaseTableSpinner v-if="isLoading"/> 
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
import BaseIconDelete from '../base/icons/BaseIconDelete.vue'
import BaseIconEdit from '../base/icons/BaseIconEdit.vue'
import BaseSearch from '../base/BaseSearch.vue'
import BaseDropDown from '../base/BaseDropDown1.vue';
import Pagination from '../Pagination.vue';

import { ref, onMounted, watch } from 'vue';
import useBorrowers from '../../composable/borrowers';
import useSorting from '../../composable/sorting';
import useStatus from '../../composable/status';

const { getBorrowers, destroyBorrower, borrowerSearch,  borrowers, pagination, isLoading } =  useBorrowers();
const { sorting } = useSorting();
const { borrowerStatus } = useStatus();

const selected = ref([])
const selectAllState = ref(false);
const keyword = ref(null);
const filterName = ref(null);
const filter = ref(null);
const sortName = ref(null);
const sort = ref(Object);

const deleteBorrower = async(id) => {

    await destroyBorrower(id)

    await getBorrowers();

} 

const selectAll = () => {   

      selectAllState.value = selectAllState.value == true ? false : true;

      selected.value = []

      if(selectAllState.value == true){  

          borrowers.value.forEach(type => {

              selected.value.push(type.id)

          })        

          return;

      }

      selected.value = []      
}

const deleteSeleted  =  () => {

    selected.value.forEach(id => { 

        destroyBorrower(id)

        getBorrowers();

    })    

}

const handleFilter = (status) => {
  filterName.value = status.name;
  filter.value = status.value;
  getBorrowers(1, filter.value)
}

const handleSort = (value) => {
  sortName.value = value.displayName;
  sort.value = value;
  getBorrowers(1, filter.value, sort.value)
}

const pageChange  = (page) => {
    page = page.split("=")[1];
    getBorrowers(page, filter.value, sort.value);
}

watch(keyword, async (value) => {
  if ( value.length > 2 ){
    await borrowerSearch(value)
    return;
  }
  await getBorrowers()
});

onMounted(getBorrowers);

</script>
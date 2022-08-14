<template>
  <div class="border   w-full bg-white rounded-md">
    <div class="flex  p-4 justify-between items-center">
    <h1>List of Loans</h1>     
    <router-link 
          :to="{name : 'loans.create'}"
          class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
          Create Loan
    </router-link>  
 
</div>
<div  class="border border-l-0 border-r-0 bg-white">
  <div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full sm:px-6 lg:px-8">       
        <div class="overflow-hidden">      
          <table class="min-w-full">
            <thead class="bg-white border-b">
              <tr>  
                <th class="w-[50px]">
                    <div class="flex justify-center">
                      <div class="form-check px-2">
                        <input  @change="selectAll()"  type="checkbox"  id="flexCheckIndeterminate" >
                      </div>
                    </div>
                </th>           
                <th scope="col">
                  Borrower
                </th>
                <th scope="col">
                    Terms
                </th>
                 <th scope="col">
                   Interest
                </th>
                <th scope="col">
                   Total Amount
                </th>               
                <th scope="col">
                  Balance
                </th>
                <th scope="col" >
                  Status
                </th>
                <th scope="col">
                
                </th>
              </tr>
            </thead>
            <tbody>  
              <tr v-if="loans.length > 0" v-for="loan in loans" class="bg-white border-b transition duration-300 ease-in-out last:border-b-0 hover:bg-gray-100"> 
                <td>
                  <div class="flex justify-center">
                    <div class="form-check">
                      <input  type="checkbox"  :value="loan.id" v-model="selected" id="flexCheckIndeterminate">
                    </div>
                  </div>  
                </td>            
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">    
                  <router-link :to="{name: 'borrowers.details', params : { id :  loan.borrower.id }}" class="text-sky-500">
                      <BaseAvatar
                        :image="loan.borrower.avatar"
                        :name="loan.borrower.name"
                      /> 
                  </router-link>        
                             
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                     {{ `${loan.terms} Months` }}
                </td>  
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ `${loan.interest}%` }}
                </td>                
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ moneyFormatter(loan.total_amount) }}
                </td>            
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ moneyFormatter(loan.balance_amount) }}
                </td> 
                <td class="text-gray-900 font-light text-center  whitespace-nowrap">
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
                </td>       
                <td>
                  <div class="flex justify-end gap-4 mr-4 ">                                   
                      <router-link :to="{name : 'loans.details' , params : {id : loan.id} }" type="button" class="btn-icon-info">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                      </router-link>
                      <button v-if="isAdmin && loan.status != 'paid'" @click="destroy(loan.id)" type="button" class="btn-icon-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>

                      </button>
                  </div>
                </td>
              </tr>
              <tr v-else>
                <td colspan="8" class="text-xl text-center text-gray-900 font-light px-6 py-4 whitespace-nowrap">No Record Found</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>
  </div>

 
</template>
<script setup>
import BaseAvatar from '../base/BaseAvatar.vue';
import useLoans from '../../composable/loans'
import useUser from '../../composable/user';
import useFormatter from '../../composable/helper/formater'

import { ref, onMounted, computed } from 'vue';

const { getLoans, destroyLoan, loans} =  useLoans();

const {checkUserRole, isAdmin } = useUser();

const { moneyFormatter } = useFormatter();

const selected = ref([])

const selectAllState = ref(false);

const selectAll = () => {   

      selectAllState.value = selectAllState.value == true ? false : true;

      selected.value = []

      if(selectAllState.value == true){  

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

    await getLoans();

}


onMounted(getLoans);
onMounted(checkUserRole)



</script>
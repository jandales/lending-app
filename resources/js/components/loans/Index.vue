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
                <th>
                    <div class="flex justify-center">
                      <div class="form-check px-2">
                        <input   type="checkbox"  id="flexCheckIndeterminate" >
                      </div>
                    </div>
                </th>           
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                  Customer
                </th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                    Loan Type
                </th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                    Amount
                </th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                   Interest
                </th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                
                </th>
              </tr>
            </thead>
            <tbody>  
              <tr  v-for="loan in list" class="bg-white border-b transition duration-300 ease-in-out last:border-b-0 hover:bg-gray-100"> 
                <td>
                  <div class="flex justify-center">
                    <div class="form-check">
                      <input  type="checkbox"  :value="loan.id" v-model="selected" id="flexCheckIndeterminate">
                    </div>
                  </div>  
                </td>            
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ loan.customer.name  }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ loan.loan_type.type }}
                </td>                
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ loan.amount}}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ loan.loan_type.interest }}
                </td>         
                <td>
                  <div class="flex justify-end gap-4 mr-4 ">
                      <router-link :to="{name : 'customers.edit' , params : {id : loan.id} }" type="button" class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">Edit</router-link>
                      <button @click="deleteCustomer(loan.id)" type="button" class="inline-block px-6 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out">Delete</button>
                  </div>
                </td>
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
import useCustomers from '../../composable/customers';
import useLoans from '../../composable/loans'
import { ref, onMounted, computed } from 'vue';

const { getLoans, loans} =  useLoans();
const selected = ref([])
const selectAllState = ref(false);


// const selectAll = () => {       
//       selectAllState.value = selectAllState.value == true ? false : true;
//       selected.value = []
//       if(selectAllState.value == true){  
//           customers.value.forEach(type => {
//               selected.value.push(type.id)
//           })        
//           return;
//       }
//       selected.value = []      
// }

// const deleteSeleted  =  () => {
//     selected.value.forEach(id => { 
//         destroyCustomer(id)
//         getCustomers();
//     })    
// }

onMounted(getLoans);

const list = computed(() => {
      return loans.value.filter(loan => {  
          loan.customer = { id: loan.customer.id, name : `${loan.customer.firstname} ${loan.customer.lastname}`};         
          return loan;
      })   
     
})



</script>
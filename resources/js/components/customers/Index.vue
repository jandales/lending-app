<template>
  <div class="border   w-full bg-white rounded-md">
    <div class="flex  p-4 justify-between items-center">
    <h1>List of Customers</h1>     
    <router-link  v-if="!selectAllState && selected.length < 2"
          :to="{name : 'customers.create'}"
          class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
          Create new Customer
    </router-link>  
    <button v-else @click="deleteSeleted" type="button" class="inline-block px-6 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out">Delete</button>
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
                        <input @change="selectAll"  type="checkbox"  id="flexCheckIndeterminate" >
                      </div>
                    </div>
                </th>           
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                  Name
                </th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                      Phone
                </th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                  Email
                </th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                
                </th>
              </tr>
            </thead>
            <tbody>  
              <tr v-for="customer in customers" class="bg-white border-b transition duration-300 ease-in-out last:border-b-0 hover:bg-gray-100"> 
                <td>
                  <div class="flex justify-center">
                    <div class="form-check">
                      <input  type="checkbox"  :value="customer.id" v-model="selected" id="flexCheckIndeterminate">
                    </div>
                  </div>  
                </td>            
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{  `${customer.firstname} ${customer.lastname}`  }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ customer.phone }}
                </td>
                
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ customer.address }}
                </td>         
                <td>
                  <div class="flex justify-end gap-4 mr-4 ">
                      <router-link :to="{name : 'customers.edit' , params : {id : customer.id} }" type="button" class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">Edit</router-link>
                      <button @click="deleteCustomer(customer.id)" type="button" class="inline-block px-6 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out">Delete</button>
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
import { ref, onMounted } from 'vue';

const { getCustomers, destroyCustomer,  customers} =  useCustomers();
const selected = ref([])
const selectAllState = ref(false);
const deleteCustomer = async(id) => {
    await destroyCustomer(id)
    await getCustomers();
} 

const selectAll = () => {       
      selectAllState.value = selectAllState.value == true ? false : true;
      selected.value = []
      if(selectAllState.value == true){  
          customers.value.forEach(type => {
              selected.value.push(type.id)
          })        
          return;
      }
      selected.value = []      
}

const deleteSeleted  =  () => {
    selected.value.forEach(id => { 
        destroyCustomer(id)
        getCustomers();
    })    
}

onMounted(getCustomers);

</script>
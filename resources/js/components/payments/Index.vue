<template>
  <div class="w-full bg-white">
      <div class="flex justify-between items-center p-4">
      <h1>List of Payments</h1>     
      <router-link  v-if="!selectAllState && listId.length < 2"
            :to="{name: 'payments.create'}"
            class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
            Create Payment
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
                        <div class="form-check">
                          <input  @change="selectAll" type="checkbox"  id="flexCheckIndeterminate" >
                        </div>
                      </div>
                  </th>           
                  <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                    Customer
                  </th>
                  <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                    Amount
                  </th>
                  <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                    Date of payment
                  </th>
                     <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left ">
                    Status
                  </th>
                  <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                   
                  </th>
                </tr>
              </thead>
              <tbody>  
                <tr v-for="payment in payments" class="bg-white border-b transition duration-300 ease-in-out last:border-b-0 hover:bg-gray-100"> 
                  <td>
                    <div class="flex justify-center">
                      <div class="form-check px-2">
                        <input  type="checkbox"  :value="payment.id" v-model="listId" id="flexCheckIndeterminate">
                      </div>
                    </div>  
                  </td>            
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <img
                        :src="payment.customer.avatar"
                        class="rounded-full w-10"
                        alt="Avatar"
                      />
                      <label for="customer_name" class="ml-2">{{`${payment.customer.firstname} ${payment.customer.lastname}`}}</label>
                    </div>
                    
                  </td>
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    {{ payment.amount}}
                  </td>
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    {{ payment.created_at }}
                  </td>   
                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap capitalize">
                    {{ payment.status }}
                  </td>       
                  <td>
                    <div class="flex justify-end gap-4 mr-4 ">                     
                        <button @click="voidPayment(payment.id)" type="button" class="inline-block px-6 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out">Void</button>
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

  import usePayments from '../../composable/payments';
  import { onMounted, ref } from 'vue';

  const listId = ref([]);
  const selectAllState = ref(false);

  const { getPayments, removePayment, payments } = usePayments();

  const voidPayment = async(id)=>{
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

</script>
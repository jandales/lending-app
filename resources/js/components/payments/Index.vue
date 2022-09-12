<template>
  <div class="w-full bg-white">
      <div class="flex justify-between items-center p-4">
      <h1>List of Payments</h1>    

      <button v-if="selectAllState" @click="deleteSeleted" type="button" class="inline-block px-6 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out">Delete</button>
  </div>
  <div  class="border border-l-0 border-r-0 bg-white">
    <div class="flex flex-col">
      <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full sm:px-6 lg:px-8">       
          <div class="overflow-hidden">      
            <table class="min-w-full">
              <thead class="bg-white border-b">
                <tr>  
                  <!-- <th>
                      <div class="flex justify-center">
                        <div class="form-check">
                          <input  @change="selectAll" type="checkbox"  id="flexCheckIndeterminate" >
                        </div>
                      </div>
                  </th>     -->
                   <th scope="col">
                    Loan Number
                  </th>       
                  <th scope="col">
                    Customer
                  </th>
                  <th scope="col" >
                    Amount
                  </th>
                  <th scope="col" >
                    Date of payment
                  </th>
                     <th scope="col" >
                    Status
                  </th>
                  <th scope="col">
                   
                  </th>
                </tr>
              </thead>
              <tbody>  
                <tr v-if="payments.length > 0" v-for="payment in payments" class="bg-white border-b transition duration-300 ease-in-out last:border-b-0 hover:bg-gray-100"> 
                  <!-- <td>
                    <div class="flex justify-center">
                      <div class="form-check px-2">
                        <input  type="checkbox"  :value="payment.id" v-model="listId" id="flexCheckIndeterminate">
                      </div>
                    </div>  
                  </td>    -->
                   <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap cursor-pointer">
                      <RouterLink :to="{name : 'loans.details' , params : {id : payment.loan.id} }" class="text-sky-500">
                        {{ payment.loan.number }}
                      </RouterLink>                    
                  </td>         
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"> 
                    <router-link :to="{name: 'borrowers.details', params : { id :  payment.borrower.id }}" class="text-sky-500">
                      <BaseAvatar
                        :image="payment.borrower.avatar"
                        :name="payment.borrower.name"
                      />              
                    </router-link>      
                  </td>
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    {{ moneyFormatter(payment.amount) }}
                  </td>
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    {{ payment.created_at }}
                  </td> 
                  
                  <td class="text-gray-900 font-light text-center  whitespace-nowrap">
                  <span  
                  class="bg-green-500 text-xs px-2 py-1 rounded-md text-white capitalize"
                  :class="{'!bg-rose-500' : payment.status == 'void' }"
                  >
                     {{ payment.status }}
                  </span>
                 
                 
                </td>    
                  <td>
                    <div v-if="payment.loan.status != 'paid'" class="flex justify-end gap-4 mr-4 ">                     
                        <button @click="voidPayment(payment.id)" type="button" class="btn-icon-danger">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
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
  import BaseAvatar from '../base/BaseAvatar.vue'
  import usePayments from '../../composable/payments';
  import useFormatter from '../../composable/helper/formater'
    import { onMounted, ref } from 'vue';

  const listId = ref([]);
  const selectAllState = ref(false);

  const { getPayments, removePayment, payments } = usePayments();
  const { moneyFormatter } = useFormatter();

  const voidPayment = async(id)=> {

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
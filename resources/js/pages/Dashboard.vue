<template>

<div class="w-full flex gap-8"> 
  <BaseCard :title="'Customers'"  :value="customerCount" :icon="'person'" />

  <BaseCard :title="'Capital'"  :value="moneyFormatter(loanCapital)" :icon="'capital'" />

  <BaseCard :title="'Revenue'"  :value="moneyFormatter(loanRevenue)" :icon="'revenue'"/> 
</div>


  <div class="border   w-full bg-white rounded-md mt-8">
    <div class="flex  p-4 justify-between items-center">
    <h1 class="font-semibold text-gray-700">Recent Loans</h1> 
    </div>
    <div  class="border border-l-0 border-r-0 bg-white">
  <div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full sm:px-6 lg:px-8">       
        <div class="overflow-hidden">      
          <table class="min-w-full">
            <thead class="bg-white border-b">
              <tr>                            
                <th scope="col">
                  Customer
                </th>
                <th scope="col">
                  Type
                </th>
                <th scope="col">
                  Amount
                </th>             
                <th scope="col">
                  Balance
                </th>
                <th scope="col">
                  Status
                </th>                
              </tr>
            </thead>
            <tbody>  
              <tr v-if="loans" v-for="loan in loans" class="bg-white border-b transition duration-300 ease-in-out last:border-b-">                      
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">            
                    <BaseAvatar
                      :image="loan.customer.avatar"
                      :name="`${loan.customer.firstname} ${loan.customer.lastname}`"
                    />             
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ loan.loan_type.type }}
                </td>                                
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ loan.total_amount}}
                </td>            
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ loan.balance_amount }}
                </td> 
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap capitalize">
                  {{ loan.status }}
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
import BaseCard from '../components/base/BaseCard.vue';
import BaseAvatar from '../components/base/BaseAvatar.vue';
import useApp from '../composable/app'
import useFormatter from '../composable/helper/formater'
import { onMounted, ref} from 'vue';
import useLoans from '../composable/loans'

const { getLoans, loans} =  useLoans();

const { moneyFormatter } = useFormatter();

const { getDashboards ,customerCount, loanRevenue, loanCapital  } = useApp();

const getData = () => {
    getDashboards();
}

onMounted(getData);
onMounted(getLoans);

</script>
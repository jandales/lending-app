<template>

<div class="w-full flex gap-8"> 
  <BaseCard :title="'Customers'"  :value="customerCount" :icon="'person'" />

  <BaseCard :title="'Active Loan'"  :value="activeLoansCount" :icon="'activeLoanCount'" />

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
                  Terms
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
              <tr v-if="loans" v-for="loan in loans" class="bg-white border-b transition duration-300 ease-in-out last:border-b-0">                      
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">  
                  <RouterLink :to="{name : 'borrowers.details' , params : {id : loan.borrower.id } }" class="text-sky-500">         
                    <BaseAvatar
                      :image="loan.borrower.avatar"
                      :name="loan.borrower.name"
                    />      
                  </RouterLink>       
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ `${loan.terms} Months` }}
                </td>                                
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ loan.total_amount}}
                </td>            
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ loan.balance_amount }}
                </td> 
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap capitalize">
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
import { onMounted, computed} from 'vue';

const { moneyFormatter } = useFormatter();

const { getDashboards ,customerCount, loanRevenue, loanCapital,activeLoansCount, recentLoans  } = useApp();

const getData = () => {

    getDashboards();
  
}

onMounted(getData);

const loans = computed(() => {

    if(recentLoans.value == null) return;

    return recentLoans.value.map(loan => {

        loan.total_amount = moneyFormatter(loan.total_amount);

        loan.balance_amount = moneyFormatter(loan.balance_amount);

        return loan;

    });

});

</script>
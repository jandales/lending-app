<template>
<Alert v-if="isSuccess" :alert="'success'" :message="'Payment Successfully created'" />
<div  class="flex w-full gap-4">
    <div  class="w-1/3 bg-white rounded-md border h-max p-4 mb-4">
        <div class="flex items-center">
            
            <img v-if="loan" :src="loan.customer.avatar" class="rounded-full border w-16"  alt="Avatar" />

            <img v-else src="/img/avatar/avatar.png" class="rounded-full border w-16"  alt="Avatar"/>
    
            <div v-if="loan" class="w-full flex  items-center justify-between ml-4">
               <div>
                    <label for="" class="block text-sm font-semibold text-gray-700">{{`${loan.customer.firstname} ${loan.customer.lastname}`}}</label>
                    <label for="" class="block text-sm text-gray-700">{{loan.customer.phone}}</label>
               </div>  
               <span class="text-sky-500" data-bs-toggle="modal" data-bs-target="#exampleModalLg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
               </span>   
            </div>

        

        </div>

    <div v-if="loan" class="mt-4">
        <BaseLabelRow :name="'Loan Type :'" :value="loan.loan_type.type"/>
        <BaseLabelRow :name="'Amount to pay'" :value="loan.loan_type.amount_to_pay"/>
        <BaseLabelRow :name="'Loan Amount'" :value="loan.amount"/>
        <BaseLabelRow :name="'Interest'" :value="loan.loan_type.interest"/>
        <BaseLabelRow :name="'Total Amount'" :value="calculateInterest(loan.amount, loan.loan_type.interest)"/>        
        <BaseLabelRow :name="'Balance'" :value="loan.balance_amount" />  
        <BaseLabelRow :name="'Status :'" :value="loan.status"  />  
    </div>        
    
    </div>

    <div class="bg-white p-4 border w-2/3 rounded-md mx-auto">
      <div class="block bg-white">     
        <hi class="block tracking-wider text-lg mb-6 ">Payment History</hi>

        <div v-if="loan" class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <table class="min-w-full">
                    <thead class="bg-white border-b">
                        <tr>
                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            #
                        </th>
                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Date
                        </th>
                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Payment Amount
                        </th>
                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Status
                        </th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        <tr  v-for="payment in loan.payments" class="border-b">
                           
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{`000-${payment.id}`}}
                            </td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                {{ payment.created_format }}
                            </td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                {{ payment.amount }}
                            </td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                               <div class="px-2 py-1 text-white text-sm rounded-sm bg-green-500 text-center capitalize">
                                 {{ payment.status }}
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



</div>


  
</template>

<script setup>
import BaseLabelRow from '../../components/base/BaseLabelRow.vue'

import useLoans from '../../composable/loans';
import useCalculateInterest from '../../composable/helper/calculateInterest';
import useCalculateNumbersToPay from '../../composable/helper/calculateNumberToPay';
import usePayments from '../../composable/payments';

import { reactive, ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const {  getLoan, loan } = useLoans();
const { calculateInterest } = useCalculateInterest();
  
const route = useRoute();
const router =useRouter();

const form = reactive({
    amount : 0,
    remark : null,
    customer_id : null,
    loan_id : null,
})



onMounted(getLoan(route.params.id));

console.log(loan);

</script>
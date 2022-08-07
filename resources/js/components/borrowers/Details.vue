<template >
    <div v-if="borrower" class="flex w-full  gap-4">
        <div class=" flex flex-col gap-4 w-1/3">
            <div  class="w-full bg-white rounded-md border h-max py-4 px-8 mb-4">
            <hi class="block tracking-wider text-lg mb-4">Borrower Info</hi>
            <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center  w-full">                
                        <img v-if="borrower && borrower.avatar" :src="borrower.avatar" class="rounded-full border w-20 h-20"  alt="Avatar" />
                        <img v-else src="/img/avatar/avatar.png" class="rounded-full border w-20 h-20"  alt="Avatar"/>        
                        <div class="w-full flex  items-center justify-between ml-4">
                            <div>
                                <label for="" class="block text-xl capitalize font-semibold text-gray-700 mb-1">{{ borrower.name }} 
                                    <router-link :to="{name: 'borrowers.edit', params : { id :  borrower.id } }" class="ml-2 text-xs text-sky-500">Edit</router-link>
                                </label>  
                            </div>  
                        </div> 
                    </div>
            </div>
        
                <div  class="flex flex-col w-full">
                    <div class="flex gap-2 mb-1">
                        <div for="" class="block min-w-[100px] text-sm text-gray-700 break-words">Phone Number :</div>
                        <label for="" class="block text-sm text-gray-500">{{borrower.phone}}</label>
                    </div>

                    <div class="flex gap-2 mb-1">
                        <div for="" class="block min-w-[100px] text-sm text-gray-700 break-words">Email :</div>
                        <label for="" class="block text-sm text-gray-500">{{borrower.email}}</label>    
                    </div>  
                    
                    <div class="flex gap-2 mb-1">
                        <div  for="" class="block min-w-[100px] text-sm text-gray-700">Address :</div>
                        <label for="" class="block text-sm text-gray-500 break-all">{{borrower.address}}</label>    
                    </div>

                </div>
        
            
            </div> 
            <div  class="w-full bg-white rounded-md border h-max py-4 px-8 mb-4">
                <hi class="block tracking-wider text-lg mb-4">List of Loans</hi>
                <ul>              
                        <li v-for="loan in borrower.loans"  
                            @click="selectLoan(loan.id)"  
                            class="w-full flex items-center justify-between  py-1 cursor-pointer">
                                <label class="text-sky-500" for="">{{ loan.loan_number }}</label>
                                <label for="">{{ moneyFormatter(loan.total_amount) }}</label>
                                <label v-if="loan.status == 'pending'" for=""  class="bg-sky-500 text-xs capitalize text-white p-1 px-2 rounded-md">
                                    {{ loan.status }}
                                </label>
                               <label v-else-if="loan.status == 'paid'" for=""  class="bg-green-500 text-xs capitalize text-white p-1 px-2 rounded-md">               
                                    {{ loan.status }}
                               </label>
                                <label v-else-if="loan.status == 'void'" for=""  class="bg-rose-500 text-xs capitalize text-white p-1 px-2 rounded-md">               
                                    {{ loan.status }}
                               </label>  <label v-else-if="loan.status == 'rejected'" for=""  class="bg-rose-500 text-xs capitalize text-white p-1 px-2 rounded-md">               
                                    {{ loan.status }}
                               </label>
                                <label v-else="loan.status == 'paid'" for=""  class="bg-sky-500 text-xs capitalize text-white p-1 px-2 rounded-md">               
                                    {{ loan.status }}
                               </label>
                                <label v-else="loan.status == 'active'" for=""  class="bg-blue-500 text-xs capitalize text-white p-1 px-2 rounded-md">               
                                    {{ loan.status }}
                               </label>

                        </li>
                </ul>
            </div>       
        </div>
        
        <div v-if="loan" class="w-2/3 flex flex-col gap-4">  
            <div class="w-full bg-white rounded-md border h-max py-4 px-8 mb-4">
                <h1>Loan Details</h1>
                <div v-if="loan" class="mt-4">
                    <div class="flex gap-8">
                    <div  class="w-1/2 flex flex-col">
                            <BaseLabelRow :name="'Loan Number :'" :value="loan.loan_number"/>
                            <BaseLabelRow :name="'Terms :'" :value="`${loan.terms} Months`"/>
                            <BaseLabelRow :name="'Total Interest :'" :value="moneyFormatter(loan.total_interest)"/>
                            <BaseLabelRow :name="'Collection Amount :'" :value="moneyFormatter(loan.collection_amount)"/>
                            <BaseLabelRow :name="'Principal Amount :'" :value="moneyFormatter(loan.principal_amount)"/>
                    </div>
                    <div class="w-1/2">                
                            <BaseLabelRow :name="'Interest :'" :value="`${loan.interest}%`"/>
                            <BaseLabelRow :name="'Total Amount :'" :value="moneyFormatter(loan.total_amount)"/>        
                            <BaseLabelRow :name="'Balance :'" :value="moneyFormatter(loan.balance_amount)" />  
                            <BaseLabelRow v-if="loan.status == 'paid'" :name="'Status :'" :value="loan.status" :backgroundColor="'success'" />  
                            <BaseLabelRow v-else-if="loan.status == 'approved'" :name="'Status :'" :value="loan.status" :backgroundColor="'info'" /> 
                            <BaseLabelRow v-else-if="loan.status == 'active'" :name="'Status :'" :value="loan.status" :backgroundColor="'info'" />  
                            <BaseLabelRow v-else-if="loan.status == 'void' || loan.status == 'rejected'" :name="'Status :'" :value="loan.status" :backgroundColor="'danger'" /> 
                            <BaseLabelRow v-else :name="'Status :'" :value="loan.status" :backgroundColor="info" />
                    </div>
                    </div>    
                </div>  
            </div>
            <div v-if="loan" class="w-full bg-white p-4 border  rounded-md mx-auto">
            <div class="block bg-white">     
                <hi class="block tracking-wider text-lg">Payment Due Dates</hi>
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="overflow-hidden">
                            <table class="min-w-full">
                            <thead class="bg-white border-b">
                                <tr>
                                    <th scope="col">Due Date</th>
                                    <th scope="col">Amount</th> 
                                    <th scope="col">Interest</th>
                                    <th scope="col">Paid Date</th>  
                                    <th scope="col">Amount Paid</th>                     
                                    <th scope="col">Balance</th>
                                </tr>
                            </thead>
                            <tbody>                       
                                <tr v-if="loan"  v-for="item in dueDateList" class="last:border-b-0">                           
                                    <td>
                                        {{ item.due_date }}
                                    </td>
                                    <td>
                                        {{ item.collection_amount }}
                                    </td>
                                    <td>
                                        {{ item.interest }}
                                    </td>
                                    <td>                   
                                        {{ item.paid_at }}                            
                                    </td>  
                                    <td>                               
                                        {{ item.amount_paid }}                            
                                    </td>  
                                    <td>                               
                                        {{ item.balance }}                            
                                    </td>                           
                                </tr> 
                                <tr v-else>
                                    <td colspan="6" class="text-center text-xl">No Data Found</td>
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
    </div>

    

{{ activeloan }}

  
     
    
   
</template>

<script setup>

import useBorrowers from '../../composable/borrowers.js';

import useLoans from '../../composable/loans';

import useCalculation from '../../composable/helper/calculations';

import useFormatter from '../../composable/helper/formater';

import BaseLabelRow from '../../components/base/BaseLabelRow.vue'

import { onMounted, computed } from 'vue';

import { useRoute } from 'vue-router';

const { moneyFormatter } = useFormatter(); 

const {  getBorrower, borrower, } = useBorrowers();

const { calculateInterest } = useCalculation();

const { getLoan, getActiveLoan, loan } = useLoans();

const route = useRoute();

const selectLoan = async (id) => { 

    await getLoan(id);
}

onMounted(getBorrower(route.params.id));

onMounted(getActiveLoan(route.params.id));

const dueDateList = computed(() => {

    if(loan.value == null) return;   

    const interest = calculateInterest(loan.value.principal_amount, loan.value.interest);

    return loan.value.due_dates.map(due => {

        due.paid_at = due.paid_at == null ? '-- / -- / --' : due.paid_at;

        due.amount_paid = moneyFormatter(due.amount_paid);

        due.collection_amount = moneyFormatter(due.collection_amount);

        due.balance = moneyFormatter(due.balance);

        due.interest = moneyFormatter(interest);

        return due;

    });

});

</script>
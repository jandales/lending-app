<template>
    <div  class="w-full bg-white rounded-md border h-max py-4 px-8 mb-4">
           <hi class="block tracking-wider text-lg mb-4">Borrower Info</hi>
           <div class="flex justify-between items-center">

                <div class="flex items-center  w-full">                
                    <img v-if="customer && customer.avatar" :src="customer.avatar" class="rounded-full border w-20 h-20"  alt="Avatar" />
                    <img v-else src="/img/avatar/avatar.png" class="rounded-full border w-20 h-20"  alt="Avatar"/>        
                    <div v-if="customer" class="w-full flex  items-center justify-between ml-4">
                        <div>
                            <label for="" class="block text-xl capitalize font-semibold text-gray-700 mb-1">{{ customer.name }} 
                                 <router-link :to="{name: 'customers.edit', params : { id :  customer.id } }" class="ml-4 text-sky-500"></router-link>
                            </label>                         
                            
                            <div class="flex gap-8">

                                <div class="flex gap-4">
                                    <label for="" class="block text-base text-gray-400">Phone Number :</label>
                                    <label for="" class="block text-base text-gray-700">{{customer.phone}}</label>
                                </div>

                                <div class="flex gap-4">
                                    <label for="" class="block text-base text-gray-400">Email :</label>
                                    <label for="" class="block text-base text-gray-700">{{customer.email}}</label>    
                                </div>                               
                            </div>
                        </div>  
                    </div> 
                </div>
           </div>
            <div v-if="customer" class="flex gap-4 mt-4">
                        <label for="" class="block text-base text-gray-400">Address :</label>
                        <label for="" class="block text-base text-gray-700">{{customer.address}}</label>    
            </div>
    </div>  
    <div class="w-full flex gap-4">
         <div  class="w-1/3 bg-white rounded-md border h-max py-4 px-8 mb-4">
           <hi class="block tracking-wider text-lg mb-4">Loans</hi>

           <ul v-if="customer">              
                <li v-for="loan in customer.loans"  
                    @click="selectLoan(loan.id)"  
                    class="w-full flex items-center justify-between text-sky-500 py-1 cursor-pointer">
                        <label for="">{{ loan.loan_number }}</label>
                        <label for=""  class="bg-sky-500 text-xs capitalize text-white p-1 px-2 rounded-md"
                            :class="{ '!bg-green-500' :  loan.status == 'paid','!bg-green-500' :  loan.status == 'active', '!bg-rose-500'  :  loan.status == 'void','!bg-rose-500'  :  loan.status == 'rejected'}">
                            {{ loan.status }}
                        </label>
                </li>
           </ul>
        </div>
    <div class="w-2/3 bg-white p-4 border  rounded-md mx-auto">
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
     
    
   
</template>

<script setup>

import useCustomers from '../../composable/customers.js';
import useLoans from '../../composable/loans';
import useCalculation from '../../composable/helper/calculations';
import useFormatter from '../../composable/helper/formater';
import { onMounted, ref, computed } from 'vue';
import { useRoute } from 'vue-router';

const { moneyFormatter } = useFormatter(); 

const {  getCustomer, customer } = useCustomers();

const { calculateInterest } = useCalculation();

const { getLoan,  loan } = useLoans();

const route = useRoute();



const selectLoan = async (id) => {      
    await getLoan(id);
}

onMounted(
    getCustomer(route.params.id)
);

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
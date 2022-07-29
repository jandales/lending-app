<template>
<Alert v-if="isSuccess" :alert="'success'" :message="'Payment Successfully created'" />
<div  class="flex w-full gap-4">
    <div  class="w-1/3 bg-white rounded-md border h-max p-4 mb-4">
        <div class="flex items-center">
            
            <img v-if="loan" :src="loan.customer.avatar" class="rounded-full border w-16 h-16"  alt="Avatar" />
            <img v-else src="/img/avatar/avatar.png" class="rounded-full border w-16 h-16"  alt="Avatar"/>
    
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

            <div v-else class="ml-4">
                <label for=""  class="text-sky-500" data-bs-toggle="modal" data-bs-target="#exampleModalLg">Select Customer</label>
            </div>

        </div>

    <div v-if="loan" class="mt-4">
        <BaseLabelRow :name="'Loan Type :'" :value="loan.loan_type.type"/>
         <BaseLabelRow :name="'Interest'" :value="`${loan.loan_type.interest}%`"/>
        <BaseLabelRow :name="'Payment Amount'" :value="moneyFormatter(loan.loan_type.amount_to_pay)"/>
        <BaseLabelRow :name="'Principal Amount'" :value="moneyFormatter(loan.principal_amount)"/>       
        <BaseLabelRow :name="'Total Amount'" :value="calculateInterest(loan.principal_amount, loan.loan_type.interest)"/>        
        <BaseLabelRow :name="'Balance'" :value="moneyFormatter(loan.balance_amount)" />  
        <BaseLabelRow :name="'Status :'" :value="loan.status"  />  
    </div>        
    
    </div>

    <div v-if="loan" class="bg-white p-4 border w-2/3 rounded-md mx-auto">
      <div class="block bg-white">     
        <hi class="block tracking-wider text-lg mb-6 ">Create  Payment</hi>
        <BaseInput    
            :label="`Amount`"
            v-model="loan.loan_type.amount_to_pay"
            :type="textarea"        
            :id="typename"
            :errors="errors.amount"                
        />  

        <BaseInput           
            :label="`Remark`"
            v-model="form.remark"
            :type="'textarea'"        
            :id="typename"
            :errors="errors.remark"                
        />       


         <button v-if="!loan || loan.balance_amount == 0" 
            type="button" 
            class="inline-block px-6 py-2.5 bg-blue-600
            text-white font-medium text-xs
            leading-tight uppercase rounded
            shadow-md focus:outline-none focus:ring-0
            transition duration-150 ease-in-out
            pointer-events-none opacity-60"
            disabled>
            Pay
        </button>

        <button v-else           
            @click="store"
            type="button"
            data-mdb-ripple="true"
            data-mdb-ripple-color="light"
            class="btn-primary"          
            >
            Pay
        </button>

       


    </div>
</div>

<CustomersModal @selectCustomer="selectedCustomer"></CustomersModal>

</div>


  
</template>

<script setup>
import Alert from '../../components/Alert.vue'
import BaseInput from '../../components/base/BaseInput.vue'
import CustomersModal from '../Modal/CustomersModal.vue';
import BaseLabelRow from '../../components/base/BaseLabelRow.vue'

import useLoans from '../../composable/loans';
import useCalculateInterest from '../../composable/helper/calculateInterest';
import usePayments from '../../composable/payments';
import useFormatter from '../../composable/helper/formater';

const { moneyFormatter } = useFormatter();

import { reactive, ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const {  getLoan,getLoanByCustomer, loan } = useLoans();
const {  addPayment, isSuccess, errors } = usePayments();
const { calculateInterest } = useCalculateInterest();
  
const route = useRoute();
const router =useRouter();

const form = reactive({
    amount : 0,
    remark : null,
    customer_id : null,
    loan_id : null,
})

const store = async () => {    
    form.customer_id = loan.value.customer_id;
    form.amount = loan.value.loan_type.amount_to_pay;
    form.loan_id = loan.value.id; 
    await addPayment({...form});   
    if(isSuccess.value === true){
        router.push({name: 'payments'})
    }  
}

const selectedCustomer = (customer) => {
   getLoanByCustomer(customer.id);
}

onMounted(getLoan(route.params.loan_id));

</script>
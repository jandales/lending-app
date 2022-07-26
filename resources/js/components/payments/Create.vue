<template>
<Alert v-if="isSuccess" :alert="'success'" :message="'Payment Successfully created'" />
<div class="flex w-full gap-4">
    <div v-if="loan" class="w-1/3 bg-white rounded-md border p-4 mb-4">
    <div class="flex items-center">
        <img  src="/img/avatar/2022165867781452020.jpg" class="rounded-full border w-16"  alt="Avatar" />
  
        <div class="ml-4">
                <label for="" class="block font-semibold text-gray-700">{{`${loan.customer.firstname} ${loan.customer.lastname}`}}</label>
                <label for="" class="block text-sm text-gray-700">{{loan.customer.phone}}</label>     
        </div>
    </div>

    <div class="mt-4">

        <div class="flex justify-between">
             <label for="" class="block font-[500] text-gray-700 mb-2">Loan Type :</label> 
             <span class="font-normal">{{ loan.loan_type.type}}</span> 
        </div> 

        <div class="flex justify-between">
             <label for="" class="block font-[500] text-gray-700 mb-2">Amount to Pay :</label> 
             <span class="font-normal">{{ loan.loan_type.amount_to_pay}}</span> 
        </div> 

        <div class="flex justify-between">
            <label for="" class="block font-[500] text-gray-700 mb-2">Loan Amount :</label>  
            <span class="font-normal">{{ loan.amount}}</span>
        </div>

        <div class="flex justify-between">
            <label for="" class="block font-[500]  text-gray-700 mb-2">Interest :</label>
            <span class="font-normal">{{ `${loan.loan_type.interest} %` }}</span>
        </div>

        <div class="flex justify-between">
            <label for="" class="block font-[500] text-gray-700 mb-2">Total Amount:</label>
            <span class="font-normal">{{calculateInterest(loan.amount, loan.loan_type.interest)}}</span>
        </div>
       
        
        
        
    </div>        
    
    </div>

    <div class="bg-white p-4 border w-2/3 rounded-md mx-auto">
      <div class="block bg-white">     
        <hi class="block tracking-wider text-lg mb-6 ">Create  Payment</hi>

        <div>

        </div>

        <BaseInput    
            :label="`Amount`"
            v-model="form.amount"
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

        <button
            @click="store"
            type="button"
            data-mdb-ripple="true"
            data-mdb-ripple-color="light"
            class="btn-primary">
            Pay
        </button>


    </div>
</div>


</div>


  
</template>

<script setup>
import Alert from '../../components/Alert.vue'
import BaseInput from '../../components/base/BaseInput.vue'
import useLoans from '../../composable/loans';
import useCalculateInterest from '../../composable/helper/calculateInterest';
import useCalculateNumbersToPay from '../../composable/helper/calculateNumberToPay';
import usePayments from '../../composable/payments';

import { reactive, ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const {  getLoan, loan } = useLoans();
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
    form.loan_id = loan.value.id; 
    await addPayment({...form});   
    if(isSuccess.value === true){
        router.push({name: 'payments'})
    }  
}

onMounted(getLoan(route.params.loan_id));

</script>
<template>
<Alert v-if="isSuccess" :alert="'success'" :message="'Payment Successfully created'" />

<Alert v-if="errors.message"  :alert="'danger'" :message="errors.message"/>
       
<div   class="flex w-full gap-4">
    <div  class="w-1/3 bg-white rounded-md border h-max p-4 mb-4">
        <div class="flex items-center">
            <div v-if="loan" class="w-16 h-16">
                <img v-if="loan" :src="loan.customer.avatar" class="rounded-full border w-16 h-16"  alt="Avatar" />
                <img v-else src="/img/avatar/avatar.png" class="rounded-full border w-16 h-16"  alt="Avatar"/>    
            </div>
            <div v-else> 
                <img  src="/img/avatar/avatar.png" class="rounded-full border w-16 h-16"  alt="Avatar"/>    
            </div>
           
            <div v-if="loan" class="w-[calc(100%_-_4rem)] flex  items-center justify-between ml-4">
               <div>
                     <label for="" class="block text-sm font-semibold text-gray-700">{{loan.customer.name}}</label>
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
        <BaseLabelRow :name="'Payment Term :'" :value="loan.loan_type.type"/> 
        <BaseLabelRow :name="'Effective Date :'" :value="loan.effective_at"/>          
        <BaseLabelRow :name="'Collection Amount'" :value="moneyFormatter(loan.loan_type.amount_to_pay)"/>
        <BaseLabelRow :name="'Principal Amount'" :value="moneyFormatter(loan.principal_amount)"/>   
        <BaseLabelRow :name="'Interest'" :value="`${loan.loan_type.interest}%`"/>    
        <BaseLabelRow :name="'Total Amount'" :value="moneyFormatter(calculateInterest(loan.principal_amount, loan.loan_type.interest))"/>        
        <BaseLabelRow :name="'Balance'" :value="moneyFormatter(loan.balance_amount)" />  
        
        <BaseLabelRow v-if="loan.status == 'paid'" :name="'Status :'" :value="loan.status" :backgroundColor="success" />  
        <BaseLabelRow v-else-if="loan.status == 'void' || loan.status == 'rejected'" :name="'Status :'" :value="loan.status" :backgroundColor="danger" /> 
        <BaseLabelRow v-else :name="'Status :'" :value="loan.status" :backgroundColor="info" /> 

    </div>        
    
    </div>

    <div  class="bg-white p-4 border w-2/3 rounded-md mx-auto">
      <div  class="block bg-white">     
        <hi class="block tracking-wider text-lg mb-6 ">Create  Payment</hi>
        <BaseInput
            v-if="loan"    
            :label="`Amount`"
            v-model="loan.loan_type.amount_to_pay"
            :type="textarea"        
            :id="typename"
            :errors="errors.amount"                
        />  

        <BaseInput  
            v-else  
            :label="`Amount`"     
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


        <button v-if="loan && loan.balance_amount > 0 && loan.status == 'released'"          
            @click="store"
            type="button"
            data-mdb-ripple="true"
            data-mdb-ripple-color="light"
            class="btn-primary"          
            >
            Pay
        </button>

        <button v-else 
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

       


    </div>
</div>

<LoansModal @selectLoan="selectedLoan"/>

</div>


  
</template>

<script setup>
import Alert from '../../components/Alert.vue'
import BaseInput from '../../components/base/BaseInput.vue'
import CustomersModal from '../Modal/CustomersModal.vue';
import LoansModal from '../Modal/LoansModal.vue';
import BaseLabelRow from '../../components/base/BaseLabelRow.vue'

import useLoans from '../../composable/loans';
import useCalculateInterest from '../../composable/helper/calculateInterest';
import usePayments from '../../composable/payments';
import useFormatter from '../../composable/helper/formater';
import { reactive, onMounted} from 'vue';
import { useRoute, useRouter } from 'vue-router';



const { moneyFormatter } = useFormatter();
const { getLoan, exist, loan } = useLoans();
const { addPayment, isSuccess, errors } = usePayments();
const { calculateInterest } = useCalculateInterest();  
const route = useRoute();
const router = useRouter();

const success = 'success';
const danger = 'danger';
const info = 'info';

const form = reactive({
    amount : 0,
    remark : null,
    customer_id : null,
    loan_id : null,
})

const store = async () => {    
    form.customer_id = loan.value.customer.id;
    form.amount = loan.value.loan_type.amount_to_pay;
    form.loan_id = loan.value.id; 
    await addPayment({...form}); 
    if(isSuccess.value === true){        // router.push({name: 'payments'})
        await getLoan(route.params.loan_id);
    }  
}

const selectedLoan = (loan) => {
    console.log(loan)
   router.push({name: 'payments.create', params : {loan_id : loan.id}})
   getLoan(loan.id);  
}

onMounted(() => {
     if(route.params.loan_id == null) return;
    getLoan(route.params.loan_id)
});

</script>
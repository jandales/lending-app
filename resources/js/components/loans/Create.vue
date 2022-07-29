<template>


<div class="bg-white p-4 border rounded-md w-2/3 mx-auto">
    <div class="block bg-white">   

        <div v-for="error in errors.message">
            <Alert :alert="'danger'" :message="error"/>
        </div>       
        
        <hi class="block tracking-wider text-lg mb-6 ">Create Loan</hi>

          <div class="flex items-center mb-6">
            
            <img v-if="form.customer" :src="form.customer.avatar" class="rounded-full border w-16 h-16"  alt="Avatar" />
            <img v-else src="/img/avatar/avatar.png" class="rounded-full border w-16 h-16"  alt="Avatar"/>
    
            <div v-if="form.customer" class="w-full flex  items-center justify-between ml-4">
               <div>
                     <label for="" class="block text-sm font-semibold text-gray-700">{{`${form.customer.firstname} ${form.customer.lastname}`}}</label>
                    <label for="" class="block text-sm text-gray-700">{{form.customer.phone}}</label>
               </div>  
               <span class="text-sky-500" data-bs-toggle="modal" data-bs-target="#exampleModalLg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
               </span>   
            </div>

            <div v-else class="ml-4">
                <label for=""  class="text-sky-500" data-bs-toggle="modal" data-bs-target="#exampleModalLg">Select borrower</label>
                 <small class="text-alert-danger" v-for="error in errors.customer_id" >{{ error }}</small>
            </div>
        </div>         

            <div class="grid grid-cols-2 gap-4">
                <div class="form-group mb-6">
                    <label for="exampleInputPassword1" class="form-label inline-block mb-2 text-gray-700">Payment Terms</label>
                    <select aria-label="Default select example"  v-model="form.loan_type_id" @change="chooseLoanType" placeholder="Select" class="py-[10px] capitalize">     
                            <option 
                            v-for="loanType in loanTypes"
                            :selected="loanType.id == form.loan_type_id"
                            :value="loanType.id"
                            class="capitalize"
                            >{{loanType.type }}</option>
                    </select>
                    <small class="text-alert-danger" v-for="error in errors.loan_type_id">{{ error }}</small>
             </div>

            <BaseInput 
                :id="'effective_at'"
                :type="'date'"
                :label="'Effective Date'"
                :errors="errors.effective_at"
                v-model="form.effective_at"
            />

            </div>
     

          <div class="grid grid-cols-2 gap-4">

                <BaseInput 
                    :id="'payment-amount'" 
                    :type="'number'"
                    :label="'Payment Amount'" 
                    :errors="errors.interest"
                    v-model="form.payment_amount"
                    :disabled="true"
                />

                <BaseInput 
                    :id="'interest'" 
                    :type="'number'"
                    :label="'Interest (%)'" 
                    :errors="errors.interest"
                    v-model="form.interest"
                    :disabled="true"
                />

          </div>

      
        <div class="grid grid-cols-2 gap-4">
        <BaseInput 
            @input="handlecalculateInterest"
            :id="'principal_amount'"
            :type="'number'"
            :label="'Principal Amount'"           
            :errors="errors.principal_amount"
            v-model="form.principal_amount" 
        />

        <BaseInput 
            :id="'amount'"
            :type="'number'"
            :label="'Total Amount'"
            v-model="form.balance_amount"
        />
        </div>




       

        <button  
            @click="store"  
            type="button" 
            data-mdb-ripple="true"
            data-mdb-ripple-color="light"
            class="btn-primary">
            Save
        </button>
        
    </div>
   
</div>



<CustomersModal @selectCustomer="selectedCustomer"></CustomersModal>

</template>

<script setup>
import CustomersModal from '../../components/Modal/CustomersModal.vue'
import Alert from '../Alert.vue';
import BaseInput from '../Base/BaseInput.vue';

import useLoanTypes from '../../composable/loanType';
import useLoans from '../../composable/loans';
import useCalculateInterest from '../../composable/helper/calculateInterest';
import useCalculateNumbersToPay from '../../composable/helper/calculateNumberToPay';
import { reactive, onMounted } from 'vue';
import { useRouter } from 'vue-router';

const { getLoanTypes, loanTypes } = useLoanTypes();
const { storeLoan, errors, isSuccess } = useLoans();
const { calculateInterest } = useCalculateInterest();
const { calculateNumbersToPay } = useCalculateNumbersToPay();
const  router = useRouter();

const form = reactive({
    customer : null,
    customer_id : null,        
    loan_type_id : null,
    interest : 0,
    payment_amount : null,
    principal_amount: 0,
    balance_amount : 0, 
    effective_at : null,   
    count_to_pay : 0,
});

const chooseLoanType =  () => {
    if(loanTypes.value.length === 0) return form.interest = 0;
    
    loanTypes.value.forEach(loanType => {     
        if(form.loan_type_id == loanType.id){        
            form.interest = loanType.interest; 
            form.payment_amount = loanType.amount_to_pay;       
        }
    })
    handlecalculateInterest();
}

const handlecalculateInterest = () => { 
    form.balance_amount = calculateInterest(parseInt(form.principal_amount), form.interest);
    handlecalculateNumberToPay();  
}

const handlecalculateNumberToPay = () => {
    loanTypes.value.forEach(loanType => {     
        if(form.loan_type_id == loanType.id){    
            form.count_to_pay = calculateNumbersToPay(form.principal_amount, loanType.amount_to_pay);
        }
    })       
}

const selectedCustomer = (customer) => {
    form.customer_id = customer.id;
    form.customer = customer;
}

const store = async () => {
    await storeLoan(form) 
    if(isSuccess.value === true){
        router.push({name : 'loans'});
    }     
}

onMounted(getLoanTypes)

</script>
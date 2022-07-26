<template>

<div class="bg-white p-4 border rounded-md w-1/2 mx-auto">
    <div class="block bg-white">   

        <div v-for="error in errors.message">
            <Alert :alert="'danger'" :message="error"/>
        </div>       
        
        <hi class="block tracking-wider text-lg mb-6 ">Create Loan</hi>

        <BaseInput1
            :id="'customer_name'" 
            :type="'text'"
            :label="'Customer'" 
            :errors="errors.customer_id"
            v-model="form.customer_name"           
        />
           
        <div class="form-group mb-6">
            <label for="exampleInputPassword1" class="form-label inline-block mb-2 text-gray-700">Loan Type</label>
            <select aria-label="Default select example" v-model="form.loan_type_id" @change="chooseLoanType" placeholder="Select">     
                <option v-for="loanType in loanTypes" :selected="loanType.id == form.loan_type_id" :value="loanType.id">{{loanType.type }}</option>
            </select>
              <small class="text-alert-danger" v-for="error in errors.loan_type_id">{{ error }}</small>
        </div>

         <BaseInput 
            :id="'interest'" 
            :type="'number'"
            :label="'Interest (%)'" 
            :errors="errors.interest"
            v-model="form.interest"
            :disabled="true"
        />

        <BaseInput 
            @input="handlecalculateInterest"
            :id="'amount'"
            :type="'number'"
            :label="'Amount'"           
            :errors="errors.amount"
            v-model="form.amount" 
        />

        <BaseInput  
            :id="'day-to-pay'"
            :type="'number'"
            :label="'Number to Pay'" 
            :disabled="true"
            v-model="form.count_to_pay" 
        />

        <BaseInput 
            :id="'amount'"
            :type="'number'"
            :label="'Total Amount'"
            v-model="form.totalAmount"
        />

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
import BaseInput1 from '../Base/BaseInput1.vue';

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
    customer_name : null,
    customer_id : null,        
    loan_type_id : null,
    interest : 0,
    amount: 0,
    totalAmount : 0,  
    user_id : null,
    count_to_pay : null,
});

const chooseLoanType =  () => {
    if(loanTypes.value.length === 0) return form.interest = 0;
    
    loanTypes.value.forEach(loanType => {     
        if(form.loan_type_id == loanType.id){        
            form.interest = loanType.interest;        
        }
    })
    handlecalculateInterest();
}

const handlecalculateInterest = () => {  
    form.totalAmount = calculateInterest(parseInt(form.amount), form.interest);
    handlecalculateNumberToPay();  
}

const handlecalculateNumberToPay = () => {
    loanTypes.value.forEach(loanType => {     
        if(form.loan_type_id == loanType.id){    
            form.count_to_pay = calculateNumbersToPay(form.amount, loanType.amount_to_pay);
        }
    })       
}

const selectedCustomer = (customer) => {
    form.customer_id = customer.id;
    form.customer_name = `${customer.firstname} ${customer.lastname}`;
}

const store = async () => {
    await storeLoan(form) 
    if(isSuccess.value === true){
        router.push({name : 'loans'});
    }     
}

onMounted(getLoanTypes)

</script>
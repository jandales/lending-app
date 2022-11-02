<template>

        
<div class="w-2/3 mx-auto">
    <Alert v-if="isSuccess" :alert="'success'" :message="'Payment Successfully created'" />
<Alert v-if="loan && loan.status == 'approved' " :alert="'danger'" :message="'You cant create payment for this loan, Because is not yet released'" />

<Alert v-if="errors.message"  :alert="'danger'" :message="errors.message"/>
</div>   
<div   class="flex w-full justify-center gap-4">



    

    <div  class="bg-white p-4 border w-2/3 rounded-md mx-auto">
        <h1 class="block tracking-wider text-lg mb-6 ">Create  Payment</h1>
    

      <div  class="block bg-white"> 


        <div class="flex items-center mb-3">
                    <div v-if="loan" class="w-16 h-16">
                        <img v-if="loan.borrower.avatar" :src="loan.borrower.avatar" class="rounded-full border w-16 h-16"  alt="Avatar" />
                        <img v-else :src="$defaultAvatarSrc" class="rounded-full border w-16 h-16"  alt="Avatar"/>    
                    </div>
                    <div v-else> 
                        <img  :src="$defaultAvatarSrc" class="rounded-full border w-16 h-16"  alt="Avatar"/>    
                    </div>
                
                    <div v-if="loan" class="w-[calc(100%_-_4rem)] flex  items-center justify-between ml-4">
                    <div>
                            <label for="" class="block text-sm font-semibold text-gray-700">{{loan.borrower.name}}</label>
                            <label for="" class="block text-sm text-gray-700">{{`${loan.borrower.phone} / ${loan.borrower.email}`}}</label>
                    </div>  
                    
                    </div>
                    

                </div>

            <div class="flex justify-center">
            <div class="mb-2 w-full">
                <label class="block mb-2">Reference Number</label>
                <div class="input-group relative flex flex-wrap items-stretch w-full mb-4">
                <input type="search" v-model="form.reference_number" class="form-control relative flex-auto min-w-0 block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" disabled aria-label="Search" aria-describedby="button-addon2">
                <button @click="toggleModal(true)" class="btn inline-block px-6 py-2.5 bg-gray-400 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-500 hover:shadow-lg focus:bg-gray-500  focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-500 active:shadow-lg transition duration-150 ease-in-out flex items-center" type="button" id="button-addon2">
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" class="w-4" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
                    </svg>
                </button>
                </div>
            </div>
            </div>

            <div v-if="loan" class="flex justify-center">
                <div class="mb-2 w-full">
                    <label class="block mb-2">Due Date</label>
                    <div class="input-group relative flex flex-wrap items-stretch w-full mb-2">
                    <input type="text" v-model="form.due_date" class="form-control relative flex-auto min-w-0 block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" disabled aria-label="Search" aria-describedby="button-addon2">
                        <button @click="toggleDueDatesModal(true)" class="btn inline-block px-6 py-2.5 bg-gray-400 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-500 hover:shadow-lg focus:bg-gray-500  focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-700 active:shadow-lg transition duration-150 ease-in-out flex items-center" type="button" id="button-addon2">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" class="w-4" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
                            </svg>
                        </button>
                    </div>
                    <small class="text-alert-danger mb-1" v-for="error in errors.due_date" >{{ error }}</small>
                </div>
            </div>  

        <BaseInput
            v-if="loan"    
            :label="`Collection Amount`"
             v-model="loan.collection_amount"
            disabled                        
        /> 
        
        <BaseInput
            v-if="loan"    
            :label="`Balance`"
             v-model="loan.balance_amount"
            disabled                        
        />  

        <BaseInput       
            :label="`Date`"
             v-model="form.payment_date"
            :type="'date'"   
            :errors="errors.payment_date"                
        />

        <BaseInput
            v-if="loan"    
            :label="`Amount`"
            v-model="form.amount"
            :errors="errors.amount"                
        />  

        <BaseInput  
            v-else  
            :label="`Amount`"     
            type="number"   
            :errors="errors.amount"                
        />

        <BaseInput           
            :label="`Remark`"
            v-model="form.remark"
            :type="'textarea'"  
            :errors="errors.remark"                
        />             


        <button v-if="loan"          
            @click="store"
            type="button"
            data-mdb-ripple="true"
            data-mdb-ripple-color="light"
            class="btn-primary"          
            >
            Submit Payment
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

<Teleport to="body">

    <LoanFinderModal 
        v-if="isOpenFinder" 
        @close="toggleModal" 
        @select="selectedLoan"
    />

    <DueDatesModal
        v-if="isOpenDueDateModal"
        :list="loan.due_dates"
        @select="selectDueDate"
        @close="toggleDueDatesModal"
    />

    <ConfirmPopup
        v-if="confirm" 
        :heading="'Confirm'"
        :message="'The amount value you enter is zero. This will mark this as a failed payment status.'"
        @result="handleConfirmPayment"
    />



</Teleport>


</div>


  
</template>

<script setup>

import Alert from '../Alert.vue'
import BaseInput from '../base/BaseInput.vue'


import useLoans from '../../composable/loans'
import useCalculateInterest from '../../composable/helper/calculateInterest'
import usePayments from '../../composable/payments'
import useFormatter from '../../composable/helper/formater'
import { ref, reactive, onMounted, defineAsyncComponent } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const LoanFinderModal = defineAsyncComponent(()=> import('../modal/LoansModal.vue'))
const DueDatesModal = defineAsyncComponent(()=> import('../modal/DueDatesModal.vue'))
const ConfirmPopup = defineAsyncComponent(() => import('../modal/ConfirmModal.vue'))

const { moneyFormatter } = useFormatter()
const { getLoan, exist, loan } = useLoans()
const { addPayment, isSuccess, errors } = usePayments()
const { calculateInterest } = useCalculateInterest()
const route = useRoute()
const router = useRouter()

const success = 'success'
const danger = 'danger'
const info = 'info'

const isOpenFinder = ref(false)
const isOpenDueDateModal = ref(false)
const confirm = ref(false)

const form = reactive({
    amount : 0,
    remark : null,
    borrower_id : null,
    loan_id : null,
    reference_number : null,
    due_date_id :  null,
    due_date : null,
    payment_date : null,
})

const toggleModal = (state) => {
   isOpenFinder.value = state; 
}

const toggleDueDatesModal = (state) => {
    isOpenDueDateModal.value = state;
}

const handleConfirmPayment = async (state) => {

    if (!state) return confirm.value = false;

    await handleProccessPayment();
    confirm.value = false;
    
}

const store = async () => { 
      
    errors.value = [];

    if (form.payment_date == null) {
        errors.value =  { payment_date : ['Amount value is greater than balance amount']};    
        return;
    }

    if (form.amount == 0) {
        confirm.value = true;
        return;
    }  

    if ( form.amount > loan.value.balance_amount ) { 
        errors.value =  { amount: ['Amount value is greater than balance amount']};      
        return;
    }

    await handleProccessPayment();
    
}

const handleProccessPayment =  async () => {
    form.borrower_id = loan.value.borrower.id;    
    form.loan_id = loan.value.id; 
    await addPayment({...form});    
    if (isSuccess.value === false) return 
    router.push({name : 'payments'})     
}

const selectedLoan = (loan) => {    
   getLoan(loan.id);  
   form.reference_number = loan.loan_number   
}

const selectDueDate = (date) => {
    form.due_date_id = date.id
    form.due_date = date.due_date
}

onMounted(() => {
     if(route.params.loan_id == null) return;
     getLoan(route.params.loan_id)
});

</script>

<script setup>

import { useRoute, useRouter } from 'vue-router';
import { ref, reactive, onMounted, defineAsyncComponent } from 'vue';

import Alert from '../Alert.vue';
import BaseInput from '../base/BaseInput.vue';
import useLoans from '../../composable/loans';
import usePayments from '../../composable/payments';

const DueDatesModal = defineAsyncComponent( ()=> import('../modal/DueDatesModal.vue') );
const ConfirmPopup = defineAsyncComponent( () => import('../modal/ConfirmModal.vue') );
const LoansModal = defineAsyncComponent( () => import('../modal/LoansModal.vue') );

const { getLoan, loan } = useLoans()
const { addPayment, isSuccess, errors } = usePayments()

const route = useRoute()
const router = useRouter()

//states for modal
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
    isOpenDueDateModal.value = state
}

const handleConfirmPayment = async (state) => {
    if (!state) return confirm.value = false
    await handleProccessPayment()
    confirm.value = false;    
}

const store = async () => { 
      
    errors.value = [];

    if (!form.payment_date) {
        errors.value =  { payment_date : ['Please select a payment date']};    
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

<template>
        
<div class="w-2/3 mx-auto">
    <Alert v-if="isSuccess" :alert="'success'" :message="'Payment Successfully created'" />
    <Alert v-if="loan && loan.status == 'approved' " :alert="'danger'" :message="'You cant create payment for this loan, Because is not yet released'" />
    <Alert v-if="errors.message"  :alert="'danger'" :message="errors.message"/>
</div>

<div   class="flex w-full justify-center gap-4">    

    <div  class="bg-white p-6 border border-slate-200/80 shadow-card w-2/3 rounded-3xl mx-auto">
        <h1 class="block text-lg font-bold text-slate-800 tracking-tight mb-6">Create Payment</h1>
    

      <div  class="block bg-white"> 


        <div class="flex items-center mb-5">
                    <div v-if="loan" class="w-14 h-14 shrink-0">
                        <img v-if="loan.borrower.avatar" :src="loan.borrower.avatar" class="rounded-full border border-slate-200 w-14 h-14 object-cover"  alt="Avatar" />
                        <img v-else :src="$defaultAvatarSrc" class="rounded-full border border-slate-200 w-14 h-14 object-cover"  alt="Avatar"/>    
                    </div>
                    <div v-else class="shrink-0"> 
                        <img  :src="$defaultAvatarSrc" class="rounded-full border border-slate-200 w-14 h-14 object-cover"  alt="Avatar"/>    
                    </div>
                
                    <div v-if="loan" class="min-w-0 flex items-center justify-between ml-4">
                    <div>
                            <label for="" class="block text-sm font-semibold text-slate-800">{{loan.borrower.name}}</label>
                            <label for="" class="block text-sm text-slate-500">{{`${loan.borrower.phone} / ${loan.borrower.email}`}}</label>
                    </div>  
                    
                    </div>
                    

                </div>

            <div class="mb-5 w-full">
                <label class="block mb-1.5 text-sm font-medium text-slate-700">Reference Number</label>
                <div class="flex items-stretch w-full">
                    <input
                      type="text"
                      v-model="form.reference_number"
                      class="!rounded-r-none !w-auto flex-1 min-w-0"
                      disabled
                      placeholder="Select a loan"
                      aria-label="Reference Number"
                    >
                    <button
                      @click="toggleModal(true)"
                      class="inline-flex items-center justify-center px-3.5 shrink-0 rounded-r-xl border border-l-0 border-slate-200 bg-slate-50 text-slate-500 hover:bg-brand-50 hover:text-brand-600 transition"
                      type="button"
                      title="Find loan"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </div>

            <div v-if="loan" class="mb-5 w-full">
                <label class="block mb-1.5 text-sm font-medium text-slate-700">Due Date</label>
                <div class="flex items-stretch w-full">
                    <input
                      type="text"
                      v-model="form.due_date"
                      class="!rounded-r-none !w-auto flex-1 min-w-0"
                      disabled
                      placeholder="Select a due date"
                      aria-label="Due Date"
                    >
                    <button
                      @click="toggleDueDatesModal(true)"
                      class="inline-flex items-center justify-center px-3.5 shrink-0 rounded-r-xl border border-l-0 border-slate-200 bg-slate-50 text-slate-500 hover:bg-brand-50 hover:text-brand-600 transition"
                      type="button"
                      title="Find due date"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
                <small class="text-alert-danger mb-1" v-for="error in errors.due_date" >{{ error }}</small>
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
            class="btn-primary"          
            >
            Submit Payment
        </button>

        <button v-else 
            type="button" 
            class="btn-primary pointer-events-none opacity-60"
            disabled>
            Pay
        </button>      


    </div>
</div>

<Teleport to="body">

    <LoansModal 
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


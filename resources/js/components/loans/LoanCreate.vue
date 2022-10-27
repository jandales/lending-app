<template>

    <Alert v-if="errors.message" :alert="'danger'" :message="errors.message"/>  

    <h1 class="block tracking-wider text-lg mb-6 ">Create Loan</h1>
    <h1 class="block tracking-wider text-lg mb-4 ">Borrower</h1>
    <div class="w-full">
        <div class="bg-white p-4 border rounded-md w-full mb-4  h-auto">           
            <div class="flex items-center">
                <div class="mr-4">
                    <div v-if="borrower" class="w-20 h-20">
                        <img v-if="borrower.avatar" :src="borrower.avatar" class="rounded-full border w-16 h-16"  alt="Avatar" />
                        <img v-else :src="$defaultAvatarSrc" class="rounded-full border w-20 h-20"  alt="Avatar"/>
                    </div>
                    <div v-else class="w-20 h-20">
                        <img  :src="$defaultAvatarSrc" class="rounded-full border w-20 h-20"  alt="Avatar"/>
                    </div> 
                </div>    
        
                <div  class="w-full flex justify-between items-center">
                    
                    <div v-if="borrower">
                        <label  for="" class="block text-lg font-semibold text-sky-500 capitalize" :class="{'text-rose-500' : exist}">{{ borrower.name }}</label>
                        <label v-if="!exist" class="text-gray-500">{{ borrower.email }} / {{ borrower.phone }}</label>
                        <label v-else class="text-rose-500">This Borrower has an exist loan</label>
                    </div>                                      
                
                    <span  class="text-sky-500 cursor-pointer" @click="toggleModal(true)">                           
                        Select Borrower
                    </span> 

                </div>

            
            </div> 

        </div>

        <h1 class="block tracking-wider text-lg mb-4">Payment</h1> 

        <div class="bg-white p-4 border rounded-md w-full mb-4 h-auto">
            <BaseSelect
                v-model="form.terms"
                :label="'Terms'"
                :options=paymentTerms
                :errors="errors.terms"
                @change="handleTotalInterest"
                class="py-[10px] capitalize"
            />

            <BaseSelect
                v-model="form.type"
                @change="handleTotalInterest"
                :label="'Type'"
                :options="paymentTypes"
                :errors="errors.type"
                class="py-[10px] capitalize"
            />

            <BaseSelect
                :label="'Interest'"
                :options="filteredInterests"                
                @change="handleTotalInterest"
                v-model="form.interest"
                :errors="errors.interest"
                class="py-[10px] capitalize"
            />
        


        </div>

    </div>
    


    <h1 class="block tracking-wider text-lg mb-4">Loan Info</h1>  
    <div class="bg-white p-4 border rounded-md w-full">
        <div class="block">  
            <BaseInput 
                :id="'effective_at'"
                :type="'date'"
                :label="'Effective Date'"
                :errors="errors.effective_at"
                v-model="form.effective_at"
            />

           

            <BaseInput 
                @input="handleTotalInterest"
                :id="'principal_amount'"
                :type="'number'"
                :label="'Principal Amount'"           
                :errors="errors.principal_amount"
                v-model="form.principal_amount" 
            />

            <BaseInput              
                :id="'interest'" 
                :type="'number'"
                :label="'Total Interest'" 
                :errors="errors.total_interest"
                v-model="form.total_interest"
                :disabled="true"
            />

            <BaseInput 
                :id="'amount'"
                :type="'number'"
                :label="'Total Amount'"
                v-model="form.total_amount"
                :errors="errors.total_amount"
                :disabled="true"
            />  

            <BaseInput 
                :id="'Collection-Amount'" 
                :type="'number'"
                :label="'Collection Amount'" 
                :errors="errors.collection_amount"
                v-model="form.collection_amount"
                :disabled="true"
            />

            <BaseButton 
                v-if="exist"  
                name="Save"         
                disabled  
            />

            <BaseButton
                v-else 
                @click="store" 
                name=" Save"
                :class="{'!bg-gray-700' : exist }"
                :disabled="exist"
            />         
        </div>
    
    </div>
 


<Teleport to="body">
    <ModalSearch v-if="selectBorrowerState" @select="selectBorrower" @close="toggleModal" />
</Teleport>



</template>

<script setup>


import BaseInput from '../base/BaseInput.vue';
import BaseButton from '../base/BaseButton.vue';
import BaseSelect from '../base/BaseSelect.vue';
import useLoans from '../../composable/loans';
import useInterests from '../../composable/interest';

import useCalculation from '../../composable/helper/calculations'
import usePaymentTypes from '../../composable/helper/paymentTypes'
import usePaymentTerms from '../../composable/helper/paymentTerms'

import { reactive,ref, toRefs, onMounted, computed, defineAsyncComponent } from 'vue';
import { useRouter } from 'vue-router';

const Alert = defineAsyncComponent(() => import('../Alert.vue'));
const ModalSearch =  defineAsyncComponent(() =>  import('../Modal/BorrowerSearchModal.vue'));

const { paymentTypes } = usePaymentTypes();
const { paymentTerms } = usePaymentTerms();
const { getInterests, interests } = useInterests();
const { storeLoan, existLoan, loan, errors, isSuccess, exist} = useLoans();
const { calculateTotalInterest, calculateTotalAmount, calculateCollectionAmount } =  useCalculation();

const router = useRouter();
const borrower = ref();
const selectBorrowerState = ref(false);

const form = reactive({ 
    borrower_id : null, 
    terms : null,
    type : null,
    total_interest : 0,
    interest : null,
    collection_amount : 0,
    principal_amount: 0,   
    total_amount : 0, 
    effective_at : null, 
});

const handleTotalInterest = () => { 

    const { principal_amount, interest, terms, type } = toRefs(form)    
    let total= calculateTotalInterest(parseFloat(principal_amount.value), interest.value, terms.value);    
    form.total_interest = total;  

    const total_amount = calculateTotalAmount(parseFloat(principal_amount.value), total);
    form.total_amount = total_amount;

    form.collection_amount = calculateCollectionAmount(total_amount, terms.value, type.value);

}

const toggleModal = (state) => {
    selectBorrowerState.value = state;  
}

const selectBorrower = (person) => {
    existLoan(person.id);  
    form.borrower_id = person.id;
    borrower.value = person; 
}

const store = async () => {

    await storeLoan(form) 

    if (isSuccess.value === true) {
        router.push({name : 'loans.details', params : { id : loan.value.id }});
    }     
}

onMounted(getInterests);


const filteredInterests = computed( () => {
    let formatted = interests.value.map(interest => {
        return {
            name : `${interest.value}%`,
            value : interest.value,
        };     
    })
    return formatted;
});



</script>
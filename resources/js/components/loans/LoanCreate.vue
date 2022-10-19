<template>


    <div class="w-full" v-for="error in errors.message">
                <Alert :alert="'danger'" :message="error"/>
    </div>    
            
    <div  class="w-full" v-if="exist">
            <Alert :alert="'danger'" :message="'This Customer has an exist loan'"/>
    </div>  

    <hi class="block tracking-wider text-lg mb-6 ">Create Loan</hi>
<div class="flex gap-4">
    <div class="w-full md:w-2/6 gap-8">
        <div class="bg-white p-4 border rounded-md w-full mb-4  h-auto">
            <h1 class="block tracking-wider text-lg mb-6 ">Customer</h1>
            <div class="flex items-center mb-6">
                <div class="mr-4">
                    <div v-if="borrower" class="w-20 h-20">
                        <img v-if="borrower.avatar" :src="borrower.avatar" class="rounded-full border w-16 h-16"  alt="Avatar" />
                        <img v-else :src="$defaultAvatarSrc" class="rounded-full border w-20 h-20"  alt="Avatar"/>
                    </div>
                    <div v-else class="w-20 h-20">
                        <img  :src="$defaultAvatarSrc" class="rounded-full border w-20 h-20"  alt="Avatar"/>
                    </div> 
                </div>    
        
                <div  class="w-full flex flex-col">
                
                    <label v-if="borrower" for="" class="block text-sm font-semibold text-gray-700 capitalize">{{ borrower.name }}</label>                    
                
                    <span  class="text-sky-500 cursor-pointer" data-bs-toggle="modal" data-bs-target="#exampleModalLg">                           
                        Find Customer
                    </span> 

                </div>

             
            </div> 

        </div>

        <div class="bg-white p-4 border rounded-md w-full  h-auto">
            <h1 class="block tracking-wider text-lg mb-6 ">Payment</h1>           

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
         


        </div>

    </div>
   


<div class="bg-white p-4 border rounded-md w-full md:w-4/6">
    <div class="block bg-white">                   
        <h1 class="block tracking-wider text-lg mb-6 ">Loan Info</h1>  

        <BaseInput 
            :id="'effective_at'"
            :type="'date'"
            :label="'Effective Date'"
            :errors="errors.effective_at"
            v-model="form.effective_at"
        />

        <BaseSelect
            :label="'Interest'"
            :options="filteredInterests"                
            @change="handleTotalInterest"
            v-model="form.interest"
            :errors="errors.interest"
            class="py-[10px] capitalize"
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
        />         
    </div>
   
</div>
</div>




<BorrowersModal @selectBorrower="selectBorrower"></BorrowersModal>

</template>

<script setup>
import BorrowersModal from '../Modal/BorrowersModal.vue'
import Alert from '../Alert.vue';
import BaseInput from '../base/BaseInput.vue';
import BaseButton from '../base/BaseButton.vue';
import BaseSelect from '../base/BaseSelect.vue';
import useLoans from '../../composable/loans';
import useInterests from '../../composable/interest';
import useCalculation from '../../composable/helper/calculations'
import { reactive,ref, toRefs, onMounted, computed } from 'vue';
import { useRouter } from 'vue-router';

const { getInterests, interests } = useInterests();
const { storeLoan, existLoan, loan, errors, isSuccess, exist} = useLoans();
const { calculateTotalInterest, calculateTotalAmount, calculateCollectionAmount } =  useCalculation();

const router = useRouter();

const borrower = ref();

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

const paymentTerms = [
    { name : `${1} Month`, value : 1 },
    { name : `${2} Months`, value : 2 },
    { name : `${3} Months`, value : 3 },
    { name : `${4} Months`, value : 4 },
    { name : `${5} Months`, value : 5 },
    { name : `${6} Months`, value : 6 },
    { name : `${7} Months`, value : 7 },
    { name : `${8} Months`, value : 8 },
    { name : `${9} Months`, value : 9 },
    { name : `${10} Months`, value : 10 },
    { name : `${11} Months`, value : 11 },
    { name : `${12} Months`, value : 12 },
]

const paymentTypes = [
    { name :  'Daily', value : 'daily'},
    { name :  'Weekly', value : 'weekly'},
    { name :  '15Days', value :'15Days'},
    { name :  'Monthly', value :'monthly'},
]

const handleTotalInterest = () => { 

    const { principal_amount, interest, terms, type } = toRefs(form)
    
    let total= calculateTotalInterest(parseFloat(principal_amount.value), interest.value, terms.value);    
    form.total_interest = total;  

    const total_amount = calculateTotalAmount(parseFloat(principal_amount.value), total);
    form.total_amount = total_amount;

    form.collection_amount = calculateCollectionAmount(total_amount, terms.value, type.value);

}

const selectBorrower = (person) => {

    form.borrower_id = person.id;

    borrower.value = person;

    existLoan(person.id); 

}

const store = async () => {

    await storeLoan(form) 

    if(isSuccess.value === true){

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
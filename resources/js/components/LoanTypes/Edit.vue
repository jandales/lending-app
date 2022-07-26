<template>
    <div class="w-max border bg-white rounded-md p-4">     
        <hi class="block tracking-wider text-lg mb-8">Edit Type</hi>
        <div class="block  w-80">
            <form v-if="loanType">         
                <BaseInput
                    :type="'text'"
                    :id="'type'"
                    :label="'Type Name'"
                    :errors="errors.type"
                    v-model="loanType.type"
                />

               <BaseInput
                    :type="'text'"
                    :id="'description'"
                    :label="'Description'"                  
                    v-model="loanType.description"
                />
                
                <BaseInput
                    :type="'text'"
                    :id="'interest'"
                    :label="'Interest (%)'"
                    :errors="errors.interest"
                    v-model="loanType.interest"
                />  
                
                <BaseInput
                    v-model="loanType.amount_to_pay"
                    :type="number"        
                    :id="exampleFormControlInput3"
                    :label="'Amount to pay'"           
                    :errors="errors.amount_to_pay"
                />
 
                <BaseInput
                    v-model="loanType.due_type"
                    :type="number"        
                    :id="exampleFormControlInput3"
                    :label="'Day to pay'"           
                    :errors="errors.due_type"
                />

     

                <button        
                        @click="update"               
                        type="button"
                        data-mdb-ripple="true"
                        data-mdb-ripple-color="light"
                        class="btn-primary">
                        Save
                </button>
               
            </form>          
        </div>
    </div>
</template>

<script setup>
import BaseInput from '../../components/base/BaseInput.vue'
import useLoanTypes from '../../composable/loanType';

import { reactive, onMounted } from 'vue';

    const {  getLoanType, updateLoanType , loanType , errors } = useLoanTypes();

    const update = async () => {        
        await updateLoanType();       
    }

    onMounted(() => {
         getLoanType()
    });




</script>
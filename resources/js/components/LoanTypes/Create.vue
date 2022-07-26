<template>
<div class="bg-white p-4 border rounded-md w-max">
      <div class="block bg-white w-80">     
        <hi class="block tracking-wider text-lg mb-6 ">Create new Type</hi>

        <BaseInput
            :label="`Type Name`"
            v-model="form.type"
            :type="text"        
            :id="typename"
            :errors="errors.type"                
        />   

        <BaseInput
            v-model="form.description"
            :type="`text`"        
            :id="description"
            :label="'Description'" 
        />  

        <BaseInput
            v-model="form.interest"
            :type="number"        
            :id="exampleFormControlInput3"
            :label="'Interest %'"           
            :errors="errors.interest"
        />

        <BaseInput
            v-model="form.amount_to_pay"
            :type="number"        
            :id="exampleFormControlInput3"
            :label="'Amount to pay'"           
            :errors="errors.amount_to_pay"
        />

        <BaseInput
            v-model="form.due_type"
            :type="number"        
            :id="exampleFormControlInput3"
            :label="'Days to pay'"           
            :errors="errors.due_type"
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
  
</template>

<script setup>
import BaseInput from '../../components/base/BaseInput.vue'
import useLoanTypes from '../../composable/loanType';
import { reactive } from 'vue';

    const { storeLoanType, errors } = useLoanTypes();
  

    const form = reactive({
        type : null,
        interest : 0,
        amount_to_pay : 0,
        due_type : 0,
        description : null,
    });

    const store = async () => {        
        await storeLoanType({...form});       
    }


</script>
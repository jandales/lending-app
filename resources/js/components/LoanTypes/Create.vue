<template>
    <div class="block bg-white max-w-sm">     
        <hi class="block tracking-wider text-lg mb-8">Create new Type</hi>
        <div class="form-group mb-6">
            <label 
                    for="exampleFormControlInpu3" 
                    class="form-label inline-block mb-2 text-gray-700">
                    Type Name
            </label>
            <input
                v-model="form.type"
                type="text"        
                id="exampleFormControlInput3"
                placeholder="Type Name"
            />
             <small class="text-alert-danger" v-for="error in errors.type">{{ error }}</small>
        </div>

        <div class="form-group mb-6">
            <label 
                    for="exampleFormControlInpu3" 
                    class="form-label inline-block mb-2 text-gray-700">
                    Description
            </label>
            <input
                v-model="form.description"
                type="text"        
                id="exampleFormControlInput3"
                placeholder="Description"
            />
        </div>

        <div class="form-group mb-6">
            <label 
                    for="exampleFormControlInpu3" 
                    class="form-label inline-block mb-2 text-gray-700">
                    Interest
            </label>
            <input
                v-model="form.interest"
                type="number"        
                id="exampleFormControlInput3"
                placeholder="Interest"
            />
             <small class="text-alert-danger" v-for="error in errors.interest" >{{ error }}</small>

           
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
</template>

<script setup>
import useLoanTypes from '../../composable/loanType';
import { reactive } from 'vue';

    const { storeLoanType, errors } = useLoanTypes();
  

    const form = reactive({
        'type' : '',
        'interest' : '',
        'description' : ''
    });

    const store = async () => {        
        await storeLoanType({...form});       
    }


</script>
<template>
    <div class="w-max border bg-white rounded-md p-4">     
        <hi class="block tracking-wider text-lg mb-8">Edit Type</hi>
        <div class="block  w-80">
            <form v-if="loanType">
                <div class="form-group mb-6">
                    <label for="exampleInputPassword1" class="form-label inline-block mb-2 text-gray-700">Name</label>
                    <input type="text"
                        v-model="loanType.type"
                        id="exampleInputPassword1"
                        placeholder="Name">
                    <small class="text-alert-danger" v-for="error in errors.type" >{{ error }}</small>
                </div>

                <div class="form-group mb-6">
                    <label for="exampleInputPassword1" class="form-label inline-block mb-2 text-gray-700">Description</label>
                    <input type="text"
                        v-model="loanType.description"
                        id="exampleInputPassword1"
                        placeholder="Description">                        
                </div>

                <div class="form-group mb-6">
                    <label for="exampleInputPassword1" class="form-label inline-block mb-2 text-gray-700">Interest</label>
                    <input type="text"
                        v-model="loanType.interest"
                        id="exampleInputPassword1"
                        placeholder="Interest">
                    <small class="text-alert-danger" v-for="error in errors.interest" >{{ error }}</small>
                </div>

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
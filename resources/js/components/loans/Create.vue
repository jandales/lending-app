<template>

<div class="bg-white p-4 border rounded-md w-max">
      <div class="block bg-white w-80">     
        <hi class="block tracking-wider text-lg mb-6 ">Create Loan</hi>
 
           
         <div class="form-group mb-6"> 
            <div class="flex justify-between">
                 <label 
                    for="exampleFormControlInpu3" 
                    class="form-label inline-block mb-2 text-gray-700">
                    Customer
            </label>    
             <label for="" class="ml-auto cursor-pointer mb-2 text-sm" data-bs-toggle="modal" data-bs-target="#exampleModalLg">Find Customers</label>      
            </div>
            <input
                v-model="form.type"
                type="text"        
                id="exampleFormControlInput3"
                placeholder=""
            />
            
             <!-- <small class="text-alert-danger" v-for="error in errors.type">{{ error }}</small> -->
        </div>
     


           
    <div class="form-group mb-6">
          <label for="exampleInputPassword1" class="form-label inline-block mb-2 text-gray-700">Loan Type</label>

    <select class="form-select appearance-none
      block
      w-full
      px-3
      py-1.5
      text-base
      font-normal
      text-gray-700
      bg-white bg-clip-padding bg-no-repeat
      border border-solid border-gray-300
      rounded
      transition
      ease-in-out
      m-0
      focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label="Default select example">
        <option selected>Select</option>
        <option v-for="loanType in loanTypes" :value="loanType.interest">{{loanType.type }}</option>
    </select>
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
           
             <!-- <small class="text-alert-danger" v-for="error in errors.interest" >{{ error }}</small> -->

           
        </div>

         <div class="form-group mb-6">
             <label 
                    for="exampleFormControlInpu3" 
                    class="form-label inline-block mb-2 text-gray-700">
                    Amount
            </label>
            <input
                v-model="form.interest"
                type="number"        
                id="exampleFormControlInput3"
                placeholder="Interest"
            />
           
             <!-- <small class="text-alert-danger" v-for="error in errors.interest" >{{ error }}</small> -->

           
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




<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="exampleModalLg" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-lg relative w-auto pointer-events-none">
    <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
      <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
        <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLgLabel">
          Large modal
        </h5>
        <button type="button"
          class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
          data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body relative p-4">
        ...
      </div>
    </div>
  </div>
</div>


  
</template>

<script setup>
import useLoanTypes from '../../composable/loanType';
import { reactive, onMounted } from 'vue';

    const { getLoanTypes, loanTypes } = useLoanTypes();
  

    const form = reactive({
        'type' : '',
        'interest' : '',
        'description' : ''
    });

    onMounted(getLoanTypes)


</script>
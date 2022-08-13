<template>
<section class="h-screen">
  <div class="px-6 h-full flex justify-center items-center text-gray-800"> 
      <div class="md:w-2/6 mb-12 md:mb-0">
        <form>
          <div class="flex flex-row items-center justify-center py-4">
            <h1 class="text-[2rem] mb-0 font-bold">Forgot Password</h1>   
          </div>

          <!-- Email input -->
          <div class="mb-6">
            <label for=""  class="form-label inline-block mb-2 text-gray-700">Please Enter your email Address</label>
            <input
            name="email"
             v-model="email"
              type="email"
              class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
              id="exampleFormControlInput2"
              placeholder="Email address"
            />
            <small class="text-alert-danger" v-for="error in errors.email">{{ error }}</small>
            </div>
          
          <div class="text-center lg:text-left mb-6">
            <button
            @click.prevent="forgotPassword"
              type="button"
              class="inline-block w-full px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
            >
              Submit
            </button>          
          </div>
            <div class="flex justify-between items-center mb-6">
            <!-- <div class="form-group form-check">
              <input
              
                type="checkbox"
                class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                id="exampleCheck2"
              />
             
              <label class="form-check-label inline-block text-gray-800" for="exampleCheck2"
                >Remember me</label
              >
            </div> -->
            <router-link :to="{name : 'login' }" class="text-gray-800 text-sm cursor-pointer hover:text-sky-500">Back to Login</router-link>
          </div>
        </form>
      </div>  
  </div>
</section>
</template>
<script setup>
import { ref } from 'vue';
import useForgotPassword from '../composable/auth/forgotpassword.js';


const { userForgotPassword, errors } = useForgotPassword();

const email = ref()

const forgotPassword = async() => {
  await userForgotPassword({email : email.value })   
}


</script>
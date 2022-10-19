<template>
<section class="h-screen">
  <div class="px-6 h-full flex justify-center items-center text-gray-800"> 
      <div class="w-full md:w-2/6 mb-12 md:mb-0">
        <form>
          <Alert v-if="errors.message" :alert="'danger'" :message="errors.message" />

          <div class="flex flex-row items-center justify-center py-4">
            <h1 class="text-[2rem] mb-0 font-bold">Login</h1>   
          </div>

          <!-- Email input -->
            <BaseInput 
              :id="'email'"
              :type="'email'"
              :label="'Email'"
              :errors="errors.password"
              v-model="email"
              placeholder="Email"
            />

            <BaseInput 
              :id="'password'"
              :type="'password'"
              :label="'Password'"
              :errors="errors.password"
              v-model="password"
              placeholder="Password"
            />         

          <div class="text-center lg:text-left mb-6">
            <button
              @click.prevent="login"
              type="button"
              class="inline-block w-full px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
               >
              <div v-if="isLoading" class="spinner-border animate-spin inline-block w-4 h-4 border-4 rounded-full" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <label v-else for="">Login</label>               
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
            <!-- <router-link :to="{name : 'forgot.password' }" class="text-gray-800 text-sm cursor-pointer hover:text-sky-500">Forgot password?</router-link> -->
          </div>
        </form>
      </div>  
  </div>

</section>
</template>
<script setup>

import { ref, defineAsyncComponent } from 'vue';
import useUser from '../composable/user';
import BaseInput from '../components/base/BaseInput.vue';

const Alert = defineAsyncComponent(
  () =>  import('../components/Alert.vue')
);

const { userlogin, isLoading, errors } = useUser();

const email = ref('admin@gmail.com')
const password = ref('password')

const login = async() => {
  await userlogin({email : email.value, password : password.value })   
}


</script>
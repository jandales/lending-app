<template>
<section class="h-screen relative overflow-hidden bg-canvas">
  <div class="absolute inset-0 brand-gradient opacity-[0.12]"></div>
  <div class="relative px-6 h-full flex justify-center items-center">
      <div class="w-full max-w-md bg-white rounded-3xl shadow-float border border-white p-9">
        <form>
          <div class="flex flex-col items-center py-2 mb-8">
            <div class="w-14 h-14 rounded-2xl brand-gradient flex items-center justify-center shadow-glow mb-4">
              <span class="text-white font-bold text-2xl">E</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Forgot password</h1>
            <p class="text-sm text-slate-400 mt-1">We'll email you a reset link</p>
          </div>

          <div class="mb-5">
            <label for="" class="inline-block mb-1.5 text-sm font-medium text-slate-700">Email address</label>
            <input
            name="email"
             v-model="email"
              type="email"
              id="exampleFormControlInput2"
              placeholder="Email address"
            />
            <small class="text-alert-danger" v-for="error in errors.email">{{ error }}</small>
            </div>
          
          <div class="text-center lg:text-left mb-4">
            <button
            @click.prevent="forgotPassword"
              type="button"
              class="btn-primary w-full !py-3"
            >
              Submit
            </button>          
          </div>
            <div class="flex justify-center items-center">
            <router-link :to="{name : 'login' }" class="text-sm text-slate-500 hover:text-brand-600">Back to Login</router-link>
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

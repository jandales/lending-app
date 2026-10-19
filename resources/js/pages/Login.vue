<template>
<section class="h-screen relative overflow-hidden bg-canvas">
  <div class="absolute inset-0 brand-gradient opacity-[0.12]"></div>
  <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-brand-400/20 blur-3xl"></div>
  <div class="absolute -bottom-32 -left-24 w-[28rem] h-[28rem] rounded-full bg-emerald-300/20 blur-3xl"></div>
  <div class="relative px-6 h-full flex justify-center items-center">
      <div class="w-full max-w-md bg-white rounded-3xl shadow-float border border-white p-9">
        <form>
          <Alert v-if="errors.message" :alert="'danger'" :message="errors.message" />

          <div class="flex flex-col items-center py-2 mb-8">
            <div class="w-14 h-14 rounded-2xl brand-gradient flex items-center justify-center shadow-glow mb-4">
              <span class="text-white font-bold text-2xl">E</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Welcome back</h1>
            <p class="text-sm text-slate-400 mt-1">Sign in to Etto Lending</p>
          </div>

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

          <div class="text-center lg:text-left mb-2 mt-2">
            <button
              @click.prevent="login"
              type="button"
              class="btn-primary w-full !py-3"
               >
              <div v-if="isLoading" class="spinner-border animate-spin inline-block w-4 h-4 border-4 rounded-full" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <label v-else for="">Sign in</label>               
            </button>          
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

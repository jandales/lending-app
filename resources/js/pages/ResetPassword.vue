<template>
<section class="h-screen relative overflow-hidden bg-canvas">
  <div class="absolute inset-0 brand-gradient opacity-[0.12]"></div>
  <div class="relative px-6 h-full flex justify-center items-center">
      <div v-if="data" class="w-full max-w-md bg-white rounded-3xl shadow-float border border-white p-9">
        <div v-if="success" class="rounded-2xl py-3.5 px-4 mb-4 text-sm font-medium border bg-emerald-50 text-emerald-700 border-emerald-100" role="alert">
          {{ success }}
        </div>
        <form>
          <div class="flex flex-col items-center py-2 mb-8">
            <div class="w-14 h-14 rounded-2xl brand-gradient flex items-center justify-center shadow-glow mb-4">
              <span class="text-white font-bold text-2xl">E</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Reset password</h1>
          </div>

          <div class="mb-5">
            <label for="" class="inline-block mb-1.5 text-sm font-medium text-slate-700">New password</label>
            <input
            name="password"
              v-model="form.password"
              type="password"
              id="exampleFormControlInput2"
              placeholder="New Password"
            />
            <small class="text-alert-danger" v-for="error in errors.password">{{ error }}</small>
            </div>

             <div class="mb-5">
                <label for="" class="inline-block mb-1.5 text-sm font-medium text-slate-700">Confirm password</label>
                <input
                  name="password_confirmation"
                  v-model="form.password_confirmation"
                  type="password"
                  id="exampleFormControlInput2"
                  placeholder="Confirm Password"
                />
                <small class="text-alert-danger" v-for="error in errors.password_confirmation">{{ error }}</small>
            </div>
            <div class="flex justify-center items-center mb-4">
              <router-link :to="{name:'login'}" class="text-sm text-slate-500 hover:text-brand-600">Back to Login</router-link>
            </div> 
          <div class="w-full text-left">
            <button
              @click.prevent="handleSumbit"
              type="button"
              class="btn-primary w-full !py-3">
              Change password
            </button>          
          </div>
        </form>
      </div>  
  </div>
</section>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from 'vue';
import useResetPassword from '../composable/auth/resetpassword';
import { useRoute } from 'vue-router';

const route = useRoute();

const { userResetPassword, errors, success, checkToken, data } = useResetPassword();

const form  = reactive({
  password : '',
  password_confirmation : '',
})

const handleSumbit  = async() => {
      await userResetPassword(form); 
}

onMounted(() => {
  checkToken(route.params.token);
})

</script>

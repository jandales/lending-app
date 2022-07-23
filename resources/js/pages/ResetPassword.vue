<template>
<section  class="h-screen">
  <div class="px-6 h-full flex justify-center items-center text-gray-800"> 
      <div v-if="data" class="md:w-2/6 mb-12 md:mb-0">
        <div v-if="success" class="bg-green-100 rounded-lg py-5 px-6 mb-4 text-base text-green-700 mb-3" role="alert">
          {{ success }}
        </div>
        <form>
          <div class="flex flex-row items-center justify-center py-4">
            <h1 class="text-[2rem] mb-0 font-bold">Reset Password</h1>   
          </div>

          <!-- Email input -->
          <div class="mb-6">
            <label for=""  class="form-label inline-block mb-2 text-gray-700">New Password</label>
            <input
            name="password"
              v-model="form.password"
              type="password"
              class="form-control block w-full px-4 py-2 text-sm font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
              id="exampleFormControlInput2"
              placeholder="New Password"
            />
            <small class="text-alert-danger" v-for="error in errors.password">{{ error }}</small>
            </div>

             <div class="mb-6">
                <label for=""  class="form-label inline-block mb-2 text-gray-700">Confirm Password</label>
                <input
                  name="password_confirmation"
                  v-model="form.password_confirmation"
                  type="password"
                  class="form-control block w-full px-4 py-2 text-sm font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                  id="exampleFormControlInput2"
                  placeholder="Confirm Password"
                />
                <small class="text-alert-danger" v-for="error in errors.password_confirmation">{{ error }}</small>
            </div>
            <div class="flex justify-between items-center mb-6">
              <router-link :to="{name:'login'}" class="text-sm">Back to Login</router-link>
            </div> 
          <div class="w-full text-left">
            <button
              @click.prevent="handleSumbit"
              type="button"
              class="inline-block w-full  px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
              Change Password
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

// const form = computed(() => {
//     return {
//         email : data.value.email,
//         token : data.value.token,
//         password : '',
//         password_confirmation : '',
//     }
    
// })







</script>
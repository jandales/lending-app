<template>  
    <div class="w-full bg-white rounded-md border p-4"> 
        <div v-if="success" class="bg-green-100  rounded-lg py-5 px-6 mb-4 text-base text-green-700" role="alert">
            {{ success }}
        </div>
     
         <div v-for="message in errors.message" class="bg-red-100  rounded-lg py-5 px-6 mb-4 text-base text-red-700" role="alert">
            {{ message }}
        </div>
        <h1 class="text-xl">Change Password</h1>
        <form @submit.prevent="handleSubmit" class="my-6 ">
            <div class="form-floating mb-6">                
                <input type="password" name="password" v-model="form.current_password" placeholder="Current password">
                <label for=""  class="form-label inline-block mb-2 text-gray-700">Current Password</label>
                <small class="text-alert-danger" v-for="error in errors.current_password">{{ error }}</small>
            </div>  

             <div class="form-floating mb-6">                
                <input type="password" name="password" v-model="form.password" placeholder="New password">
                <label for=""  class="form-label inline-block mb-2 text-gray-700">Password</label>
                <small class="text-alert-danger" v-for="error in errors.password">{{ error }}</small>
            </div>

            <div class="form-floating mb-6">                
                <input type="password" v-model="form.password_confirmation" placeholder="Confirm Password">
                <label for=""  class="form-label inline-block mb-2 text-gray-700">Confirm Password</label>
                <small class="text-alert-danger" v-for="error in errors.password_confirmation">{{ error }}</small>
            </div>  

         <button  type="submit" class="btn-primary">Update Password</button>
        </form>
         
       
       
    </div>
</template>

<script setup>
    import { ref } from 'vue';
    import useUser from '../../composable/user';
    const { changePassword, errors, success } = useUser();
    const form = ref({
        current_password : null,
        password : null,
        password_confirmation : null,
    })
    const handleSubmit = async() => {
        await changePassword({...form});        
        form.value.current_password = null,
        form.value.password = null;
        form.value.password_confirmation = null;
    }
</script>
<template>
    <div v-if="success" class="bg-green-100 rounded-lg py-5 px-6 mb-4 text-base text-green-700" role="alert">
            {{ success }}
    </div>
    <h1 class="text-xl">Change Password</h1>
    
    <div class="w-1/2 mt-4">
          
        <div class="form-group mb-6">
            <input type="password" 
                name="password"
                v-model="form.password"       
                placeholder="Email address">
                <small class="text-alert-danger" v-for="error in errors.password">{{ error }}</small>
        </div>
        <div class="form-group mb-6">
        <input type="password"
        v-model="form.password_confirmation"       
        placeholder="Password">
        <small class="text-alert-danger" v-for="error in errors.password_confirmation">{{ error }}</small>
        </div>
    
        <button @click="handleSubmit" type="submit" class="
        w-full
        px-6
        py-2.5
        bg-blue-600
        text-white
        font-medium
        text-xs
        leading-tight
        uppercase
        rounded
        shadow-md
        hover:bg-blue-700 hover:shadow-lg
        focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
        active:bg-blue-800 active:shadow-lg
        transition
        duration-150
        ease-in-out">Change Password</button>
       
    </div>
</template>

<script setup>
    import { reactive } from 'vue';
    import useUser from '../../composable/user';
    const { changePassword, errors, success } = useUser();
    const form = reactive({
        password : null,
        password_confirmation : null,
    })
    const handleSubmit = async() => {
        await changePassword({...form});
    }
</script>
<template>  
    <div class="w-full bg-white rounded-3xl shadow-card border border-white p-6"> 
        <div v-if="success" class="rounded-2xl py-3.5 px-4 mb-4 text-sm font-medium border bg-emerald-50 text-emerald-700 border-emerald-100" role="alert">
            {{ success }}
        </div>
     
         <div v-for="message in errors.message" :key="message" class="rounded-2xl py-3.5 px-4 mb-4 text-sm font-medium border bg-rose-50 text-rose-700 border-rose-100" role="alert">
            {{ message }}
        </div>
        <h1 class="text-xl font-bold text-slate-800 tracking-tight mb-6">Change Password</h1>
        <form @submit.prevent="handleSubmit">
            <BaseInput
                label="Current Password"
                type="password"
                name="current_password"
                v-model="form.current_password"
                :errors="errors.current_password"
            />

            <BaseInput
                label="Password"
                type="password"
                name="password"
                v-model="form.password"
                :errors="errors.password"
            />

            <BaseInput
                label="Confirm Password"
                type="password"
                name="password_confirmation"
                v-model="form.password_confirmation"
                :errors="errors.password_confirmation"
            />

         <button type="submit" class="btn-primary">Update Password</button>
        </form>
    </div>
</template>

<script setup>
    import { ref } from 'vue';
    import BaseInput from '../base/BaseInput.vue';
    import useUser from '../../composable/user';

    const { changePassword, errors, success } = useUser();
    const form = ref({
        current_password: null,
        password: null,
        password_confirmation: null,
    });

    const handleSubmit = async () => {
        await changePassword({ ...form.value });
        form.value.current_password = null;
        form.value.password = null;
        form.value.password_confirmation = null;
    };
</script>

<template>
   <div class="w-full flex items-center bg-white rounded-3xl shadow-card border border-white p-6 mb-5">
     <img v-if="form.avatarPreview" :src="form.avatarPreview" class="rounded-full border-2 border-brand-100 w-20 h-20 object-cover"  alt="Avatar" />
     <img v-else :src="$defaultAvatarSrc" class="rounded-full border-2 border-brand-100 w-20 h-20 object-cover"  alt="Avatar" />
     <div class="ml-4">
        <label for="" class="block font-bold text-slate-800 text-lg">{{ form.name }}</label>
        <label class="text-brand-600 cursor-pointer text-sm hover:underline hover:text-brand-700">
            <input @change="upload($event)" name="avatar" type="file" class="hidden" accept="image/*" />
            Change avatar
        </label>
     </div>
   </div>
   <div class="w-full bg-white rounded-3xl shadow-card border border-white p-6">
        <div v-if="success" class="rounded-2xl py-3.5 px-4 mb-4 text-sm font-medium border bg-emerald-50 text-emerald-700 border-emerald-100" role="alert">
                {{ success }}
        </div>
        <h1 class="text-xl font-bold text-slate-800 tracking-tight mb-6">Personal information</h1>
        
        <form @submit.prevent="updateProfile">
            <BaseInput
                label="Name"
                v-model="form.name"
                :errors="errors.name"
            />

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <BaseInput
                    label="Email"
                    type="email"
                    v-model="form.email"
                    :disabled="true"
                    :errors="errors.email"
                />
                <BaseInput
                    label="Phone Number"
                    v-model="form.phone"
                    :errors="errors.phone"
                />
            </div>

            <BaseInput
                label="Address"
                v-model="form.address"
                :errors="errors.address"
            />

            <button type="submit" class="btn-primary">Update Profile</button>
        </form>
   </div>
</template>

<script setup>
    import { onMounted, reactive, watch } from 'vue';
    import BaseInput from '../base/BaseInput.vue';
    import useUser from '../../composable/user';
    
    const { getUser, updateUser, uploadAvatar, user, errors, success } = useUser();

    const form = reactive({
        name: '',
        email: '',
        phone: '',
        address: '',
        avatarPreview: null,
    });

    const syncForm = (data) => {
        if (!data) return;
        form.name = data.name ?? '';
        form.email = data.email ?? '';
        form.phone = data.phone ?? '';
        form.address = data.address ?? '';
        form.avatarPreview = data.avatar ?? null;
    };

    watch(user, (value) => syncForm(value), { immediate: true });

    const updateProfile = async () => {
        await updateUser({
            value: {
                name: form.name,
                email: form.email,
                phone: form.phone,
                address: form.address,
            },
        });
    };

    const upload = async (event) => {
        const file = event.target.files?.[0];
        if (!file) return;
        await uploadAvatar({ avatar: file });
    };

    onMounted(getUser);
</script>

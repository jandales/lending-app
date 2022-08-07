<template>
   <div class="w-full flex items-center bg-white rounded-md border p-4 mb-4">
     <img v-if="profile.avatar" :src="profile.avatar" class="rounded-full border w-20 h-20"  alt="Avatar" />
     <img v-else src="/img/avatar/avatar.png" class="rounded-full border w-20 h-20"  alt="Avatar" />
     <div class="ml-4">
        <label for="" class="block">{{ profile.name }}</label>
        <label class="text-blue-600 cursor-pointer text-sm hover:underline hover:text-blue-700">
            <input @change="upload($event)"  v-on="profile.avatar" name="avatar" type="file" class="hidden" />
            Change Avatar
        </label>
     </div>
   </div>
   <div class="w-full bg-white rounded-md border p-4">
        <div v-if="success" class="bg-green-100  rounded-lg py-5 px-6 mb-4 text-base text-green-700" role="alert">
                {{ success }}
        </div>
        <h1 class="text-xl">Profile</h1>
        
        <form @submit.prevent="updateProfile" v-if="profile">
           
        
                <div class="form-floating mt-6 mb-6">
                    <input type="text"  v-model="profile.name"  placeholder="First Name">
                    <label for="floatingInput"  class="text-gray-700">Name</label>
                     <small class="text-alert-danger" v-for="error in errors.name">{{ error }}</small>
                </div>  

         
            <div class="grid grid-cols-2 gap-4">
                <div class="form-floating mb-6">
                    <input type="email"  disabled  v-model="profile.email"  placeholder="Email Address">
                    <label for="floatingInput"  class="text-gray-700">Email</label>
                     <small class="text-alert-danger" v-for="error in errors.email">{{ error }}</small>
                </div>             
                <div class="form-floating mb-6">                    
                    <input type="text" v-model="profile.phone" placeholder="Phone Number">
                    <label class="text-gray-700">Phone Number</label>
                    <small class="text-alert-danger" v-for="error in errors.phone">{{ error }}</small>
                </div>
            </div>

            <div class="form-floating mb-6">               
                <input type="text" v-model="profile.address" aria-describedby="emailHelp123" placeholder="Address">
                 <label class="text-gray-700">Address</label>
                 <small class="text-alert-danger" v-for="error in errors.phone">{{ error }}</small>
            </div>

            <button  type="submit" class="btn-primary">Update Profile</button>
           
        </form>
   </div>
</template>

<script setup>

    import { onMounted, computed } from 'vue';

    import useUser from '../../composable/user';
    
    const { getUser, updateUser, uploadAvatar, user, errors, success } = useUser();

    const updateProfile = async() => {

        await updateUser(profile)

    }

    const upload = async(event) => {

        const  file = event.target.files[0];

        profile.value.avatar = file; 

        await uploadAvatar({avatar : profile.value.avatar})

    }

    onMounted(getUser())

    const profile = computed(()=> {

        if(user.value ==  null) return {};

        return  {

            name : user.value.name,

            email : user.value.email,

            phone : user.value.phone,

            address : user.value.address, 

            avatar : user.value.avatar, 

        };   
    }) 
   
</script>
<template>
   <div class="bg-white p-4 border rounded-md w-1/2 mx-auto">
        <div class="flex justify-between items-center ">
      <h1 class="text-xl">Create User</h1> 
  </div>
  
   <div class="block bg-white  rounded-md mt-6">
        <form>
             <div class="form-group mb-6">
                <label for="exampleInputPassword1" class="form-label inline-block mb-2 text-gray-700">Name</label>
                <input type="text" 
                    name="email"
                    v-model="form.name"                      
                    id="exampleInputPassword1"
                   >   
                    <small class="text-alert-danger" v-for="error in errors.name">{{ error }}</small>                          
            </div>
            <div class="form-group mb-6">
                <label for="exampleInputPassword1" class="form-label inline-block mb-2 text-gray-700">Email</label>
                <input type="email" 
                    name="email"
                    v-model="form.email"                      
                    id="exampleInputPassword1"
                    >        
                     <small class="text-alert-danger" v-for="error in errors.email">{{ error }}</small>                
            </div>

            <div class="form-group mb-6">
                <label for="exampleInputPassword1" class="form-label inline-block mb-2 text-gray-700">Phone Number</label>
                <input type="number"  
                    v-model="form.phone"   
                    name="phone"                   
                    id="exampleInputPassword1"
                    >
                    <small class="text-alert-danger" v-for="error in errors.phone">{{ error }}</small>
            </div>

            <div class="form-group mb-6">
                <label for="exampleInputPassword1" class="form-label inline-block mb-2 text-gray-700">Address</label>
                <input type="text"
                    name="street"
                    v-model="form.address"
                    id="exampleInputPassword1"
                    >
                    <small class="text-alert-danger" v-for="error in errors.address">{{ error }}</small>
            </div>

            <div class="form-group mb-6">
                <label for="exampleInputPassword1" class="form-label inline-block mb-2 text-gray-700">Password</label>
                <input type="text"
                    name="password"
                    v-model="form.password"
                    id="exampleInputPassword1"
                    >
                    <small class="text-alert-danger" v-for="error in errors.password">{{ error }}</small>
            </div>

            <div class="flex justify-center">
                <div class="mb-6 w-full">
                    <label for="formFile" class="form-label inline-block mb-2 text-gray-700">Role</label>
                    <select name="role" id="" v-model="form.role" class="py-[10px] capitalize">
                        <option value="select" selected>Select Role</option>
                        <option value="2">Employee</option>
                        <option value="1">Admin</option>
                    </select>
                    <small class="text-alert-danger" v-for="error in errors.role">{{ error }}</small>
                </div>

            </div>

            <button      
                    @click="store"                
                    type="button"
                    data-mdb-ripple="true"
                    data-mdb-ripple-color="light"
                    class="btn-primary">
                    <div v-if="isLoading" class="spinner-border animate-spin inline-block w-4 h-4 border-4 rounded-full" role="status">
                            <span class="visually-hidden">Loading...</span>
                    </div>
                    <label v-else for="">Save</label>     
                 
            </button>
               
        </form>
   
    </div>
   </div>  
</template>
<script setup>

import useUsers from '../../composable/users';
import { useRouter } from 'vue-router';
import { reactive, ref } from 'vue';

const   router = useRouter();

const { storeUser, errors, isLoading, isSuccess  } = useUsers();

const form =  reactive({
    name : null,  
    email : null,
    phone : null,
    address : null,
    role : 'select',
    password : 'password'
})

const avatar = ref();



const store = async() => {

    await storeUser({...form});

    if(isSuccess.value === true) {

        router.push({name : 'users'});

    }

}

</script>
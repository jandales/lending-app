<template>
   <div v-if="customer"  class="bg-white p-4 border rounded-md w-max">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl">Edit Customer</h1> 
         </div>
         <div class="block bg-white">
           
        <form>
            <div class="grid grid-cols-2 gap-4">
                
                <div class="form-group mb-6">
                    <label for="exampleInputPassword1" class="text-gray-700">First Name</label>
                    <input type="text"
                        v-model="customer.firstname"
                        name="firstname"
                        id="exampleInput123"
                        aria-describedby="emailHelp123" placeholder="First name">
                        <small class="text-alert-danger" v-for="error in errors.firstname">{{ error }}</small>
                </div>
                <div class="form-group mb-6">
                    <label for="exampleInputPassword1" class="text-gray-700">Last Name</label>
                    <input type="text" 
                        v-model="customer.lastname" 
                         name="lastname"
                        id="exampleInput124"
                        aria-describedby="emailHelp124" placeholder="Last name">
                        <small class="text-alert-danger" v-for="error in errors.lastname">{{ error }}</small>
                </div>
            </div>
            <div class="form-group mb-6">
                <label for="exampleInputPassword1" class="form-label inline-block mb-2 text-gray-700">Email</label>
                <input type="email" 
                    name="email"
                    v-model="customer.email"                      
                    id="exampleInputPassword1"
                    placeholder="Email">                        
            </div>

            <div class="form-group mb-6">
                <label for="exampleInputPassword1" class="form-label inline-block mb-2 text-gray-700">Phone Number</label>
                <input type="number"  
                    name="phone_number"
                    v-model="customer.phone"                      
                    id="exampleInputPassword1"
                    placeholder="Phone Number">
                <small class="text-alert-danger" v-for="error in errors.phone">{{ error }}</small>
            </div>

            <div class="form-group mb-6">
                <label for="exampleInputPassword1" class="form-label inline-block mb-2 text-gray-700">Address</label>
                <input type="text"
                name="address"
                    v-model="customer.address"
                    id="exampleInputPassword1"
                    placeholder="address">
                <small class="text-alert-danger" v-for="error in errors.address">{{ error }}</small>
            </div>

            <div class="flex justify-center">
                    <div class="mb-6 w-full">
                        <label for="formFile" class="form-label inline-block mb-2 text-gray-700">Image</label>
                        <input 
                        @change="onChangeFile($event)"
                        v-on="customer.avatar"
                        class="form-control
                        block
                        w-full
                        px-3
                        py-1.5
                        text-base
                        font-normal
                        text-gray-700
                        bg-white bg-clip-padding
                        border border-solid border-gray-300
                        rounded
                        transition
                        ease-in-out
                        m-0
                        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="file" id="formFile">  
                        <img  v-if="!isImageChange" :src="customer.avatar" class="rounded-full w-32 h-32 mt-4" alt="" srcset=""> 
                        <img  v-else  v-if="image" :src="image" class="rounded-full w-32 h-32 mt-4" alt="Avatar" />
                                                              
                    </div>
            </div>

            <button      
                    @click="update"                
                    type="button"
                    data-mdb-ripple="true"
                    data-mdb-ripple-color="light"
                    class="btn-primary">
                    Save
            </button>
               
        </form>
   
    </div> 
   </div>


    
</template>
<script setup>

import useCustomers from '../../composable/customers';
import { reactive, ref, onMounted, computed} from 'vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();

const { updateCustomer, getCustomer, errors, customer } = useCustomers();
const isImageChange = ref(false);
const image = ref();

const onChangeFile = (event) => {
    const file = event.target.files[0];
    customer.value.avatar = file;
    const reader = new FileReader();
    reader.onload = (e) => {     
       image.value = e.target.result;       
    }
    reader.readAsDataURL(file);  
    isImageChange.value = true;
}

const update = async() => {  
    await updateCustomer(route.params.id, {... customer.value})
}

onMounted(getCustomer(route.params.id));



</script>
<template>
   <div v-if="borrower"  class="bg-white p-4 border rounded-md w-max mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl">Edit Borrower</h1> 
         </div>
         <div class="block bg-white">
           
        <form>
            <div class="grid grid-cols-2 gap-4">
                
                <div class="form-group mb-6">
                    <label for="exampleInputPassword1" class="text-gray-700">First Name</label>
                    <input type="text"
                        v-model="borrower.firstname"
                        name="firstname"
                        id="exampleInput123"
                        aria-describedby="emailHelp123" placeholder="First name">
                        <small class="text-alert-danger" v-for="error in errors.firstname">{{ error }}</small>
                </div>
                <div class="form-group mb-6">
                    <label for="exampleInputPassword1" class="text-gray-700">Last Name</label>
                    <input type="text" 
                        v-model="borrower.lastname" 
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
                    v-model="borrower.email"                      
                    id="exampleInputPassword1"
                    placeholder="Email">                        
            </div>

            <div class="form-group mb-6">
                <label for="exampleInputPassword1" class="form-label inline-block mb-2 text-gray-700">Phone Number</label>
                <input type="number"  
                    name="phone_number"
                    v-model="borrower.phone"                      
                    id="exampleInputPassword1"
                    placeholder="Phone Number">
                <small class="text-alert-danger" v-for="error in errors.phone">{{ error }}</small>
            </div>

            <div class="form-group mb-6">
                <label for="exampleInputPassword1" class="form-label inline-block mb-2 text-gray-700">Address</label>
                <input type="text"
                name="address"
                    v-model="borrower.address"
                    id="exampleInputPassword1"
                    placeholder="address">
                <small class="text-alert-danger" v-for="error in errors.address">{{ error }}</small>
            </div>

            <div class="flex justify-center">
                    <div class="mb-6 w-full">
                        <label for="formFile" class="form-label inline-block mb-2 text-gray-700">Image</label>
                        <input 
                        @change="onChangeFile($event)"
                        v-on="borrower.avatar"
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
                        <img v-if="isImageChange"  :src="image" class="rounded-full w-32 h-32 mt-4" alt="Avatar" />
                        <img v-else-if="borrower.avatar" :src="borrower.avatar" class="rounded-full w-32 h-32 mt-4" alt=""/>                         
                        <img v-else :src="imagesrc" class="rounded-full w-32 h-32 mt-4">
                                                              
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
import useBorrowers from '../../composable/borrowers';
import {  ref, onMounted} from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();

const { updateBorrower, editBorrower, errors, borrower } = useBorrowers();

const isImageChange = ref(false);

const image = ref();

const imagesrc = '/img/avatar/avatar.png'

const onChangeFile = (event) => {

    const file = event.target.files[0];

    borrower.value.avatar = file;

    const reader = new FileReader();

    reader.onload = (e) => {     

       image.value = e.target.result;  

    }

    reader.readAsDataURL(file);  

    isImageChange.value = true;

}

const update = async() => {  

    await updateBorrower(route.params.id, {... borrower.value})

}

onMounted(editBorrower(route.params.id));



</script>

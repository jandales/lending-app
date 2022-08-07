<template>
   <div class="bg-white p-4 border rounded-md w-max mx-auto">
        <div class="flex justify-between items-center ">
      <h1 class="text-xl">Create Borrower</h1> 
  </div>
  
   <div class="block bg-white  rounded-md max-w-2xl mt-6">
        <form>
            <div class="grid grid-cols-2 gap-4">
                <div class="form-group mb-6">
                    <input type="text"
                        v-model="form.firstname"
                        name="firstname"
                        id="exampleInput123"
                        aria-describedby="emailHelp123" placeholder="First name">
                        <small class="text-alert-danger"  v-for="error in errors.firstname">{{ error }}</small>
                </div>
                <div class="form-group mb-6">
                    <input type="text" 
                        name="lastname"
                        v-model="form.lastname" 
                        id="exampleInput124"
                        aria-describedby="emailHelp124" placeholder="Last name">
                       <small class="text-alert-danger" v-for="error in errors.lastname">{{ error }}</small> 
                </div>
            </div>
            <div class="form-group mb-6">
                <label for="exampleInputPassword1" class="form-label inline-block mb-2 text-gray-700">Email</label>
                <input type="email" 
                    name="email"
                    v-model="form.email"                      
                    id="exampleInputPassword1"
                    placeholder="Email">                        
            </div>

            <div class="form-group mb-6">
                <label for="exampleInputPassword1" class="form-label inline-block mb-2 text-gray-700">Phone Number</label>
                <input type="number"  
                    v-model="form.phone"   
                    name="phone"                   
                    id="exampleInputPassword1"
                    placeholder="Phone Number">
                    <small class="text-alert-danger" v-for="error in errors.phone">{{ error }}</small>
            </div>

            <div class="form-group mb-6">
                <label for="exampleInputPassword1" class="form-label inline-block mb-2 text-gray-700">Address</label>
                <input type="text"
                    name="street"
                    v-model="form.address"
                    id="exampleInputPassword1"
                    placeholder="address">
                    <small class="text-alert-danger" v-for="error in errors.address">{{ error }}</small>
            </div>

            <div class="flex justify-center">
                    <div class="mb-6 w-full">
                        <label for="formFile" class="form-label inline-block mb-2 text-gray-700">Image</label>
                        <input 
                        @change="onChangeFile($event)"
                        v-on="form.avatar"
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
                        <img
                            v-if="avatar" 
                            :src="avatar"
                            class="rounded-full w-32 h-32 mt-4"
                            alt="Avatar"
                        />
                    </div>
            </div>

            <button      
                    @click="store"                
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

import { reactive, ref } from 'vue';

const { storeBorrower, errors, } = useBorrowers();

const form =  reactive({
    firstname : '',
    lastname : '',
    email : '',
    phone : '',
    address : '',
    avatar : '',
})

const avatar = ref();


const onChangeFile = (event) => {   

    form.avatar = event.target.files[0];     

    avatar.value  = URL.createObjectURL(event.target.files[0]);

}

const store = async() => {

    await storeBorrower({...form});

}

</script>
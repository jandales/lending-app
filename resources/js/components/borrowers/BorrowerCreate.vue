<template>
   <div class="bg-white p-4 border rounded-md w-full">        
        <PageHeading :title="'Create Borrower'" />    
        <div class="block bg-white  rounded-md mt-6">
            <form>
                <div class="grid grid-cols-2 gap-4">
                    <BaseInput
                        :label="'Firstname'"                       
                        :errors="errors.firstname"
                        name="firstname"
                        v-model="form.firstname"
                    />

                    <BaseInput
                        :label="'Lastname'"
                        :errors="errors.lastname"
                        v-model="form.lastname"                        
                        name="lastname"                       
                    />           
                </div>

                    <BaseInput
                        :label="'Email'"
                        v-model="form.email"  
                        :errors="errors.email"
                        name="email"
                        type="email"
                    />

                    <BaseInput
                        :label="'Phone Number'"
                        id="phone"                                    
                        v-model="form.phone"
                        name="phone"  
                        :errors="errors.phone"
                    />
                    
                    <BaseInput 
                        :label="'Address'"
                        type="text"
                        name="address"
                        v-model="form.address"
                        :errors="errors.address"
                        />


                

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


                <BaseButton  
                    @click="store"
                    name="Create Borrower"
                    :isloading="isLoading" 
                />
                        
                
                    
            </form>

        </div>
   </div>  
</template>
<script setup>
import BaseInput from '../base/BaseInput.vue';
import BaseButton from '../base/BaseButton.vue';
import PageHeading from '../PageHeading.vue';
import useBorrowers from '../../composable/borrowers';

import { reactive, ref } from 'vue';


const { storeBorrower, errors, isLoading, } = useBorrowers();

const form =  reactive({
    firstname : '',
    lastname : '',
    email : '',
    phone : '',
    address : '',
    avatar : '',
    status : 1,
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
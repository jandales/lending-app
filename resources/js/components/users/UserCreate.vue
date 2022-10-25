<template>
   <div class="bg-white p-4 border rounded-md w-full"> 
        <PageHeading :title="'Create User'" />  
        <p class="mt-2 text-gray-400">Password is auto generated and sent to user email</p>
        <div class="block bg-white rounded-md mt-6">
            <form>
                <BaseInput
                    :id="'name'"
                    :name="'name'"
                    :label="'Name'"
                    v-model="form.name"
                    :errors="errors.name"
                />

                <BaseInput
                    :id="'email'"
                    :name="'email'"
                    :label="'Email'"
                    v-model="form.email"
                    :errors="errors.email"
                />

                <BaseInput
                    :id="'phone'"
                    :name="'phone'"
                    :label="'Phone Number'"
                    v-model="form.phone"
                    :errors="errors.phone"
                />   
                
                <BaseInput
                    :id="'phone'"
                    :name="'address'"
                    :label="'Address'"
                    v-model="form.address"
                    :errors="errors.address"
                />   

            <BaseSelect
                :label="'Role'"
                :options="userTypes"
                v-model="form.role"
                :errors="errors.role"
            />                 

                <BaseButton 
                    @click="store"
                    :isLoading="isLoading"
                    :name="'Save'"
                />         
                
            </form>
        </div>
   </div>  
</template>
<script setup>
import PageHeading from '../PageHeading.vue';
import BaseInput from '../base/BaseInput.vue';
import BaseButton from '../base/BaseButton.vue';
import BaseSelect from '../base/BaseSelect.vue';
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
    role : null,   
})

const userTypes = [  
    { name : 'Employee', value : 2},
    { name : 'Admin', value : 1} 
]



const store = async() => {

    try {
        await storeUser({...form});        
        if(isSuccess.value === true){
            router.push({name : 'users'});
        }
    } catch (error) {
        
    } 
}

</script>
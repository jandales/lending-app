<template>
   <div v-if="user" class="bg-white p-4 border rounded-md w-1/2 mx-auto">
        <PageHeading :title="'Edit User'" />  
        <div class="block bg-white  rounded-md mt-6">
            <form>
                <BaseInput 
                    :label="'Name'"
                    :id="'name'"
                    :name="'name'"
                    v-model="user.name"
                    :errors="errors.name"
                />

                <BaseInput 
                    :label="'Email'"
                    :id="'name'"
                    :type="'email'"
                    :name="'email'"
                    v-model="user.email"     
                    :errors="errors.email"
                />

                <BaseInput 
                    :label="'Phone Number'"
                    :id="'phone'"                
                    :name="'phone'"
                    :errors="errors.phone"
                    v-model="user.phone" 
                />  
                
                <BaseInput 
                    :label="'Address'"
                    :id="'address'"                
                    :name="'address'"
                    :errors="errors.address"
                    v-model="user.address" 
                />  
                
                <BaseInput 
                    :label="'Password'"
                    :id="'password'"   
                    :type="'password'"             
                    :name="'password'"
                    :errors="errors.password"
                    v-model="user.password" 
                /> 

                <BaseSelect
                    :label="'Role'"
                    :options="userTypes"
                    v-model="user.role"
                    :errors="errors.role"
                />

                <BaseButton
                    @click="update"
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
import { onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();
const {editUser, user,  updateUser, errors, isLoading, isSuccess } = useUsers();

const update = async () => {
    await updateUser(route.params.id,user.value)
    if ( !isSuccess.value ) return;
    router.push({name : 'users'});
}

const userTypes = [  
    { name : 'Employee', value : 2},
    { name : 'Admin', value : 1} 
]

onMounted(editUser(route.params.id))



</script>
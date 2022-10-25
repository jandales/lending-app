<template>
   <div v-if="borrower"  class="bg-white p-4 border rounded-md">     
         <PageHeading :title="'Edit Borrower'" />
         <div class="block bg-white mt-6">
           
        <form>
            <div class="grid grid-cols-2 gap-4">                
                <BaseInput                        
                        v-model="borrower.firstname"
                        name="firstname"
                        :label="'Firstname'"
                        :errors="errors.firstname"
                />                
                <BaseInput                        
                        v-model="borrower.lastname"
                        name="lastname"
                        :label="'Lastname'"
                        :errors="errors.lastname"
                />   
            </div>

            <BaseInput                        
                v-model="borrower.email"
                name="email"
                :label="'Email'"
                :errors="errors.email"
            /> 

            <BaseInput                        
                v-model="borrower.phone" 
                name="phone_number"
                :label="'Phone Number'"
                :errors="errors.phone"
            /> 

            <BaseInput 
                :label="'Address'"
                type="text"
                name="address"
                v-model="borrower.address"
                :errors="errors.address"
            />   

            
            <BaseSelect
                :label="'Status'"
                :options="status"
                v-model="borrower.status"
                :errors="errors.status"
            />
         

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

                        <img v-else :src="$defaultAvatarSrc" class="rounded-full w-32 h-32 mt-4">
                                                              
                    </div>
            </div>

            <BaseButton
                @click="update" 
                :isLoading="isLoading"
                name="Update Borrower"
            />          
               
        </form>

        </div> 
   </div>


    
</template>
<script setup>
import BaseInput from '../base/BaseInput.vue';
import BaseButton from '../base/BaseButton.vue';
import BaseSelect from '../base/BaseSelect.vue';
import PageHeading from '../PageHeading.vue';
import useBorrowers from '../../composable/borrowers';
import { ref, onMounted} from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const { updateBorrower, editBorrower, errors, borrower, isLoading } = useBorrowers();
const isImageChange = ref(false);
const image = ref();

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

const status = ref([
    { name : 'active', value : 1 },
    { name : 'not active', value : 0 },
])

onMounted(editBorrower(route.params.id));



</script>

<script setup>
import BaseAvatar from '../base/BaseAvatarWithName.vue';
import { reactive } from 'vue';
import BaseInput from '../base/BaseInput.vue';
import BaseButton from '../base/BaseButton.vue';
import useFund from '../../composable/fund'


const emit = defineEmits(['close']);



const props = defineProps({ 
    data : {
        type : Object,
        default : null
    } 
})


const closeModal = () => {
    emit('close')
}

</script>
<template>
    <div class="fixed  modal top-0 left-0  w-full h-full outline-none overflow-x-hidden overflow-y-auto backdrop-blur-sm bg-black/30"
      tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog relative w-auto pointer-events-none">
        <div
          class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
          <div
            class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
            <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel">Activity Info</h5>
            <button type="button"
                @click="closeModal()"
              class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
              aria-label="Close"></button>
          </div>
          <div class="modal-body relative p-4">
          <!-- <Alert v-if="success" :alert="'success'" :message="success"/> -->

        <BaseAvatar :user="data.user" class="mb-4" />  

        <BaseInput         
                :label="'Action'"                   
                :name="'action'"
                v-model="data.action" 
                :disabled="true"  
                :class="'capitalize'"          
            
          /> 

          <BaseInput         
                :label="'Last Capital Amount'"
                :type="'number'"      
                :name="'amount'"
                v-model="data.last_capital_amount"
                :disabled="true"
            
          />

          <BaseInput         
                :label="'Amount'"
                :type="'number'"      
                :name="'amount'"
                v-model="data.amount"
                :disabled="true"
            
          /> 

          <BaseInput         
                :label="'Date'"                   
                name="Date"
                v-model="data.created_at" 
                :disabled="true"  
                :class="'capitalize'"          
            
          />
          
        
  <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label inline-block mb-2 text-gray-700"
      >Remark</label
    >
    <textarea
      class="
        form-control
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
        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
      "
      id="exampleFormControlTextarea1"
      rows="3"
      placeholder="Your Remark"
      v-model="data.remark"
    ></textarea>


  </div>

       
          </div>
          <div  class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
            <BaseButton name="Close" class="btn-danger" @click="closeModal" />       
          </div>
        </div>
      </div>
    </div>
  </template>
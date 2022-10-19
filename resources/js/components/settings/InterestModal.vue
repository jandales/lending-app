<script setup>
import { ref, defineAsyncComponent,  } from 'vue'
import BaseInput from '../base/BaseInput.vue';
import useInterests from '../../composable/interest';
const { storeInterest, updateInterest, errors, success } = useInterests();

const Alert = defineAsyncComponent(
    () => import('../Alert.vue')
)  

const emit = defineEmits(['update', 'toggleModal']);

const props = defineProps({ 
    EditState : Boolean,
    currentInterest : Object,
})

const currentInterestValue = props.currentInterest.value; 
const interestValue = ref(currentInterestValue ?? null);

const title =  props.EditState === true 
    ? 'Edit Interest'
    : 'Add Interest'




const save = async () => {
    const payload = { value : parseInt(interestValue.value) };

    if (props.EditState === true) {
        await updateInterest(props.currentInterest.id, payload)        
    } else {
        await storeInterest(payload);
    }

    if (success.value) {
        interestValue.value = null;
        emit('getInterests');
        closeModal();    
    }  

   
    
    
}

const closeModal = () => {
    emit('toggleModal', false)
}





</script>
<template>
    <div class="fixed  modal top-0 left-0  w-full h-full outline-none overflow-x-hidden overflow-y-auto"
  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog relative w-auto pointer-events-none">
    <div
      class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
      <div
        class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
        <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel">{{ title }}</h5>
        <button type="button"
            @click="closeModal()"
          class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
          aria-label="Close"></button>
      </div>
      <div class="modal-body relative p-4">
       <Alert v-if="success" :alert="'success'" :message="success"/>
       <BaseInput         
            :label="'Interest'"
            :type="'number'"
            :id="'interest'"
            :errors="errors.value"            
            v-model="interestValue"
       />     
      </div>
      <div
        class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
        <button 
            @click="closeModal"
            type="button" class="px-6
          py-2.5
          bg-purple-600
          text-white
          font-medium
          text-xs
          leading-tight
          uppercase
          rounded
          shadow-md
          hover:bg-purple-700 hover:shadow-lg
          focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0
          active:bg-purple-800 active:shadow-lg
          transition
          duration-150
          ease-in-out" 
         >Close</button>
        <button type="button" class="px-6
      py-2.5
      bg-blue-600
      text-white
      font-medium
      text-xs
      leading-tight
      uppercase
      rounded
      shadow-md
      hover:bg-blue-700 hover:shadow-lg
      focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
      active:bg-blue-800 active:shadow-lg
      transition
      duration-150
      ease-in-out
      ml-1"
      data-bs-dismiss="modal"
      
      @click="save">Save</button>
      </div>
    </div>
  </div>
</div>
</template>
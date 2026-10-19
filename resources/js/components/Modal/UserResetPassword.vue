
<script setup>
import { ref, reactive, computed, defineAsyncComponent } from 'vue';
import usePassword from '../../composable/password'

import BaseButton from '../base/BaseButton.vue';

const AlertMessage = defineAsyncComponent(() => import('../Alert.vue'))

const emit = defineEmits(['update', 'toggleModal']);

const { resetPassword, isLoading, message } = usePassword();

const closeModal = () => {
    message.value = null;
    emit('toggleModal', false, null)

}

const loadingState = ref(false);



const props = defineProps({

    user : {

      type : Number,
      default : null,

    },
    
});

const handleReset = async () => {
    try {
      loadingState.value = true;
      await resetPassword(props.user);
    } catch (error) {
      console.log(error)
    } finally {
      loadingState.value = false;
    }
    
}

</script>


<template>
  <div class="fixed modal top-0 left-0  w-full h-full outline-none overflow-x-hidden overflow-y-auto"
    tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog relative w-auto pointer-events-none">
      <div
        class="modal-content border-none shadow-card relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
        <div
          class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-slate-200 rounded-t-lg">
          <h5 class="text-lg font-semibold leading-normal text-slate-800" id="exampleModalLabel">Reset Password</h5>
          <button type="button"
              @click="closeModal()"
            class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
            aria-label="Close"></button>
        </div>
        <div class="modal-body relative p-4">
            <AlertMessage v-if="message" :alert="'success'" :message="message"/>
            <h1>Password will be send to user email</h1>
      
        </div>
        <div
          class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-slate-200 rounded-b-lg gap-2">
   

          <BaseButton @click="closeModal"  name="Close" class="btn-light" />

          <BaseButton @click="handleReset" :isLoading="isLoading" name="Send reset password" />
  
        </div>
      </div>
    </div>
  </div>
</template>
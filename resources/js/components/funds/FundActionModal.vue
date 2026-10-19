<script setup>
import { reactive } from 'vue';
import BaseInput from '../base/BaseInput.vue';
import BaseButton from '../base/BaseButton.vue';
import useFund from '../../composable/fund'

const emit = defineEmits(['updateFund', 'close']);

const { addFund, deductFund, isSaving, errors, isSuccess, fund } = useFund();

const props = defineProps({ 
    isDeductState : {
        type : Boolean,
        default : false
    } 
})

const form = reactive({
    amount : 0,
    remark : '',
});


const save = async() => {

    if (props.isDeductState === true) 
        await deductFund(form);  
    else 
        await addFund(form);    

    if (isSuccess.value === false) return;
    closeModal();
    emit('updateFund', fund.value);


}

const title = props.isDeductState == true 
    ? 'Deduct Fund'
    : 'Add Fund'

const closeModal = () => {
    emit('close')
}

</script>
<template>
    <div class="fixed  modal top-0 left-0  w-full h-full outline-none overflow-x-hidden overflow-y-auto backdrop-blur-sm bg-slate-900/40"
      tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog relative w-auto pointer-events-none">
        <div
          class="modal-content border-none shadow-card relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
          <div
            class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-slate-200 rounded-t-md">
            <h5 class="text-xl font-medium leading-normal text-slate-800" id="exampleModalLabel">{{ title }}</h5>
            <button type="button"
                @click="closeModal()"
              class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
              aria-label="Close"></button>
          </div>
          <div class="modal-body relative p-4">
          <!-- <Alert v-if="success" :alert="'success'" :message="success"/> -->

          <BaseInput         
                :label="'Amount'"
                :type="'number'"      
                :name="'amount'"
                v-model="form.amount"
                :errors="errors.amount"
            
          /> 
          
        
  <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="inline-block mb-1.5 text-sm font-medium text-slate-700"
      >Remark</label
    >
    <textarea
      id="exampleFormControlTextarea1"
      rows="3"
      placeholder="Your Remark"
      v-model="form.remark"
    ></textarea>

    <small class="text-alert-danger" v-for="error in errors.remark" >{{ error }}</small>
  </div>

       
          </div>
          <div  class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-slate-200 rounded-b-md">
            <BaseButton name="Cancel" class="btn-light mr-2" @click="closeModal" />
            <BaseButton name="Submit" :isLoading="isSaving" @click="save" />
          </div>
        </div>
      </div>
    </div>
  </template>
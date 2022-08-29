<template>
    <!-- Modal -->
<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
  id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog relative w-auto pointer-events-none">
    <div
      class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
      <div
        class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
        <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel">Create Payment</h5>
        <button type="button"
          class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
          data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body relative p-4">
        <BaseLabelRow :name="'Due Date :'" :value="data.due_date"/>
       <div class="flex flex-col gap-2 mb-4">    
            <label for="" class="block text-sm font-semibold text-gray-700 mb-2">{{`Reference Number :`}} <span class="font-normal">{{loan.loan_number}}</span></label>      
            <label for="" class="block text-sm font-semibold text-gray-700 mb-2">{{`Due Date :`}} <span class="font-normal">{{data.due_date}}</span></label> 
            <label for="" class="block text-sm font-semibold text-gray-700 mb-2">{{`Collection Amount :`}} <span class="font-normal">{{moneyFormatter(data.collection_amount)}}</span></label>                           
        </div>
         <!-- <BaseInput           
            :label="`Amount`"
            :modelValue="data.collection_amount"
            :type="'number'"        
            :id="'typename'"                         
        />    -->
        
        <input type="number" 
                    name="amount"
                    v-model="data.collection_amount"                      
                    id="exampleInputPassword1"
                 >        
                      
     

      
      </div>
      <div
        class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
        <button type="button" class="px-6
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
          ease-in-out" data-bs-dismiss="modal">Close</button>
        <button type="button"
        @click="store" class="px-6
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
      data-bs-dismiss="modal">Submit</button>
      </div>
    </div>
  </div>
</div>
</template>
<script setup>
import { ref, reactive, computed } from 'vue';
import BaseInput from '../../components/base/BaseInput.vue'
import usePayments from '../../composable/payments';
import useFormatter from '../../composable/helper/formater'

const { addPayment, isSuccess, errors } = usePayments();

const { moneyFormatter } = useFormatter(); 

const props = defineProps({

    loan : {

      type : String,

      default : null,

    },

    data : {

      type : Object,

      default : null,

    },
    
});

const emit = defineEmits(['loadLoan']);

const collection_amount = ref();

const loadLoan = () => {
    
    emit('loadLoan');
  
}

const form = reactive({

    amount : 0,

    due_date : null,

    remark : null,

    borrower_id : null,

    loan_id : null,
    
    due_date_id : null,

})

const store = async () => { 

    form.due_date = props.data.due_date,

    form.borrower_id = props.loan.borrower.id; 

    form.amount = props.data.collection_amount; 

    form.loan_id = props.loan.id; 

    form.due_date_id = props.data.id;

    await addPayment({...form}); 
    // if(isSuccess.value === true){        // router.push({name: 'payments'})
    //     await getLoan(route.params.loan_id);
    // }  
    loadLoan();

}




</script>
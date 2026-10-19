<script setup>

import BaseStatus from '../base/BaseStatus.vue';
import useFormatter from '../../composable/helper/formater'
import { ref } from 'vue';

const { moneyFormatter } = useFormatter(); 

const props = defineProps({ list : {type : Array, default : [] }}) 
const error = ref(null)
const emit =  defineEmits(['close', 'select'])

const select = (item) => {

    if (item.status == 'paid' || item.status == 'void' || item.status == 'failed' ) {
        error.value = 'Choose another dates';
        return;
    }

    emit('select', item)
    emit('close', false)
    
}
const close = () => {
    emit('close', false)
}
</script>

<template>
     <div  class="fixed w-full flex justify-center z-10 top-0 left-0 min-h-screen backdrop-blur-sm bg-slate-900/40">
        <div class="relative w-full max-w-[700px] transform px-4 transition-all mx-auto opacity-100 scale-100 py-10 h-fit ">
            <div class="bg-white p-5 border border-slate-200 shadow-card w-full rounded-xl mx-auto">
                <div class="block">    
                    <div class="flex items-center justify-between">
                        <h1 class="block text-lg font-semibold text-slate-800">Payment due dates</h1>
                        <span @click="close" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        </span>
                    </div> 
                  
                    <div  class="flex flex-col">

                        <div v-if="error" class="rounded-lg py-2.5 px-4 mb-4 mt-4 text-sm font-medium border bg-red-50 text-red-700 border-red-100" role="alert">
                                    {{ error }}
                         </div>

                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="overflow-hidden">
                                <table class="min-w-full">
                                <thead class="bg-white border-b">
                                    <tr>
                                        <th scope="col">Due Date</th>
                                        <th class="text-center" scope="col">Collection Amount</th>                           
                                        <th class="text-center" scope="col">Paid Date</th>  
                                        <th class="text-center" scope="col">Amount Paid</th>                     
                                        <th class="text-center" scope="col">Balance</th>
                                        <th class="text-center" scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>           
                                         
                                    <tr v-for="item in list" :key="item.id" @click="select(item)" class="border-b border-slate-100 last:border-b-0 cursor-pointer hover:bg-slate-50">                           
                                        <td>
                                            {{ item.due_date}}
                                        </td>
                                        <td class="text-center">
                                            {{  moneyFormatter(item.collection_amount) }}
                                        </td>                           
                                        <td class="text-center">                   
                                            {{ item.paid_at ?? '-- / -- / --' }}                            
                                        </td>  
                                        <td class="text-center">                               
                                            {{  moneyFormatter(item.amount_paid) }}                            
                                        </td>  
                                        <td class="text-center">                               
                                            {{  moneyFormatter(item.balance) }}                            
                                        </td>    
                                        <td class="text-center">                               
                                              <BaseStatus :status="item.status ?? '--' " />                                                               
                                        </td>                         
                                    </tr> 
                                        
                                </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
   
</template>
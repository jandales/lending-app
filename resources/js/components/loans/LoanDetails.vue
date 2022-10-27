<template>
<Alert v-if="isSuccess" :alert="'success'" :message="'Loan status updated'" />
<Alert v-for="error in errors.status" :alert="'danger'" :message="error" />
<div v-if="loan"  class="flex flex-col w-full  gap-8">

    <div  class="w-full bg-white rounded-md border h-max py-4 px-8 mb-4">
        <div class="w-full flex items-center justify-between mb-4">
           <hi class="block tracking-wider text-lg mb-4">Loan Details</hi>
           <div class="flex gap-4">
            <button @click="exportHandle">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
              </svg>

            </button>

            <button @click="printHandle(loan.id)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                </svg>
            </button>

          </div>
        </div>
           <div class="flex justify-between items-center">

                <div class="flex items-center">                
                    <img v-if="loan && loan.borrower.avatar" :src="loan.borrower.avatar" class="rounded-full border w-20 h-20"  alt="Avatar" />
                    <img v-else :src="$defaultAvatarSrc" class="rounded-full border w-20 h-20"  alt="Avatar"/>        
                    <div v-if="loan" class="w-full flex  items-center justify-between ml-4">
                        <div>
                            <label for="" class="block text-xl capitalize font-semibold text-gray-700 mb-1">{{ loan.borrower.name }}</label>                         
                        </div> 
                    </div>        
                </div>

                <div  class="flex items-center gap-4">
                    <div v-if="isAdmin" class="form-group w-60 mb-6 mt-6">
                        <div class="flex items-center gap-4">
                            <label for="exampleInputPassword1"  class="form-label text-sm inline-block text-gray-700">Status</label>
                            <select v-model="status" aria-label="Default select example"  placeholder="Select" class="py-[10px] w-full capitalize text-sm">  
                                <option v-if="loan.status == 'pending'"  value='approved'  :selected="status == loan.status">Approved</option>
                                <option v-if="loan.status == 'approved'" value='active'  :selected="status == loan.status">Release</option>  
                                <option v-if="loan.status == 'pending'"  value='rejected'  :selected="status == loan.status">Reject</option>
                                <option v-else  value='void'>Void</option>
                            </select>
                        </div> 
                    </div>    
                    <button                         
                        @click="update"  
                        type="button" 
                        data-mdb-ripple="true"
                        data-mdb-ripple-color="light"
                        class="btn-primary h-max flex justify-center items-center ">     
                        <div v-if="isLoading" class="spinner-border animate-spin inline-block w-4 h-4 border-4 rounded-full" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <label v-else for="">Save</label>        
                    </button> 
                </div>                           
           </div>
           

    <div v-if="loan" class="mt-4">
        <div class="flex gap-8">
           <div  class="w-1/2 flex flex-col">
                <BaseLabelRow :name="'Loan Number :'" :value="loan.loan_number"/>
                <BaseLabelRow :name="'Terms :'" :value="`${loan.terms} Months`"/>
                <BaseLabelRow :name="'Type :'" :value="loan.type"/>
                <BaseLabelRow :name="'Total Interest :'" :value="moneyFormatter(loan.total_interest)"/>
                <BaseLabelRow :name="'Collection Amount :'" :value="moneyFormatter(loan.collection_amount)"/>
               
           </div>
           <div class="w-1/2">      
                <BaseLabelRow :name="'Due Date :'" :value="`${loan.due_date_at}`"/>          
                <BaseLabelRow :name="'Interest :'" :value="`${loan.interest}%`"/>
                <BaseLabelRow :name="'Principal Amount :'" :value="moneyFormatter(loan.principal_amount)"/>
                <BaseLabelRow :name="'Total Amount :'" :value="moneyFormatter(loan.total_amount)"/>        
                <BaseLabelRow :name="'Balance :'" :value="moneyFormatter(loan.balance_amount)" />  
                <BaseLabelRow v-if="loan.status == 'paid'" :name="'Status :'" :value="loan.status" :backgroundColor="'success'" />  
                <BaseLabelRow v-else-if="loan.status == 'approved'" :name="'Status :'" :value="loan.status" :backgroundColor="'info'" /> 
                <BaseLabelRow v-else-if="loan.status == 'active'" :name="'Status :'" :value="loan.status" :backgroundColor="'info'" />  
                <BaseLabelRow v-else-if="loan.status == 'void' || loan.status == 'rejected'" :name="'Status :'" :value="loan.status" :backgroundColor="'danger'" /> 
                <BaseLabelRow v-else :name="'Status :'" :value="loan.status" :backgroundColor="info" />
           </div>
        </div>    
    </div>   
    
         


           
           
    </div>

    <div class="bg-white p-4 border w-full rounded-md mx-auto">
      <div class="block bg-white">     
        <hi class="block tracking-wider text-lg">Payment Due Dates</hi>
        <div v-if="loan" class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <table class="min-w-full">
                    <thead class="bg-white border-b">
                        <tr>
                            <th scope="col">Due Date</th>
                            <th scope="col">Amount</th>                           
                            <th scope="col">Paid Date</th>  
                            <th scope="col">Amount Paid</th>                     
                            <th scope="col">Balance</th>
                        </tr>
                    </thead>
                    <tbody>                       
                        <tr v-if="loan.due_dates.length > 0"  v-for="item in dueDateList" class="last:border-b-0">                           
                            <td>
                                {{ item.due_date}}
                            </td>
                            <td>
                                {{ moneyFormatter(item.collection_amount) }}
                            </td>                           
                            <td>                   
                                {{ item.paid_at }}                            
                            </td>  
                            <td>                               
                                {{ item.amount_paid }}                            
                            </td>  
                            <td>                               
                                {{ item.balance }}                            
                            </td>
                            <td class="flex gap-2 items-center">                               
                               <button v-if="item.status == null" @click="createPayment(item)" class="btn-primary" :class="{'!bg-slate-400 cursor-not-allowed' : loan.status != 'active' }" :disabled="loan.status != 'active'"  data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Pay
                               </button>  
                               <span v-else class="px-2 py-1 bg-green-400 text-white capitalize rounded-md text-center " :class="{ '!bg-rose-500': item.status == 'failed' , '!bg-rose-500' : item.status == 'void'}">
                                    {{item.status}}
                               </span>                                               
                            </td>
                        </tr> 
                        <tr v-else>
                            <td colspan="6" class="text-center text-xl">No Data Found</td>
                        </tr>         
                    </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>

    </div>
    </div>

<PaymentModal @loadLoan="loadLoan" :loan="loan" :data="dueDate"/>

</div>


  
</template>

<script setup>

import Alert from '../Alert.vue';
import PaymentModal from '../Modal/PaymentModal.vue';
import BaseLabelRow from '../base/BaseLabelRow.vue'
import useLoans from '../../composable/loans';
import useCalculation from '../../composable/helper/calculations';
import useFormatter from '../../composable/helper/formater'
import useUser from '../../composable/user';
import {  ref,  onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import useExport from '../../composable/exports/loans';

const { getLoan, updateStatusLoan, loan, isLoading, isSuccess, errors } = useLoans();

const { calculateInterest } = useCalculation();

const { moneyFormatter } = useFormatter(); 

const {  loanDetailsToPDF } = useExport();

const { checkUserRole, isAdmin} = useUser();

const route = useRoute();

const status = ref();

const dueDate = ref(0);

const update = async () => {

    if(status.value == null) return;

    await updateStatusLoan(loan.value.id, {status : status.value});

    await loadLoan();

}

const createPayment = (date) => {

    dueDate.value = date;   

}

const loadLoan = async() => {

   await getLoan(route.params.id)

}

const exportHandle = async () => {
     await exportLoans({...form});
  }

  const printHandle = async (id) => {
    await  loanDetailsToPDF(id);
  }


onMounted(loadLoan);

onMounted(checkUserRole);

const dueDateList = computed(() => {

    if(loan.value == null) return;
    
    return loan.value.due_dates.map(due => {

        due.paid_at = due.paid_at == null ? '-- / -- / --' : due.paid_at;

        due.amount_paid = moneyFormatter(due.amount_paid);    

        due.balance = moneyFormatter(due.balance);

        return due;

    });

});

const interestPerDueDate = computed(() => {

    if(loan.value == null) return;  

    const amount = calculateInterest(loan.value.principal_amount, loan.value.interest)

    return  moneyFormatter(amount);

});


</script>
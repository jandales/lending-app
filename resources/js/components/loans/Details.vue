<template>
<Alert v-if="isSuccess" :alert="'success'" :message="'Loan status updated'" />
<Alert v-for="error in errors.status" :alert="'danger'" :message="error" />
<div v-if="loan"  class="flex flex-col w-full  gap-8">

    <div  class="w-full bg-white rounded-md border h-max py-4 px-8 mb-4">
           <hi class="block tracking-wider text-lg mb-4">Loan Details</hi>
           <div class="flex justify-between items-center">

                <div class="flex items-center">                
                    <img v-if="loan && loan.borrower.avatar" :src="loan.borrower.avatar" class="rounded-full border w-20 h-20"  alt="Avatar" />
                    <img v-else :accesskey="$defaultAvatarSrc" class="rounded-full border w-20 h-20"  alt="Avatar"/>        
                    <div v-if="loan" class="w-full flex  items-center justify-between ml-4">
                        <div>
                            <label for="" class="block text-xl capitalize font-semibold text-gray-700 mb-1">{{ loan.borrower.name }}</label>
                            <label for="" class="block text-base text-gray-400">{{ loan.borrower.phone }}</label>
                        </div> 
                    </div>        
                </div>

                <div v-if="loan && loan.status != 'paid'" class="flex items-center gap-4">
                    <div  class="form-group w-60 mb-6 mt-6">
                        <div class="flex items-center gap-4">
                            <label for="exampleInputPassword1"  class="form-label text-sm inline-block text-gray-700">Status</label>
                            <select v-model="status" aria-label="Default select example"  placeholder="Select" class="py-[10px] w-full capitalize text-sm">  
                                <option v-if="loan.status == 'pending'"  value='approved'  :selected="status == loan.status">Approved</option>
                                <option v-if="loan.status == 'approved'" value='active'  :selected="status == loan.status">Release</option>  
                                <option v-if="loan.status != 'paid' || loan.status != 'active' "     value='rejected'  :selected="status == loan.status">Reject</option>
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
                <BaseLabelRow :name="'Total Interest :'" :value="moneyFormatter(loan.total_interest)"/>
                <BaseLabelRow :name="'Collection Amount :'" :value="moneyFormatter(loan.collection_amount)"/>
                <BaseLabelRow :name="'Principal Amount :'" :value="moneyFormatter(loan.principal_amount)"/>
           </div>
           <div class="w-1/2">                
                <BaseLabelRow :name="'Interest :'" :value="`${loan.interest}%`"/>
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
                            <th scope="col">Interest</th>
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
                                {{ item.collection_amount }}
                            </td>
                            <td>
                                {{ interestPerDueDate }}
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
                               <button v-if="item.status == null" @click="createPayment(item)" class="btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Pay
                               </button>  
                               <span v-else class="px-2 py-1 bg-green-400 text-white capitalize rounded-md text-center" :class="{ '!bg-rose-500': item.status == 'failed' , '!bg-rose-500' : item.status == 'void'}">
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
import PaymentModal from '../../components/Modal/PaymentModal.vue';
import BaseLabelRow from '../../components/base/BaseLabelRow.vue'
import useLoans from '../../composable/loans';
import useCalculation from '../../composable/helper/calculations';
import useFormatter from '../../composable/helper/formater'
import {  ref,  onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const { getLoan, updateStatusLoan, loan, isLoading, isSuccess, errors } = useLoans();

const { calculateInterest } = useCalculation();

const { moneyFormatter } = useFormatter(); 

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

onMounted(loadLoan);

const dueDateList = computed(() => {

    if(loan.value == null) return;
    
    return loan.value.due_dates.map(due => {

        due.paid_at = due.paid_at == null ? '-- / -- / --' : due.paid_at;

        due.amount_paid = moneyFormatter(due.amount_paid);

        due.collection_amount = moneyFormatter(due.collection_amount);

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
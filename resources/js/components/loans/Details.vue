<template>
<Alert v-if="isSuccess" :alert="'success'" :message="'Payment Successfully created'" />
<div v-if="loan"  class="flex w-full gap-8">
    <div  class="w-1/3 bg-white rounded-md border h-max p-4 mb-4">
        <div class="flex items-center">
            
            <img v-if="loan" :src="loan.customer.avatar" class="rounded-full border w-16 h-16"  alt="Avatar" />

            <img v-else src="/img/avatar/avatar.png" class="rounded-full border w-16 h-16"  alt="Avatar"/>
    
            <div v-if="loan" class="w-full flex  items-center justify-between ml-4">
               <div>
                    <label for="" class="block text-sm font-semibold text-gray-700">{{ loan.customer.name }}</label>
                    <label for="" class="block text-sm text-gray-700">{{loan.customer.phone}}</label>
               </div> 
            </div>        

        </div>

    <div v-if="loan" class="mt-4">
        <BaseLabelRow :name="'Loan Type :'" :value="loan.loan_type.type"/>
        <BaseLabelRow :name="'Amount to pay'" :value="moneyFormatter(loan.loan_type.amount_to_pay)"/>
        <BaseLabelRow :name="'Principal Amount'" :value="moneyFormatter(loan.principal_amount)"/>
        <BaseLabelRow :name="'Interest'" :value="`${loan.loan_type.interest}%`"/>
        <BaseLabelRow :name="'Total Amount'" :value="moneyFormatter(calculateInterest(loan.principal_amount, loan.loan_type.interest))"/>        
        <BaseLabelRow :name="'Balance'" :value="moneyFormatter(loan.balance_amount)" />  
        <BaseLabelRow :name="'Status :'" :value="loan.status"  />  
       
    </div>   
    
         
    <div v-if="loan" class="form-group w-full mb-6 mt-6">
        <div class="flex items-center gap-4">
        <label for="exampleInputPassword1" class="form-label inline-block text-gray-700">Status</label>
        <select v-model="status" aria-label="Default select example"    placeholder="Select" class="py-[10px] w-full capitalize">     
                <option value='approved'>Approved</option>
                 <option value='released'>Release</option>  
                <option value='reject'>Reject</option>
               
        </select>
        </div>
        <!-- <small class="text-alert-danger" v-for="error in errors.loan_type_id">{{ error }}</small> -->
    </div>

    <button  
        @click="update"  
        type="button" 
        data-mdb-ripple="true"
        data-mdb-ripple-color="light"
        class="btn-primary w-full flex justify-center items-center ">
     
        <div v-if="isLoading" class="spinner-border animate-spin inline-block w-4 h-4 border-4 rounded-full" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>

        <label v-else for="">Save</label>
        
    </button>
           
           
    </div>

    <div class="bg-white p-4 border w-2/3 rounded-md mx-auto">
      <div class="block bg-white">     
        <hi class="block tracking-wider text-lg mb-6 ">Payment History</hi>

        <div v-if="loan" class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <table class="min-w-full">
                    <thead class="bg-white border-b">
                        <tr>
                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            #
                        </th>
                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Date
                        </th>
                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Payment Amount
                        </th>
                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Status
                        </th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        <tr  v-for="payment in loan.payments" class="border-b">                           
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{`000-${payment.id}`}}
                            </td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                {{ payment.created_at }}
                            </td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                {{ moneyFormatter(payment.amount) }}
                            </td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                               <div class="px-2 py-1 text-white text-sm rounded-sm bg-green-500 text-center capitalize">
                                 {{ payment.status }}
                               </div>
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


  
</template>

<script setup>
import BaseLabelRow from '../../components/base/BaseLabelRow.vue'
import useLoans from '../../composable/loans';
import useCalculateInterest from '../../composable/helper/calculateInterest';
import useFormatter from '../../composable/helper/formater'
import { reactive, ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const { getLoan, updateStatusLoan , loan, isLoading } = useLoans();
const { calculateInterest } = useCalculateInterest();
const { moneyFormatter } = useFormatter(); 
const route = useRoute();
const status = ref();


const update = async () => {
        if(status.value == null) return;
        await updateStatusLoan(loan.value.id, {status : status.value});
}

onMounted(getLoan(route.params.id));

</script>
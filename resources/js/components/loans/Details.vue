<template>
<Alert v-if="isSuccess" :alert="'success'" :message="'Loan status updated'" />
<div v-if="loan"  class="flex w-full gap-8">
    <div  class="w-1/3 bg-white rounded-md border h-max p-4 mb-4">
        <div class="flex items-center">
            
            <img v-if="loan" :src="loan.borrower.avatar" class="rounded-full border w-16 h-16"  alt="Avatar" />

            <img v-else src="/img/avatar/avatar.png" class="rounded-full border w-16 h-16"  alt="Avatar"/>
    
            <div v-if="loan" class="w-full flex  items-center justify-between ml-4">
               <div>
                    <label for="" class="block text-sm font-semibold text-gray-700">{{ loan.borrower.name }}</label>
                    <label for="" class="block text-sm text-gray-700">{{loan.borrower.phone}}</label>
               </div> 
            </div>        
        </div>

    <div v-if="loan" class="mt-4">
        <BaseLabelRow :name="'Loan Number :'" :value="loan.loan_number"/>
        <BaseLabelRow :name="'Terms :'" :value="`${loan.terms} Months`"/>
        <BaseLabelRow :name="'Total Interest'" :value="moneyFormatter(loan.total_interest)"/>
        <BaseLabelRow :name="'Collection Amount'" :value="moneyFormatter(loan.collection_amount)"/>
        <BaseLabelRow :name="'Principal Amount'" :value="moneyFormatter(loan.principal_amount)"/>
        <BaseLabelRow :name="'Interest'" :value="`${loan.interest}%`"/>
        <BaseLabelRow :name="'Total Amount'" :value="moneyFormatter(loan.total_amount)"/>        
        <BaseLabelRow :name="'Balance'" :value="moneyFormatter(loan.balance_amount)" />  
        <BaseLabelRow v-if="loan.status == 'paid'" :name="'Status :'" :value="loan.status" :backgroundColor="success" />  
        <BaseLabelRow v-else-if="loan.status == 'void' || loan.status == 'rejected'" :name="'Status :'" :value="loan.status" :backgroundColor="danger" /> 
        <BaseLabelRow v-else :name="'Status :'" :value="loan.status" :backgroundColor="info" />
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
        <hi class="block tracking-wider text-lg mb-6 ">Payment Due Dates</hi>

        <div v-if="loan" class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <table class="min-w-full">
                    <thead class="bg-white border-b">
                        <tr>
                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Due Date
                        </th>
                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Amount
                        </th> 
                         <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Interest
                        </th>
                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                           Paid Date
                        </th>  
                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                           Amount Paid
                        </th>                     
                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Balance
                        </th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        <tr  v-for="item in loan.due_dates" class="border-b">                           
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ item.due_date}}
                            </td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                {{ moneyFormatter(item.collection_amount) }}
                            </td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                {{ moneyFormatter(calculateInterest(loan.principal_amount,loan.interest)) }}
                            </td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">                               
                                 {{ '-- / -- / -- ' }}                            
                            </td>  
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">                               
                                 {{ moneyFormatter(item.amount_paid) }}                            
                            </td>  

                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                               
                                 {{ moneyFormatter(item.balance)  }}
                            
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
import Alert from '../Alert.vue';
import BaseLabelRow from '../../components/base/BaseLabelRow.vue'
import useLoans from '../../composable/loans';
import useCalculation from '../../composable/helper/calculations';
import useFormatter from '../../composable/helper/formater'
import { reactive, ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const { getLoan, updateStatusLoan , loan, isLoading, isSuccess } = useLoans();
const { calculateInterest } = useCalculation();
const { moneyFormatter } = useFormatter(); 
const route = useRoute();
const status = ref();


const update = async () => {
        if(status.value == null) return;
        await updateStatusLoan(loan.value.id, {status : status.value});
}

onMounted(getLoan(route.params.id));

</script>
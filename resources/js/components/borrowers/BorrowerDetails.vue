<template >
    <div v-if="borrower" class="w-full">
        <div class=" flex flex-col gap-4">
            <div  class="w-full bg-white rounded-md border h-max py-4 px-8 mb-4">
                <hi class="block tracking-wider text-lg mb-4">Borrower Info</hi>
                <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center  w-full">                
                            <img v-if="borrower && borrower.avatar" :src="borrower.avatar" class="rounded-full border w-20 h-20"  alt="Avatar" />
                            <img v-else :src="$defaultAvatarSrc" class="rounded-full border w-20 h-20"  alt="Avatar"/>        
                            <div class="w-full flex  items-center justify-between ml-4">
                                <div>
                                    <label for="" class="block text-xl capitalize font-semibold text-gray-700 mb-1">{{ borrower.name }} 
                                        <router-link :to="{name: 'borrowers.edit', params : { id :  borrower.id } }" class="ml-2 text-xs text-sky-500">Edit</router-link>
                                    </label>  
                                </div>  
                            </div> 
                        </div>
                </div>
            
                <div  class="flex flex-col w-full">
                        <div class="flex gap-2 mb-1">
                            <div for="" class="block min-w-[100px] text-sm text-gray-700 break-words">Phone Number :</div>
                            <label for="" class="block text-sm text-gray-500">{{borrower.phone}}</label>
                        </div>

                        <div class="flex gap-2 mb-1">
                            <div for="" class="block min-w-[100px] text-sm text-gray-700 break-words">Email :</div>
                            <label for="" class="block text-sm text-gray-500">{{borrower.email}}</label>    
                        </div>  
                        
                        <div class="flex gap-2 mb-1">
                            <div  for="" class="block min-w-[100px] text-sm text-gray-700">Address :</div>
                            <label for="" class="block text-sm text-gray-500 break-all">{{borrower.address}}</label>    
                        </div>
                </div>
            </div> 
        </div>
        <BasePanelWrapper :title="'Loans'">      
                <template #body>
                    <BaseTableWrapper >
                        <BaseTable>
                            <BaseTableHead>
                                <BaseTableRow>                               
                                    <BaseTableTh class="capitalize">Loan Number</BaseTableTh>                               
                                    <BaseTableTh class="capitalize text-center">Total Amount</BaseTableTh>      
                                    <BaseTableTh class="capitalize text-center">Date</BaseTableTh>                 
                                    <BaseTableTh class="capitalize text-center">Status</BaseTableTh> 
                                    <BaseTableTh class="capitalize text-center"></BaseTableTh>                                 
                                </BaseTableRow>                   
                            </BaseTableHead>
                            <BaseTableBody v-if="borrower.loans.length > 0"  >
                            <BaseTableRow :body="true" v-for="loan in borrower.loans">                                
                                <BaseTd class="capitalize">                                     
                                    <router-link :to="{name : 'loans.details' , params : {id : loan.id} }" class="text-sky-500">
                                        {{ loan.loan_number }}
                                    </router-link>
                                </BaseTd>                
                                <BaseTd class="capitalize text-center"> {{ moneyFormatter(loan.total_amount) }}</BaseTd>                               
                                <BaseTd class="capitalize text-center"> {{ loan.created_at }}</BaseTd>       
                                <BaseTd class="capitalize text-center"> {{ loan.status }}</BaseTd>                          
                                <BaseTd>
                                    <div class="flex justify-end gap-4 mr-4 ">                                   
                                        <router-link :to="{name : 'loans.details' , params : {id : loan.id} }" type="button" class="btn-icon-info">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                        </router-link>
                                        <BaseButton v-if="isAdmin && loan.status != 'paid'" @click="destroy(loan.id)" class="btn-icon-danger">
                                            <template #icon>
                                                <BaseIconShow />
                                            </template>
                                        </BaseButton>
                                    </div>
                                </BaseTd>
                            </BaseTableRow>                  
                            </BaseTableBody>
                            <BaseTableRow v-if="!isLoading && borrower.loans.length === 0">
                                <BaseTd   colspan="8" class="text-center font-semibold">No Record Found</BaseTd>
                            </BaseTableRow>
                        </BaseTable>
                        <Pagination v-if="pagination.last_page > 1" :pagination="pagination" @page-change=pageChange />
                        <BaseTableSpinner v-if="isLoading" />
                    </BaseTableWrapper>

                </template>
        </BasePanelWrapper>
    </div>
</template>

<script setup>

import useBorrowers from '../../composable/borrowers.js';
import useLoans from '../../composable/loans';
import useCalculation from '../../composable/helper/calculations';
import useFormatter from '../../composable/helper/formater';


import BasePanelWrapper from '../base/BasePanelWrapper.vue'
import BaseAvatar from '../base/BaseAvatar.vue'
import BaseTableWrapper from '../base/table/BaseTableWrapper.vue'
import BaseTable from '../base/table/BaseTable.vue'
import BaseTableHead from '../base/table/BaseTableHead.vue'
import BaseTableRow from '../base/table/TableRow.vue'
import BaseTableTh from '../base/table/BaseTableTh.vue'
import BaseTableBody from '../base/table/BaseTableBody.vue'
import BaseTd from '../base/table/BaseTd.vue'
import BaseButton from '../base/BaseButton.vue'
import BaseTableSpinner from '../base/table/BaseTableSpinner.vue'
import Pagination from '../Pagination.vue'
import BaseIconShow from '../base/icons/BaseIconShow.vue';
import BaseSearch from '../base/BaseSearch.vue'
import BaseDropDown from '../base/BaseDropDown1.vue'

import BaseLabelRow from '../base/BaseLabelRow.vue'

import { onMounted, computed } from 'vue';
import { useRoute } from 'vue-router';

const { moneyFormatter } = useFormatter(); 
const {  getBorrower, borrower, isLoading } = useBorrowers();
const { calculateInterest } = useCalculation();
const {   pagination,  } = useLoans();

const route = useRoute();

onMounted(getBorrower(route.params.id));

const dueDateList = computed(() => {

    if(loan.value == null) return;   

    const interest = calculateInterest(loan.value.principal_amount, loan.value.interest);

    return loan.value.due_dates.map(due => {

        due.paid_at = due.paid_at == null ? '-- / -- / --' : due.paid_at;

        due.amount_paid = moneyFormatter(due.amount_paid);

        due.collection_amount = moneyFormatter(due.collection_amount);

        due.balance = moneyFormatter(due.balance);

        due.interest = moneyFormatter(interest);

        return due;

    });

});

</script>
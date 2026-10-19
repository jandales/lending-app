<template>

<!-- Welcome hero -->
<div class="relative overflow-hidden rounded-3xl brand-gradient shadow-float mb-8 px-8 py-8 text-white">
  <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full bg-white/10 blur-2xl"></div>
  <div class="absolute right-20 -bottom-16 w-64 h-64 rounded-full bg-emerald-300/20 blur-3xl"></div>
  <div class="relative flex flex-col md:flex-row md:items-end md:justify-between gap-6">
    <div>
      <p class="text-white/80 text-sm font-medium mb-2">Welcome back{{ userName ? `, ${userName}` : '' }}</p>
      <h2 class="text-2xl md:text-3xl font-bold tracking-tight mb-1">Lending overview</h2>
      <p class="text-white/75 text-sm max-w-md">Track borrowers, collections, and active loans in one place.</p>
    </div>
    <div class="bg-white/15 backdrop-blur-md rounded-2xl px-6 py-4 border border-white/20 min-w-[200px]">
      <p class="text-white/70 text-xs font-medium uppercase tracking-wider mb-1">Collectable</p>
      <p class="text-2xl font-bold tracking-tight">{{ moneyFormatter(totalInterest) }}</p>
    </div>
  </div>
</div>

<div class="w-full flex flex-col sm:flex-row gap-5 mb-8"> 
  <BaseCard :title="'Borrowers'"  :value="borrowerCount" :icon="'person'" />
  <BaseCard :title="'Active Loan'"  :value="activeLoansCount" :icon="'activeLoanCount'" />
  <BaseCard :title="'Collected'"  :value="moneyFormatter(totalCollectedInterest)" :icon="'capital'" />
  <BaseCard :title="'Collectable'"  :value="moneyFormatter(totalInterest)" :icon="'revenue'"/> 
</div>

<BasePanelWrapper :title="'Recent loans'">
  <template #body>
  <BaseTableWrapper >
    <BaseTable>
      <BaseTableHead>
        <BaseTableRow>
          <BaseTableTh>Customer</BaseTableTh>
          <BaseTableTh>Terms</BaseTableTh> 
          <BaseTableTh>Amount</BaseTableTh>   
          <BaseTableTh>Balance</BaseTableTh>                 
          <BaseTableTh>Status</BaseTableTh>
        </BaseTableRow>
      </BaseTableHead>
      <BaseTableBody v-if="loans && loans.length > 0">
        <BaseTableRow  :body="true" v-for="loan in loans">
          <BaseTd>
            <RouterLink :to="{name : 'borrowers.details' , params : {id : loan.borrower.id } }" class="text-brand-600 hover:text-brand-700">         
                    <BaseAvatar
                      :image="loan.borrower.avatar"
                      :name="loan.borrower.name"
                    />      
            </RouterLink>
          </BaseTd>
          <BaseTd>{{ `${loan.terms} Months` }}</BaseTd>
          <BaseTd>{{ loan.principal_amount }}</BaseTd>
          <BaseTd>{{ loan.balance_amount }}</BaseTd>
          <BaseTd><BaseStatus :status="loan.status" /></BaseTd>
        </BaseTableRow>
      </BaseTableBody>
      <BaseTableBody v-else>
        <BaseTableRow v-if="!isLoading && loans.length === 0">
          <BaseTd colspan="5" class="text-center font-semibold text-slate-400">No records found</BaseTd>
        </BaseTableRow>
      </BaseTableBody>
    </BaseTable>
    <BaseTableSpinner v-if="isLoading" />
  </BaseTableWrapper>
  </template>

</BasePanelWrapper>

</template>
<script setup>
import BasePanelWrapper from '../components/base/BasePanelWrapper.vue'
import BaseTableWrapper from '../components/base/table/BaseTableWrapper.vue'
import BaseTable from '../components/base/table/BaseTable.vue'
import BaseTableHead from '../components/base/table/BaseTableHead.vue'
import BaseTableRow from '../components/base/table/TableRow.vue'
import BaseTableTh from '../components/base/table/BaseTableTh.vue'
import BaseTableBody from '../components/base/table/BaseTableBody.vue'
import BaseTd from '../components/base/table/BaseTd.vue'
import BaseTableSpinner from '../components/base/table/BaseTableSpinner.vue'

import BaseStatus from '../components/base/BaseStatus.vue'
import BaseCard from '../components/base/BaseCard.vue';
import BaseAvatar from '../components/base/BaseAvatar.vue';
import useApp from '../composable/app'
import useFormatter from '../composable/helper/formater'
import { onMounted, computed, ref} from 'vue';

const { moneyFormatter } = useFormatter();

const { getDashboards ,borrowerCount, totalInterest, currentCapital ,activeLoansCount, recentLoans, totalCollectedInterest, isLoading  } = useApp();

const userName = ref('');

const getData = () => {
    getDashboards();
    try {
      const stored = JSON.parse(localStorage.getItem('user'));
      userName.value = stored?.name || '';
    } catch (e) {
      userName.value = '';
    }
}

onMounted(getData);

const loans = computed(() => {

    if(recentLoans.value == null) return;

    return recentLoans.value.map(loan => {

        loan.total_amount = moneyFormatter(loan.total_amount);

        loan.balance_amount = moneyFormatter(loan.balance_amount);

        loan.principal_amount = moneyFormatter(loan.principal_amount);

        return loan;

    });

});

</script>

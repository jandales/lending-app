<template>

<div class="w-full flex gap-8 mb-8"> 
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
            <RouterLink :to="{name : 'borrowers.details' , params : {id : loan.borrower.id } }" class="text-sky-500">         
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
          <BaseTd colspan="5" class="text-center font-semibold">No Found Record</BaseTd>
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
import { onMounted, computed} from 'vue';

const { moneyFormatter } = useFormatter();

const { getDashboards ,borrowerCount, totalInterest, currentCapital ,activeLoansCount, recentLoans, totalCollectedInterest, isLoading  } = useApp();

const getData = () => {
    getDashboards();  
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
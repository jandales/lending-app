<template>
<BasePanelWrapper :title="title">
      <template #action>
          <BaseButton  
              v-if="!selectAllState && listId.length < 2"  
              @click="toggleModal(false)" 
              name="Add new Interest"
            />      
          <BaseButton 
              v-else
              name="Delete"
              @click="deleteSeleted" 
              class="btn-danger"
          /> 
      </template>
      <template #body>
        <BaseTableWrapper>
            <BaseTable>
              <BaseTableHead>
                  <BaseTableRow>                  
                    <BaseTableTh>No.</BaseTableTh>
                    <BaseTableTh>Interest</BaseTableTh>                  
                    <BaseTableTh class="text-center">Action</BaseTableTh>
                  </BaseTableRow>
              </BaseTableHead>
              <BaseTableBody>
          
                <BaseTableRow v-for="(interest, index) in lists" :body="true" :key="interest.id">      
                    <BaseTd>{{ index + 1  }}</BaseTd>              
                    <BaseTd>{{ `${interest.value}%`}}</BaseTd>
                    
                    <BaseTd>
                        <div class="flex justify-end gap-4 mr-4 ">                     
                            <BaseButton @click="edit(interest.id)"  type="button" class="btn-icon-info">
                              <template #icon>
                                  <BaseIconEdit />
                              </template>
                            </BaseButton>
                            <BaseButton @click="destroy(interest.id)" class="btn-icon-danger">
                                <template #icon>
                                  <BaseIconDelete />
                                </template>
                            </BaseButton>
                        </div>
                    </BaseTd>
                </BaseTableRow>
              </BaseTableBody>
            </BaseTable>
            <BaseTableSpinner v-if="isLoading"/>
        </BaseTableWrapper>
       
      </template> 
</BasePanelWrapper>



<Teleport to="body">
  <AddInterestModalForm 
    v-if="addInterestState" 
    @getInterests="getInterests"
    @toggleModal="toggleModal"
    :EditState="EditState" 
    :currentInterest="EditState === true 
      ? interest
      : interest.value = 0"
   />
</Teleport>




</template>
<script setup> 

import BasePanelWrapper from '../base/BasePanelWrapper.vue'
import BaseIconDelete from '../base/icons/BaseIconDelete.vue'
import BaseTableWrapper from '../base/table/BaseTableWrapper.vue'
import BaseTable from '../base/table/BaseTable.vue'
import BaseTableHead from '../base/table/BaseTableHead.vue'
import BaseTableRow from '../base/table/TableRow.vue'
import BaseTableTh from '../base/table/BaseTableTh.vue'
import BaseTableBody from '../base/table/BaseTableBody.vue'
import BaseTd from '../base/table/BaseTd.vue'
import BaseButton from '../base/BaseButton.vue'
import BaseIconEdit from '../base/icons/BaseIconEdit.vue'
import BaseTableSpinner from '../base/table/BaseTableSpinner.vue'


import useInterests from '../../composable/interest';
import { onMounted, computed, ref, defineAsyncComponent } from 'vue';

const AddInterestModalForm = defineAsyncComponent(() => import('../settings/InterestModal.vue'));

const title = 'Interest';
const listId = ref([]);  
const selectAllState = ref(false);
const addInterestState = ref(false);
const EditState = ref(false);

const { getInterests, destroyInterest, getInterest, interests, interest, errors, success, isLoading } = useInterests();

const destroy = async (id) => {
    await destroyInterest(id);
    await getInterests();
}

const edit = async (id) => {
  errors.value = [];
  success.value = null;
  await getInterest(id);  
  toggleModal(true);   
}

const toggleModal = (isEdit) => {
    addInterestState.value = addInterestState.value === true 
    ? false
    : true;  
    EditState.value = isEdit;
}

onMounted(getInterests)
const lists = computed(() => {
    return interests.value.map(interest => {
      let date = new Date(interest.created_at);
      interest.created_at = date.toLocaleDateString("en-US"); 
      return interest;
    })
})


</script>

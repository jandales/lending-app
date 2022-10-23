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
                    <BaseTableTh>
                        <div class="flex justify-center">
                            <div class="form-check">
                              <input @change="selectAll" type="checkbox"  id="flexCheckIndeterminate" >
                            </div>
                        </div>
                    </BaseTableTh>
                    <BaseTableTh>Interest</BaseTableTh>
                    <BaseTableTh>Date created</BaseTableTh>
                    <BaseTableTh class="text-center">Action</BaseTableTh>
                  </BaseTableRow>
              </BaseTableHead>
              <BaseTableBody>
          
                <BaseTableRow v-for="interest in lists" :body="true">
                    <BaseTd>
                        <div class="flex justify-center">
                            <div class="form-check px-2">
                              <input  type="checkbox"  :value="interest.id" v-model="listId" id="flexCheckIndeterminate">
                            </div>
                        </div>  
                    </BaseTd>
                    <BaseTd>{{ `${interest.value}%`}}</BaseTd>
                    <BaseTd>{{ interest.created_at  }}</BaseTd>
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
const title = 'List of Interest';
const listId = ref([]);  
const selectAllState = ref(false);
const addInterestState = ref(false);
const EditState = ref(false);

  const { getInterests, destroyInterest, getInterest, interests, interest, errors, success, isLoading } = useInterests();



  const deleteSeleted  = () => {

      listId.value.forEach(id => { 

          destroy(id);

      })    

  }

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


  
  const selectAll = () => {    

      selectAllState.value = selectAllState.value == true ? false : true;

      listId.value = []

      if (selectAllState.value == true) {  

          interests.value.forEach(interest => {

            listId.value = [...listId.value, interest.id];

          })     

          return;

      }

      listId.value = []
      
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

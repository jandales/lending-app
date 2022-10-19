<template>
  <BasePanelWrapper :title="'List of Users'">
        <template #action>
            <router-link 
                    :to="{name : 'users.create'}"
                    class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                    Create User
            </router-link>  
        </template>
        <template #body>
          <BaseTableWrapper>
            <BaseTable>
                <BaseTableHead>
                  <BaseTableRow>
                      <BaseTableTh class="w-[50px]">
                          <div class="flex justify-center">
                              <div class="form-check px-2">
                                <input  @change="selectAll()"  type="checkbox"  id="flexCheckIndeterminate" >
                              </div>
                          </div>
                      </BaseTableTh>
                      <BaseTableTh>Name</BaseTableTh>
                      <BaseTableTh>Email</BaseTableTh>
                      <BaseTableTh>Phone</BaseTableTh>
                      <BaseTableTh>Role</BaseTableTh>
                      <BaseTableTh>Action</BaseTableTh>   
                  </BaseTableRow>             
                </BaseTableHead>            
                <BaseTableBody>                         
                  <BaseTableRow  :body="true"  v-for="(user, index) in users" :key="index">
                    <BaseTd>
                        <div class="flex justify-center">
                          <div class="form-check">
                            <input  type="checkbox"  :value="user.id" v-model="selected" id="flexCheckIndeterminate">
                          </div>
                        </div>  
                    </BaseTd>
                    <BaseTd>
                        <BaseAvatar 
                          :image="user.avatar" 
                          :name="user.name"
                        /> 
                    </BaseTd>
                    <BaseTd>{{ user.email }}</BaseTd>
                    <BaseTd>{{ user.phone }}</BaseTd>
                    <BaseTd>{{ user.role  }}</BaseTd>
                    <BaseTd>
                        <div class="flex justify-end gap-4 mr-4">                                   
                                <router-link :to="{name : 'users.edit' , params : {id : user.id} }" type="button" class="btn-icon-info">
                                    <BaseIconEdit/>
                                </router-link>                   
                                <BaseButton  @click="destroy(user.id)" class="btn-icon-danger">
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
</template>
<script setup>
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
import BaseIconDelete from '../base/icons/BaseIconDelete.vue'
import BaseIconEdit from '../base/icons/BaseIconEdit.vue'

import useUsers from '../../composable/users'
import { ref, onMounted, computed } from 'vue'


const { getUsers, destroyUser, users, isLoading } = useUsers();


const selected = ref([])

const selectAllState = ref(false);

const selectAll = () => {   

      selectAllState.value = selectAllState.value == true ? false : true;

      selected.value = []

      if(selectAllState.value == true){  

          users.value.forEach(type => {

              selected.value.push(type.id)

          })        

          return;
      }

      selected.value = []      
}

const deleteSeleted  =  () => {

    selected.value.forEach(id => { 

        destroy(id);

    })    
}
const destroy = async (id) => {

    await destroyUser(id)

    await getUsers();

}



onMounted(getUsers);




</script>
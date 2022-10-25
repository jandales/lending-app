<template>

<div class="w-full flex mb-6 justify-between">
      <div class="flex items-center justify-center">
            <div class="xl:w-52">
              <BaseSearch v-model="keyword"/>                     
            </div>
      </div>            

      <div class="flex gap-2">
      <BaseDropDown1  :options="roles" :title="'Roles'" :value="filterName"  @click-action="filterUser" />
      <BaseDropDown1  :options="usersSorting" :title="'Sort'" :value="sortBy"  @click-action="handleSort" />
</div>

</div>
  <BasePanelWrapper :title="'users'">
        <template #action>
          <router-link 
                    :to="{name : 'users.create'}"
                    class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                    Create User
            </router-link>  
        </template>
        <template #filter>
           
        </template>
        <template #body>
          <BaseTableWrapper>
            <BaseTable>
                <BaseTableHead>
                  <BaseTableRow>                            
                      <BaseTableTh>Name</BaseTableTh>
                      <BaseTableTh>Email</BaseTableTh>
                      <BaseTableTh>Phone</BaseTableTh>
                      <BaseTableTh>Date</BaseTableTh>
                      <BaseTableTh>Role</BaseTableTh>
                      <BaseTableTh class="text-center">Action</BaseTableTh>   
                  </BaseTableRow>             
                </BaseTableHead>            
                <BaseTableBody>                         
                  <BaseTableRow  :body="true"  v-for="(user, index) in users" :key="index">                            
                    <BaseTd>
                        <BaseAvatar 
                          :image="user.avatar" 
                          :name="user.name"
                        /> 
                    </BaseTd>
                    <BaseTd>{{ user.email }}</BaseTd>
                    <BaseTd>{{ user.phone }}</BaseTd>
                    <BaseTd>{{ user.created_at }}</BaseTd>
                    <BaseTd>{{ user.role  }}</BaseTd>
                    <BaseTd>
                        <div class="flex justify-end gap-4 mr-4">  

                                <router-link :to="{name : 'users.edit' , params : {id : user.id} }" type="button" class="btn-icon-info">
                                    <BaseIconEdit/>
                                </router-link>       
                                <BaseButton @click="toggleModal(true, user.id)" class="btn-icon-info" tooltip="change Password">
                                  <template #icon>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                    </svg>
                                  </template>
                                </BaseButton>            
                                <BaseButton  @click="destroy(user.id)" class="btn-icon-danger">
                                  <template #icon>
                                    <BaseIconDelete />
                                  </template>
                                </BaseButton>
                        </div>
                    </BaseTd>
                  </BaseTableRow>                          
                </BaseTableBody>  
                
                <!-- show if no record  found -->
                <BaseTableRow v-if="!isLoading && users.length === 0">
                        <BaseTd   colspan="8" class="text-center font-semibold">No Record Found</BaseTd>
                </BaseTableRow>  

            </BaseTable>  
            <BasePagination v-if="pagination.last_page > 1" :pagination="pagination" @page-change="changePage"/>
            <BaseTableSpinner v-if="isLoading"/> 
          </BaseTableWrapper>
        </template>
  </BasePanelWrapper> 
  <Teleport to="body">
    <ResetPasswordModal 
    v-if="resetPasswordState"
    :user="userId" 
    @toggleModal="toggleModal"
    />
  </Teleport>
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
import BaseSearch from '../base/BaseSearch.vue';
import BaseDropDown1 from '../base/BaseDropDown1.vue';
import BasePagination from '../Pagination.vue';

import useUsers from '../../composable/users'
import useSorting from '../../composable/sorting'
import useStatus from '../../composable/status'

import {  ref,
          onMounted,
          watch,
          defineAsyncComponent
        } from 'vue'

const  { usersSorting } = useSorting();
const  { roles } = useStatus();

const { getUsers,
        destroyUser, 
        searchUsers, 
        pagination,
        users, 
        isLoading
      } = useUsers();

const ResetPasswordModal = defineAsyncComponent(() => import('../Modal/UserResetPassword.vue'))

const keyword = ref(null);
const filterName = ref('All');
const filter =ref(null);
const sortBy = ref(null);
const resetPasswordState = ref(false);
const userId = ref(null)


const destroy = async (id) => {
    await destroyUser(id)
    await getUsers();
}


const filterUser  = (role) => {
  let value = role.value == 0  ? null  : role.value;
  filterName.value = role.name
  filter.value = value
  getUsers(1, filter.value);
}

const handleSort  = (sort) => {
    sortBy.value = sort.displayName      
    getUsers(1, filter.value, sort);
};

const changePage = (page) => {
    page = page.split("=")[1];   
    getUsers(page, filter.value)
}

const toggleModal = (state, user) => {
  resetPasswordState.value = state;
  userId.value = user;
}

onMounted(() => {  
  getUsers(); 
});


watch( keyword, async (value) => {
  if (value.length > 0 ) {
    await searchUsers(value); 
     return;
  }
  await getUsers()
});

</script>
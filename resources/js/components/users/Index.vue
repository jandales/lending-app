<template>
  <div class="border   w-full bg-white rounded-md">
    <div class="flex  p-4 justify-between items-center">
    <h1>List of Users</h1>   

    <router-link 
          :to="{name : 'users.create'}"
          class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
          Create User
    </router-link>  
 
</div>
<div  class="border border-l-0 border-r-0 bg-white">
  <div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full sm:px-6 lg:px-8">       
        <div class="overflow-hidden">      
          <table class="min-w-full">
            <thead class="bg-white border-b">
              <tr>  
                <th class="w-[50px]">
                    <div class="flex justify-center">
                      <div class="form-check px-2">
                        <input  @change="selectAll()"  type="checkbox"  id="flexCheckIndeterminate" >
                      </div>
                    </div>
                </th>           
                <th scope="col">
                  Name
                </th>
                <th scope="col">
                    Email
                </th>
                <th scope="col">
                    Phone
                </th>
                 <th scope="col">
                   Role
                </th>
                <th scope="col">
                
                </th>
              </tr>
            </thead>
            <tbody>  
              <tr v-if="users.length > 0" v-for="user in users" class="bg-white border-b transition duration-300 ease-in-out last:border-b-0 hover:bg-gray-100"> 
                <td>
                  <div class="flex justify-center">
                    <div class="form-check">
                      <input  type="checkbox"  :value="user.id" v-model="selected" id="flexCheckIndeterminate">
                    </div>
                  </div>  
                </td>            
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">    
               
                      <BaseAvatar
                        :image="user.avatar"
                        :name="user.name"
                      /> 
                 
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                     {{ user.email}}
                </td>  
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ user.phone }}
                </td>    
                
                 <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ user.role }}
                </td>  
      
                   
                <td>
                  <div class="flex justify-end gap-4 mr-4 ">                                   
                     <router-link :to="{name : 'users.edit' , params : {id : user.id} }" type="button" class="btn-icon-info">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                              </svg>
                      </router-link>
                     <button  @click="destroy(user.id)" type="button" class="btn-icon-danger">
                       

               

                         <svg  xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>

                      </button> 
                  </div>
                </td>
              </tr>
              <tr v-else>
                <td colspan="8" class="text-xl text-center text-gray-900 font-light px-6 py-4 whitespace-nowrap">No Record Found</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>
  </div>

 
</template>
<script setup>
import BaseAvatar from '../base/BaseAvatar.vue';
import useUsers from '../../composable/users';


import { ref, onMounted, computed } from 'vue';



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
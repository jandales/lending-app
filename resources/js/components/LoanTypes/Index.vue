<template>
  <div class="w-full bg-white">
      <div class="flex justify-between items-center p-4">
      <h1>List of types</h1>     
      <router-link  v-if="!selectAllState && listId.length < 2"
            to="/loan-types/create"
            class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
            Create new type
      </router-link>
       <button v-else @click="deleteSeleted" type="button" class="inline-block px-6 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out">Delete</button>
  </div>
  <div  class="border border-l-0 border-r-0 bg-white">
    <div class="flex flex-col">
      <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full sm:px-6 lg:px-8">       
          <div class="overflow-hidden">      
            <table class="min-w-full">
              <thead class="bg-white border-b">
                <tr>  
                  <th>
                      <div class="flex justify-center">
                        <div class="form-check">
                          <input  @change="selectAll" type="checkbox"  id="flexCheckIndeterminate" >
                        </div>
                      </div>
                  </th>           
                  <th scope="col">
                    Type
                  </th>
                  <th scope="col" >
                  Interest
                  </th>
                  <th scope="col">
                    Description
                  </th>
                  <th scope="col">
                   
                  </th>
                </tr>
              </thead>
              <tbody>  
                <tr v-for="loanType in loanTypes" class="bg-white border-b transition duration-300 ease-in-out last:border-b-0 hover:bg-gray-100"> 
                  <td>
                    <div class="flex justify-center">
                      <div class="form-check px-2">
                        <input  type="checkbox"  :value="loanType.id" v-model="listId" id="flexCheckIndeterminate">
                      </div>
                    </div>  
                  </td>            
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    {{loanType.type}}
                  </td>
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    {{`${loanType.interest}%`}}
                  </td>
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    {{loanType.description}}
                  </td>         
                  <td>
                    <div class="flex justify-end gap-4 mr-4 ">
                        <router-link :to="{name : 'loanTypes.edit' , params : {id : loanType.id} }" type="button" class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">Edit</router-link>
                        <button @click="deleteLoanType(loanType.id)" type="button" class="inline-block px-6 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out">Delete</button>
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
 
</template>
<script setup>

  import useLoanTypes from '../../composable/loanType';
  import { onMounted, ref } from 'vue';

  const listId = ref([]);
  const selectAllState = ref(false);

  const { getLoanTypes, destroyLoanType ,loanTypes} = useLoanTypes();

  const deleteLoanType = async(id)=>{
      await destroyLoanType(id);
  }

  const deleteSeleted  = () => {
      listId.value.forEach(id => { 
           destroyLoanType(id)
      })    
  }
  
  const selectAll = () => {       
      selectAllState.value = selectAllState.value == true ? false : true;
      listId.value = []
      if(selectAllState.value == true){  
          loanTypes.value.forEach(type => {
              listId.value.push(type.id)
          })        
          return;
      }

      listId.value = []
      
  }

  onMounted(getLoanTypes)

</script>
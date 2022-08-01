<template>

  <div class="w-full bg-white">
      <div class="flex justify-between items-center p-4">
      <h1>List of Interest</h1>     
      <button  v-if="!selectAllState && listId.length < 2"     
            class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
            data-bs-toggle="modal" data-bs-target="#exampleModal"
            >
            Create Payment
      </button>
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
                    Interest
                  </th>
                 
                  <th scope="col" >
                    Date of payment
                  </th>
             
                  <th scope="col">
                   
                  </th>
                </tr>
              </thead>
              <tbody>  
                <tr v-for="interest in interests" class="bg-white border-b transition duration-300 ease-in-out last:border-b-0 hover:bg-gray-100"> 
                  <td>
                    <div class="flex justify-center">
                      <div class="form-check px-2">
                        <input  type="checkbox"  :value="interest.id" v-model="listId" id="flexCheckIndeterminate">
                      </div>
                    </div>  
                  </td>           
                  
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    {{ `${interest.value}%`}}
                  </td>
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    {{ interest.created_at }}
                  </td>                   
                  <td>
                    <div class="flex justify-end gap-4 mr-4 ">                     
                        <button @click="edit(interest.id)" data-bs-toggle="modal" data-bs-target="#ModalEdit"  type="button" class="btn-primary">Edit</button>
                        <button @click="destroy(interest.id)" type="button" class="inline-block px-6 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out">Void</button>
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
 
<!-- Modal -->
<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
  id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog relative w-auto pointer-events-none">
    <div
      class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
      <div
        class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
        <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel">Add new Interest</h5>
        <button type="button"
          class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
          data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body relative p-4">
         <Alert v-if="success" :alert="'success'" :message="success"/>
       <BaseInput 
            :label="'Interest'"
            :type="'number'"
            :id="'interest'"
            :errors="errors.value"
            v-model="interestValue"
       />
      </div>
      <div
        class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
        <button type="button" class="px-6
          py-2.5
          bg-purple-600
          text-white
          font-medium
          text-xs
          leading-tight
          uppercase
          rounded
          shadow-md
          hover:bg-purple-700 hover:shadow-lg
          focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0
          active:bg-purple-800 active:shadow-lg
          transition
          duration-150
          ease-in-out" data-bs-dismiss="modal">Close</button>
        <button type="button" class="px-6
      py-2.5
      bg-blue-600
      text-white
      font-medium
      text-xs
      leading-tight
      uppercase
      rounded
      shadow-md
      hover:bg-blue-700 hover:shadow-lg
      focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
      active:bg-blue-800 active:shadow-lg
      transition
      duration-150
      ease-in-out
      ml-1"
      @click="store">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
  id="ModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog relative w-auto pointer-events-none">
    <div
      class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
      <div
        class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
        <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel">Edit Interest</h5>
        <button type="button"
          class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
          data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body relative p-4">
        <!-- <Alert v-if="success" :alert="'success'" :message="success"/> -->
       <BaseInput
            v-if="interest" 
            :label="'Interest'"
            :type="'number'"
            :id="'interest'"
            :errors="errors.value"
            v-model="interest.value"
       />
      </div>
      <div
        class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
        <button type="button" class="px-6
          py-2.5
          bg-purple-600
          text-white
          font-medium
          text-xs
          leading-tight
          uppercase
          rounded
          shadow-md
          hover:bg-purple-700 hover:shadow-lg
          focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0
          active:bg-purple-800 active:shadow-lg
          transition
          duration-150
          ease-in-out" 
          data-bs-dismiss="modal">Close</button>
        <button type="button" class="px-6
      py-2.5
      bg-blue-600
      text-white
      font-medium
      text-xs
      leading-tight
      uppercase
      rounded
      shadow-md
      hover:bg-blue-700 hover:shadow-lg
      focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
      active:bg-blue-800 active:shadow-lg
      transition
      duration-150
      ease-in-out
      ml-1"
      data-bs-dismiss="modal"
      @click="update">Save changes</button>
      </div>
    </div>
  </div>
</div>




</template>
<script setup>
  import Alert from '../Alert.vue';
  import BaseInput from '../../components/base/BaseInput.vue';
  import useInterests from '../../composable/interest';
  import { onMounted, ref } from 'vue';

  const listId = ref([]);
  const selectAllState = ref(false);

  const interestValue = ref(0)

  const { getInterests, getInterest, destroyInterest, storeInterest,updateInterest, interests, interest, errors, success } = useInterests();

  const store = async () => { 
     await storeInterest({value : parseInt(interestValue.value)});
     await getInterests();
     interestValue.value = null;
  }

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
       await interestValugetInterest(id);
  }

  const update = async () => {
        await updateInterest(interest.value.id, interest.value)
        await getInterests();
  }
  
  const selectAll = () => {       
      selectAllState.value = selectAllState.value == true ? false : true;
      listId.value = []
      if(selectAllState.value == true){  
          interests.value.forEach(interest => {
            listId.value = [...listId.value, interest.id];          
          })        
          return;
      }

      listId.value = []
      
  }

  onMounted(getInterests)

</script>

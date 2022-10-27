<template>
<div class="modal fade fixed top-0 left-0 w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="exampleModalLg" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-lg relative w-auto pointer-events-none">
    <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
      <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
        <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLgLabel">
          Find Borrower
        </h5>
        <button type="button"
          class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
          data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body relative p-4">
            <div class="border flex items-center">
                <input type="text" @input="search($event)" class="!border-0 !outline-none focus:!border-0" name="" id="">
                <span class="block px-4 ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </span>
            </div>
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <table class="min-w-full">
                        <thead class="bg-white border-b">
                            <tr>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                #
                            </th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                Name
                            </th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                Address
                            </th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                Phone
                            </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="borrowers.length === 0">
                                <td colspan="4" class="text-sm text-gray-900 text-center font-light px-6 py-4 whitespace-nowrap">No borrower found</td>
                            </tr>
                            <tr v-for="borrower in borrowers" class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <div class="form-check">
                                    <input v-model="selected" class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="borrower" id="flexCheckChecked" :value="borrower">                    
                                </div>
                            </td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                            {{ borrower.name }}
                            </td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                            {{ borrower.address}}
                            </td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                            {{ borrower.phone}}
                            </td>             
                            </tr>           
                        </tbody>
                        </table>
                    </div>
                    </div>   
                </div>
            </div>
           <div class="flex gap-4 justify-end mt-4">
                <button type="button" class="btn-danger" data-bs-dismiss="modal">Cancel</button>
                <button @click="selectBorrower" data-bs-dismiss="modal" class="btn-primary">Select</button>
           </div>
      </div>
    </div>
  </div>
</div>
</template>
<script setup>
    import {  ref } from 'vue';
    import useBorrowers from '../../composable/borrowers';

    const { getBorrowers, borrowerSearch , borrowers} = useBorrowers(); 
    const emit = defineEmits(['selectBorrower']);
    const selected  = ref();


    const search = (event) => {
        let keyword = event.target.value; 
        if(keyword == null) return;   
        borrowerSearch(keyword);
    }

    const selectBorrower = () => {      
        emit('selectBorrower', selected.value);
    }

    // const listborrowers = computed(() => {
    //     if(borrowers.value.length == 0) return [];
    //     borrowers.value.filter(borrower => {
    //         if (borrower.status == 'void' || borrower.status == 'paid')
    //         {
    //             return borrower;
    //         }
    //     })
    // });


</script>
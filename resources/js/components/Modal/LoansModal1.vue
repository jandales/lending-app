<script setup>
import {ref, watch} from 'vue';
import useLoans from '../../composable/loans';
const { loanSearch , loans} = useLoans(); 

const keyword  = ref('')
const modal = ref(null)


const emit = defineEmits(['select', 'close']);

const select = (borrower) => {
    emit('select', borrower);
    emit('close', false);    
}

const close = (event) => {
    if(event.target == modal.value){
        emit('close',false);
    };
}

watch(keyword, async (value) => {
    if (value.length > 0) {
        await loanSearch(value);
        return;
    } 
    loans.value = [];       
})

</script>
<template>
    <div id="modal" ref="modal" @click="close($event)" class="fixed w-full flex justify-center z-10 top-0 left-0 min-h-screen backdrop-blur-sm bg-black/30 ...">
        <div class="relative w-full max-w-lg transform px-4 transition-all opacity-100 scale-100 py-10 h-fit">
            <div class="overflow-hidden rounded-lg bg-white shadow-md" id="headlessui-dialog-panel-506">
                <div class="flex items-center">
                    <input v-model="keyword"
                    class="block w-full 
                    appearance-none 
                    bg-transparent 
                    py-4 pl-4 pr-4
                    text-base
                  text-slate-900
                    placeholder:text-slate-600
                    focus:outline-none 
                    sm:text-sm 
                    sm:leading-6" placeholder="Find borrower..."  role="combobox" type="search" aria-expanded="true" tabindex="0" style="caret-color: rgb(107, 114, 128);">
                    <svg class="pointer-events-none  mr-4 h-6 w-6 fill-slate-400" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.47 21.53a.75.75 0 1 0 1.06-1.06l-1.06 1.06Zm-9.97-4.28a6.75 6.75 0 0 1-6.75-6.75h-1.5a8.25 8.25 0 0 0 8.25 8.25v-1.5ZM3.75 10.5a6.75 6.75 0 0 1 6.75-6.75v-1.5a8.25 8.25 0 0 0-8.25 8.25h1.5Zm6.75-6.75a6.75 6.75 0 0 1 6.75 6.75h1.5a8.25 8.25 0 0 0-8.25-8.25v1.5Zm11.03 16.72-5.196-5.197-1.061 1.06 5.197 5.197 1.06-1.06Zm-4.28-9.97c0 1.864-.755 3.55-1.977 4.773l1.06 1.06A8.226 8.226 0 0 0 18.75 10.5h-1.5Zm-1.977 4.773A6.727 6.727 0 0 1 10.5 17.25v1.5a8.226 8.226 0 0 0 5.834-2.416l-1.061-1.061Z">
                        </path>
                    </svg>
                </div>
             
                <div v-if="keyword.length > 0 && loans.length == 0 " class="bg-slate-50 py-20 px-16 text-center border-t"><h2 class="font-semibold text-slate-900">No results found</h2></div>
                <ul v-else class="max-h-[18.375rem] divide-y divide-slate-200 overflow-y-auto rounded-b-lg border-t border-slate-200 text-sm leading-6">
                    <li v-for="loan in loans" :key="loan.id" @click="select(loan)" class="flex items-center justify-between p-4 bg-slate-50 cursor-pointer">
                        <span class="whitespace-nowrap font-semibold text-sky-600">{{ loan.loan_number }}</span>
                        <span class="ml-4 text-right text-xs text-slate-600">{{ `${loan.borrower.name} / ${loan.borrower.email}` }}</span>
                    </li>
                </ul>
              
            </div>
        </div>    
    </div>
</template>
<template>
    <div class="fixed w-full flex justify-center z-10 top-0 left-0 min-h-screen backdrop-blur-sm bg-slate-900/40 transition-all ease-in-out duration-300">
        <div class="bg-white max-w-md h-fit border border-slate-200 shadow-card rounded-xl mt-12 p-5">
            <div class="flex items-center">
                <span class="text-amber-500 bg-amber-50 p-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </span>
                <h1 class="ml-3 text-slate-800 font-semibold text-base">{{heading}}</h1>
            </div>

            <div class="text-sm text-slate-500 px-1 mt-3">{{ message }}</div>

            <div class="w-full flex justify-end items-end mt-5 gap-3">                
                <BaseButton  @click="confirm(false)" :isLoading="isLoading" name="Close" class="btn-light" />
                <BaseButton  @click="confirm(true)" :isLoading="isLoading" name="Confirm" />
            </div>


        </div>
    </div>
</template>

<script setup>
import BaseButton from '../base/BaseButton.vue'
import { ref }  from 'vue'
const isLoading = ref(false);
const props = defineProps({
    heading : String,
    message  : String,   
})



const emit  =  defineEmits(['result'])

function confirm(result) {
    isLoading.value = true;
    emit('result', result)
}


</script>

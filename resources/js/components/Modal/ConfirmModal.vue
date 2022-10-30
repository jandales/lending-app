<template>
    <div class="fixed w-full flex justify-center z-10 top-0 left-0 min-h-screen backdrop-blur-sm bg-black/30  transition-all ease-in-out duration-[500ms]">
        <div class="bg-white max-w-md h-fit  border shadow-xl rounded-xl mt-12 p-4">
            <div class="flex items-center">
                <span class="text-amber-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </span>
                <h1 class="ml-2 text-gray-500 font-bold text-base">{{heading}}</h1>
            </div>

            <div class="text-sm text-gray-500 px-4 mt-2">{{ message }}</div>

            <div class="w-full flex justify-end items-end mt-4 gap-4">                
                <BaseButton  @click="confirm(false)" :isLoading="isLoading" name="Close" class="btn-danger" />
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
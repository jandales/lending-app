<template>
     <div class="w-1/3 p-4 bg-white rounded-lg shadow-md min-h-[100px]">       
        <div class="flex justify-between items-center">
           <div>
             <div class="flex w-full text-gray-500 font-semibold text-sm capitalize mb-4">{{props.title}}</div>
            <div class="text-xl  text-gray-700 font-bold">{{props.value}}</div>
           </div>

            <span v-if="props.icon == 'person'"  class="bg-sky-500 text-white p-4 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </span>
            <span v-if="props.icon == 'capital'"  class="bg-teal-400 text-white p-4 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </span>
            <span v-if="props.icon == 'revenue'" class="bg-rose-500 text-white p-4 rounded-md">
               <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                </svg>
            </span>
        </div>
     </div>
     
</template>
<script setup>
    const props = defineProps({
        title : {
            type: String,
            default : ''
        },
        value : {
            type: [String, Number],
            default : null,
        },
        icon : {
            type : String,
            default : ''
        } 

    })
</script>
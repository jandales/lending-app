<template>
    <div class="flex">
        <Sidebar></Sidebar> 
        <div class="w-[calc(100%_-_15rem)] flex flex-col ml-auto ">
           <div class="h-16 flex items-center px-8 ">  
                 <h1 class="text-gray-500 capitalize">{{pageTitle}}</h1>
           </div>
           <div class="p-8">              
                <router-view></router-view>
           </div>
        </div>     
    </div>
   
</template>
<script setup> 

import { computed } from 'vue';
import { useRoute } from 'vue-router';
import Sidebar from '../components/Sidebar.vue'   

const route = useRoute();


const pageTitle = computed(() => { 

    let name = route.name;  

    const nameList = name.split(".");

    return name = nameList[0];
    
})


</script>
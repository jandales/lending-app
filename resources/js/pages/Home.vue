<template>
    <div class="flex">
        <Sidebar></Sidebar> 
        <div class="w-[calc(100%_-_15rem)] flex flex-col ml-auto ">
           <div class="h-16 flex items-center px-8 ">  
                 <h1 class="text-gray-500">{{pageTitle}}</h1>
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
const listword = ['index', 'create', 'edit'];

const pageTitle = computed(() => {     
    let name = route.name;     
    listword.forEach(word => {
        name = name.replace(`.${word}`, '')
    });

    switch (name) {
        case 'dashboard' :
            return 'Dashboard'
        case 'loanTypes' :
            return 'Loan Types';              
        case 'customers':
            return 'Customers';
        case 'transactions':
            return 'Transactions';  
        case 'reports':
            return 'Reports'; 
        case 'settings':
            return 'Settings';   
        default:
            return 'Dashboard'            
    }
    
})
</script>
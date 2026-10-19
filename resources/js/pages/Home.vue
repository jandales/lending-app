<template>
    <div class="flex min-h-screen bg-canvas">
        <Sidebar></Sidebar>
        <div class="w-[calc(100%_-_16rem)] flex flex-col ml-auto min-h-screen">
           <div class="h-[4.25rem] flex items-center justify-between px-10 sticky top-0 z-10 bg-canvas/80 backdrop-blur-md">
                 <h1 class="text-2xl font-bold text-slate-800 capitalize tracking-tight">{{pageTitle}}</h1>
           </div>
           <div class="px-10 pb-10">
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

<template>
    <div class="flex items-start content-start gap-6">
        <div class="w-56 rounded-3xl bg-white shadow-card border border-white flex p-3 shrink-0">
            <ul class="w-full relative space-y-1">
                <li class="relative">
                    <router-link :to="{name : 'settings.profile'}" class="flex items-center text-sm py-3 px-3.5 overflow-hidden text-slate-500 text-ellipsis whitespace-nowrap rounded-2xl hover:text-brand-700 hover:bg-brand-50/80 transition duration-150 ease-in-out font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        <span>Profile</span>
                    </router-link>
                </li> 
                <li v-if="role < 2" class="relative">
                    <router-link :to="{name : 'settings.interest'}" class="flex items-center text-sm py-3 px-3.5 overflow-hidden text-slate-500 text-ellipsis whitespace-nowrap rounded-2xl hover:text-brand-700 hover:bg-brand-50/80 transition duration-150 ease-in-out font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
                        </svg>
                        <span>Interest</span>
                    </router-link>
                </li>               
            </ul>
        </div>
        <div class="w-[calc(100%_-_15rem)] min-w-0">
            <router-view></router-view>
        </div>
    </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue';
    const role = ref();

    const getUser = () =>  {
         role.value =  JSON.parse(localStorage.getItem('user')).role;
    }

    onMounted(() => {
        getUser();
    })
  
</script>

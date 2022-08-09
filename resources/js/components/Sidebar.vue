<template>
    <div class="w-60 h-full shadow-md bg-white fixed" id="sidenavSecExample">
  <div class="pt-4 pb-2 px-6">
    <a href="#!">
      <div class="flex items-center">
        <div v-if="user" class="shrink-0">        
          <img v-if="user.avatar" :src="user.avatar" class="rounded-full border w-10 h-10" alt="Avatar">
          <img v-else :src="$defaultAvatarSrc" class="rounded-full border w-10 h-10" alt="Avatar">
        </div>
        <div v-else class="shrink-0"> 
            <img  :src="$defaultAvatarSrc" class="rounded-full border w-10 h-10" alt="Avatar">
        </div>
        <div class="grow ml-3">
          <p v-if="user" class="text-sm font-semibold text-blue-600">{{ `${user.name}`}}</p>
        </div>
      </div>
    </a>
  </div>
  <ul class="relative px-1">
    <li class="relative">
      <NavItem :route="{name:'dashboard'}" :label="'dashboard'"/>    
    </li>
    <!-- <li class="relative">
       <NavItem  :route="{name : 'loanTypes'}" :label="'loan Type'"  />   
    </li> -->
    <li class="relative">
        <NavItem  :route="{name : 'loans'}" :label="'loans'"  />
    </li>  
    <li class="relative">
        <NavItem  :route="{name : 'payments'}" :label="'payments'"  />  
    </li>  
    <li class="relative">
      <NavItem :to="{name : 'borrowers'}" :label="'borrowers'"/>
    </li> 
    <li class="relative">
      <NavItem :to="{name : 'reports'}" :label="'reports'"/>
    </li>    
   
  </ul>
  <hr class="my-2"> 
  <div class="text-center bottom-0 absolute w-full">
    <hr class="m-0">
   
    <ul class="relative px-1">
          <li class="relative">
            <NavItem :route="{name : 'settings'}" :label="'settings'"/>             
          </li> 
         <li class="relative">
            <div @click="signOut" class="flex items-center text-sm py-4 px-6 h-12 overflow-hidden text-gray-700 text-ellipsis whitespace-nowrap rounded hover:text-blue-600 hover:bg-blue-50 transition duration-300 ease-in-out" href="#!" data-mdb-ripple="true" data-mdb-ripple-color="primary">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
              </svg>
              <span>Logout</span>
            </div>
        </li> 
    </ul>
  </div>
</div>
</template>
<script setup>
  import { onMounted } from 'vue';
  import useUser from '../composable/user';
  import NavItem from './base/NavItem.vue';
  const  {  getUser, user, logout} = useUser()

  const signOut = async()=> {      
      await logout();
  }
  onMounted(getUser);
</script>
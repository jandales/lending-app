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
          <router-link v-if="user" :to="{name : 'settings.profile'}">
            <p  class="text-sm font-semibold text-blue-600">{{ `${user.name}`}}</p>
          </router-link>
         
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
     <li class="relative" id="sidenavEx1">
      <a class="flex items-center text-sm py-4 px-6 h-12 overflow-hidden text-gray-700 text-ellipsis whitespace-nowrap rounded hover:text-gray-900 hover:bg-gray-100 transition duration-300 ease-in-out cursor-pointer" data-mdb-ripple="true" data-mdb-ripple-color="dark" data-bs-toggle="collapse" data-bs-target="#collapseSidenavEx1" aria-expanded="true" aria-controls="collapseSidenavEx1">
        <svg aria-hidden="true" focusable="false" data-prefix="fas" class="w-3 h-3 mr-3" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
          <path fill="currentColor" d="M216 0h80c13.3 0 24 10.7 24 24v168h87.7c17.8 0 26.7 21.5 14.1 34.1L269.7 378.3c-7.5 7.5-19.8 7.5-27.3 0L90.1 226.1c-12.6-12.6-3.7-34.1 14.1-34.1H192V24c0-13.3 10.7-24 24-24zm296 376v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h146.7l49 49c20.1 20.1 52.5 20.1 72.6 0l49-49H488c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z"></path>
        </svg>
        <span>Reports</span>
        <svg aria-hidden="true" focusable="false" data-prefix="fas" class="w-3 h-3 ml-auto" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
          <path fill="currentColor" d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"></path>
        </svg>
      </a>
      <ul class="relative accordion-collapse collapse" id="collapseSidenavEx1" aria-labelledby="sidenavEx1" data-bs-parent="#sidenavExample">
        <li class="relative">          
          <router-link :to="{name: 'report.loans'}" class="flex items-center text-xs py-4 pl-12 pr-6 h-6 overflow-hidden text-gray-700 text-ellipsis whitespace-nowrap rounded hover:text-gray-900 hover:bg-gray-100 transition duration-300 ease-in-out" data-mdb-ripple="true" data-mdb-ripple-color="dark">Loans</router-link>
        </li>
        <li class="relative">
          <router-link  :to="{name: 'report.customers'}" class="flex items-center text-xs py-4 pl-12 pr-6 h-6 overflow-hidden text-gray-700 text-ellipsis whitespace-nowrap rounded hover:text-gray-900 hover:bg-gray-100 transition duration-300 ease-in-out" data-mdb-ripple="true" data-mdb-ripple-color="dark">Customers</router-link>
        </li>
         <li class="relative">
         <router-link :to="{name: 'report.payments'}"  class="flex items-center text-xs py-4 pl-12 pr-6 h-6 overflow-hidden text-gray-700 text-ellipsis whitespace-nowrap rounded hover:text-gray-900 hover:bg-gray-100 transition duration-300 ease-in-out" data-mdb-ripple="true" data-mdb-ripple-color="dark">Payments</router-link>
        </li>
      </ul>
    </li>
    <li v-if="user && user.role < 1" class="relative">
      <NavItem :to="{name : 'users'}" :label="'users'"/>
    </li>    
   
  </ul>
  <hr class="my-2"> 
  <div class="text-center bottom-0 absolute w-full">
    <hr class="m-0">
   
    <ul class="relative px-1">
        
          <li  class="relative">
            <NavItem :route="{name : 'settings.profile'}" :label="'settings'"/>             
          </li> 
         <li class="relative">
            <div @click="signOut" class="flex items-center text-sm py-4 px-6 h-12 overflow-hidden text-gray-700 text-ellipsis whitespace-nowrap rounded hover:text-blue-600 hover:bg-blue-50 transition duration-300 ease-in-out cursor-pointer"  href="#!" data-mdb-ripple="true" data-mdb-ripple-color="primary">
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
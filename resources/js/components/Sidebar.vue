<template>
    <div class="w-64 h-full bg-white fixed flex flex-col shadow-card z-20" id="sidenavSecExample">
  <div class="pt-6 pb-5 px-5">
    <a href="/" class="flex items-center gap-3 px-2 mb-6">
      <div class="w-10 h-10 rounded-2xl brand-gradient flex items-center justify-center shadow-glow shrink-0">
        <span class="text-white font-bold text-lg">E</span>
      </div>
      <div class="min-w-0">
        <p class="text-base font-bold text-slate-800 tracking-tight truncate">Etto</p>
        <p class="text-[11px] text-slate-400 font-medium">Lending System</p>
      </div>
    </a>
    <router-link v-if="user" :to="{name : 'settings.profile'}" class="flex items-center gap-3 px-2 py-2 rounded-2xl hover:bg-slate-50 transition">
      <div class="shrink-0">
        <img v-if="user.avatar" :src="user.avatar" class="rounded-full border-2 border-brand-100 w-9 h-9 object-cover" alt="Avatar">
        <img v-else :src="$defaultAvatarSrc" class="rounded-full border-2 border-brand-100 w-9 h-9 object-cover" alt="Avatar">
      </div>
      <div class="grow min-w-0">
        <p class="text-sm font-semibold text-slate-700 truncate">{{ `${user.name}`}}</p>
        <p class="text-[11px] text-slate-400">View profile</p>
      </div>
    </router-link>
  </div>
  <ul class="relative px-3 flex-1 space-y-1">
    <li class="relative">
      <NavItem :route="{name:'dashboard'}" :label="'dashboard'"/>
    </li>
    <li class="relative">
        <NavItem  :route="{name : 'loans'}" :label="'loans'"  />
    </li>
    <li v-if="user && user.isAdmin" class="relative">
        <NavItem  :route="{name : 'funds'}" :label="'funds'"  />
    </li>
    <li class="relative">
        <NavItem  :route="{name : 'payments'}" :label="'payments'"  />
    </li>
    <li class="relative">
      <NavItem :route="{name : 'borrowers'}" :label="'borrowers'"/>
    </li>
     <li class="relative" id="sidenavEx1">
      <a class="flex items-center text-sm py-3 px-3.5 mx-0.5 overflow-hidden text-slate-500 text-ellipsis whitespace-nowrap rounded-2xl hover:text-brand-700 hover:bg-brand-50/80 transition duration-150 ease-in-out cursor-pointer font-medium" data-bs-toggle="collapse" data-bs-target="#collapseSidenavEx1" aria-expanded="true" aria-controls="collapseSidenavEx1">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <span>Reports</span>
        <svg class="w-3.5 h-3.5 ml-auto text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
      </a>
      <ul class="relative accordion-collapse collapse mt-0.5" id="collapseSidenavEx1" aria-labelledby="sidenavEx1" data-bs-parent="#sidenavExample">
        <li class="relative">
          <router-link :to="{name: 'report.loans'}" class="flex items-center text-sm py-2.5 pl-12 pr-3 mx-0.5 overflow-hidden text-slate-500 text-ellipsis whitespace-nowrap rounded-xl hover:text-brand-700 hover:bg-brand-50/80 transition duration-150 ease-in-out">Loans</router-link>
        </li>
        <li class="relative">
          <router-link  :to="{name: 'report.customers'}" class="flex items-center text-sm py-2.5 pl-12 pr-3 mx-0.5 overflow-hidden text-slate-500 text-ellipsis whitespace-nowrap rounded-xl hover:text-brand-700 hover:bg-brand-50/80 transition duration-150 ease-in-out">Customers</router-link>
        </li>
         <li class="relative">
         <router-link :to="{name: 'report.payments'}"  class="flex items-center text-sm py-2.5 pl-12 pr-3 mx-0.5 overflow-hidden text-slate-500 text-ellipsis whitespace-nowrap rounded-xl hover:text-brand-700 hover:bg-brand-50/80 transition duration-150 ease-in-out">Payments</router-link>
        </li>
      </ul>
    </li>
    <li v-if="user && user.isAdmin" class="relative">
      <NavItem :route="{name : 'users'}" :label="'users'"/>
    </li>

  </ul>


  <div class="mt-auto border-t border-slate-100 py-3 px-3">
    <ul class="relative space-y-1">
          <li class="relative">
            <NavItem :route="{name : 'settings.profile'}" :label="'settings'"/>
          </li>
         <li class="relative">
            <div @click="signOut" class="flex items-center text-sm py-3 px-3.5 mx-0.5 overflow-hidden text-slate-500 text-ellipsis whitespace-nowrap rounded-2xl hover:text-rose-600 hover:bg-rose-50 transition duration-150 ease-in-out cursor-pointer font-medium">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
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
import useUser from '../composable/user'
import NavItem from './base/NavItem.vue';

const  { getUser, user, logout } = useUser()

const signOut = async() => {
    await logout();
}

onMounted(getUser);

</script>

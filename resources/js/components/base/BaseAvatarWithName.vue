<template> 
    <div class="flex items-center"  v-bind="$attrs">
            <img
                v-if="user.image"
                :src="user.image"
                class="rounded-full w-10 h-10 border border-slate-200 object-cover"
                alt="Avatar"
            />
            <img
                v-else
                :src="$defaultAvatarSrc"
                class="rounded-full w-10 h-10 border border-slate-200 object-cover"
                alt="Avatar"
            />
            <div class="ml-3 min-w-0">
                <span class="block text-sm font-semibold text-slate-800 truncate">{{ user.name }}</span>
                <span class="block text-xs text-slate-400 truncate">{{ user.email }}</span>
            </div>
     </div>
  </template>
  
  <script setup>

      const props = defineProps({          
          user : { 
              type: String,
              default: '',
          }
      });
  </script>
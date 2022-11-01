<template> 
    <div class="flex items-center"  v-bind="$attrs">
            <img
                v-if="user.image"
                :src="user.image"
                class="rounded-full w-12 shadow-lg"
                alt="Avatar"
            />
            <img
                v-else
                :src="$defaultAvatarSrc"
                class="rounded-full w-12 shadow-lg"
                alt="Avatar"
            />   
            
         
            <div class="ml-4">
                <span class="block text-sm">{{ user.name }}</span>
                <span class="block text-sm">{{ user.email }}</span>
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
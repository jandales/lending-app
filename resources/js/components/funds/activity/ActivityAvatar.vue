<template> 
    <div class="flex items-center">
            <img
                v-if="user.image"
                src="https://mdbcdn.b-cdn.net/img/new/avatars/1.webp"
                class="rounded-full w-12 shadow-lg"
                alt="Avatar"
            />
            <img
                v-else
                :src="$defaultAvatarSrc"
                class="rounded-full w-9 h-9 border"
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
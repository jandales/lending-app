  
  <script setup>
  const props = defineProps({          
      activity : { 
          type: Object,
          default: null,
      }
  });
</script>
<template>
    <div class="flex items-center ml-[10rem]">
        <div class="w-full">
            <span class="block text-sm">Applied on {{ activity.created_at }} </span>
            <div class="flex mt-2">
                <div class="mr-2">
                    <span class="block">
                    <svg v-if="activity.action  == 'deposit'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-orange-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    </span>
                </div>
                <p class="text-sm text-gray-500">{{ activity.remark }}</p>
                
            </div>
        </div>
    </div>
</template>
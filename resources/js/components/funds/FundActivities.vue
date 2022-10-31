<script setup>
    const props = defineProps({activities : Array})
    const emit = defineEmits(['showActivity']);

    const show = (activity) => {
        emit('showActivity', activity);
    }
</script>

<template>
   <ul class="bg-white overflow-hidden z-20 rounded-lg">
    <li v-for="activity in activities">
      <div class="border border-b-0 w-full p-4">

        <div class="flex justify-between">
         <div class="flex">
            <img
                src="https://mdbcdn.b-cdn.net/img/new/avatars/1.webp"
                class="rounded-full w-12 shadow-lg"
                alt="Avatar"
            />
            <div class="ml-4">
                <span class="block text-sm">{{ activity.user.name }}</span>
                <span class="block text-sm">{{ activity.user.email }}</span>
            </div>
        </div>

        <div class="flex items-center">
            <div class="ml-4">
                <span class="block text-sm">Applied on {{ activity.created_at }} </span>
                <div class="flex mt-2">
                    <div class="mr-2">
                        <span class="block">
                        <svg v-if="activity.action  == 'add'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-500">
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

        <div class="flex items-center"> 
            <svg @click="show(activity)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500 hover:text-gray-700">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </div>


        </div>


      </div>
    </li>

   </ul>
</template>
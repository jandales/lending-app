<template>
  <div class="flex items-center">                  
        <img
            v-if="props.image"
        :src="props.image"
        class="rounded-full w-9 h-9 border"
        alt="Avatar"
        />
        <img
        v-else
        :src="$defaultAvatarSrc"
        class="rounded-full w-9 h-9 border"
        alt="Avatar"
        />

        <label for="customer_name" class="ml-2">{{props.name}}</label>
    </div>
</template>
<script setup>
    const props = defineProps({
        image : {
            type: String,
            default: ''
        },
        name : { 
            type: String,
            default: '',
        }
    });
</script>
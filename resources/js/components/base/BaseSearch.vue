<script setup>
    const props = defineProps({  
            modelValue: {
                type: [String, Number],
                default: "",
            },           
            disabled : {
                type: Boolean,
                default : false
            },     
    })

    const emit  = defineEmits(['update:modelValue'])

    const updateInput = (event) => {
       emit("update:modelValue", event.target.value);
    }
</script>

<template>
     <div class="relative flex w-full items-center group py-0.5 overflow-visible">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-4 z-10 h-4 w-4 text-brand-500 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input
              type="search"
              @input="updateInput"
              :value="modelValue"
              v-bind="$attrs"
              class="!pl-11 !pr-4 !py-2.5 !rounded-full !bg-white
                !border !border-slate-300 !shadow-none
                focus:!border-brand-500 focus:!outline-none focus:!ring-2 focus:!ring-brand-500/20
                placeholder:text-slate-400 w-full"
              placeholder="Search"
              aria-label="Search"
            >
     </div>
</template>

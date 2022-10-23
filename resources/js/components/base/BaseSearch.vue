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
     <div class="input-group group relative flex flex-wrap items-stretch w-full border border-solid bg-white  rounded focus:border-blue-600 focus:outline-none">
        <!-- <span class="input-group-text flex items-center px-3 py-1.5 text-base font-normal text-gray-00 text-center whitespace-nowrap rounded" id="basic-addon2">
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" class="w-4" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
                </svg>
            </span> -->
            <input type="search" @input="updateInput" :value="modelValue" v-bind="$attrs" 
             class="form-control relative flex-auto min-w-0 block w-full px-3 py-1.5 text-sm font-normal text-gray-700 bg-white bg-clip-padding  rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white form-control:focus:border-transparent focus:outline-none" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
           
     </div>
</template>
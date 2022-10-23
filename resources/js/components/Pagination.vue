<script setup>
    const props = defineProps({
        pagination : {
            type : Object,
            default : null,
        }
    });

    const emit = defineEmits(['page-change']);

    const change = (url) => {
        emit('page-change', url);
    }
    
    
 

    const split = (string) => {
        const myArray  = string.split(" ");
        return myArray[0];
    }

    const isNan = number => {
        const parse = parseInt(number);
        return Number.isNaN(parse);
    }
</script>
<template>
    <div class="w-full flex items-center justify-between mt-4 mb-4">
    <div class="px-4">
        <label class="text-sm">Page {{ pagination.current_page }} of {{ pagination.last_page }}</label>
    </div>
    <nav aria-label="Page navigation example">
        <ul class="flex list-style-none">   
        <li v-for="(link,index) in pagination.links" class="page-item">
    
            <span v-if="!isNan(link.label)"
                @click="change(link.url)"
                class="page-link relative block py-1.5 px-3 text-sm border-0 bg-transparent outline-none transition-all duration-300 rounded text-gray-800 hover:text-gray-800 hover:bg-gray-200 focus:shadow-none cursor-pointer" 
                :class="{'bg-gray-200' : link.active}"
               >
                {{link.label}}
            </span>

            <span v-else
                @click="change(link.url)"
                class="page-link relative block py-1.5 px-3 text-sm  border-0 bg-transparent outline-none transition-all duration-300 rounded text-gray-800 hover:text-gray-800 focus:shadow-none cursor-pointer"
                >
                <span v-if="index === 0" aria-hidden="true">&laquo;</span>
                <span v-else aria-hidden="true">&raquo;</span>
            </span>
        </li>


        </ul>
    </nav>
    </div>
</template>
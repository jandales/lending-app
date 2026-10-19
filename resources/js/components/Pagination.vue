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
    <div class="w-full flex items-center justify-between mt-4 mb-4 px-1">
    <div>
        <label class="text-sm text-slate-500">Page {{ pagination.current_page }} of {{ pagination.last_page }}</label>
    </div>
    <nav aria-label="Page navigation example">
        <ul class="flex list-style-none gap-1">   
        <li v-for="(link,index) in pagination.links" class="page-item">
    
            <span v-if="!isNan(link.label)"
                @click="change(link.url)"
                class="relative block py-1.5 px-3 text-sm rounded-md text-slate-600 hover:text-brand-700 hover:bg-brand-50 transition-all duration-150 cursor-pointer" 
                :class="{'!bg-brand-600 !text-white hover:!bg-brand-700 hover:!text-white' : link.active}"
               >
                {{link.label}}
            </span>

            <span v-else
                @click="change(link.url)"
                class="relative block py-1.5 px-3 text-sm rounded-md text-slate-600 hover:text-brand-700 hover:bg-brand-50 transition-all duration-150 cursor-pointer"
                >
                <span v-if="index === 0" aria-hidden="true">&laquo;</span>
                <span v-else aria-hidden="true">&raquo;</span>
            </span>
        </li>


        </ul>
    </nav>
    </div>
</template>

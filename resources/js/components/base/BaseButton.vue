<template>
     <button                
        type="button"
        :class="buttonClass"
        v-bind="$attrs"
        >
        <div v-if="isLoading" class="spinner-border animate-spin inline-block w-4 h-4 border-4 rounded-full" role="status">
                <span class="visually-hidden">Loading...</span>
        </div>                    
        <label v-else-if="name" for="">{{name}}</label> 
        <slot name="icon">

        </slot>
    </button>
</template>

<script setup>
    import { computed, useAttrs } from 'vue';

    const props = defineProps({
        isLoading : {
            type : Boolean,
            default : false,
        },
        name : {
            type : String,
            default : null, 
        },
        variant : {
            type : String,
            default : 'primary',
        }
    });

    const attrs = useAttrs();

    const buttonClass = computed(() => {
        const passed = attrs.class || '';
        const classStr = typeof passed === 'string' ? passed : Array.isArray(passed) ? passed.join(' ') : '';
        // If a specific button class is already passed, don't force primary
        if (
            classStr.includes('btn-icon-') ||
            classStr.includes('btn-danger') ||
            classStr.includes('btn-light') ||
            classStr.includes('btn-info') ||
            classStr.includes('btn-primary')
        ) {
            return '';
        }
        return `btn-${props.variant}`;
    });
</script>

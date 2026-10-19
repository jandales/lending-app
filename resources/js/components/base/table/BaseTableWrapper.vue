<template>
    <div v-bind="$attrs" class="bg-white">
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full">       
                    <div class="overflow-hidden">      
                        <slot></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

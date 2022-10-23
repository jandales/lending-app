<template>
    <div v-bind="$attrs" class="border border-l-0 border-r-0 bg-white">
        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full sm:px-6 lg:px-8">       
                    <div class="overflow-hidden">      
                        <slot></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
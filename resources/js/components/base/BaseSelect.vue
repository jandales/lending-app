<template>
     <div class="flex items-center justify-center">
                <div class="mb-6 w-full" :class="parentClass">
                    <label for="formFile" class="form-label inline-block mb-2 text-gray-700" :class="labelClass">{{label}}</label>
                    <select name="role" :id="id" :value="modelValue" class="py-[10px] capitalize" @input="updateInput" v-bind="$attrs" >                       
                        <option v-for="(option, index) in options" :key="index" :value="option.value" selected> 
                            {{  option.name }} 
                        </option>                       
                    </select>
                    <small class="text-alert-danger" v-for="error in props.errors" >{{ error }}</small>
                </div>
            </div>
</template>
<script setup>
    const props = defineProps({
            id: {
                type: String,
                default: "",
            },
            optionKey :{
                type : String,
                default : null,
            },
            label: {
                type: String,
                default: "",
            },
            modelValue: {
                type: [String, Number],
                default: "",
            },
            type: {
                type: String,
                default: "text",
            },
            disabled : {
                type: Boolean,
                default : false
            },
            inline : {
                type: Boolean,
                default: false,
            },
            errors : {
                type: Array,
                default : null,
            },
            options : {
                type : Array,
                default : null,
            },
            parentClass : {
                type : String,
                default : null,
            },
            labelClass : {
                type : String,
                default : null,
            },


    })

    const emit  = defineEmits(['update:modelValue'])

    const updateInput = (event) => {
       emit("update:modelValue", event.target.value);
    }

   
</script>
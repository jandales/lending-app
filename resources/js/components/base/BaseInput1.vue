<template>
    <div class="form-group mb-6">
        <div class="flex justify-between">
            <label for="exampleFormControlInpu3" class="inline-block mb-1.5 text-sm font-medium text-slate-700">{{props.label}}</label> 
             <label for="" class="ml-auto cursor-pointer mb-1.5 text-sm font-medium text-brand-600 hover:text-brand-700" data-bs-toggle="modal" data-bs-target="#exampleModalLg">Find Customers</label>  
        </div>
        <input 
            :id="props.id"
            :type="props.type"
            :value="props.modelValue"
            :disabled="props.disabled"
            @input="updateInput" 
        />
        <small class="text-alert-danger" v-for="error in props.errors" >{{ error }}</small>
     </div>
</template>

<script setup>
    const props = defineProps({
            id: {
                type: String,
                default: "",
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
            errors : {
                type: Array,
                default : null,
            }
    })

    const emit  = defineEmits(['update:modelValue'])

    const updateInput = (event) => {
       emit("update:modelValue", event.target.value);
    }
</script>
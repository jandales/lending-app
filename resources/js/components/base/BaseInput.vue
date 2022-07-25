<template>
    <div class="form-group mb-6">
        <label for="exampleFormControlInpu3" class="form-label inline-block mb-2 text-gray-700">{{props.label}}</label> 
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
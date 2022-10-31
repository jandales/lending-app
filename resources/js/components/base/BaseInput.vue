<template>
    <div class="form-group mb-6">
        <div class="block" :class="{ 'flex items-center  gap-4 ' : inline}">
               <label class="form-label inline-block mb-2 text-gray-700" :class="{'!mb-0' : inline}">{{props.label}}</label> 
        <textarea 
            v-if="props.type == 'textarea'"
            id="exampleFormControlTextarea1"
            rows="3"  
            :value="props.modelValue"
            v-bind="$attrs">
        </textarea>

        <input 
            v-else-if ="props.type == 'date'"
            :id="props.id"
            :type="props.type"
            :value="props.modelValue"
            :disabled="props.disabled"
            v-bind="$attrs"
            @input="updateInput" 
        />

        <input 
            v-else
            :id="props.id"
            :type="props.type"
            :value="props.modelValue"
            :disabled="props.disabled"
            :name="name"
            v-bind="$attrs"
            @input="updateInput" 
        />
        </div>
        <small class="text-alert-danger" v-for="error in props.errors" >{{ error }}</small>
     </div>
</template>

<script setup>
    const props = defineProps({
            id: {
                type: String,
                default: null,
            },
            label: {
                type: String,
                default: "",
            },
            name : {
                type : String,
                default : null,
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
            }
    })

    const emit  = defineEmits(['update:modelValue'])

    const updateInput = (event) => {
       emit("update:modelValue", event.target.value);
    }
</script>
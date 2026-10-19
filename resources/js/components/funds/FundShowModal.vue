<script setup>
import BaseAvatar from '../base/BaseAvatarWithName.vue';
import { computed } from 'vue';
import BaseInput from '../base/BaseInput.vue';
import BaseButton from '../base/BaseButton.vue';
import useFormatter from '../../composable/helper/formater';

const { moneyFormatter } = useFormatter();

const emit = defineEmits(['close']);

const props = defineProps({ 
    data : {
        type : Object,
        default : null
    } 
})

const closeModal = () => {
    emit('close')
}

const actionLabel = computed(() => {
    if (props.data?.action_label) {
        return props.data.action_label;
    }
    const action = props.data?.action || '';
    return action.charAt(0).toUpperCase() + action.slice(1);
})

</script>
<template>
    <div class="fixed inset-0 z-50 flex items-start justify-center pt-16 px-4 backdrop-blur-sm bg-slate-900/40"
      tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="w-full max-w-lg pointer-events-auto">
        <div class="bg-white rounded-3xl shadow-float border border-white overflow-hidden">
          <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h5 class="text-lg font-bold text-slate-800 tracking-tight" id="exampleModalLabel">Activity Info</h5>
            <button type="button"
                @click="closeModal()"
              class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-50 transition"
              aria-label="Close">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <div class="px-6 py-5 space-y-1">
            <BaseAvatar :user="data.user" class="mb-5" />

            <BaseInput
                :label="'Action'"
                :modelValue="actionLabel"
                :disabled="true"
            />

            <BaseInput
                :label="'Last Capital Amount'"
                :modelValue="moneyFormatter(data.last_capital_amount)"
                :disabled="true"
            />

            <BaseInput
                :label="'Amount'"
                :modelValue="moneyFormatter(data.amount)"
                :disabled="true"
            />

            <BaseInput
                :label="'Date'"
                :modelValue="data.created_at"
                :disabled="true"
            />

            <BaseInput
                :label="'Remark'"
                :type="'textarea'"
                :modelValue="data.remark"
                :disabled="true"
            />
          </div>
          <div class="flex justify-end px-6 py-4 border-t border-slate-100">
            <BaseButton name="Close" class="btn-light" @click="closeModal" />
          </div>
        </div>
      </div>
    </div>
  </template>

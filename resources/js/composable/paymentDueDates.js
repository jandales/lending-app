import {ref} from 'vue';
import axios from '../axios/index.js';


export default function usePaymentDueDates() {
    
    const dueDates = ref([]);
    const dueDate = ref();


    const getDueDates = async(id) => {
        let response = await axios.get(`/payment-due-date/loans/${id}`);
        dueDates.value = response.data;
    }

    
    const getDueDate = async(id) => {
        let response = await axios.get(`/payment-due-date/${id}`);
        dueDate.value = response.data;
    }


    return {
        getDueDates,
        getDueDate,
        dueDates,
        dueDate,
    }

}
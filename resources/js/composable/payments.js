import axios from '../axios/index.js'
import {ref}  from 'vue'
export default function usePayments(){
    
    const payment  = ref();
    const payments = ref([]);
    const errors = ref([]);
    const isSuccess = ref(false);

    const getPayments = async () => {
        let response = await axios.get('/payments');
        payments.value = response.data.data;
    }

    const getPayment = async (id) => {
        let response = await axios.get(`/payments/${id}`);
        payment.value = response.data.data;
    }

    const addPayment = async (payment) => {
        errors.value = [];
        isSuccess.value = false;
        try {
            let response = await axios.post('/payments/store', payment)
            if(response.data.status === 500){
                errors.value = {  message: response.data.message }
                return;
            }
            isSuccess.value = true;
        } catch (e) {
            if(e.response.status === 422){
                errors.value = e.response.data.errors;
            }
        }
       
    }

    const removePayment = async (id) => {
        await axios.delete(`/payments/destroy/${id}`)
    }

    return {
        getPayments,
        getPayment,
        addPayment,
        removePayment,
        payments,
        payment,
        errors,
        isSuccess,        
    }

}
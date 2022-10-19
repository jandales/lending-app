import axios from '../axios/index.js'
import {ref}  from 'vue'


export default function usePayments() {
    
    const payment  = ref();
    const payments = ref([]);
    const errors = ref([]);
    const isSuccess = ref(false);
    const isLoading = ref(false);

    const getPayments = async () => {
        try {
            isLoading.value = true
            let response = await axios.get('/payments');
            payments.value = response.data.data;
        } catch (error) {
            console.log(error)
        } finally {
            isLoading.value = false;
        }      
    }

    const getPayment = async (id) => {
        try {
            isLoading.value = true
            let response = await axios.get(`/payments/${id}`);
            payment.value = response.data.data;
        } catch (error) {
            console.log(error)
        } finally {
            isLoading.value = false;
        } 
    }

    const addPayment = async (payment) => {
        errors.value = [];
        isSuccess.value = false;
        try {
            isLoading.value = true
            let response = await axios.post('/payments/store', payment)
            if (response.data.status === 500) { 
                return errors.value = { message: response.data.message }
            }
            isSuccess.value = true;
        } catch (e) {           
            if(e.response.status === 422){
                return errors.value = e.response.data.errors;
            }
        } finally {
            isLoading.value = false
        }       
    }

    const removePayment = async (id) => {
        try {
            isLoading.value = true
            await axios.delete(`/payments/destroy/${id}`)
        } catch (error) {
            console.log(error)
        } finally {
            isLoading.value = false
        }      
    }

    const failedToPay = async (id) => {
        try {
            isLoading.value = true
            await axios.delete(`/payments/due-date/failed-to-pay/${id}`);
        } catch (error) {
            console.log(error)
        } finally {
            isLoading.value = false
        }
    }

    return {
        getPayments,
        getPayment,
        addPayment,
        removePayment,
        failedToPay,
        payments,
        payment,
        errors,
        isSuccess,  
        isLoading,      
    }

}
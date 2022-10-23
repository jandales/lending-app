import axios from '../axios/index.js'
import {ref}  from 'vue'


export default function usePayments() {
    
    const payment  = ref();
    const payments = ref([]);
    const errors = ref([]);
    const isSuccess = ref(false);
    const isLoading = ref(false);
    const pagination = ref(Object);

    const getPayments = async (page = 1, filter = null,  sort = {}) => {

        let api = '/payments';

        if (page != null){
            api += `?page=${page}`;
        }

        if (filter != null) {
            api += `&filter=${filter}`;
        }

        if (Object.keys(sort).length > 1) {
            api += `&sort=${sort.name}&order=${sort.value}`;
        }

        try {
            isLoading.value = true
            let response = await axios.get(api);        
            const { data, meta} = response.data;
            payments.value = data;
            const { links, per_page, last_page, current_page, total } = meta;                    
            pagination.value = { per_page, last_page, current_page, total, links }
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

    const paymentSearch = async (keyword) => {
        try {
            isLoading.value = true
            const response = await axios.get(`/payments/search?keyword=${keyword}`);

            const { data, meta} = response.data;
            const { links, per_page, last_page, current_page, total } = meta; 

            payments.value = data;                               
            pagination.value = { per_page, last_page, current_page, total, links }
            
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
        paymentSearch,
        pagination,
        payments,
        payment,
        errors,
        isSuccess,  
        isLoading,      
    }

}
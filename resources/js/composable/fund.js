import axios from '../axios/index'
import { ref } from 'vue'

export default function useFund() {

    const errors = ref([]);
    const hasFund = ref(false);
    const fund = ref({
        current_capital : 0,
    });
    const isSuccess = ref(false);
    const isLoading = ref(false);   
    const isSaving = ref(false);

    const activities = ref([]);

    const getHasFund = async () => {
        errors.value = []
        isSuccess.value = false;;
        try {
            isLoading.value = true;
            let response = await axios.get('/fund/has');
            hasFund.value = response.data; 
            isSuccess.value = true;         
        } catch (e) {
            if(e.response.status === 422){
                errors .value = e.response.data.errors;
            }
        } finally {
            isLoading.value = false
        }              
    }

    const getFund = async () => {
        try {
            isLoading.value = true;
            let response = await axios.get('/fund');
            const { data} =  response.data;
            fund.value = data;
        }  catch (error) {
            errors.value = error.response.data.errors;
        } finally {
            isLoading.value = false
        }
    }

    const addFund = async(payload)  => {
        isSuccess.value = false;
        try {
            isSaving.value = true;
            let response = await axios.post('/fund/add', payload);
            isSuccess.value = true;
            fund.value = response.data;
        } catch (error) {
            errors.value = error.response.data.errors;
        } finally {
            isSaving.value = false;
        }
        
    }

    const deductFund = async(payload)  => {
        isSuccess.value = false;
        try {
            isSaving.value = true;
            let response = await axios.post('/fund/deduct', payload);
            isSuccess.value = true;
            fund.value = response.data;
        } catch (error) {
            errors.value = error.response.data.errors;
        } finally {
            isSaving.value = false;
        }
        
    }  

    return {
        getHasFund,
        addFund,
        deductFund,
        getFund,
        isSaving,
        fund,
        hasFund,   
        errors,    
        isSuccess,
        isLoading,
    }


}


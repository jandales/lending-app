import axios from '../axios/index'
import { ref } from 'vue'

export default function useFund() {

    const interests = ref([]);
    const interest = ref({});
    const errors = ref([]);
    const hasFund = ref(false);
    const success = ref();
    const isLoading = ref(false);   

    const getHasFund = async () => {
        errors.value = []
        success.value = null;
        try {
            isLoading.value = true;
            let response = await axios.get('/fund/hasFunds');
            hasFund.value = response.data;          
        } catch (e) {
            if(e.response.status === 422){
                errors .value = e.response.data.errors;
            }
        } finally {
            isLoading.value = false
        }              
    }

  

    return {
        getHasFund,   
        hasFund,   
        errors,    
        success,
        isLoading,
    }


}


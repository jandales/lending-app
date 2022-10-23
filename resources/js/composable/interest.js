import axios from '../axios/index'
import { ref } from 'vue'

export default function useInterests() {

    const interests = ref([]);
    const interest = ref({});
    const errors = ref([]);
    const success = ref();
    const isLoading = ref(false);

    const getInterests = async () => {
        try {
            isLoading.value = true;
            let response = await axios.get('/interests');
            interests.value = response.data;  
        } catch (error) {
            console.log(error);
        } finally {
            isLoading.value = false;
        }
            
    }

    const getInterest = async (id) => {
        try {
            isLoading.value = true;
            let response = await axios.get(`/interests/${id}`);
            interest.value = response.data;  
        } catch (error) {
            console.log(error);
        } finally {
            isLoading.value = false;
        }

              
    }

    const storeInterest = async (body) => {
        errors.value = []
        success.value = null;
        try {
            isLoading.value = true;
            let response = await axios.post('/interests/store', body);
            interest.value = response.data; 
            success.value = 'Interest successfuly updated'
        } catch (e) {
            if(e.response.status === 422){
                errors .value = e.response.data.errors;
            }
        } finally {
            isLoading.value = false
        }              
    }

    const updateInterest = async (id, body) => {
        errors.value = []
        success.value = null;
        try {
            isLoading.value = true;
            let response = await axios.put(`/interests/update/${id}`, body);
            interest.value = response.data; 
            success.value = 'Interest successfuly updated'    
        } catch (e) {
            if(e.response.status === 422){
                errors .value = e.response.data.errors;
            }
        } finally {
            isLoading.value = false
        }           
    }

    const destroyInterest = async (id) => {
        try {
            isLoading.value = true
            await axios.delete(`/interests/destroy/${id}`); 
        } catch (error) {
            console.log(error)
        } finally {
            isLoading.value = false
        }
          
    }

    return {
        getInterests,
        getInterest,
        storeInterest,
        updateInterest,
        destroyInterest, 
        errors,
        interest,
        interests,
        success,
        isLoading,
    }


}


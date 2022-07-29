import axios from '../axios/index'
import {ref} from 'vue'
export default function useInterests(){

    const interests = ref([]);
    const interest = ref({});
    const errors = ref([]);
    const success = ref();

    const getInterests = async () => {
        let response = await axios.get('/interests');
        interests.value = response.data;        
    }

    const getInterest = async (id) => {
        let response = await axios.get(`/interests/${id}`);
        interest.value = response.data;        
    }

    const storeInterest = async (body) => {
        errors.value = []
        success.value = null;
        try {
            let response = await axios.post('/interests/store', body);
            interest.value = response.data; 
            success.value = 'Interest successfuly updated'
        } catch (e) {
            if(e.response.status === 422){
                errors .value = e.response.data.errors;
            }
        }              
    }

    const updateInterest = async (id, body) => {
        errors.value = []
        success.value = null;
        try {
            let response = await axios.put(`/interests/update/${id}`, body);
            interest.value = response.data; 
            success.value = 'Interest successfuly updated'    
        } catch (e) {
            if(e.response.status === 422){
                errors .value = e.response.data.errors;
            }
        }           
    }

    const destroyInterest = async (id) => {
            await axios.delete(`/interests/destroy/${id}`); 
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
    }


}


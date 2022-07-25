import axios from "../axios/index.js"
import { ref } from "vue";
import { useRouter, useRoute } from 'vue-router';

export default function useLoanTypes() {

    const loanTypes = ref([]);
    const loanType = ref();
    const errors = ref([]);
    const router = useRouter();
    const route = useRoute();

    const getLoanTypes = async () => {
        let response = await axios.get('/loan-types');
        loanTypes.value = response.data;
    }

    const getLoanType = async () => {       
        let response =  await axios.get(`/loan-types/${route.params.id}`)
        loanType.value = response.data;
    }

    const updateLoanType = async () => {
        errors.value = [];       
        try {
            await axios.put(`/loan-types/update/${route.params.id}`, loanType.value);
            await router.push({name : 'loanTypes'})
        }
        catch(e){
            errors.value = e.response.data.errors;
        }
    }
 
    const storeLoanType = async(data) => {
        errors.value = [];
        try {
            await axios.post('/loan-types/store', data);
            await router.push({name : 'loanTypes'})
        }
        catch(e){
            errors.value = e.response.data.errors;
        }
       
    }
    
    const destroyLoanType =  async(id) => {
        await axios.delete(`/loan-types/destroy/${id}`);
        await getLoanTypes();
    }

    return  {
        getLoanTypes,
        getLoanType,
        storeLoanType,
        updateLoanType,
        destroyLoanType,
        loanTypes,
        loanType,
        errors
    }

};
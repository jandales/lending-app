import axios from '../axios/index.js'
import { ref } from 'vue'


export default function useLoans() {
   
    const loans = ref([]);
    const loan = ref();
    const errors = ref([]);
    const isSuccess = ref(false);

    const getLoans = async () => {
        let response = await axios.get('/loans');
        loans.value = response.data;
    }

    const getLoan = async (id) => {
        let response = await axios.get(`/loans/${id}`);
        loan.value = response.data;
    }

    const getLoanByCustomer = async (id) => {
        let response = await axios.get(`/loans/customer/${id}`);
        loan.value = response.data;
    }

    const storeLoan =  async (data) => {
        errors.value = [];
        isSuccess.value = false;
        try {
           let response =  await axios.post('/loans/store', data);
           if(response.data.status === 500){ 
                errors.value = { message : [response.data.message]}
                return;             
           }
           isSuccess.value =true;

        } catch (e) {
           if(e.response.status === 422){
                errors.value = e.response.data.errors;
           } 
        }
       
    }
    
    const destroyLoan = async (id) => {
        await axios.delete(`/loans/destroy/${id}`);    
    }

    return {
        getLoans,
        getLoan,
        getLoanByCustomer,
        storeLoan,
        destroyLoan,
        loans,
        loan,
        errors,
        isSuccess,
    }
}
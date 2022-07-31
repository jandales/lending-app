import axios from '../axios/index.js'
import { ref } from 'vue'


export default function useLoans() {
   
    const loans = ref([]);
    const loan = ref();
    const errors = ref([]);
    const isSuccess = ref(false);
    const isLoading = ref(false);
    const exist = ref(false);

    const getLoans = async () => {
        isLoading.value = true;
        try {
            let response = await axios.get('/loans');
            loans.value = response.data.data;
        }catch (e) {
            console.error(e);
        }finally {
            isLoading.value = false;
        }
       
    }

    const getLoan = async (id) => {
        isLoading.value = true;
        try {
            let response = await axios.get(`/loans/${id}`);
            loan.value = response.data.data;
        }
        catch (e){
            console.error(e);
        }
        finally {
            isLoading.value = false;
        }       
    }

    const searchLoans = async (keyword) => {
        isLoading.value = true;
        try {
            let response = await axios.get(`/loans/search/keyword=${keyword}`);
            loans.value = response.data.data;
        }
        catch (e){
            console.error(e);
        }
        finally {
            isLoading.value = false;
        }       
    }

    const existLoan = async (id) => {    
        exist.value = false; 
        let response = await axios.get(`/loans/existing-loan/${id}`);
        exist.value = response.data.status;                    
    }

    const getLoanByCustomer = async (id) => {
        isLoading.value = true;
        try {  
            let response = await axios.get(`/loans/customer/${id}`);
            loan.value = response.data.data;
        }
        catch (e){
            console.error(e);
        }
        finally {
            isLoading.value = false;
        }
        
    }

    const storeLoan =  async (data) => {
        errors.value = [];
        isSuccess.value = false;
        isLoading.value = true;
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
        finally {
            isLoading.value = false;
        }
       
    }
    
    const destroyLoan = async (id) => {
        try {
            await axios.delete(`/loans/destroy/${id}`);  
        }       
        catch (e) {
           console.log(e)
        } 
        finally {
            isLoading.value = false;
        } 
    }

    const updateStatusLoan = async (id, body) => {
        isLoading.value = true;
        try {
            let response = await axios.put(`/loans/update-status/${id}`, body);    
            loan.value = response.data.data;
        }catch (error) {
            console.log(error)
        }
        finally {
            isLoading.value = false;
        }
        
    }



    return {
        getLoans,
        getLoan,
        getLoanByCustomer,
        storeLoan,
        destroyLoan,
        updateStatusLoan,
        searchLoans,
        loans,
        loan,
        errors,
        isSuccess,
        isLoading,
        exist,
        existLoan
    }
}
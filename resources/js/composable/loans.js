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
        try {
            isLoading.value = true;
            let response = await axios.get('/loans');
            loans.value = response.data.data;
        }catch (e) {
            console.error(e);
        }finally {
            isLoading.value = false;
        }       
    }

    const getLoan = async (id) => {
        
        try {
            isLoading.value = true;
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
       
        try {
            isLoading.value = true;
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
        try {
            isLoading.value = true;
            exist.value = false; 
            let response = await axios.get(`/loans/existing-loan/${id}`);
            exist.value = response.data.status;  
        } catch (error) {
            console.log(error)
        } finally {
            isLoading.value = false;
        }  
                         
    }

    const getLoanByCustomer = async (id) => {
      
        try {  
            isLoading.value = true;
            let response = await axios.get(`/loans/borrower/${id}`);
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
       
       
        try {
            errors.value = [];
            isSuccess.value = false;
            isLoading.value = true;
            let response =  await axios.post('/loans/store', data);

            if(response.data.status === 500){ 
                return  errors.value = { message : [response.data.message]}                                
            }

            loan.value = response.data.data;
            isSuccess.value =true;

        } catch (e) {
           if(e.response.status === 422){
                errors.value = e.response.data.errors;
           } 
        } finally {
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
        
        try {
            isLoading.value = true;
            let response = await axios.put(`/loans/update-status/${id}`, body);    
            loan.value = response.data.data;
            isSuccess.value = true;
        }catch (e) {
            if (e.response.status === 422) {
                errors.value = e.response.data.errors;
            } 
        }
        finally {
            isLoading.value = false;
        }
        
    }

    const getActiveLoan = async (id) => {

        try {
            isLoading.value = true;
            let response = await axios.get(`/loans/customers/${id}/active-loan`);
            loan.value = response.data.data;
        } catch (e) {
            console.error(e);
        } finally {
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
        getActiveLoan,
        existLoan,
        loans,
        loan,
        errors,
        isSuccess,
        isLoading,
        exist,        
    }
}
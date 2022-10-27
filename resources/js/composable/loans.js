import axios from '../axios/index.js'
import { ref } from 'vue'
import { isEmpty } from 'lodash';


export default function useLoans() {
   
    const loans = ref([]);
    const loan = ref();
    const errors = ref([]);
    const isSuccess = ref(false);
    const isLoading = ref(false);
    const exist = ref(false);
    const pagination = ref(Object);

    const getLoans = async (page = 1, type = null,  filter = null, sort = {} ) => {    

        let api = '/loans'

        if (page != null) {
            api += `?page=${page}`
        }
        if (type != null) {
            api += `&type=${type}`;
        }

        if (filter != null) {
            api += `&filter=${filter}`
        }

        if (Object.keys(sort).length > 1){
            api += `&sort=${sort.name}&order=${sort.value}`;
        }

        try {
            isLoading.value = true
            let response = await axios.get(api)
            const { data, meta } = response.data
            loans.value = data
            const { links, per_page, last_page, current_page, total } = meta                   
            pagination.value = { per_page, last_page, current_page, total, links }
        }catch (e) {
            console.error(e)
        }finally {
            isLoading.value = false
        }       
    }

    const getLoan = async (id) => {        
        try {
            isLoading.value = true;
            let response = await axios.get(`/loans/${id}/show`);
            loan.value = response.data.data;
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
        } catch (e) {
            if(e.response.status === 422){
                errors.value = e.response.data.errors;
           } 
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

    const loanSearch = async (keyword, loanType = null) => {

        let api = `/loans/search?keyword=${keyword}`

        if (loanType != null) {
            api += `&type=${loanType}` 
        }

        try {

            isLoading.value = true   

            let response = await axios.get(api)
            const { data, meta } = response.data
            loans.value = data
            const { links, per_page, last_page, current_page, total } = meta                   
            pagination.value = { per_page, last_page, current_page, total, links }
        }catch (e) {
            console.error(e)
        }finally {
            isLoading.value = false
        } 
    }



    return {
        getLoans,
        getLoan,
        getLoanByCustomer,
        storeLoan,
        destroyLoan,
        updateStatusLoan,      
        getActiveLoan,
        existLoan,
        loanSearch,
        pagination,
        loans,
        loan,
        errors,
        isSuccess,
        isLoading,
        exist,        
    }
}
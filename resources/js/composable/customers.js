import {ref} from 'vue';
import axios from '../axios/index.js';
import { useRoute, useRouter } from 'vue-router'

export default function useCustomers(){

    const router = useRouter();

    const customers = ref([]);

    const customersCount =ref([]);

    const customer = ref();

    const errors =  ref([]);

    const activeLoan = ref();

    const isLoading = ref(false);

    const getCustomers = async() => {

        let response = await axios.get('/customers');

        customers.value = response.data.data;

    }

    const getCustomer = async(id) => {

        let response = await axios.get(`/customers/${id}`);

        customer.value = response.data.data;

    }

    const getCustomersCount = async() => {

        let response = await axios.get('/customers/person/count');

        customersCount.value = response.data;

    }

    const searchCustomers = async(keyword) => {

        let response = await axios.get(`/customers/search/${keyword}`);

        customers.value = response.data;

    }

    const storeCustomer = async(data) => {

        errors.value = [];

        try {
            
            await axios.post('/customers/store', data, { headers : { 'Content-Type': 'multipart/form-data' } }) 

            router.push({name : 'customers'})

        } catch (e) {    

            if(e.response.status === 422){

                errors.value = e.response.data.errors;

            }

        }        
    }

    const updateCustomer = async(id,data) => {

        errors.value = [];
   
        try {

            await axios.post(`/customers/update/${id}`, data, { headers : { 'Content-Type': 'multipart/form-data' } });

            router.push({name : 'customers'})

        } 
        
        catch (e) {
            
            if(e.response.status === 422){

                errors.value = e.response.data.errors;
                
            }

        }
       
    }

    const destroyCustomer = async(id) => {

        await axios.delete(`/customers/destroy/${id}`);

    }

    const getActiveLoan = async (id) => {

        isLoading.value = true;

        try {

            let response = await axios.get(`/customers/active-loan/${id}`);

            activeLoan.value = response.data.data;

        }

        catch (e){

            console.error(e);

        }

        finally {

            isLoading.value = false;

        }   

    }
    

    return {
        getCustomers,
        getCustomer,
        storeCustomer,
        destroyCustomer,
        updateCustomer,
        searchCustomers,
        getCustomersCount,
        getActiveLoan,
        isLoading,
        customersCount,
        customers,
        customer,
        errors,
        activeLoan,
    }
}
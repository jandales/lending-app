import {ref} from 'vue';
import axios from '../axios/index.js';
import { useRoute, useRouter } from 'vue-router'

export default function useCustomers(){

    const router = useRouter();

    const customers = ref([]);
    const customersCount =ref([]);
    const customer = ref();
    const errors =  ref([])

    const getCustomers = async() => {
        let response = await axios.get('/customers');
        customers.value = response.data;
    }

    const getCustomer = async(id) => {
        let response = await axios.get(`/customers/${id}`);
        customer.value = response.data;
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
        } catch (e) {
            
            if(e.response.status === 422){
                errors.value = e.response.data.errors;
            }
        }
       
    }

    const destroyCustomer = async(id) => {
        await axios.delete(`/customers/destroy/${id}`);
    }


    

    return {
        getCustomers,
        getCustomer,
        storeCustomer,
        destroyCustomer,
        updateCustomer,
        searchCustomers,
        getCustomersCount,
        customersCount,
        customers,
        customer,
        errors,
    }
}
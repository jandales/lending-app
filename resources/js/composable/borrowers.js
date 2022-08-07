import {ref} from 'vue';
import axios from '../axios/index.js';
import { useRouter } from 'vue-router'

export default function useBorrowers(){

    const router = useRouter();

    const borrowers = ref([]);

    const borrowersCount =ref([]);

    const borrower = ref();

    const errors =  ref([]);

    const isLoading = ref(false);

    const getBorrowers = async() => {

        let response = await axios.get('/borrowers');

        borrowers.value = response.data.data;

    }

    const getBorrower = async(id) => {

        let response = await axios.get(`/borrowers/show/${id}`);

        borrower.value = response.data.data;

    }

    const editBorrower = async(id) => {

        let response = await axios.get(`/borrowers/${id}/edit`);

        borrower.value = response.data;

    }

    const getBorrowersCount = async() => {

        let response = await axios.get('/borrowers/person/count');

        borrowersCount.value = response.data;

    }

    const searchborrowers = async(keyword) => {

        let response = await axios.get(`/borrowers/search/${keyword}`);

        borrowers.value = response.data;

    }

    const storeBorrower = async(data) => {

        errors.value = [];

        try {
            
            await axios.post('/borrowers/store', data, { headers : { 'Content-Type': 'multipart/form-data' } }) 

            router.push({name : 'borrowers'})

        } catch (e) {    

            if(e.response.status === 422){

                errors.value = e.response.data.errors;

            }

        }        
    }

    const updateBorrower = async(id,data) => {

        errors.value = [];
   
        try {

            await axios.post(`/borrowers/update/${id}`, data, { headers : { 'Content-Type': 'multipart/form-data' } });

            router.push({name : 'borrowers'})

        } 
        
        catch (e) {
            
            if(e.response.status === 422){

                errors.value = e.response.data.errors;
                
            }

        }
       
    }

    const destroyBorrower = async(id) => {

        await axios.delete(`/borrowers/destroy/${id}`);

    }


    

    return {
        getBorrowers,
        getBorrower,
        storeBorrower,
        destroyBorrower,
        updateBorrower,
        searchborrowers,
        getBorrowersCount,
        editBorrower,
        isLoading,
        borrowersCount,
        borrowers,
        borrower,
        errors,       
    }
}
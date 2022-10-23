import {ref} from 'vue';
import axios from '../axios/index.js';
import { useRouter } from 'vue-router'


export default function useBorrowers(){

    const router = useRouter();
    const borrowers = ref([]);
    const borrowersCount = ref([]);
    const borrower = ref();
    const errors =  ref([]);
    const isLoading = ref(false);
    const pagination = ref(Object);

    const getBorrowers = async(page = 1, filter = null, sort = {}) => {

        let api = '/borrowers'

        if (page != null) {
            api += `?page=${page}`    
        }

        if (filter != null) {          
            api += `&filter=${filter}`;
        }

        if (Object.keys(sort).length != 0) {
            api += `&sort=${sort.name}&order=${sort.value}`;
        } 
  

        try {
            isLoading.value = true;
            let response = await axios.get(api);
            const { data, meta} = response.data;
            borrowers.value = data; 
            const { links, per_page, last_page, current_page, total } = meta;                    
            pagination.value = { per_page, last_page, current_page, total, links }
        } catch (error) {
            console.log(error);
        } finally {
            isLoading.value = false;
        }
    }

    const getBorrower = async(id) => {

        try {
            isLoading.value = true
            let response = await axios.get(`/borrowers/show/${id}`);
            borrower.value = response.data.data;
        } catch (error) {
            console.log(error);
        } finally {
            isLoading.value = false;
        }
      

    }

    const editBorrower = async(id) => {

        try {
            isLoading.value = true
            let response = await axios.get(`/borrowers/${id}/edit`);
            borrower.value = response.data;
        } catch (error) {
            console.log(error)
        } finally {
            isLoading.value = false
        }
      

    }

    const getBorrowersCount = async() => {
        try {
            isLoading.value = true
            let response = await axios.get('/borrowers/person/count');
            borrowersCount.value = response.data;
        } catch (error) {
            console.log(error)
        } finally {
            isLoading.value = false
        }  
    }

    const borrowerSearch = async(keyword) => {

        try {
            isLoading.value = true
            let response = await axios.get(`/borrowers/search?keyword=${keyword}`);
            const { data, meta } = response.data;
            borrowers.value = data; 
            const { links, per_page, last_page, current_page, total } = meta;                    
            pagination.value = { per_page, last_page, current_page, total, links }
        } catch (error) {
            console.log(error)
        } finally {
            isLoading.value = false
        }
    

    }

    const storeBorrower = async(data) => {

        errors.value = [];
        try {
            isLoading.value = true
            await axios.post('/borrowers/store', data, { headers : { 'Content-Type': 'multipart/form-data' } }) 
            router.push({name : 'borrowers'})
        } catch (e) {    
            if(e.response.status === 422){
                errors.value = e.response.data.errors;
            }
        }  finally {
            isLoading.value = false
        }    

    }

    const updateBorrower = async(id,data) => {

        errors.value = [];
   
        try {
            isLoading.value = true
            await axios.post(`/borrowers/update/${id}`, data, { headers : { 'Content-Type': 'multipart/form-data' } });
            router.push({name : 'borrowers'})
        }  catch (e) {            
            if (e.response.status === 422) {
                errors.value = e.response.data.errors;                
            }
        } finally {
            isLoading.value = false
        }
       
    }

    const destroyBorrower = async(id) => {
        try {
            isLoading.value = true
            await axios.delete(`/borrowers/destroy/${id}`);
        } catch (error) {
            console.log(error)
        } finally {
            isLoading.value = false
        }
    }


    

    return {
        getBorrowers,
        getBorrower,
        storeBorrower,
        destroyBorrower,
        updateBorrower,
        borrowerSearch,
        getBorrowersCount,
        editBorrower,
        pagination,
        isLoading,
        borrowersCount,
        borrowers,
        borrower,
        errors,       
    }
}
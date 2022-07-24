import axios from '../axios/index.js'
import { ref } from 'vue'


export default function useLoans() {
   
    const loans = ref([]);

    const getLoans = async () => {
       let response = await axios.get('/loans');
       loans.value = response.data;
    }

    return {
        getLoans,
        loans,
    }
}
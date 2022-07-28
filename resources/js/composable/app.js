import { ref } from 'vue';
import axios from '../axios/index.js';

export default function useApp(){

    const customerCount = ref(0);
    const loanCapital = ref(0);
    const loanRevenue = ref(0)
  

    const getDashboards = async() => {
        let response = await axios.get('/app/dashboard');
        const { customersCount, capital, revenue}  = response.data;       
        customerCount.value = customersCount;
        loanCapital.value = capital;
        loanRevenue.value = revenue;
    }


    return {
        getDashboards,
        loanCapital,
        loanRevenue,
        customerCount,
    }


}
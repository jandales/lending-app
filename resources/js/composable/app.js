import { ref } from 'vue';
import axios from '../axios/index.js';

export default function useApp(){

    const customerCount = ref(0);
    const loanCapital = ref(0);
    const loanRevenue = ref(0);
    const recentLoans = ref([]);
  

    const getDashboards = async() => {

        let response = await axios.get('/app/dashboard');

        const { customersCount, capital, revenue, loans}  = response.data; 

        customerCount.value = customersCount;

        loanCapital.value = capital;

        loanRevenue.value = revenue;

        recentLoans.value = loans;


    }


    return {

        getDashboards,

        loanCapital,

        loanRevenue,

        customerCount,

        recentLoans,

    }


}
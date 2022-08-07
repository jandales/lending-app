import { ref } from 'vue';
import axios from '../axios/index.js';

export default function useApp(){

    const customerCount = ref(0);

    const loanCapital = ref(0);

    const loanRevenue = ref(0);
    
    const activeLoansCount = ref(0);

    const recentLoans = ref([]);  

    const getDashboards = async() => {

        let response = await axios.get('/app/dashboard');

        const { customersCount, capital, revenue, activeLoan, loans}  = response.data; 

        customerCount.value = customersCount;

        loanCapital.value = capital;

        loanRevenue.value = revenue;

        recentLoans.value = loans;

        activeLoansCount.value =  activeLoan;


    }


    return {

        getDashboards,

        loanCapital,

        loanRevenue,

        customerCount,

        recentLoans,

        activeLoansCount,

    }


}
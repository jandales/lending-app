import { ref } from 'vue';
import axios from '../axios/index.js';

export default function useApp(){

    const customerCount = ref(0);

    const currentCapital = ref(0);

    const loanRevenue = ref(0);
    
    const activeLoansCount = ref(0);

    const recentLoans = ref([]);  

    const totalInterest = ref(0);

    const getDashboards = async() => {

        let response = await axios.get('/app/dashboard');

        const { customers_count, current_capital, total_interest,  active_loan, loans}  = response.data; 

        customerCount.value = customers_count ?? 0;

        currentCapital.value = current_capital ?? 0;

        recentLoans.value = loans;

        activeLoansCount.value =  active_loan ?? 0;

        totalInterest.value = total_interest ?? 0;


    }


    return {

        getDashboards,

        currentCapital,

        loanRevenue,

        customerCount,

        recentLoans,

        activeLoansCount,
        totalInterest

    }


}
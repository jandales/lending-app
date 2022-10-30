import { ref } from 'vue';
import axios from '../axios/index.js';

export default function useApp(){

    const borrowerCount = ref(0);

    const currentCapital = ref(0);

    const loanRevenue = ref(0);
    
    const activeLoansCount = ref(0);

    const recentLoans = ref([]);  

    const totalInterest = ref(0);

    const getDashboards = async() => {

        let response = await axios.get('/app/dashboard');

        const { borrower_count, current_capital, total_interest,  active_loan, loans}  = response.data; 

        borrowerCount.value = borrower_count;

        currentCapital.value = current_capital;

        recentLoans.value = loans;

        activeLoansCount.value =  active_loan;

        totalInterest.value = total_interest;


    }


    return {

        getDashboards,
        currentCapital,
        loanRevenue,
        borrowerCount,
        recentLoans,
        activeLoansCount,
        totalInterest

    }


}
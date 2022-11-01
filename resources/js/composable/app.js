import { ref } from 'vue';
import axios from '../axios/index.js';

export default function useApp(){

    const borrowerCount = ref(0);
    const currentCapital = ref(0);
    const loanRevenue = ref(0);    
    const activeLoansCount = ref(0);
    const recentLoans = ref([]);  
    const totalInterest = ref(0);
    const totalCollectedInterest = ref(0);
    const isLoading = ref(false);

    const getDashboards = async() => {

        try {
            isLoading.value = true;
            let response = await axios.get('/app/dashboard');
            const { borrower_count, current_capital, total_collected_interest, total_interest,collectable_interest,  active_loan, loans}  = response.data; 
            borrowerCount.value = borrower_count;
            currentCapital.value = total_interest;
            recentLoans.value = loans;
            activeLoansCount.value =  active_loan;
            totalInterest.value = collectable_interest;
            totalCollectedInterest.value = total_collected_interest;
        } catch (err) {
            console.log(err)
        } finally {
            isLoading.value = false;
        }
        

    }


    return {

        getDashboards,
        totalCollectedInterest,
        isLoading,
        currentCapital,
        loanRevenue,
        borrowerCount,
        recentLoans,
        activeLoansCount,
        totalInterest

    }


}
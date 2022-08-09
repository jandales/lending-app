import axios from "../axios/index.js"   
import { ref } from "vue";


export default function useReport()  {

    const loanReports = ref([]);

    const borrowerReports = ref([]);

    const paymentReports = ref([]);

    const getLoanReports = async(body) => {
   
        const response = await axios.post(`/reports/loans`, body);

        loanReports.value = response.data.data;

    }

    const getBorrowerReports = async(body) => {
   
        const response = await axios.post(`/reports/borrowers`, body);   

        borrowerReports.value = response.data;

    }

    const getPaymentReports = async (body) => {

        const response = await axios.post(`/reports/payments`, body);   

        paymentReports.value = response.data;

    }


    return {        
        getLoanReports,
        getBorrowerReports,
        getPaymentReports,
        paymentReports,
        borrowerReports,
        loanReports,
    }

}
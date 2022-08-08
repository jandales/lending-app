import axios from "../axios/index.js"   
import { ref } from "vue";


export default function useReport()  {

    const loanReports = ref([]);

    const borrowerReports = ref([]);

    const getLoanReports = async(body) => {
   
        const response = await axios.post(`/reports/loans`, body);

        loanReports.value = response.data.data;

    }

    const getBorrowersReports = async(body) => {
   
        const response = await axios.post(`/reports/borrowers`, body);   

        loanReports.value = response.data;

    }


    return {

        getLoanReports,
        getBorrowersReports,
        borrowerReports,
        loanReports,

    }

}
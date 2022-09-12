
import axios from '../../axios/index.js';

export default function useExport(){

    const createLinkDownload = (url, file) => {
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', file); 
        document.body.appendChild(link);
        link.click();
    }

    const downloadExcel = (data, filename = 'file') => {   
        const url = window.URL.createObjectURL(new Blob([data]));
        const file = `${filename}.csv`
        createLinkDownload(url,file);
    }

    const downloadPDF = (data, filename = 'file') => {
        const url = window.URL.createObjectURL(new Blob([data],  { type : ' application/pdf'}));
        const file = `${filename}.pdf`;
        createLinkDownload(url, file);
    }

    const exportLoans = async (body) => {

        let response = await axios.post('/report/export/loan', body, {
                            responseType: "blob",
                        });  

        downloadExcel(response.data, 'Loans')
    }

    const exportBorrowers = async (body) => {
        let response = await axios.post('/report/export/loan', body, {
                            responseType: "blob",
                        });  
                        
        downloadExcel(response.data, 'Borrower')
        
    }

    const exportPayments = async (body) => {

        let response = await axios.post('/report/export/payments', body, {
                            responseType: "blob",
                        });  
                        
        downloadExcel(response.data, 'Payments')
        
    }

    const reportBorrowerstoPDF = async () => {
        let response = await axios.get('/create-pdf', {
                            responseType: 'arraybuffer'
                        });                      
       downloadPDF(response.data, 'borrowers');
    }

    const reportLoanToPDF = async (body) => {
        let response = await axios.post('/report/loans/create-pdf', body, {
                            responseType: 'arraybuffer'
                        });

                      
        downloadPDF(response.data, 'loans');
    }

    const reportPaymentToPDF = async (body) => {
        
        let response = await axios.post('/report/payments/create-pdf', body, {
                            responseType: 'arraybuffer'
                        });

        downloadPDF(response.data, 'payments');
    }

    const loanDetailsToPDF = async (id) => {

        let response = await axios.get(`/loans/details/${id}/create-pdf`, {
                            responseType: 'arraybuffer'
                        });

        downloadPDF(response.data, 'loan-details');
    }

   

    return {
        exportLoans,
        exportBorrowers,
        exportPayments,
        reportBorrowerstoPDF,
        reportLoanToPDF,
        reportPaymentToPDF,
        loanDetailsToPDF,
    }


}
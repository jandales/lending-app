
import axios from '../../axios/index.js';

export default function useExport(){

    const downloadExcel = (data, filename = 'file') => {   
        const url = window.URL.createObjectURL(new Blob([data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', `${filename}.csv`); //or any other extension
        document.body.appendChild(link);
        link.click();
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

    const toPDF = async () => {
        let response = await axios.get('/create-pdf', {
                            responseType: 'arraybuffer'
                        });

                      
        const url = window.URL.createObjectURL(new Blob([response.data],  { type : ' application/pdf'}));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', `file.pdf`); //or any other extension
        document.body.appendChild(link);
        link.click();
    }

   

    return {
        exportLoans,
        exportBorrowers,
        exportPayments,
        toPDF,
    }


}
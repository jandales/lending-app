
import axios from '../../axios/index.js';

export default function useExport(){

    const exportLoan = async (body) => {
        let response = await axios.post('/report/export/loan', body, {
            responseType: "blob",
        });  
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'file.csv'); //or any other extension
        document.body.appendChild(link);
        link.click();
    }

    return {
        exportLoan,
    }


}
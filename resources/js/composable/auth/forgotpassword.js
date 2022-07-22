import axios from '../../axios/index.js'
import { ref } from 'vue';
export default function useForgotPassword(){

    const errors = ref([]);

    const userForgotPassword = async (data) => {
        try{
            await axios.post('/forgot-password', data);
        }catch(e){
            if(e.response.status == 422){
                errors.value = e.response.data.errors;
            }
        }
           
    }

    return {
        userForgotPassword,
        errors
    }
}
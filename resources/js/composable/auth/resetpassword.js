import axios from "../../axios/index.js";
import { ref } from "vue";
import { useRouter} from 'vue-router';
export default function useResetPassword() {

    const router = useRouter();

    const errors = ref([]);
    const success = ref(); 
    const data = ref(Object)

    const checkToken = async (token) => {
        try{
            let response =  await axios.get(`/reset-password/${token}`);
            data.value = response.data;           
        }   
        catch(e){
            if(e.response.status === 404){
                router.push('/page-not-found');
            }
        }
     
      
    };
    const userResetPassword = async(form) => {
        errors.value = [];
        success.value = null;
        data.value = Object.assign(data.value,form)       
        try {
            let response = await axios.put(`/reset-password`, data.value)
            if (response.status === 200){
                success.value = response.data.message;
            }
            
        } catch (e) {
            if(e.response.status === 422){
                errors.value = e.response.data.errors;
            }
        }        
    }

    return {
        userResetPassword,
        checkToken,
        data,
        errors,
        success,
    }
}
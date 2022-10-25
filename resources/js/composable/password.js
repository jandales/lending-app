import { ref } from "vue";
import axios from "../axios/index.js"   

export default function usePassword() {

    const isLoading = ref(false);
    const message = ref();

    const resetPassword = async(user) => {
        try {  
            isLoading.value = true
            let response = await axios.post(`/password/reset/user/${user}`);  
            message.value = response.data.message;
        } catch (error) {
            console.log(error)
        } finally {
            isLoading.value = false
        }
    }

    return {
        resetPassword,
        isLoading,
        message
    }
}

   import axios from "../axios/index.js"
   import { ref } from "vue";


export default function useUser()  {
 
    const user = ref();
    const errors = ref([]);

    const getUser = async() => {
       let response = await axios.get('/user');       
       user.value = response.data;     
    }

    const userlogin = async(data) => {
        await axios.post('/login',data)
        .then(res => {    
            localStorage.setItem('user', JSON.stringify(res.data.user))
            localStorage.setItem('token', res.data.token)
            location.reload();
        })
        .catch(e => {
            if(e.response.status === 422){
                errors.value = e.response.data.errors;
            }
        })
    }

    const logout = async() => {
        await axios.delete('/logout');
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        location.reload();
    }

    return {
        getUser,
        logout,
        userlogin,
        user,
        errors,        
    }

}
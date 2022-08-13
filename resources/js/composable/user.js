
   import axios from "../axios/index.js"   
   import { ref } from "vue";


export default function useUser()  {
 
    const user = ref();
    const errors = ref([]);
    const success = ref();
    const isLoading = ref(false);

    const getUser = async() => {

       let response = await axios.get('/user');  

       user.value = response.data;  

    }

    const updateUser =  async(body) => {

        errors.value = []

        success.value = null;  

        try {

            let response= await axios.put('/user/update', body.value);

            user.value = response.data;            
            
            location.reload();

        } catch (e) {

            if(e.response.status === 422){

                errors.value = e.response.data.errors;

            }
        }
   
    }

    const userlogin = async(data) => {

        errors.value = []

        isLoading.value = true;

        try {

           let response =  await axios.post('/login',data)

           localStorage.setItem('user', JSON.stringify(response.data.user))

           localStorage.setItem('token', response.data.token)

           location.reload();

        }  catch (e) {

            if (e.response.status === 422) {

                errors.value = e.response.data.errors;

            }
            
        } finally {

            isLoading.value = false;

        }

       

      
       
    }

    const uploadAvatar = async(data) => {

        errors.value = []

        success.value = null; 
       
        try {
            let response = await axios.post('/user/upload-avatar',data, { headers : { 'Content-Type': 'multipart/form-data' } });

            user.value = response.data; 

            location.reload();   

        } catch (e) {        

            if(e.response.status === 422){

                errors.value = e.response.data.errors;

            }         
        }
    }

    const logout = async() => {

        await axios.delete('/logout');

        localStorage.removeItem('token');

        localStorage.removeItem('user');

        location.reload();
    }

    const changePassword = async(data) => {

        errors.value = []

        success.value = null;

        try {

            let response = await axios.put('/change-password', data)  

            if (response.data.status === 500) {    

                errors.value = { message : [response.data.message]}              
             

            }  

            success.value = response.data;

        } catch (e) {  

            if (e.response.status === 422) {

                errors.value = e.response.data.errors;

            }         
        }
       
    };

    return {
        getUser,
        logout,
        userlogin,
        changePassword,
        updateUser,
        uploadAvatar,
        isLoading,
        user,
        success,
        errors,        
    }

}
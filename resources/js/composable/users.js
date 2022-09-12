
   import axios from "../axios/index.js"   
   import { ref } from "vue";


export default function useUsers()  {
 
    const users = ref([]);

    const user = ref();

    const errors = ref([]);  

    const isLoading = ref(false);

    const isSuccess = ref(false);

    const initProps = () => {

        errors.value = [];

        isLoading.value = true;

        isSuccess.value = false;

    }

    const getUsers = async() => {
    
        try {
            const response = await axios.get(`/users`);
            users.value = response.data;
        } catch (error) {
            console.log(error)
        }   

    }

    const editUser = async (id) => {

        const response = await axios.get(`/users/${id}/edit`)

        user.value = response.data.data;

    }

    const updateUser = async (id, payload) => {     

        initProps();

        try {

            const response = await axios.put(`/users/${id}/update`, payload) 

            user.value = response.data;

            isSuccess.value = true;        
          
        } catch (e) {

            if (e.response.status === 422) {

                errors.value = e.response.data.errors;

            }
        }

        finally {

            isLoading.value = false;

        }

    }

    const storeUser = async (payload) => {

        initProps();

        try {

            await axios.post(`/users/store`, payload);

            isSuccess.value = true;
          
        } catch (e) {

            if (e.response.status === 422) {

                errors.value = e.response.data.errors;

            }
        }
        finally {

            isLoading.value = false;

        }
    }

    const destroyUser = async (id)  => {
        
        isLoading.value = true;

        try {

            await axios.delete(`/users/${id}/destroy`); 

        } catch (error) {

            console.log(error)
            
        }
        finally {

            isLoading.value = false;

        }
       

    }

    return {

        getUsers,

        storeUser,

        editUser,

        updateUser,

        destroyUser,

        user,

        users,

        isLoading,

        isSuccess,

        errors,

    }
      
    

}
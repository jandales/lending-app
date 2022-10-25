import axios from "../axios/index.js"   
import { ref } from "vue";

export default function useUsers()  {
 
    const users = ref([]);
    const user = ref();
    const errors = ref([]);  
    const isLoading = ref(false);
    const isSuccess = ref(false);
    const pagination = ref(Object);

    const initProps = () => {

        errors.value = [];

        isLoading.value = true;

        isSuccess.value = false;

    }

    const getUsers = async (page = 1, filter = null, sort ={} ) => {
        
       
        let api = '/users'
       

        if (page  != null ){
            api += `?page=${page}`;
        }

        if (filter != null) {
            api += `&filter=${filter}`;
        }

        if (Object.keys(sort).length > 1) {
            api += `&sort=${sort.name}&order=${sort.value}`;
        }


        try {
            isLoading.value = true;
            const response = await axios.get(api);
            const { data, meta } = response.data;
            users.value = data;  
            const { links, per_page, last_page, current_page, total } = meta;                    
            pagination.value = { per_page, last_page, current_page, total, links }
            
        } catch (error) {
            console.log(error)
        } finally {
            isLoading.value = false;
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

    const searchUsers = async(keyword) => {
        try {  
            let response = await axios.get(`/users/search?keyword=${keyword}`); 
            const { data, meta} = response.data;
            users.value = data;  
            const { links, per_page, last_page, current_page, total } = meta;                    
            pagination.value = { per_page, last_page, current_page, total, links }    
        } catch (error) {
            console.log(error)
        }
        
    }

  

    return {
        getUsers,
        storeUser,        
        editUser,
        updateUser,
        destroyUser,
        searchUsers ,
        user,
        users,
        pagination,
        isLoading,
        isSuccess,
        errors,
    }
      
    

}
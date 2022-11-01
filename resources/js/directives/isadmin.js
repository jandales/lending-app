import useUser from "../composable/user";

const { getUser, user } = useUser();

const isAdmin = async (el) => {
    await getUser();

    const { role } = user.value;
  
    if ( role == 1 || role == 0) return  el.classList.remove('hidden')
    el.classList.add('hidden')
    
}   

export default isAdmin;
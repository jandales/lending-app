import useUser from "../composable/user"

const { getUser, unAuthorized} = useUser()

export default async (to, from, next) => { 

    await getUser() 
   
    if (unAuthorized.value === true) return  next({name: 'dashboard'});
       
    next();
   
}
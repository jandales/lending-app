import useUser from "../../../composable/user";

const {getUser, user} =  useUser();

export default (to, from, next) => {

    const role  =  JSON.parse(localStorage.getItem('user')).role;

    if (role > 1) {

        next({name: 'dashboard'});

    } else  next() 
    
}
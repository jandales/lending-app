

export default (to, from, next) => {   
    const isAuth = localStorage.getItem('token') == null ? false : true;  
    if (isAuth === false) {
        next({name: 'login'});
    } else   next()
}
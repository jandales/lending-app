

export default (to, from, next) => {   
    const isAuth = localStorage.getItem('token') == null ? false : true;  
    if (isAuth === true) {
        next({name: 'dashboard'});
    } else   next()
}
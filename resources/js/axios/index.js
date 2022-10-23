import axios from 'axios'

const instance = axios.create({
    baseURL: '/api/',  
    withCredentials: true,
});

instance.interceptors.request.use(request => {
    request.headers.common['Accept']       = 'application/json'; 
    request.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
    request.headers.common['Content-Type'] = 'application/json';
    request.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
    return request;
}) 

instance.interceptors.response.use(
    response => { return response },
    error => {  return Promise.reject(error)}
);

export default instance;

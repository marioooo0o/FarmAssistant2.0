import axios from 'axios';

window.axios = axios;
axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://localhost:8000/api/';
axios.defaults.validateStatus = status => status >= 200 && status <300 || status === 422;
axios.interceptors.request.use(function(config) {
    config.headers.common = {
        Accept: 'application/json',
        'Content-Type': 'application/json'
    }
    return config;
})
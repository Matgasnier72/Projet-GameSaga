import axios from 'axios';

const Axios = axios.create({
    baseURL: 'http://localhost:8000/api',
    headers: {
        Accept: 'application/json'
    },
    withCredentials: true,
    withXSRFToken: true,
    xsrfCookieName: 'XSRF-TOKEN',
    xsrfHeaderName: 'X-XSRF-TOKEN'
});


export default Axios
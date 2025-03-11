import axios from 'axios';

const Axios = axios.create({
    baseURL: import.meta.env.VITE_API_BASE + '/api',
    headers: {
        Accept: 'application/json'
    },
    withCredentials: true,
    withXSRFToken: true,
    xsrfCookieName: 'XSRF-TOKEN',
    xsrfHeaderName: 'X-XSRF-TOKEN'
});


export default Axios
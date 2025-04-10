import Axios from './CallerService';

/**
 
Email verification function for new user.*/
export async function verification(email: string, token: string): Promise<void> {
    await Axios.get('/sanctum/csrf-cookie', {
        baseURL: import.meta.env.VITE_API_BASE,
    });
    await Axios.post('/verification', { email, token });
}
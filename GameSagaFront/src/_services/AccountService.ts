import Axios from './CallerService';
import type { User } from '@/_models/User';
import { useUserStore } from '@/stores/User';


export async function login(credentials: { email: string; password: string }): Promise<void> {
  await Axios.get('/sanctum/csrf-cookie', {
    baseURL: import.meta.env.VITE_API_BASE,
  });
  const res = await Axios.post('/authenticate', credentials, {
    baseURL: import.meta.env.VITE_API_BASE,
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
  });
  const userStore = useUserStore();
  userStore.setUser({
    //id: res.data.user.id,
    email: res.data.user.email,
    role: res.data.user.role
  });
}

export async function register(credentials:{email:string; password:string; pseudo:string}):Promise<void>{
  await Axios.get('/sanctum/csrf-cookie', {
    baseURL: import.meta.env.VITE_API_BASE ,
  });

  await Axios.post('/register', credentials, {
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
  });
}

export async function logout(): Promise<void> {
  await Axios.get('/logout', {
    baseURL: import.meta.env.VITE_API_BASE,
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },    
  });
  const userStore = useUserStore();
  userStore.clearUser();
  const cookies = document.cookie.split(';');
  for (let i = 0; i < cookies.length; i++) {
    const cookie = cookies[i];
    const eqPos = cookie.indexOf('=');
    const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
    document.cookie = `${name}=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/`;
  }
}

export async function getUser(){
  const response = await Axios.get('/user', {
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
  });
return response.data;
  // Optionnel : nettoyer les cookies de l'application (si nécessaire)
  
}

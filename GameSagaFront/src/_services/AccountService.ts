import Axios from './CallerService';
import type { User } from '@/_models/User';

export async function login(credentials: { email: string; password: string }): Promise<void> {
  await Axios.get('/sanctum/csrf-cookie', {
    baseURL: 'http://localhost:8000',
  });
  await Axios.post('/authenticate', credentials, {
    baseURL: 'http://localhost:8000',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
  });
}

export async function logout(): Promise<void> {
  await Axios.get('/logout', {
    baseURL: 'http://localhost:8000',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
  });

  // Optionnel : nettoyer les cookies de l'application (si nécessaire)
  const cookies = document.cookie.split(';');
  for (let i = 0; i < cookies.length; i++) {
    const cookie = cookies[i];
    const eqPos = cookie.indexOf('=');
    const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
    document.cookie = `${name}=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/`;
  }
}
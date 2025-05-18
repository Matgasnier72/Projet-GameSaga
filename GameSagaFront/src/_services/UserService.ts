import Axios from './CallerService'
import type { User, UserStatut,UserRole } from '@/_models/User';

interface UserResponse {
  success: boolean;
  data: {
    posts: User[];
  };
}

export async function getUsers(): Promise<UserResponse> {
  const response = await Axios.get('/getUser');
  return response.data;
}

export async function getUser(id: number): Promise<User> {
  const res = await Axios.get('/users/' + id);
  return res.data;
}

export async function updateUser(user: UserStatut): Promise<any> {
  return await Axios.put('/updateUser/' + user.id, user);
}

export async function roleUser(user: UserRole): Promise<any> {
  return await Axios.put('/updateUser/' + user.id, user);
}

export async function createUser(user: User): Promise<User> {
  const res = await Axios.post('/users', user);
  return res.data;
}

export async function deleteUser(id: number): Promise<any> {
  return await Axios.delete('/deleteUser/' + id);
}
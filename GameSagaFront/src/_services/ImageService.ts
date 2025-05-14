import Axios from './CallerService';
import type { Image, ImagePost } from '@/_models/Image';


/* export async function postImage(email: string, token: string): Promise<void> {
    await Axios.get('/sanctum/csrf-cookie', {
        baseURL: import.meta.env.VITE_API_BASE,
    });
    await Axios.post('/image', { email, token });
} */
export async function postImage(image: ImagePost): Promise<Image> {
    const res = await Axios.post('/images', image, {
        headers: { 'Content-Type': 'multipart/form-data' }
    });
    return res.data;
}
export async function deleteImage(idImage:number): Promise<void> {
    await Axios.get('/sanctum/csrf-cookie', {
        baseURL: import.meta.env.VITE_API_BASE,
    });
    await Axios.post('/images/' + idImage);
}
export async function imagesByArticle(articleID : number): Promise<Image[]> {
    await Axios.get('/sanctum/csrf-cookie', {
        baseURL: import.meta.env.VITE_API_BASE,
    });
    const res = await Axios.get('/imagesByArticle/' + articleID );
    return res.data;

}
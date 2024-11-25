import Axios from './CallerService'
import type { Article } from '@/_models/Article';

export async function getArticles(): Promise<Array<Article>> {
  const res = await Axios.get('/articles');
  return res.data;
}

export async function getArticle(id: number): Promise<Article> {
  const res = await Axios.get('/articles/' + id);
  return res.data;
}

export async function updateArticle(article: Article): Promise<any> {
  return await Axios.patch('/articles/' + article.titre, article);
}

export async function createArticle(article: Article): Promise<Article> {
  const res = await Axios.post('/articles', article);
  return res.data;
}

export async function deleteArticle(id: number): Promise<any> {
  return await Axios.delete('/articles/' + id);
}

export async function searchArticle(q: string): Promise<Array<Article>> {
  const res = await Axios.get('/search', { params: { q } }); // Ajoute le paramètre `q`
  return res.data;
}

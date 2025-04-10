import Axios from './CallerService'
import type { Article } from '@/_models/Article';
import type { Commentaire } from '@/_models/Commentaire';

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

export async function getCommentaires(articleId: number): Promise<Commentaire[]> {
  const res = await Axios.get(`/articles/${articleId}/commentaires`);
  return res.data;
}

export async function createCommentaire(commentaire: Omit<Commentaire, 'id' | 'created_at'>): Promise<Commentaire> {
  const res = await Axios.post('/commentaires', commentaire);
  return res.data;
}
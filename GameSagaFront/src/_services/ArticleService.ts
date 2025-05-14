import Axios from './CallerService'
import type { Article,ArticleCreate,SearchResponse } from '@/_models/Article';

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

export async function createArticle(article: ArticleCreate): Promise<Article> {
  const res = await Axios.post('/articles', article,{
    headers: { 'Content-Type': 'multipart/form-data' }});
  return res.data;
}

export async function deleteArticle(id: number): Promise<any> {
  return await Axios.delete('/articles/' + id);
}

export async function getCommentaires(idArticle: number): Promise<Array<Article>> {
  const res = await Axios.get('/articles/'+ idArticle +'/commentaires');
  return res.data;
}

//import type { SearchResponse } from '@/_models/Articles';

export async function searchArticle(q: string): Promise<any> {
  try {
    const response = await Axios.get(`/search?q=${encodeURIComponent(q)}`, {
      headers: {
        'Accept': 'application/json',
      },
    });

    if (!response.data) {
      const errorText = response.data;
      console.error(`Erreur HTTP ${response.status}:`, errorText);
      throw new Error(`Erreur HTTP ${response.status}: ${errorText}`);
    }

    return response.data;
  } catch (err) {
    console.error('Erreur lors de la requête fetch:', err);
    throw err;
  }
}

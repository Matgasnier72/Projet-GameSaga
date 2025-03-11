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

//import type { SearchResponse } from '@/_models/Articles';

export async function searchArticle(q: string): Promise<any> {
  try {
    const response = await Axios.get(`/api/search?q=${encodeURIComponent(q)}`, {
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
    });

    if (!response.data.ok) {
      const errorText = response.data; // Lire la réponse même si elle n'est pas JSON
      console.error(`Erreur HTTP ${response.status}:`, errorText);
      throw new Error(`Erreur HTTP ${response.status}: ${errorText}`);
    }

    return response.data; // Parse uniquement si le statut est correct
  } catch (err) {
    console.error('Erreur lors de la requête fetch:', err);
    throw err;
  }
}

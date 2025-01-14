import Axios from './CallerService'
import type { Article } from '@/_models/Articles';

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
  const url = `http://localhost:8000/api/search?q=${encodeURIComponent(q)}`;
  try {
    const response = await fetch(url, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
    });

    if (!response.ok) {
      const errorText = await response.text(); // Lire la réponse même si elle n'est pas JSON
      console.error(`Erreur HTTP ${response.status}:`, errorText);
      throw new Error(`Erreur HTTP ${response.status}: ${errorText}`);
    }

    return await response.json(); // Parse uniquement si le statut est correct
  } catch (err) {
    console.error('Erreur lors de la requête fetch:', err);
    throw err;
  }
}

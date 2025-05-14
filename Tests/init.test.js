const axios = require('axios');
const $baseurl = import.meta.env.BASE_URL;

const Axios = axios.create({
  baseURL: $baseurl,
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json'
  },
  withCredentials: true
});

let csrfToken;
let cookies;
let user = {};
let createdArticleId;

beforeAll(async () => {
  // Récupère le cookie CSRF
  const csrfRes = await Axios.get('/sanctum/csrf-cookie');
  cookies = csrfRes.headers['set-cookie'];
  csrfToken = getCSRFToken(cookies);

  // Authentifie l'utilisateur
  const authRes = await Axios.post('/authenticate', {
    email: 'admin@admin.net',
    password: 'test_Laravel_project'
  }, {
    headers: {
      'X-XSRF-TOKEN': csrfToken,
      cookie: cookies.join('; ')
    }
  });
  user = authRes.data.user;
  Axios.defaults.headers.common['X-XSRF-TOKEN'] = csrfToken;
  Axios.defaults.headers.common['cookie'] = cookies.join('; ');
});

function getCSRFToken(cookies) {
  const xsrf = cookies.find(c => c.startsWith('XSRF-TOKEN='));
  if (!xsrf) return '';
  return decodeURIComponent(xsrf.split('=')[1].split(';')[0]);
}

describe('Auth integration', () => {
  test('should authenticate user', async () => {
    expect(user).toHaveProperty('email', 'admin@admin.net');
  });
});

/* describe('Articles integration', () => {
  test('POST /api/articles - create article', async () => {
    const articleData = {
      titre: 'Article Intégration',
      contenu: 'Contenu test',
      note_auteur: 15,
      status: 'ok'
    };

    try {
      const res = await Axios.post('/api/articles', articleData);
      expect(res.status).toBe(200);
      expect(res.data.data.titre).toBe('Article Intégration');
      createdArticleId = res.data.data.id;
    } catch (error) {
      console.error('Error details:', error.response?.data);
      throw error;
    }
  });

  test('GET /api/articles/{id} - get article', async () => {
    const res = await Axios.get(`/api/articles/${createdArticleId}`);
    expect(res.status).toBe(200);
    expect(res.data.titre).toBeDefined();
  });

  test('PUT /api/articles/{id} - update article', async () => {
    const updateData = {
      titre: 'Article Modifié',
      contenu: 'Nouveau contenu',
      note_auteur: 18,
      status: 'ok',
      _method: 'PUT'
    };

    const res = await Axios.post(`/api/articles/${createdArticleId}`, updateData);
    expect(res.status).toBe(200);
    expect(res.data.data.titre).toBe('Article Modifié');
  });

  test('DELETE /api/articles/{id} - delete article', async () => {
    const res = await Axios.delete(`/api/articles/${createdArticleId}`);
    expect(res.status).toBe(200);

    try {
      await Axios.get(`/api/articles/${createdArticleId}`);
      throw new Error('Article still exists after deletion');
    } catch (error) {
      expect(error.response.status).toBe(404);
    }
  });
}); */
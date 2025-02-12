const { expect } = require('@jest/globals');
const axios = require('axios');

const Axios = axios.create({
    baseURL: 'http://localhost:8000',
    headers: {
        Accept: 'application/json'
    }
});

const user = {};
describe("User Login", () => {
    test("verification de l'authentification", async () => {
        await login(user, {
            email: 'admin@admin.net',
            password: 'test_Laravel_project'
        });
    });
});


//Utils

async function login(user, credentials) {
    await Axios.get('/logout');

    const res = await Axios.get('/sanctum/csrf-cookie', {
        baseURL: 'http://localhost:8000'
    });

    Axios.defaults.headers.cookie = res.headers['set-cookie'];
    Axios.defaults.headers.common['X-XSRF-TOKEN'] = parseCSRFToken(res.headers['set-cookie']);
    Axios.defaults.headers.common['Origin'] = 'http://localhost:8000';
    Axios.defaults.headers.common['Referer'] = 'http://localhost:8000';

    const auth = await Axios.post('/authenticate', credentials, {
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
    });

    Axios.defaults.headers.cookie = auth.headers['set-cookie'];
    Axios.defaults.headers.common['X-XSRF-TOKEN'] = parseCSRFToken(auth.headers['set-cookie'])

    for (let key in auth.data.user) {
        user[key] = auth.data.user[key];
    }
}

function parseCSRFToken(cookies) {
    const startAt = cookies[0].indexOf('=');
    const endAt = cookies[0].indexOf(';');
    const csrf = cookies[0].substring(startAt + 1, endAt - 3);
    return csrf;
}

describe("post Articles", () => {
    test("create article", async (data = { titre: 'Hollow Knight', contenu: "meilleur level-design", note_auteur: 20, status: "ok" }) => {
        const res = await Axios.post('api/articles', data);
        expect(res.data.data.titre).toBe('Hollow Knight');
    });
});
describe("put Articles", () => {
    test("modify article", async (data = { titre: 'Hollow Knights', contenu: "meilleur level-design et bonne difficulté", note_auteur: 20, status: "ok", _method: 'PUT' }) => {
        const res = await Axios.get('/api/articles');
        const articles = res.data.data.find(c => c.titre != user.id);
        const updateRes = await Axios.post('/api/articles/' + articles.id, data);
        expect(updateRes.data.data.name).toBe('Hollow Knight');
    });
});
describe("delete Articles", () => {
    test("Delete an article", async () => {
        const old = await Axios.get('/api/articles');
        const articles = old.data.find(c => c.user_id != user.id);
        const oldNumCreature = old.data.length;
        // before
        const deleteRes = await Axios.delete('/api/articles/' + articles.id);
        // after
        const cur = await Axios.get('/api/articles');
        const curNumCreature = cur.data.length;

        expect(deleteRes.status).toBe(200);
        expect(curNumCreature).toBe(oldNumCreature - 1);
    });
});
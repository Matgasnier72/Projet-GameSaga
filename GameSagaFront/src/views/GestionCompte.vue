<script setup lang="ts">
import { ref, watch, onMounted } from 'vue';
import { listCommentaires, deleteCommentaire, deleteArticle, updateCommentaire } from '@/_services/ArticleCommentaireService';
import { getArticles, updateArticle } from '@/_services/ArticleService';
import { getUsers, updateUser,roleUser } from '@/_services/UserService';
import type { Article } from '@/_models/Article';
import type { Commentaire } from '@/_models/Commentaire';
import type { User } from '@/_models/User';

const commentaires = ref<Commentaire[]>([]);
const articles = ref<Article[]>([]);
const users = ref<User[]>([]);
const error = ref<string | null>(null);
const titre = ref<string>('');
const selectedSection = ref('Commentaire');

const fetchCommentaires = async () => {
  try {
    const response = await listCommentaires();
    commentaires.value = response;
    error.value = null;
  } catch (err) {
    error.value = "Erreur lors de la récupération des commentaires.";
  }
};
const fetchArticles = async () => {
  try {
    const response = await getArticles();
    articles.value = response;
    error.value = null;
  } catch (err) {
    error.value = "Erreur lors de la récupération des articles.";
  }
};
const fetchUser = async () => {
  try {
    const response = await getUsers();
    if (response.data && response.data.posts) {
      users.value = response.data.posts;
    } else {
      throw new Error('Invalid response format');
    }
    error.value = null;
  } catch (err) {
    console.error('Error fetching users:', err);
    error.value = "Erreur lors de la récupération des users.";
  }
};

const deleteCom = async (id: number) => {
  try {
    await deleteCommentaire(id);
    console.log('Commentaire supprimé avec succès');
    fetchCommentaires();
  } catch (error) {
    console.error('Erreur lors de la suppression du commentaire:', error);
  }
};

const deleteArt = async (id: number) => {
  try {
    await deleteArticle(id);
    console.log('Article supprimé avec succès');
    fetchArticles();
  } catch (error) {
    console.error('Erreur lors de la suppression de l\'article:', error);
  }
};

const validComment = async (commentId: number) => {
  try {
    if (!commentId) return;

    await updateCommentaire({
      "id": commentId,
      "status": 'ok'
    });

    await fetchCommentaires();

    console.log('Commentaire signalé avec succès');
  } catch (err) {
    console.error('Erreur lors du signalement:', err);
    error.value = "Erreur lors du signalement du commentaire.";
  }
};

const validArticle = async (articleId: number) => {
  try {
    if (!articleId) return;

    await updateArticle({
      "id": articleId,
      "status": 'ok'
    });

    await fetchArticles();

    console.log('Article signalé avec succès');
  } catch (err) {
    console.error('Erreur lors du signalement:', err);
    error.value = "Erreur lors du signalement de l'article.";
  }
};
const banUser = async (userId: number) => {
  try {
    if (!userId) return;

    await updateUser({
      "id": userId,
      "statut": 'banni'
    });

    await fetchUser();

    console.log('Article signalé avec succès');
  } catch (err) {
    console.error('Erreur lors du signalement:', err);
    error.value = "Erreur lors du signalement de l'article.";
  }
};
const unBanUser = async (userId: number) => {
  try {
    if (!userId) return;

    await updateUser({
      "id": userId,
      "statut": 'signaler'
    });

    await fetchUser();

    console.log('Article signalé avec succès');
  } catch (err) {
    console.error('Erreur lors du signalement:', err);
    error.value = "Erreur lors du signalement de l'article.";
  }
};

const upUser = async (userId: number) => {
  try {
    if (!userId) return;

    await roleUser({
      "id": userId,
      "role": 'ROLE_REDACTEUR'
    });

    await fetchUser();

    console.log('Article signalé avec succès');
  } catch (err) {
    console.error('Erreur lors du signalement:', err);
    error.value = "Erreur lors du signalement de l'article.";
  }
};
const downUser = async (userId: number) => {
  try {
    if (!userId) return;

    await roleUser({
      "id": userId,
      "role": 'ROLE_USER'
    });

    await fetchUser();

    console.log('Article signalé avec succès');
  } catch (err) {
    console.error('Erreur lors du signalement:', err);
    error.value = "Erreur lors du signalement de l'article.";
  }
};

watch(titre, fetchCommentaires);
watch(titre, fetchArticles);
watch(titre, fetchUser);

onMounted(() => {
  fetchCommentaires();
  fetchArticles();
  fetchUser();
});
</script>

<template>
  <main>
    <div class="form-container my-5 py-5">
      <h2>Gestion Compte</h2>
      <p>Cette page est réservée aux administrateurs.<br>
        Vous pouvez gérer les comptes utilisateurs ici.<br>
        Pour plus d'informations, veuillez contacter le support technique.</p>
      <select v-model="selectedSection" name="choix" id="choix">
        <option value="Commentaire">Commentaire</option>
        <option value="Article">Article</option>
        <option value="Utilisateur">Utilisateur</option>
      </select>
      <div v-show="selectedSection === 'Commentaire'" name="Commentaire" id="Commentaire">
        <div v-for="commentaire in commentaires" class="row">
          <div v-if="commentaire.status == 'signaler'" class="col-12 element">
            <div class="row">
              <div class="col-4">Pseudo:{{ commentaire.user?.pseudo }}</div>
              <div class="col-4">Article:{{ commentaire.article?.titre }}</div>
              <div v-if="commentaire.id" class="col-4">
                <button class="boutonSup" @click="validComment(commentaire.id)">Valider</button>
                <button class="boutonSup" @click="deleteCom(commentaire.id)">Supprimer</button>
                <button class="boutonSup">Bannir</button>
              </div>
            </div>
            <div class="row contenuCom">{{ commentaire.contenu }}</div>
          </div>

        </div>
        <br><br><br><br><br>
      </div>
      <div v-show="selectedSection === 'Article'" name="Article" id="Article">
        <div v-for="article in articles" class="row">
          <div v-if="article.status == 'signaler'" class="col-12 element">
            <div class="row">
              <div class="col-4">Auteur:{{ article.author?.pseudo }}</div>
              <div class="col-4">Article:{{ article.titre }}</div>
              <div class="col-4">
                <button class="boutonSup" @click="validArticle(article.id)">valider</button>
                <button class="boutonSup" @click="deleteArt(article.id)">Supprimer</button>
                <button class="boutonSup">Bannir</button>
              </div>
            </div>
            <div class="row contenuCom">{{ article.contenu }}</div>
          </div>
        </div>
      </div>
      <div v-show="selectedSection === 'Utilisateur'" class="user-section">
        <h3>Gestion des utilisateurs</h3>

        <div class="users-list">
          <div class="user-header row">
            <div class="col-2">Pseudo</div>
            <div class="col-3">Email</div>
            <div class="col-2">Role</div>
            <div class="col-2">Statut</div>
            <div class="col-3">Actions</div>
          </div>

          <div v-for="user in users" :key="user.id" class="user-row element">
            <div v-if="user.role != 'ROLE_ADMIN'">
            <div class="row align-items-center py-2">
              <div class="col-2">{{ user.pseudo }}</div>
              <div class="col-3">{{ user.email }}</div>
              <div class="col-2">
                <span :class="'role-badge ' + user.role.toLowerCase()">
                  {{ user.role.replace('ROLE_', '') }}
                </span>
              </div>
              <div class="col-2">
                <span :class="'status-badge ' + user.statut">
                  {{ user.statut }}
                </span>
              </div>
              <div class="col-3">
                <button v-if="user.role == 'ROLE_REDACTEUR'" class="boutonSup" @click="downUser(user.id)">
                  Retrogradé
                </button>
                <button v-if="user.role == 'ROLE_USER'" class="boutonSup" @click="upUser(user.id)">
                  Promouvoir
                </button>
                <button v-if="user.statut !== 'banni'" class="boutonSup" @click="banUser(user.id)"
                  :disabled="user.role === 'ROLE_ADMIN'">
                  Bannir
                </button>
                <button v-else class="boutonSup" @click="unBanUser(user.id)">
                  Débannir
                </button>
              </div>
            </div></div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
<style scoped>
.form-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

h2 {
  color: #dc3545;
  font-family: "Press Start 2P", system-ui;
  text-align: center;
  margin-bottom: 1.5rem;
}

p {
  text-align: center;
  color: #aaa;
  margin-bottom: 2rem;
}

select {
  display: block;
  width: 100%;
  max-width: 300px;
  margin: 2rem auto;
  padding: 0.75rem;
  background-color: #434343;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.element {
  background-color: rgba(255, 255, 255, 0.05);
  border-radius: 8px;
  margin-bottom: 1rem;
  padding: 1rem;
  transition: all 0.3s ease;
}

.element:hover {
  background-color: rgba(255, 255, 255, 0.08);
}

.row {
  margin: 0;
  padding: 0.5rem;
}

.contenuCom {
  background-color: #2d2d2d;
  padding: 1rem;
  margin-top: 0.5rem;
  border-radius: 4px;
  color: #ddd;
}

.boutonSup {
  background-color: #434343;
  color: #ff4b60;
  border: none;
  padding: 0.5rem 1rem;
  margin-right: 0.5rem;
  border-radius: 4px;
  transition: all 0.3s ease;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
}

.boutonSup:hover:not(:disabled) {
  background-color: #ff4b60;
  color: #fff;
}

.boutonSup:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.user-section {
  padding: 1rem;
}

.user-header {
  background-color: #434343;
  padding: 1rem;
  border-radius: 4px;
  margin-bottom: 1rem;
  font-weight: bold;
  color: #fff;
}

.role-badge, .status-badge {
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  font-size: 0.85rem;
  display: inline-block;
}

.role-badge.role_admin {
  background-color: #dc3545;
  color: white;
}

.role-badge.role_redacteur {
  background-color: #28a745;
  color: white;
}

.role-badge.role_user {
  background-color: #17a2b8;
  color: white;
}

.status-badge.ok {
  background-color: #28a745;
  color: white;
}

.status-badge.signaler {
  background-color: #ffc107;
  color: black;
}

.status-badge.banni {
  background-color: #dc3545;
  color: white;
}

@media (max-width: 768px) {
  .form-container {
    padding: 1rem;
  }

  h2 {
    font-size: 1.5rem;
  }

  .user-row {
    font-size: 0.9rem;
  }

  .boutonSup {
    padding: 0.4rem 0.8rem;
    font-size: 0.9rem;
  }

  .row > [class*="col-"] {
    margin-bottom: 0.5rem;
  }
}

@media (max-width: 480px) {
  h2 {
    font-size: 1.2rem;
  }

  p {
    font-size: 0.9rem;
  }

  .element {
    padding: 0.5rem;
  }

  .user-header {
    display: none;
  }

  .user-row .row {
    flex-direction: column;
  }

  .user-row [class*="col-"] {
    width: 100%;
    text-align: center;
    margin-bottom: 0.5rem;
  }

  .boutonSup {
    width: 100%;
    justify-content: center;
    margin-bottom: 0.5rem;
    margin-right: 0;
  }

  .role-badge, .status-badge {
    width: 100%;
    margin-bottom: 0.25rem;
  }
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.element {
  animation: fadeIn 0.3s ease;
}
</style>
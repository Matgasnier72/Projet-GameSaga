<script setup lang="ts">
import * as AccountService from '@/_services/AccountService';
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '@/stores/User';
import { deleteUser } from '@/_services/UserService';

interface User {
  id: number;
  pseudo: string;
  email: string;
  created_at: string;
  role: string;
  articles: Array<{
    id: number;
    titre: string;
    contenu: string;
    image: string | null;
    created_at: string;
    commentaires: Array<any>;
  }>;
}

const user = ref<User | null>(null);
const error = ref<string | null>(null);
const router = useRouter();
const userStore = useUserStore();
const idUser = userStore.user.id;

const loadUser = async () => {
  error.value = null;
  try {
    const userData = await AccountService.getUser();
    console.log(userData);
    user.value = userData;
  } catch (err) {
    console.error('Erreur lors de la récupération de l\'utilisateur:', err);
    error.value = 'Une erreur est survenue lors de la récupération des données.';
  }
};

const deleteAccount = async () => {
  if (!idUser) {
    error.value = "Erreur: ID utilisateur non trouvé";
    return;
  }

  if (confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')) {
    try {
      await deleteUser(idUser);
      userStore.clearUser();
      router.push('/');
    } catch (err) {
      error.value = "Erreur lors de la suppression du compte.";
    }
  }
};

onMounted(() => {
  loadUser();
});
</script>
<template>
  <main>
    <div class="profile-container">
      <div class="profile-header">
        <h2>Espace Personnel</h2>
        <div v-if="user" class="user-info">
          <div class="user-role">
            <div class="role-icon">
              <template v-if="userStore.user.role === 'ROLE_ADMIN'">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg>
              </template>
              <template v-else-if="userStore.user.role=== 'ROLE_REDACTEUR'">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M368.4 18.3L312.7 74.1 437.9 199.3l55.7-55.7c21.9-21.9 21.9-57.3 0-79.2L447.6 18.3c-21.9-21.9-57.3-21.9-79.2 0zM288 94.6l-9.2 2.8L134.7 140.6c-19.9 6-35.7 21.2-42.3 41L3.8 445.8c-3.8 11.3-1 23.9 7.3 32.4L164.7 324.7c-3-6.3-4.7-13.3-4.7-20.7c0-26.5 21.5-48 48-48s48 21.5 48 48s-21.5 48-48 48c-7.4 0-14.4-1.7-20.7-4.7L33.7 500.9c8.6 8.3 21.1 11.2 32.4 7.3l264.3-88.6c19.7-6.6 35-22.4 41-42.3l43.2-144.1 2.7-9.2L288 94.6z"/></svg>
              </template>
              <template v-else>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z"/></svg>
              </template>
            </div>
          </div>
          
          <div class="user-details">
            <h3>{{ user.pseudo }}</h3>
            <p class="user-email">{{ user.email }}</p>
            <div class="user-stats">
              <span><i class="fa-regular fa-calendar"></i> Membre depuis le {{ user.created_at }}</span>
              <span><i class="fa-regular fa-newspaper"></i> {{ user.articles?.length || 0 }} articles</span>
            </div>
          </div>
        </div>
      </div>

      <!-- <div class="user-articles">
        <h3>Articles créés</h3>
        <div class="articles-grid">
          <div v-for="article in user?.articles" :key="article.id" class="article-card">
            <img :src="article.image ? `${baseUrl}/images/uploads/${article.image}` : '../assets/placeholder.png'" :alt="article.titre">
            <div class="article-content">
              <h4>{{ article.titre }}</h4>
              <div class="article-meta">
                <span><i class="fa-regular fa-calendar"></i> {{ new Date(article.created_at).toLocaleDateString() }}</span>
                <span><i class="fa-regular fa-comment-dots"></i> {{ article.commentaires?.length || 0 }}</span>
              </div>
              <p class="article-excerpt">{{ article.contenu.substring(0, 100) }}...</p>
              <router-link :to="{ name: 'Article', params: { id: article.id }}" class="boutonCall">
                Voir l'article
              </router-link>
            </div>
          </div>
        </div>
      </div> -->

      <div v-if="userStore.user.role != 'ROLE_ADMIN'" class="account-actions">
        <button class="boutonCall delete-account" @click="deleteAccount">
          Supprimer mon compte
        </button>
      </div>
    </div>
  </main>
</template>

<style scoped>
.profile-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

.profile-header {
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 8px;
  padding: 2rem;
  margin-bottom: 2rem;
}

.user-info {
  display: flex;
  gap: 2rem;
  margin-top: 2rem;
}

.user-avatar {
  position: relative;
  width: 150px;
  height: 150px;
  flex-shrink: 0;
}

.user-avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 8px;
}

.role-icon {
  position: absolute;
  bottom: -10px;
  right: -10px;
  background-color: #dc3545;
  border-radius: 50%;
  padding: 0.5rem;
  width: 40px;
  height: 40px;
}

.role-icon svg {
  width: 100%;
  height: 100%;
  fill: #f8f8f8;
}

.user-details {
  flex: 1;
}

.user-stats {
  display: flex;
  gap: 2rem;
  color: #aaa;
}

.articles-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 2rem;
  margin-top: 2rem;
}

.article-card {
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 8px;
  overflow: hidden;
}

.article-card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.article-content {
  padding: 1.5rem;
}

.article-meta {
  display: flex;
  gap: 1rem;
  color: #aaa;
  margin: 0.5rem 0;
}

.article-excerpt {
  margin: 1rem 0;
  color: #ddd;
}

.account-actions {
  margin-top: 3rem;
  text-align: center;
}

.delete-account {
  background-color: #dc3545;
}

.delete-account:hover {
  background-color: #c82333;
}

@media (max-width: 768px) {
  .profile-container {
    padding: 1rem;
  }

  .user-info {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  .user-stats {
    justify-content: center;
    flex-wrap: wrap;
  }

  .articles-grid {
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  }
}

@media (max-width: 480px) {
  .profile-container {
    padding: 0.5rem;
  }

  .profile-header {
    padding: 1rem;
  }

  .articles-grid {
    grid-template-columns: 1fr;
  }

  .user-stats {
    flex-direction: column;
    gap: 0.5rem;
  }
}
</style>

<script setup lang="ts">
import { ref, watch, onMounted } from 'vue';
import { getArticles } from '@/_services/ArticleService';
//import { getCommentaires } from '@/_services/ArticleCommentaireService';
import { searchArticle } from '@/_services/ArticleService';
import type { Article } from '@/_models/Article';

const baseUrl = import.meta.env.VITE_API_BASE + '/images/uploads/';
const articles = ref<Article[]>([]);
const error = ref<string | null>(null);
const titre = ref<string>('');

const fetchArticles = async () => {
  try {
    const response = await searchArticle(titre.value);
    articles.value = response.data.posts;
    error.value = null;
  } catch (err) {
    error.value = "Erreur lors de la récupération des articles.";
  }
};

watch(titre, fetchArticles);

onMounted(fetchArticles);
</script>

<template>
  <main>
    <div class="articles-container">
      <h2 class="text-center mb-4">Articles</h2>

      <!-- Search Bar -->
      <div class="search-container mb-4">
        <input v-model="titre" placeholder="Recherche" class="search-input" type="search" />
      </div>

      <!-- Error Message -->
      <p v-if="error" class="error-message">{{ error }}</p>

      <!-- Articles Grid -->
      <div class="articles-grid">
        <div v-for="article in articles" :key="article.id" class="article-card">
          <div v-if="article.status == 'ok' || article.status == 'attente'">
          <RouterLink :to="{ name: 'Article', params: { id: article.id } }" class="article-link">
            <!-- Image Container -->
            <div class="image-container">
              <img v-if="article.image" :src="baseUrl + article.image" :alt="article.titre" class="article-image" />
              <div v-else class="placeholder-image">
                <i class="fa-solid fa-image"></i>
              </div>
            </div>

            <!-- Article Content -->
            <div class="article-content">
              <h3 class="article-title">{{ article.titre }}</h3>

              <div class="article-meta">
                <span class="author">
                  <i class="fa-solid fa-user"></i>
                  {{ article.author?.pseudo }}
                </span>
                <span class="rating">
                  <i class="fa-solid fa-star"></i>
                  {{ article.note_auteur }}/20
                </span>
                <span class="date">
                  <i class="fa-regular fa-calendar"></i>
                  {{ article.created_at }}
                </span>
                <span class="comments">
                  <i class="fa-regular fa-comment-dots"></i>
                </span>
              </div>
            </div>
          </RouterLink>
          </div>
        </div>
      </div>

      <!-- No Articles Message -->
      <p v-if="articles.length === 0 && !error" class="no-articles">
        Aucun article trouvé.
      </p>
    </div>
  </main>
</template>
<style scoped>
h2 {
    font-family: "Press Start 2P", system-ui;
    color: #dc3545;
    margin-top: 5rem;
    margin-bottom: 5rem;
    font-size: 1.75rem;
    font-weight: 400;
}
.articles-container {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

.search-container {
  max-width: 600px;
  margin: 0 auto;
}

.search-input {
  width: 100%;
  padding: 1rem;
  font-size: 1.1rem;
  background-color: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 4px;
  color: #fff;
}

.articles-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 2rem;
  margin-top: 2rem;
}

.article-card {
  background-color: rgb(28, 28, 28);
  border-radius: 8px;
  overflow: hidden;
  transition: transform 0.3s ease;
}

.article-card:hover {
  transform: translateY(-5px);
}

.article-link {
  text-decoration: none;
  color: white;
  display: block;
}

.image-container {
  aspect-ratio: 16/9;
  background-color: #1a1a1a;
  overflow: hidden;
}

.article-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.placeholder-image {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #2a2a2a;
  color: #666;
  font-size: 2rem;
}

.article-content {
  padding: 1rem;
}

.article-title {
  font-size: 1.2rem;
  margin-bottom: 1rem;
  color: #fff;
  font-family: "Press Start 2P", system-ui;
}

.article-meta {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 0.5rem;
  font-size: 0.9rem;
  color: #aaa;
}

.article-meta span {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.error-message {
  color: #dc3545;
  text-align: center;
  margin: 2rem 0;
}

.no-articles {
  text-align: center;
  color: #aaa;
  margin: 2rem 0;
}

/* Responsive Design */
@media (max-width: 768px) {
  .articles-container {
    padding: 1rem;
  }

  .articles-grid {
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1rem;
  }

  .article-title {
    font-size: 1rem;
  }
}

@media (max-width: 480px) {
  .articles-container {
    padding: 0.5rem;
  }

  .articles-grid {
    grid-template-columns: 1fr;
  }

  .article-meta {
    font-size: 0.8rem;
  }
}
</style>
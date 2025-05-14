<script setup lang="ts">
import { ref, watch } from 'vue';
import { searchArticle } from '@/_services/ArticleService';
import { useRouter } from 'vue-router';

const router = useRouter();

const articles = ref<{ id: number; titre: string }[]>([]);
const error = ref<string | null>(null);
const titre = ref<string>('');

const searchArticles = async () => {
  error.value = null;
  articles.value = [];

  if (!titre.value.trim()) {
    return;
  }

  try {
    const response = await searchArticle(titre.value); 
    const foundArticles = response?.data?.posts;

    if (foundArticles && foundArticles.length > 0) {
      articles.value = foundArticles;
    } else {
      error.value = `Aucun article trouvé pour "${titre.value}".`;
    }
  } catch (err) {
    console.error('Erreur dans searchArticles:', err);
    error.value = err instanceof Error ? err.message : 'Une erreur inattendue est survenue.';
  }
};

watch(titre, (newValue) => {
  if (newValue.trim()) {
    searchArticles();
  } else {
    articles.value = [];
    error.value = null;
  }
});

const goToArticle = (articleId: number) => {
  router.push({ name: 'Article', params: { id: articleId } });
  titre.value = '';
  articles.value = [];
};
</script>

<template>
  <main>
    <div class="search-container position-relative">
      <input v-model="titre" placeholder="Recherche" class="form-control me-2 bg-dark text-light" type="search" />

      <ul v-if="articles.length > 0" class="search dropdown-menu show w-100 bg-dark border border-white text-white"
        style="max-height: 200px; overflow-y: auto;">
        <li v-for="article in articles" :key="article.id" 
            class="list dropdown-item"
            @click="goToArticle(article.id)">
          {{ article.titre }}
        </li>
      </ul>
    </div>

    <div v-if="error" class="error-message">
      {{ error }}
    </div>
  </main>
</template>

<style scoped>
.list {
  color: #FFFFFF;
  cursor: pointer;
  transition: all 0.2s ease;
}

.list:hover {
  color: #000000;
  background-color: #f8f9fa;
}

.list:active {
  background-color: #900000;
  color: white;
}

.error-message {
  color: red;
  font-weight: bold;
  margin-top: 20px;
}
</style>
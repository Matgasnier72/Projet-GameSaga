<script setup lang="ts">
import { ref, watch } from 'vue';
import { searchArticle } from '@/_services/ArticleService'; // Import de la fonction d'API
import { useRouter } from 'vue-router';

const router = useRouter();

// Variables réactives
const articles = ref<{ id: number; titre: string }[]>([]); // Stocke les articles trouvés
const error = ref<string | null>(null); // Gère les erreurs
const titre = ref<string>(''); // Valeur de la barre de recherche

// Fonction de recherche d'articles
const searchArticles = async () => {
  error.value = null;
  articles.value = [];

  // Vérifie si la barre de recherche est vide
  if (!titre.value.trim()) {
    return; // Pas de recherche si le champ est vide
  }

  try {
    const response = await searchArticle(titre.value); // Appel à l'API avec la valeur de la barre de recherche
    const foundArticles = response?.data?.posts;

    // Vérifie si des articles ont été trouvés
    if (foundArticles && foundArticles.length > 0) {
      articles.value = foundArticles; // Stocke les articles trouvés
    } else {
      error.value = `Aucun article trouvé pour "${titre.value}".`;
    }
  } catch (err) {
    console.error('Erreur dans searchArticles:', err);
    error.value = err instanceof Error ? err.message : 'Une erreur inattendue est survenue.';
  }
};

// Watch pour déclencher la recherche à chaque changement dans `titre`
watch(titre, (newValue) => {
  if (newValue.trim()) {
    searchArticles(); // Lancer la recherche
  } else {
    articles.value = []; // Réinitialiser les résultats si le champ est vide
    error.value = null;
  }
});

const goToArticle = (articleId: number) => {
  router.push({ name: 'Article', params: { id: articleId } });
  titre.value = ''; // Réinitialise la recherche
  articles.value = []; // Vide les résultats
};
</script>

<template>
  <main>
    <!-- Barre de recherche -->
    <div class="search-container position-relative">
      <input v-model="titre" placeholder="Recherche" class="form-control me-2 bg-dark text-light" type="search" />

      <!-- Dropdown avec les articles trouvés -->
      <ul v-if="articles.length > 0" class="search dropdown-menu show w-100 bg-dark border border-white text-white"
        style="max-height: 200px; overflow-y: auto;">
        <li v-for="article in articles" :key="article.id" 
            class="list dropdown-item"
            @click="goToArticle(article.id)">
          {{ article.titre }}
        </li>
      </ul>
    </div>

    <!-- Message d'erreur -->
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
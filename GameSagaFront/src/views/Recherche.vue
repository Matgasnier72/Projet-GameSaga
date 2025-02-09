<script setup lang="ts">
import { ref, watch } from 'vue';
import { searchArticle } from '@/_services/ArticleService'; // Import de la fonction d'API

// Variables réactives
const articles = ref<{ titre: string }[]>([]); // Stocke les articles trouvés
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
</script>

<template>
  <main>
    <h1>Recherche d'articles</h1>

    <!-- Barre de recherche -->
    <div class="search-container">
      <input
        v-model="titre"
        type="text"
        placeholder="Recherchez un article par titre..."
        class="search-bar"
      />
    </div>

    <!-- Affichage des articles trouvés -->
    <div v-if="articles.length > 0">
      <h2>Articles trouvés :</h2>
      <ul>
        <li v-for="(article, index) in articles" :key="index">
          {{ article.titre }}
        </li>
      </ul>
    </div>

    <!-- Message quand aucun résultat trouvé -->
    <div v-else-if="!articles.length && !error && titre.trim()">
      <p>Aucun article trouvé pour "{{ titre }}".</p>
    </div>

    <!-- Message d'erreur -->
    <div v-if="error" class="error-message">
      <p>{{ error }}</p>
    </div>
  </main>
</template>

<style scoped>
.search-container {
  display: flex;
  gap: 10px;
  margin-bottom: 20px;
}

.search-bar {
  flex: 1;
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.search-button {
  padding: 10px 20px;
  font-size: 16px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.search-button:hover {
  background-color: #0056b3;
}

.error-message {
  color: red;
  font-weight: bold;
  margin-top: 20px;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  padding: 5px 0;
  font-size: 16px;
}
</style>
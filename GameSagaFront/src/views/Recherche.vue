<script setup lang="ts">
import * as ArticleService from '@/_services/ArticleService';
import { ref, watch } from 'vue';

// Définir une interface pour le type Article
interface Article {
  titre: string;
  // Ajoutez d'autres propriétés si nécessaire
}

// Déclare des variables réactives pour stocker les articles, l'état de l'erreur, et la valeur de recherche
const articles = ref<Article[]>([]); // Stocke une liste d'articles
const error = ref<string | null>(null);
const titre = ref<string>(''); // Variable réactive pour la barre de recherche

// Fonction pour récupérer les articles correspondant à la recherche
const searchArticles = async (query: string) => {
  error.value = null; // Réinitialise l'erreur
  try {
    const articleData = await ArticleService.searchArticle(query); // Appelle la fonction avec le paramètre `q`
    articles.value = articleData; // Assigner les données à la variable réactive
  } catch (err) {
    console.error('Erreur lors de la recherche des articles:', err);
    error.value = 'Une erreur est survenue lors de la recherche des articles.';
  }
};

// Met à jour la recherche à chaque modification de `titre`
watch(titre, (newQuery) => {
  searchArticles(newQuery);
});

</script>

<template>
  <main>
    <h1>Recherche d'articles</h1>

    <!-- Barre de recherche -->
    <input
      v-model="titre"
      type="text"
      placeholder="Recherchez un article par titre..."
      class="search-bar"
    />

    <!-- Liste des articles -->
    <div v-if="articles.length">
      <div v-for="article in articles" :key="article.titre" class="article-item">
        <p>Nom : {{ article.titre }}</p>
      </div>
    </div>
    <div v-else-if="!error">
      <p>Aucun article trouvé pour "{{ titre }}".</p>
    </div>

    <!-- Message d'erreur -->
    <div v-if="error" class="error-message">
      <p>{{ error }}</p>
    </div>
  </main>
</template>

<style scoped>
.search-bar {
  width: 100%;
  padding: 10px;
  margin-bottom: 20px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.article-item {
  margin-bottom: 10px;
}

.error-message {
  color: red;
  font-weight: bold;
}

</style>

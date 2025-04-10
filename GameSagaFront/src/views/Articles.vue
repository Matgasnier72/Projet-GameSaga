<script setup lang="ts">
import { ref, watch, onMounted } from 'vue';
import { getArticles } from '@/_services/ArticleService'; // API call function
//import { getCommentaires } from '@/_services/ArticleCommentaireService';
import SearchBar from '../components/SearchBar.vue';
import type { Article } from '@/_models/Article';

// Reactive Variables
const articles = ref<Article[]>([]);
const error = ref<string | null>(null);
const titre = ref<string>(''); // Search input value

// Function to Fetch Articles
const fetchArticles = async () => {
  try {
    const response = await getArticles(); // Assuming API function takes a title parameter
    articles.value = response; // Adjust based on API response format
    error.value = null;
  } catch (err) {
    error.value = "Erreur lors de la récupération des articles.";
  }
};

// Watcher for Search
watch(titre, fetchArticles);

// Load articles on component mount
onMounted(fetchArticles);
</script>

<template>
  <main>
    <div class="form-container my-5 py-5">
      <h2 class="form-title">Articles</h2>

      <!-- Search Bar -->
      <SearchBar v-model="titre" />
      <!-- Error Message -->
      <p v-if="error" class="text-danger">{{ error }}</p>

      <!-- Articles -->
      <div v-for="article in articles" :key="article.id" class="carte container d-none d-lg-block my-5">
        <div class="row">
          <RouterLink :to="{ name: 'Article', params: { id: article.id } }" class="col carte py-3 pt-1" alt="Article Image" />
          <div class="col carte py-3 pt-1">
            <img src="../assets/valve-software-504f0b01a27a2.webp" class="vignette text-truncate" alt="Article Image" />
          </div>
          <div class="col-9">
            <div class="row-2 text-align-start">
              <h4>{{ article.titre }}</h4>
              <input type="hidden" display="none" name="article_id" :value="article.id" />
            </div>
            <div class="row">

              <div class="col">Nom Auteur</div>
              <div class="col">{{ article.note_auteur }}</div>
              <div class="col">{{ article.created_at }}</div>
              <div class="col">
                <i class="fa-regular fa-comment-dots"></i> <!-- <script>count(commentaires)</script> -->
              </div>
            </div>
            <div class="row pb-3">{{ article.contenu }}</div>
          </div>
        </div>
      </div>

      <!-- No Articles Message -->
      <p v-if="articles.length === 0 && !error" class="text-muted">Aucun article trouvé.</p>
    </div>
  </main>
</template>
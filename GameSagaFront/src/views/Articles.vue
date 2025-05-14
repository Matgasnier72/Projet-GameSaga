<script setup lang="ts">
import { ref, watch, onMounted } from 'vue';
import { getArticles } from '@/_services/ArticleService';
//import { getCommentaires } from '@/_services/ArticleCommentaireService';
import { searchArticle } from '@/_services/ArticleService'; 
import type { Article } from '@/_models/Article';

const baseUrl = import.meta.env.VITE_API_BASE+'/images/uploads/';
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
    <div class="form-container my-5 py-5">
      <h2 class="form-title">Articles</h2>

      
      <input v-model="titre" placeholder="Recherche" class="form-control me-2 bg-dark text-light" type="search" />
      
      <p v-if="error" class="text-danger">{{ error }}</p>

      <div v-for="article in articles" :key="article.id" class="carte container d-none d-lg-block my-5">
        <RouterLink :to="{ name: 'Article', params: { id: article.id } }" 
            alt="Article Image">
        <div class="row">
          
            <div class="col py-3 pt-1">
              <img :src="baseUrl + article.image" class="vignette text-truncate"
                alt="Article Image" />
                <!-- appel de l'image de l'article -->
                 
            </div>
            <div class="col-9">
              <div class="row-2 text-align-start">
                <h4>{{ article.titre }}</h4>
                <input type="hidden" display="none" name="article_id" :value="article.id" />
              </div>
              <div class="row">

                <div class="col">{{ article.author?.pseudo }}</div>
                <div class="col">{{ article.note_auteur }}</div>
                <div class="col">{{ article.created_at }}</div>
                <div class="col">
                  <i class="fa-regular fa-comment-dots"></i> <!-- <script>count(commentaires)</script> -->
                </div>
              </div>
              <div class="row pb-3">{{ article.contenu }}</div>
            </div>
          
        </div>
      </RouterLink>
      </div>

      <!-- No Articles Message -->
      <p v-if="articles.length === 0 && !error" class="text-muted">Aucun article trouvé.</p>
    </div>
  </main>
</template>
<style scoped>
.carte a {
  text-decoration: none;
  color: white;
}

.carte a:hover {
  color: white;
}
</style>
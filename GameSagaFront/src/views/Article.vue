<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { getArticle } from '@/_services/ArticleService';
import { getCommentaires, createCommentaire } from '@/_services/ArticleCommentaireService';
import type { Article } from '@/_models/Article';
import type { Commentaire } from '@/_models/Commentaire';
import { useUserStore } from '@/stores/User';

const route = useRoute();
const userStore = useUserStore();
const article = ref<Article | null>(null);
const commentaires = ref<Commentaire[]>([]);
const error = ref<string | null>(null);
const newComment = ref({
  note: 0,
  contenu: ''
});

// Function to Fetch Article
const fetchArticle = async () => {
  try {
    const articleId = parseInt(route.params.id as string);
    if (isNaN(articleId)) {
      throw new Error('ID d\'article invalide');
    }
    const response = await getArticle(articleId);
    article.value = response;
    error.value = null;
  } catch (err) {
    console.error('Erreur dans fetchArticle:', err);
    error.value = "Erreur lors de la récupération de l'article.";
  }
};

// Function to Fetch Commentaires
const fetchCommentaires = async () => {
  try {
    if (!article.value?.id) return;
    const response = await getCommentaires(article.value.id);
    commentaires.value = response;
    error.value = null;
  } catch (err) {
    console.error('Erreur dans fetchCommentaires:', err);
    error.value = "Erreur lors de la récupération des commentaires.";
  }
};

const submitComment = async () => {
  try {
    if (!article.value?.id) return;
    
    await createCommentaire({
      article_id: article.value.id,
      note: newComment.value.note,
      contenu: newComment.value.contenu
    });
    
    // Réinitialiser le formulaire
    newComment.value = {
      note: 0,
      contenu: ''
    };
    
    // Recharger les commentaires
    await fetchCommentaires();
  } catch (err) {
    console.error('Erreur lors de la création du commentaire:', err);
    error.value = "Erreur lors de la création du commentaire.";
  }
};

// Load article and commentaires on component mount
onMounted(async () => {
  await fetchArticle();
  await fetchCommentaires();
});
</script>

<template>
  <main>
    <div class="form-container my-5 py-5">
      <h2 class="form-title">Article</h2>

      <!-- Article Details -->
      <div v-if="article" class="carte container d-none d-lg-block my-5">
        <div class="row">
          <div class="col carte py-3 pt-1">
            <img src="../assets/valve-software-504f0b01a27a2.webp" class="vignette text-truncate" alt="Article Image" />
          </div>
          <div class="col-9">
            <div class="row-2 text-align-start">
              <h4>{{ article.titre }}</h4>
              <input type="hidden" display="none" name="article_id" :value="article.id" />
            </div>
            <div class="row">
              <div class="col">{{ article.note_auteur }}</div>
              <div class="col">{{ article.created_at }}</div>
              <div class="col">
                <i class="fa-regular fa-comment-dots"></i>
              </div>
            </div>
            <div class="row pb-3">{{ article.contenu }}</div>
          </div>
        </div>
      </div>

      <!-- Comment Form -->
      <div v-if="userStore.islogged" class="carte container d-none d-lg-block my-5">
        <h3 class="mb-4">Ajouter un commentaire</h3>
        <form @submit.prevent="submitComment" class="comment-form">
          <div class="mb-3">
            <label for="note" class="form-label">Note (0-20)</label>
            <input 
              type="number" 
              class="form-control" 
              id="note" 
              v-model="newComment.note" 
              min="0" 
              max="20" 
              required
            >
          </div>
          <div class="mb-3">
            <label for="contenu" class="form-label">Commentaire</label>
            <textarea 
              class="form-control" 
              id="contenu" 
              v-model="newComment.contenu" 
              rows="3" 
              required
            ></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Publier le commentaire</button>
        </form>
      </div>
      <div v-else class="carte container d-none d-lg-block my-5">
        <p class="text-muted">Connectez-vous pour ajouter un commentaire</p>
      </div>

      <!-- Comments List -->
      <div v-if="commentaires.length > 0" class="carte container d-none d-lg-block my-5">
        <h3 class="mb-4">Commentaires</h3>
        <div v-for="commentaire in commentaires" :key="commentaire.id" class="comment-item mb-4">
          <div class="row">
            <div class="col-2">
              <span class="fw-bold">Note:</span> {{ commentaire.note }}
            </div>
            <div class="col-8">
              {{ commentaire.contenu }}
            </div>
            <div class="col-2 text-end">
              {{ commentaire.created_at }}
            </div>
          </div>
        </div>
      </div>
      <p v-else class="text-muted">Aucun commentaire pour le moment.</p>
    </div>
  </main>
</template>

<style scoped>
.comment-form {
  max-width: 800px;
  margin: 0 auto;
}

.comment-item {
  padding: 15px;
  border-bottom: 1px solid #eee;
}

.comment-item:last-child {
  border-bottom: none;
}

.form-control {
  background-color: #f8f9fa;
  border: 1px solid #ced4da;
}

.form-control:focus {
  background-color: #fff;
  border-color: #80bdff;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
}

.btn-primary:hover {
  background-color: #0056b3;
  border-color: #0056b3;
}
</style>
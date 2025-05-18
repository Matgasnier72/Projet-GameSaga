<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import { useRoute } from 'vue-router';
import { getArticle, updateArticle } from '@/_services/ArticleService';
import { getCommentaires, createCommentaire, updateCommentaire } from '@/_services/ArticleCommentaireService';
import { imagesByArticle } from '@/_services/ImageService';
import type { Article } from '@/_models/Article';
import type { Commentaire } from '@/_models/Commentaire';
import { useUserStore } from '@/stores/User';

const route = useRoute();
const baseUrl = import.meta.env.VITE_API_BASE + '/images/uploads/';
const userStore = useUserStore();
const article = ref<Article | null>(null);
const commentaires = ref<Commentaire[]>([]);
const error = ref<string | null>(null);
const newComment = ref({
  note: 0,
  contenu: ''
});
const images = ref<any[]>([]);
const currentPage = ref(1);
const commentsPerPage = ref(10);
const currentImagePage = ref(1);
const imagesPerPage = ref(8);



const totalPages = computed(() => {
  return Math.ceil(commentaires.value.length / commentsPerPage.value);
});

const fetchArticle = async () => {
  try {
    const articleId = parseInt(route.params.id as string);
    console.log('ID d\'article:', articleId);
    if (isNaN(articleId)) {
      throw new Error('ID d\'article invalide');
    }
    const response = await getArticle(articleId);
    console.log('Article récupéré:', response);
    article.value = response;
    error.value = null;
  } catch (err) {
    console.error('Erreur dans fetchArticle:', err);
    error.value = "Erreur lors de la récupération de l'article.";
  }
};

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

const fetchImages = async () => {
  try {
    if (!article.value?.id) return;
    const response = await imagesByArticle(article.value.id);
    images.value = response;
    console.log('Images récupérées:', images.value);
    error.value = null;
  } catch (err) {
    console.error('Erreur dans fetchimages:', err);
    error.value = "Erreur lors de la récupération des Images.";
  }
}

const paginatedImages = computed(() => {
  const start = (currentImagePage.value - 1) * imagesPerPage.value;
  const end = start + imagesPerPage.value;
  return images.value.slice(start, end);
});
const totalImagePages = computed(() => {
  return Math.ceil(images.value.length / imagesPerPage.value);
});
const nextImagePage = () => {
  if (currentImagePage.value < totalImagePages.value) {
    currentImagePage.value++;
  }
};
const previousImagePage = () => {
  if (currentImagePage.value > 1) {
    currentImagePage.value--;
  }
};
const goToImagePage = (page: number) => {
  currentImagePage.value = page;
};

const averageRating = computed(() => {
  if (commentaires.value.length === 0) return 0;

  const total = commentaires.value.reduce((sum, comment) => sum + comment.note, 0);
  return (total / commentaires.value.length).toFixed(1);
});

const submitComment = async () => {
  try {
    if (!article.value?.id) return;

    await createCommentaire({
      article_id: article.value.id,
      note: newComment.value.note,
      contenu: newComment.value.contenu
    });

    newComment.value = {
      note: 0,
      contenu: ''
    };

    await fetchCommentaires();
  } catch (err) {
    console.error('Erreur lors de la création du commentaire:', err);
    error.value = "Erreur lors de la création du commentaire.";
  }
};

const reportArticle = async (id: number) => {
  try {
    if (!article.value?.id) return;

    await updateArticle({
      id: article.value.id,
      status: 'signaler'
    });
    await fetchArticle();

    console.log('Article signalé avec succès');
  } catch (err) {
    console.error('Erreur lors du signalement:', err);
    error.value = "Erreur lors du signalement de l'article.";
  }
};

const reportComment = async (commentId: number) => {
  try {
    if (!commentId) return;

    await updateCommentaire({
      "id": commentId,
      "status": 'signaler'
    });

    await fetchCommentaires();

    console.log('Commentaire signalé avec succès');
  } catch (err) {
    console.error('Erreur lors du signalement:', err);
    error.value = "Erreur lors du signalement du commentaire.";
  }
};

const paginatedComments = computed(() => {
  const start = (currentPage.value - 1) * commentsPerPage.value;
  const end = start + commentsPerPage.value;
  return commentaires.value.slice(start, end);
});
const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};
const previousPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

const goToPage = (page: number) => {
  currentPage.value = page;
};

onMounted(async () => {
  await fetchArticle();
  await fetchCommentaires();
  await fetchImages();
});
</script>

<template>
  <main>
    <div class="article-container">
      <div v-if="article" class="article-content">
        <h2 class="article-title">{{ article.titre }}</h2>

        <div class="article-header">
          <div class="image-container d-flex justify-content-center align-items-center">
            <img v-if="article.image" :src="baseUrl + article.image" :alt="article.titre" class="article-image" />
            <div v-else class="placeholder-image">
              <i class="fa-solid fa-image"></i>
            </div>
          </div>

          <div class="article-meta">
            <div class="meta-item">
              <i class="fa-solid fa-star"></i>
              <span>{{ article.note_auteur }}/20</span>
            </div>
            <div class="meta-item">
              <i class="fa-regular fa-calendar"></i>
              <span>{{ article.created_at }}</span>
            </div>
            <div class="meta-item">
              <i class="fa-regular fa-comment-dots"></i>
              <span>{{ commentaires.length }} commentaires</span>
            </div>
            <div class="article-meta">
              <button v-if="userStore.islogged && article.status != 'ok'" @click="reportArticle(article.id)"
                class="report-article-btn" :disabled="article.status === 'signaler'">
                <i class="fa-solid fa-flag"></i>
                <span>{{ article.status === 'signaler' ? 'Article signalé' : 'Signaler l\'article' }}</span>
              </button>
            </div>
          </div>
        </div>

        <div class="article-body">
          {{ article.contenu }}
        </div>

        <div v-if="images.length > 0" class="gallery-container">
          <h3>Galerie d'images</h3>
          <div class="image-gallery">
            <div v-for="image in paginatedImages" :key="image.id" class="gallery-item">
              <img :src="baseUrl + image.path" :alt="image.description" />
            </div>
          </div>

          <div class="pagination-controls" v-if="totalImagePages > 1">
            <button class="boutonCall" @click="previousImagePage" :disabled="currentImagePage === 1">
              <svg class="button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path
                  d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
              </svg>
            </button>

            <div class="page-numbers">
              <button v-for="page in totalImagePages" :key="page" class="page-number"
                :class="{ active: currentImagePage === page }" @click="goToImagePage(page)">
                {{ page }}
              </button>
            </div>

            <button class="boutonCall" @click="nextImagePage" :disabled="currentImagePage === totalImagePages">
              <svg class="button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path
                  d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <div class="comments-section">
        <div v-if="userStore.islogged" class="comment-form-container">
          <h3>Ajouter un commentaire</h3>
          <form @submit.prevent="submitComment" class="comment-form">
            <div class="form-group">
              <label for="note">Note (0-20)</label>
              <div class="rating-input">
                <input type="number" id="note" v-model="newComment.note" min="0" max="20" required>
                <span>/20</span>
              </div>
            </div>

            <div class="form-group">
              <label for="contenu">Commentaire</label>
              <textarea id="contenu" v-model="newComment.contenu" rows="3" required></textarea>
            </div>

            <button type="submit" class="boutonCall">Publier le commentaire</button>
          </form>
        </div>
        <div v-else-if="userStore.islogged && userStore.user.statut === 'banni'" class="login-prompt error">
          <p>Votre compte a été banni. Vous ne pouvez plus poster de commentaires.</p>
        </div>
        <div v-else class="login-prompt">
          <p>Connectez-vous pour ajouter un commentaire</p>
        </div>

        <div v-if="commentaires.length > 0" class="comments-list">
          <h3>Commentaires</h3>

          <div v-if="commentaires.length > 0" class="average-rating">
            <h4>Note moyenne</h4>
            <div class="average-rating">
              <div class="rating-value">
                <i class="fa-solid fa-star"></i>
                <span>{{ averageRating }}/20</span>
              </div>
              <div class="rating-count">
                ({{ commentaires.length }} avis)
              </div>
            </div>
          </div>
          <div class="pagination-controls" v-if="totalPages > 1">
            <button class="boutonCall" @click="previousPage" :disabled="currentPage === 1">
              <svg class="button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path
                  d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
              </svg>
            </button>

            <div class="page-numbers">
              <button v-for="page in totalPages" :key="page" class="page-number"
                :class="{ active: currentPage === page }" @click="goToPage(page)">
                {{ page }}
              </button>
            </div>

            <button class="boutonCall" @click="nextPage" :disabled="currentPage === totalPages">
              <svg class="button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path
                  d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z" />
              </svg>
            </button>
          </div>


          <div v-for="commentaire in paginatedComments" :key="commentaire.id" class="comment-item">
            <div v-if="commentaire.status != 'signaler'">
              <div class="comment-header">
                <div class="comment-author">
                  <i class="fa-solid fa-user"></i>
                  <span>{{ commentaire.user?.pseudo }}</span>
                </div>
                <div class="comment-meta">
                  <span class="comment-rating">{{ commentaire.note }}/20</span>
                  <span class="comment-date">{{ commentaire.created_at }}</span>
                </div>
              </div>
              <div class="comment-content">
                {{ commentaire.contenu }}
              </div>
              <div class="comment-actions">
                <button class="action-btn like-btn">
                  <i class="fa-regular fa-heart"></i>

                </button>
                <button v-if="commentaire.status != 'ok'" class="action-btn report-btn"
                  @click="reportComment(commentaire.id!)" :disabled="commentaire.status === 'signaler'">
                  <i class="fa-solid fa-flag"></i>
                  <span>{{ commentaire.status === 'signaler' ? 'Commentaire signalé' : 'Signaler' }}</span>
                </button>
              </div>
            </div>
          </div>


          <div class="pagination-controls" v-if="totalPages > 1">
            <button class="boutonCall" @click="previousPage" :disabled="currentPage === 1">
              <svg class="button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path
                  d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
              </svg>
            </button>

            <div class="page-numbers">
              <button v-for="page in totalPages" :key="page" class="page-number"
                :class="{ active: currentPage === page }" @click="goToPage(page)">
                {{ page }}
              </button>
            </div>

            <button class="boutonCall" @click="nextPage" :disabled="currentPage === totalPages">
              <svg class="button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path
                  d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z" />
              </svg>
            </button>
          </div>
        </div>
        <p v-else class="no-comments">Aucun commentaire pour le moment.</p>
      </div>
    </div>
  </main>
</template>

<style scoped>
.article-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
  color: #f8f8f8;
}

.article-content {
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 8px;
  padding: 2rem;
  margin-bottom: 2rem;
}

.article-title {
  font-family: "Press Start 2P", system-ui;
  color: #dc3545;
  margin-bottom: 2rem;
  font-size: 1.75rem;
  text-align: center;
}

.article-header {
  display: grid;
  gap: 2rem;
  margin-bottom: 2rem;
}

.login-prompt.error {
  background-color: rgba(220, 53, 69, 0.1);
  border: 1px solid #dc3545;
  color: #dc3545;
}

.image-container {
  aspect-ratio: 16/9;
  max-height: 500px;
  background-color: #1a1a1a;
  border-radius: 4px;
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
}

.article-image {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}

.placeholder-image {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #2a2a2a;
  color: #666;
  font-size: 3rem;
}

.article-meta {
  display: flex;
  justify-content: center;
  gap: 2rem;
  flex-wrap: wrap;
}

.meta-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #aaa;
}

.article-body {
  line-height: 1.6;
  margin-bottom: 2rem;
  white-space: pre-line;
  padding: 1rem;
  background-color: rgba(0, 0, 0, 0.2);
  border-radius: 4px;
}

.gallery-container {
  margin-top: 2rem;
}

.gallery-container h3 {
  font-family: "Press Start 2P", system-ui;
  color: #dc3545;
  margin-bottom: 1rem;
  font-size: 1.2rem;
  text-align: center;
}

.image-gallery {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  /* 4 colonnes */
  gap: 1rem;
  margin-top: 1rem;
  margin-bottom: 1rem;
}

.gallery-item {
  aspect-ratio: 1;
  overflow: hidden;
  border-radius: 4px;
  border: 2px solid rgba(255, 255, 255, 0.1);
}

.gallery-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.gallery-item:hover img {
  transform: scale(1.05);
}

.comments-section {
  margin-top: 3rem;
}

.comments-section h3 {
  font-family: "Press Start 2P", system-ui;
  color: #dc3545;
  margin-bottom: 1.5rem;
  font-size: 1.2rem;
  text-align: center;
}

.comment-form-container {
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 8px;
  padding: 2rem;
  margin-bottom: 2rem;
}

.comment-form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.form-group label {
  color: #f8f8f8;
  font-size: 1rem;
}

.rating-input {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.rating-input input {
  width: 4rem;
  padding: 0.5rem;
  background-color: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 4px;
  color: #fff;
}

textarea {
  width: 100%;
  min-height: 100px;
  padding: 1rem;
  background-color: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 4px;
  color: #fff;
  resize: vertical;
}

.comments-list {
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 8px;
  padding: 2rem;
}

.comment-item {
  padding: 1rem;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  background-color: rgba(0, 0, 0, 0.2);
  border-radius: 4px;
  margin-bottom: 1rem;
}

.comment-item:last-child {
  border-bottom: none;
  margin-bottom: 0;
}

.comment-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 0.75rem;
}

.comment-author {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #dc3545;
  font-weight: bold;
}

.comment-meta {
  display: flex;
  gap: 1rem;
  color: #aaa;
  font-size: 0.9rem;
}

.comment-content {
  line-height: 1.4;
  margin-bottom: 1rem;
}

.comment-actions {
  display: flex;
  gap: 1rem;
  padding-top: 0.5rem;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.action-btn {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 4px;
  background: none;
  color: #aaa;
  cursor: pointer;
  transition: all 0.3s ease;
}

.like-btn:hover {
  color: #dc3545;
}

.report-btn:hover {
  color: #ffd700;
}

.login-prompt,
.no-comments {
  text-align: center;
  color: #aaa;
  padding: 2rem;
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 8px;
}

.average-rating {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;
  padding: 1rem;
  background-color: rgba(0, 0, 0, 0.2);
  border-radius: 4px;
}

.rating-value {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 1.2rem;
  color: #dc3545;
}

.rating-value i {
  color: #ffd700;
}

.rating-count {
  font-size: 0.9rem;
  color: #aaa;
}

.pagination-controls {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 1rem;
  margin-top: 2rem;
  padding-top: 1rem;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.page-numbers {
  display: flex;
  gap: 0.5rem;
}

.page-number {
  width: 2rem;
  height: 2rem;
  display: flex;
  align-items: center;
  justify-content: center;
  border: none;
  background-color: rgba(255, 255, 255, 0.1);
  color: #f8f8f8;
  border-radius: 4px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.page-number.active {
  background-color: #dc3545;
  color: white;
}

.page-number:hover:not(.active) {
  background-color: rgba(220, 53, 69, 0.2);
}

.button-icon {
  width: 1rem;
  height: 1rem;
  margin-right: 0.5rem;
  fill: currentColor;
  vertical-align: middle;
}

.report-article-btn {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 4px;
  background-color: rgba(255, 255, 255, 0.1);
  color: #aaa;
  cursor: pointer;
  transition: all 0.3s ease;
}

.report-article-btn:hover:not(:disabled) {
  background-color: rgba(255, 87, 34, 0.2);
  color: #ff5722;
}

.report-article-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.report-article-btn i {
  font-size: 1rem;
}

/* Responsive Design */
@media (max-width: 768px) {
  .article-container {
    padding: 1rem;
  }

  .article-content {
    padding: 1.5rem;
  }

  .article-title {
    font-size: 1.5rem;
  }

  .article-meta {
    gap: 1rem;
  }

  .comment-form-container {
    padding: 1.5rem;
  }

  .comment-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.5rem;
  }

  .image-gallery {
    grid-template-columns: repeat(3, 1fr);
    /* 3 colonnes sur tablette */
  }

  .report-article-btn {
    padding: 0.4rem 0.8rem;
    font-size: 0.9rem;
  }
}

@media (max-width: 480px) {
  .rating-value {
    font-size: 1rem;
  }

  .rating-count {
    font-size: 0.8rem;
  }

  .article-container {
    padding: 0.5rem;
  }

  .article-content {
    padding: 1rem;
  }

  .article-title {
    font-size: 1.25rem;
  }

  .image-gallery {
    grid-template-columns: repeat(2, 1fr);
  }

  .meta-item {
    font-size: 0.9rem;
  }

  .action-btn {
    padding: 0.4rem 0.8rem;
    font-size: 0.9rem;
  }

  .comment-meta {
    flex-direction: column;
    gap: 0.25rem;
  }

  .pagination-controls {
    flex-direction: column;
    gap: 0.5rem;
  }

  .page-numbers {
    flex-wrap: wrap;
    justify-content: center;
  }

  .page-number {
    width: 1.75rem;
    height: 1.75rem;
    font-size: 0.9rem;
  }
}
</style>
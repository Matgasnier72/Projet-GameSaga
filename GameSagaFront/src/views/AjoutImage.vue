<script setup lang="ts">
import { ref, watch, onMounted, computed } from 'vue';
import router from '@/router';
import * as ArticleService from '@/_services/ArticleService';
import * as ImageService from '@/_services/ImageService';
import type { Article, ArticleCreate } from '@/_models/Article';
import { searchArticle } from '@/_services/ArticleService';
import type { ImagePost } from '@/_models/Image';
import { useUserStore } from '@/stores/User';

const articles = ref<Article[]>([]);
const image = ref<ImagePost>({
  description: '',
  nom: '',
  image_blob: null,
  article_id: 0,
});
const titre = ref<string>('');
const error = ref<string | null>(null);
const searchQuery = ref('');
const article = ref<ArticleCreate>({
  titre: '',
  image_blob: null,
  note_auteur: 0,
  contenu: '',
  id: 0,
  user_id: 0,

});
const showDropdown = ref(false);
const selectedArticle = ref<Article | null>(null);

const filteredArticles = computed(() => {
  if (!searchQuery.value) return [];
  return articles.value.filter(article =>
    article.titre.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

const selectArticle = (article: Article) => {
  selectedArticle.value = article;
  searchQuery.value = article.titre;
  showDropdown.value = false;
  image.value.article_id = selectedArticle.value.id;
};


const errorMessage = ref<any>({});

async function postImages() {
  errorMessage.value = { general: '', titre: [], note_auteur: [], contenu: [] };
  try {
    await ImageService.postImage(image.value);
    console.log('Article creation successful', image.value);
  } catch (error: any) {
    console.error('Article creation failed:', error);

    if (error.response && error.response.status === 429) {
      errorMessage.value.general = 'Trop de tentatives, veuillez réessayer ultérieurement.';
    } else {
      for (const [field, messages] of Object.entries(error.response.data.errors)) {
        errorMessage.value[field] = messages;
      }
    }
  }
}
const fetchArticles = async () => {
  try {
    const response = await searchArticle(searchQuery.value);
    articles.value = response.data.posts;
    error.value = null;
  } catch (err) {
    error.value = "Erreur lors de la récupération des articles.";
  }
};

const validateFile = (file: File): boolean => {
  const maxSize = 2 * 1024 * 1024;
  const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

  if (!allowedTypes.includes(file.type)) {
    errorMessage.value = {
      ...errorMessage.value,
      image_blob: ['Format de fichier non supporté. Utilisez JPG, PNG ou WEBP.']
    };
    return false;
  }

  if (file.size > maxSize) {
    errorMessage.value = {
      ...errorMessage.value,
      image_blob: ['L\'image ne doit pas dépasser 2MB.']
    };
    return false;
  }

  return true;
};

function handleFileUpload(event: any) {
  const file = event.target.files[0];
  if (!file) return;

  if (validateFile(file)) {
    image.value.image_blob = file;
    errorMessage.value = { ...errorMessage.value, image_blob: [] };
  } else {
    event.target.value = '';
    image.value.image_blob = null;
  }
}

watch(searchQuery, fetchArticles);

onMounted(fetchArticles);
</script>

<template>
  <div class="form-container">
    <form @submit.prevent="postImages" class="image-form">
      <h2 class="form-title">Ajout d'Image</h2>
      <div v-if="errorMessage.general" class="error-message general-error" aria-live="assertive">
        {{ errorMessage.general }}
      </div>

      <div class="form-group">
        <label for="article_search">Pour quel article ?</label>
        <div class="search-container">
          <input type="text" id="article_search" v-model="searchQuery" class="form-control"
            placeholder="Rechercher un article..." @focus="showDropdown = true" />

          <div v-if="showDropdown && filteredArticles.length > 0" class="search-dropdown">
            <button v-for="article in filteredArticles" :key="article.id" type="button" class="dropdown-item"
              @click="selectArticle(article)">
              <div v-if="useUserStore().user.id === article.author.id">
                {{ article.titre }}
              </div>
            </button>
          </div>
        </div>
      </div>

      <div class="form-grid">
        <div class="form-group">
          <label for="article_titre">Titre</label>
          <input type="text" id="article_titre" v-model="image.nom" class="form-control" />
          <div v-if="errorMessage.nom" class="error-message" v-for="error in errorMessage.nom" :key="error">
            {{ error }}
          </div>
        </div>

        <div class="form-group">
          <label for="article_file">Image</label>
          <div class="file-upload-container">
            <input type="file" id="article_file" @change="handleFileUpload" accept="image/jpeg,image/png,image/webp"
              class="file-input" />
            <div class="file-restrictions">
              Format acceptés: JPG, PNG, WEBP
              <br>
              Taille maximum: 2MB
            </div>
          </div>
          <div v-if="errorMessage.image_blob" class="error-message" v-for="error in errorMessage.image_blob"
            :key="error">
            {{ error }}
          </div>
        </div>

        <div class="form-group full-width">
          <label for="description">Description</label>
          <textarea id="description" v-model="image.description" class="form-control"
            placeholder="Décrivez votre image..." rows="4"></textarea>
        </div>
      </div>

      <div class="form-actions">
        <button type="submit" class="boutonCall">
          <svg class="button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
            <path
              d="M246.6 9.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 109.3 192 320c0 17.7 14.3 32 32 32s32-14.3 32-32l0-210.7 73.4 73.4c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-128-128zM64 352c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 64c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-64c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 64c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-64z" />
          </svg>
          Upload
        </button>
        <router-link to="/" class="boutonCall">
          <svg class="button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
            <path
              d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" />
          </svg>
          Accueil
        </router-link>
      </div>
    </form>
  </div>
</template>
<style scoped>
.form-container {
  max-width: 1000px;
  margin: 2rem auto;
  padding: 2rem;
}

.image-form {
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 8px;
  padding: 2rem;
}

.form-title {
  text-align: center;
  margin-bottom: 2rem;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.full-width {
  grid-column: 1 / -1;
}

label {
  display: block;
  margin-bottom: 0.5rem;
  color: #f8f8f8;
  font-family: "VT323", monospace;
}

.form-control {
  width: 100%;
  padding: 0.75rem;
  background-color: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 4px;
  color: #f8f8f8;
  transition: border-color 0.3s ease;
}

.form-control:focus {
  border-color: #dc3545;
  outline: none;
}

.search-container {
  position: relative;
}

.search-dropdown {
  position: absolute;
  top: 100%;
  left: 0;
  right: 0;
  background-color: #2a2a2a;
  border-radius: 4px;
  max-height: 200px;
  overflow-y: auto;
  z-index: 1000;
}

.dropdown-item {
  padding: 0.75rem 1rem;
  width: 100%;
  text-align: left;
  border: none;
  background: none;
  color: #f8f8f8;
  cursor: pointer;
}

.dropdown-item:hover {
  background-color: rgba(220, 53, 69, 0.2);
}

.file-restrictions {
  margin-top: 0.5rem;
  font-size: 0.8rem;
  color: #999;
  text-align: center;
}

.file-upload-container {
  position: relative;
  padding: 2rem;
  border: 2px dashed rgba(255, 255, 255, 0.2);
  border-radius: 4px;
  text-align: center;
  cursor: pointer;
  transition: border-color 0.3s ease;
}

.file-upload-container:hover {
  border-color: #dc3545;
}

.file-input {
  width: 100%;
  height: 100%;
  cursor: pointer;
}

.error-message {
  color: #dc3545;
  font-size: 0.9rem;
  margin-top: 0.5rem;
}

.general-error {
  background-color: rgba(220, 53, 69, 0.1);
  border: 1px solid #dc3545;
  padding: 1rem;
  border-radius: 4px;
  margin-bottom: 1.5rem;
}

.form-actions {
  display: flex;
  justify-content: center;
  gap: 1rem;
  margin-top: 2rem;
}

.button-icon {
  width: 1rem;
  height: 1rem;
  margin-right: 0.5rem;
  fill: currentColor;
  vertical-align: middle;
}

.boutonCall {
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

/* Responsive Design */
@media (max-width: 768px) {
  .form-container {
    padding: 1rem;
  }

  .image-form {
    padding: 1.5rem;
  }

  .form-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 480px) {
  .form-container {
    padding: 0.5rem;
  }

  .image-form {
    padding: 1rem;
  }

  .form-title {
    font-size: 1.5rem;
  }

  .file-upload-container {
    padding: 1rem;
  }

  .form-actions {
    flex-direction: column;
    align-items: center;
    gap: 1rem;
  }

  .boutonCall {
    width: 100%;
  }
}
</style>
<script setup lang="ts">
import { ref } from 'vue';
import router from '@/router';
import * as ArticleService from '@/_services/ArticleService';
import type { Article, ArticleCreate } from '@/_models/Article';

const article = ref<ArticleCreate>({
  titre: '',
  image_blob: null,
  note_auteur: 0,
  contenu: '',
  id: 0,
  user_id: 0,
});

const errorMessage = ref<any>({});

async function Article() {
  errorMessage.value = { general: '', titre: [], note_auteur: [], contenu: [] };
  try {
    console.log(article.value);
    await ArticleService.createArticle(article.value);
    router.push({
      name: 'AjoutImage',
      query: { 
        articleId: article.value.id,
        articleTitle: article.value.titre
      }});
    console.log('Article creation successful', article.value);
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
function handleFileUpload(event: any) {
  article.value.image_blob = event.target.files[0];
  console.log('File selected:', article.value.image_blob);
}
</script>

<template>
  <main>
    <div class="redaction-container">
      <div class="redaction-content">
        <h2>Rédaction</h2>

        <form @submit.prevent="Article" class="redaction-form">
          <!-- Error Message -->
          <div v-if="errorMessage.general" class="error-message general-error" aria-live="assertive">
            {{ errorMessage.general }}
          </div>

          <!-- Title -->
          <div class="form-group">
            <label for="article_titre">Titre</label>
            <input type="text" id="article_titre" v-model="article.titre" class="input-field"
              placeholder="Titre de l'article" required />
            <div v-if="errorMessage.titre" class="error-message" v-for="error in errorMessage.titre" :key="error">
              {{ error }}
            </div>
          </div>

          <!-- Image Upload -->
          <div class="form-group">
            <label for="article_image">Vignette</label>
            <div class="file-upload-wrapper">
              <input type="file" id="article_image" ref="fileInput" accept="image/*" @change="handleFileUpload($event)"
                class="file-input" />
            </div>
          </div>

          <!-- Rating -->
          <div class="form-group">
            <label for="auteur_note">Note</label>
            <input type="number" min="0" max="20" id="auteur_note" v-model="article.note_auteur" class="input-field"
              required />
            <div v-if="errorMessage.note_auteur" class="error-message" v-for="error in errorMessage.note_auteur"
              :key="error">
              {{ error }}
            </div>
          </div>

          <!-- Content -->
          <div class="form-group">
            <label for="article_contenu">Contenu</label>
            <textarea id="article_contenu" v-model="article.contenu" placeholder="Rédigez votre article ici..."
              required></textarea>
            <div v-if="errorMessage.contenu" class="error-message" v-for="error in errorMessage.contenu" :key="error">
              {{ error }}
            </div>
          </div>

          <!-- Submit Button -->
          <div class="form-actions">
            <button type="submit" class="boutonCall">Publier</button>
          </div>
        </form>
      </div>
    </div>
  </main>
</template>
<style scoped>
.redaction-container {
  width: 100%;
  max-width: 800px;
  margin: 0 auto;
  padding: 2rem;
  color: #f8f8f8;
}

.redaction-content {
  border-radius: 8px;
  padding: 2rem;
  margin-top: 2rem;
}

.redaction-form {
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
  font-size: 1.1rem;
  margin-bottom: 0.5rem;
}

.input-field {
  width: 100%;
  padding: 1rem;
  font-size: 1.1rem;
  background-color: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 4px;
  color: #fff;
}

textarea {
  min-height: 200px;
  resize: vertical;
  width: 100%;
}

.file-upload-wrapper {
  position: relative;
  width: 100%;
  padding: 1rem;
  background-color: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 4px;
  text-align: center;
}

.file-input {
  width: 100%;
  color: #fff;
}

.form-actions {
  display: flex;
  justify-content: center;
  margin-top: 1rem;
}

.error-message {
  color: #dc3545;
  font-size: 0.9rem;
  margin-top: 0.5rem;
}

.general-error {
  background-color: rgba(220, 53, 69, 0.1);
  border: 1px solid #dc3545;
  padding: 0.75rem;
  border-radius: 4px;
  margin-bottom: 1rem;
}

/* Responsive Design */
@media (max-width: 768px) {
  .redaction-container {
    padding: 1rem;
  }

  .redaction-content {
    padding: 1.5rem;
  }

  .input-field,
  textarea {
    font-size: 1rem;
    padding: 0.8rem;
  }
}

@media (max-width: 480px) {
  .redaction-container {
    padding: 0.5rem;
  }

  .redaction-content {
    padding: 1rem;
  }

  .input-field,
  textarea {
    padding: 0.7rem;
  }

  .form-group label {
    font-size: 1rem;
  }
}
</style>
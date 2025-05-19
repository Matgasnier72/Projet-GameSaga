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
const isSubmitting = ref(false);

const validateFile = (file: File): boolean => {
  const maxSize = 2 * 1024 * 1024; // 2MB
  const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
  
  if (!allowedTypes.includes(file.type)) {
    errorMessage.value.image_blob = ['Format de fichier non supporté. Utilisez JPG, PNG ou WEBP.'];
    return false;
  }

  if (file.size > maxSize) {
    errorMessage.value.image_blob = ['L\'image ne doit pas dépasser 2MB.'];
    return false;
  }

  return true;
};

function handleFileUpload(event: any) {
  const file = event.target.files[0];
  if (!file) return;

  if (validateFile(file)) {
    article.value.image_blob = file;
    errorMessage.value.image_blob = [];
  } else {
    event.target.value = ''; // Reset input
    article.value.image_blob = null;
  }
}

async function createArticle() {
  if (isSubmitting.value) return;
  
  errorMessage.value = { general: '', titre: [], note_auteur: [], contenu: [], image_blob: [] };
  isSubmitting.value = true;

  try {
    // Basic validation
    if (article.value.titre.length < 3) {
      errorMessage.value.titre.push('Le titre doit contenir au moins 3 caractères');
      return;
    }

    if (article.value.contenu.length < 100) {
      errorMessage.value.contenu.push('L\'article doit contenir au moins 100 caractères');
      return;
    }

    if (article.value.note_auteur < 0 || article.value.note_auteur > 20) {
      errorMessage.value.note_auteur.push('La note doit être comprise entre 0 et 20');
      return;
    }

    const response = await ArticleService.createArticle(article.value);
    
    router.push({
      name: 'AjoutImage',
      query: { 
        articleId: response.id,
        articleTitle: response.titre
      }
    });

  } catch (error: any) {
    console.error('Article creation failed:', error);

    if (error.response?.status === 429) {
      errorMessage.value.general = 'Trop de tentatives, veuillez réessayer ultérieurement.';
    } else if (error.response?.data?.errors) {
      Object.entries(error.response.data.errors).forEach(([field, messages]) => {
        errorMessage.value[field] = messages;
      });
    } else {
      errorMessage.value.general = 'Une erreur est survenue lors de la création de l\'article.';
    }
  } finally {
    isSubmitting.value = false;
  }
}
</script>

<template>
  <main>
    <div class="redaction-container">
      <div class="redaction-content">
        <h2>Rédaction</h2>

        <form @submit.prevent="createArticle" class="redaction-form">
          <!-- Error Message -->
          <div v-if="errorMessage.general" class="error-message general-error" role="alert">
            {{ errorMessage.general }}
          </div>

          <!-- Title -->
          <div class="form-group">
            <label for="article_titre">Titre</label>
            <input 
              type="text" 
              id="article_titre" 
              v-model="article.titre" 
              class="input-field"
              placeholder="Titre de l'article" 
              :maxlength="255"
              required 
            />
            <div v-if="errorMessage.titre" class="error-message" v-for="error in errorMessage.titre" :key="error">
              {{ error }}
            </div>
          </div>

          <!-- Image Upload -->
          <div class="form-group">
            <label for="article_image">Vignette</label>
            <div class="file-upload-wrapper">
              <input 
                type="file" 
                id="article_image" 
                accept="image/jpeg,image/png,image/webp"
                @change="handleFileUpload"
                class="file-input" 
              />
              <div class="file-restrictions">
                Formats acceptés: JPG, PNG, WEBP
                <br>
                Taille maximum: 2MB
              </div>
            </div>
            <div v-if="errorMessage.image_blob" class="error-message" v-for="error in errorMessage.image_blob" :key="error">
              {{ error }}
            </div>
          </div>

          <!-- Rating -->
          <div class="form-group">
            <label for="auteur_note">Note</label>
            <input 
              type="number" 
              min="0" 
              max="20" 
              id="auteur_note" 
              v-model="article.note_auteur" 
              class="input-field"
              required 
            />
            <div v-if="errorMessage.note_auteur" class="error-message" v-for="error in errorMessage.note_auteur" :key="error">
              {{ error }}
            </div>
          </div>

          <!-- Content -->
          <div class="form-group">
            <label for="article_contenu">Contenu</label>
            <textarea 
              id="article_contenu" 
              v-model="article.contenu" 
              placeholder="Rédigez votre article ici..."
              required
            ></textarea>
            <div class="content-info">
              {{ article.contenu.length }} / 10000 caractères
            </div>
            <div v-if="errorMessage.contenu" class="error-message" v-for="error in errorMessage.contenu" :key="error">
              {{ error }}
            </div>
          </div>

          <!-- Submit Button -->
          <div class="form-actions">
            <button 
              type="submit" 
              class="boutonCall" 
              :disabled="isSubmitting"
            >
              {{ isSubmitting ? 'Publication en cours...' : 'Publier' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>
</template>
<style scoped>
.file-restrictions {
  margin-top: 0.5rem;
  font-size: 0.8rem;
  color: #999;
  text-align: center;
}

.content-info {
  font-size: 0.8rem;
  color: #999;
  text-align: right;
  margin-top: 0.5rem;
}

.boutonCall:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}
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
  padding: 2rem;
  border: 2px dashed rgba(255, 255, 255, 0.2);
  border-radius: 4px;
  text-align: center;
  cursor: pointer;
  transition: border-color 0.3s ease;
}

.file-upload-wrapper:hover {
  border-color: #dc3545;
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
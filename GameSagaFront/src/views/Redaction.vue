<script setup lang="ts">
import { ref } from 'vue';
import router from '@/router';
import * as ArticleService from '@/_services/ArticleService';
import type {Article} from '@/_models/Article';

const article = ref<Article>({
  titre: '',
  note_auteur: 0,
  contenu: '',
  created_at: '',
});

const errorMessage = ref<any>({});

async function Article() {
  errorMessage.value = { general: '', titre: [], note_auteur: [], contenu: [] };
  try {
    await ArticleService.createArticle(article.value);
    router.push('/Recherche');
    console.log('Article creation successful', article.value);
  } catch (error: any) {
    console.error('Article creation failed:', error);

    if (error.response && error.response.status === 429) {
      errorMessage.value.general = 'Trop de tentatives, veuillez réessayer ultérieurement.';
    } else {
      // Mapping field-specific errors
      for (const [field, messages] of Object.entries(error.response.data.errors)) {
        errorMessage.value[field] = messages;
      }
    }
  }
}
</script>

<template>
  <div class="form-container my-5 py-5">
    <form @submit.prevent="Article">
      <h2 class="form-title">Rédaction</h2>

      <!-- General Error Message -->
      <div v-if="errorMessage.general" class="error-message general-error" aria-live="assertive">{{ errorMessage.general }}</div>

      <!-- Title Field -->
      <div class="form-group">
        <label for="article_titre">Titre</label>
        <br>
        <input type="text" id="article_titre" v-model="article.titre" class="input-field 1" />
        <div v-if="errorMessage.titre" class="error-message" v-for="error in errorMessage.titre" :key="error">{{ error }}</div>
      </div>

      <!-- Note Field -->
      <div class="form-group">
        <label for="auteur_note">Note</label>
        <br>
        <input type="number" min="0" max="20" id="auteur_note" v-model="article.note_auteur" class="input-field 2" />
        <div v-if="errorMessage.note_auteur" class="error-message" v-for="error in errorMessage.note_auteur" :key="error">{{ error }}</div>
      </div>

      <!-- Content Field -->
      <div class="form-group">
        <label for="article_contenu">Contenu</label>
        <br>
        <textarea id="article_contenu" v-model="article.contenu" class="input-field 3"></textarea>
        <div v-if="errorMessage.contenu" class="error-message" v-for="error in errorMessage.contenu" :key="error">{{ error }}</div>
      </div>

      <!-- Submit Button -->
      <div class="form-group">
        <button type="submit" class="button btn btn-danger">Soumettre</button>
      </div>
    </form>
  </div>
</template>

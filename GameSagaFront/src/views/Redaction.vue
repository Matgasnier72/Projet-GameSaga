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
});

const errorMessage = ref<any>({});

async function Article() {
  errorMessage.value = { general: '', titre: [], note_auteur: [], contenu: [] };
  try {
    console.log(article.value);
    await ArticleService.createArticle(article.value);
    router.push('/article');
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
function handleFileUpload (event: any) {
  article.value.image_blob = event.target.files[0];
  console.log('File selected:', article.value.image_blob);
}
</script>

<template>
  <div class="form-container my-5 py-5">
    <form @submit.prevent="Article" to="/Blog" class="form">
      <h2 class="form-title">Rédaction</h2>

      <div v-if="errorMessage.general" class="error-message general-error" aria-live="assertive">{{ errorMessage.general
      }}</div>

      <div class="form-group">
        <label for="article_titre">Titre</label>
        <br>
        <input type="text" id="article_titre" v-model="article.titre" class="input-field 1" />
        <div v-if="errorMessage.titre" class="error-message" v-for="error in errorMessage.titre" :key="error">{{ error
        }}</div>
      </div>

      <div class="form-group">
        <label for="article_titre">Vignette</label>
        <br>
        <input type="file" ref="fileInput" accept="image/*" @change="handleFileUpload($event)" />
        <div v-if="errorMessage.titre" class="error-message" v-for="error in errorMessage.titre" :key="error">{{ error
        }}</div>
      </div>

      <div class="form-group">
        <label for="auteur_note">Note</label>
        <br>
        <input type="number" min="0" max="20" id="auteur_note" v-model="article.note_auteur" class="input-field 2" />
        <div v-if="errorMessage.note_auteur" class="error-message" v-for="error in errorMessage.note_auteur"
          :key="error">{{ error }}</div>
      </div>

      <div class="form-floating">
        <label for="floatingTextarea2">Contenu</label><br>
        <textarea v-model="article.contenu" placeholder="Donner nous votre impression" id="floatingTextarea2"
          style="height: 100px"></textarea>
      </div>

      <div class="form-group">
        <button type="submit" class="button btn btn-danger">Soumettre</button>
      </div>
    </form>
  </div>
</template>

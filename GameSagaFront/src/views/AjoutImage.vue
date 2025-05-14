<script setup lang="ts">
import { ref, watch, onMounted,computed } from 'vue';
import router from '@/router';
import * as ArticleService from '@/_services/ArticleService';
import * as ImageService from '@/_services/ImageService';
import type { Article, ArticleCreate } from '@/_models/Article';
import { searchArticle } from '@/_services/ArticleService'; 
import type { ImagePost } from '@/_models/Image';

const articles = ref<Article[]>([]);
const image = ref<ImagePost>({
    description: '',
    nom: '',
    image_blob: null,
    article_id: 0
});
const titre = ref<string>('');
const error = ref<string | null>(null);
const searchQuery = ref('');
const article = ref<ArticleCreate>({
    titre: '',
    image_blob: null,
    note_auteur: 0,
    contenu: '',
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

function handleFileUpload (event: any) {
  image.value.image_blob = event.target.files[0];
  console.log('File selected:', image.value.image_blob);
}

watch(searchQuery, fetchArticles);

onMounted(fetchArticles);
</script>

<template>
    <div class="form-container my-5 py-5">
        <form @submit.prevent="postImages">
            <h2 class="form-title">Ajout d'Image</h2>

            <div v-if="errorMessage.general" class="error-message general-error" aria-live="assertive">{{
                errorMessage.general }}</div>

            <label class="col" for="article_titre">pour quelle article?</label>
            <label class="col" for="article_search">Pour quel article ?</label>
            <div class="search-container mb-3 position-relative">
                <input 
                    type="text" 
                    id="article_search"
                    v-model="searchQuery"
                    class="form-control" 
                    placeholder="Rechercher un article..."
                    @focus="showDropdown = true"

                />
                
                <!-- Dropdown -->
                <div 
                    v-if="showDropdown && filteredArticles.length > 0" 
                    class="dropdown-menu show position-absolute w-100"
                >
                    <button
                        v-for="article in filteredArticles"
                        :key="article.id"
                        type="button"
                        class="dropdown-item"
                        @click="selectArticle(article)"
                    >
                        {{ article.titre }}
                    </button>
                </div>
            </div>

            <div class="row">
                <label class="col" for="article_titre">Titre</label>

                <label class="col" for="article_file">Image</label>

                <label class="col" for="floatingTextarea2">Description</label>

            </div>
            <div class="row">
                <input type="text" id="article_titre" v-model="image.nom" class="input-field 1" />
                <div v-if="errorMessage.nom" class="error-message" v-for="error in errorMessage.nom" :key="error">{{
                    error }}</div>

                <div class="col">
                    <div class="col">
                        <input type="file" id="article_file"  v-on="image.image_blob" class="input-field 1" @change="handleFileUpload($event)"/>
                        <div v-if="errorMessage.image_blob" class="error-message" v-for="error in errorMessage.image_blob"
                            :key="error">{{ error }}</div>
                    </div>
                </div>

                <div class="col">
                    <textarea class="form-control" v-model="image.description" placeholder="Préciser le contenu de votre demande"
                        id="floatingTextarea2"></textarea>
                </div>

            </div>
            <div class="form-group">
                <button type="submit" class="button btn btn-danger">Soumettre</button>
            </div>

        </form>
    </div>
</template>

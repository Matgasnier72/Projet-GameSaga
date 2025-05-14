<script setup lang="ts">
import { ref, watch, onMounted } from 'vue';
import { listCommentaires, deleteCommentaire,deleteArticle } from '@/_services/ArticleCommentaireService';
import { getArticles } from '@/_services/ArticleService';
import type { Article } from '@/_models/Article';
import type { Commentaire } from '@/_models/Commentaire';

// Reactive Variables
const commentaires = ref<Commentaire[]>([]);
const articles = ref<Article[]>([]);
const error = ref<string | null>(null);
const titre = ref<string>('');
const selectedSection = ref('Commentaire');

const fetchCommentaires = async () => {
  try {
    const response = await listCommentaires();
    commentaires.value = response;
    error.value = null;
  } catch (err) {
    error.value = "Erreur lors de la récupération des articles.";
  }
};
const fetchArticles = async () => {
  try {
    const response = await getArticles();
    articles.value = response;
    error.value = null;
  } catch (err) {
    error.value = "Erreur lors de la récupération des articles.";
  }
};

const deleteCom = async (id: number) => {
  try {
    await deleteCommentaire(id);
    console.log('Commentaire supprimé avec succès');
    fetchCommentaires(); // Refresh
  } catch (error) {
    console.error('Erreur lors de la suppression du commentaire:', error);
  }
};

const deleteArt = async (id: number) => {
  try {
  await deleteArticle(id);
    console.log('Article supprimé avec succès');
    fetchArticles(); // Refresh the list after deletion
  } catch (error) {
    console.error('Erreur lors de la suppression de l\'article:', error);
  }
};


watch(titre, fetchCommentaires);

onMounted(() => {
  fetchCommentaires();
  fetchArticles();
});
</script>

<template>
  <main>
    <div class="form-container my-5 py-5">
      <h2>Gestion Compte</h2>
      <p>Cette page est réservée aux administrateurs.<br>
        Vous pouvez gérer les comptes utilisateurs ici.<br>
        Pour plus d'informations, veuillez contacter le support technique.</p>
      <select v-model="selectedSection" name="choix" id="choix">
        <option value="Commentaire">Commentaire</option>
        <option value="Article">Article</option>
        <option value="Utilisateur">Utilisateur</option>
      </select>
      <div v-show="selectedSection === 'Commentaire'" name="Commentaire" id="Commentaire">
        <div v-for="commentaire in commentaires" class="row">
          <div v-if="commentaire.status == 'ok'" class="col-12 element">
            <div class="row">
              <div class="col-4">Pseudo:{{ commentaire.user?.pseudo }}</div>
              <div class="col-4">Article:{{ commentaire.article?.titre }}</div>
              <div v-if="commentaire.id" class="col-4">
                <button class="boutonSup" @click="deleteCom(commentaire.id)">Supprimer</button>
                <button class="boutonSup">Bannir</button></div>
            </div>
            <div class="row contenuCom">{{ commentaire.contenu }}</div>
          </div>

        </div>
        <br><br><br><br><br>
      </div>
      <div v-show="selectedSection === 'Article'" name="Article" id="Article">
        <div v-for="article in articles" class="row">
          <div v-if="article.status == 'ok'" class="col-12 element">
            <div class="row">
              <div class="col-4">Auteur:{{ article.author?.pseudo }}</div>
              <div class="col-4">Article:{{ article.titre }}</div>
              <div class="col-4">
                <button class="boutonSup" >Edition</button>
                <button class="boutonSup" @click="deleteArt( article.id)">Supprimer</button>
                <button class="boutonSup">Bannir</button>
              </div>
            </div>
            <div class="row contenuCom">{{ article.contenu }}</div>
          </div>
        </div>
      </div>
      <div v-show="selectedSection === 'Utilisateur'" name="Utilisateur" id="Utilisateur">
        <div v-for="commentaire in commentaires" class="row">
          <div v-if="commentaire.status == 'ok'" class="col-12 element">
            <div class="row">
              <div class="col-4">Pseudo:{{ commentaire.user?.pseudo }}</div>
              <div class="col-4">Article:{{ commentaire.article?.titre }}</div>
              <div class="col-4"><button class="boutonSup">Supprimer</button><button class="boutonSup">Bannir</button>
              </div>
            </div>
            <div class="row contenuCom">{{ commentaire.contenu }}</div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
<style scoped>
.element {
  border-bottom: #434343 solid;
}

.boutonSup {
  background-color: #434343;
  color: #ff4b60;
}

.contenuCom {
  background-color: #2d2d2d;
}
</style>
<script setup lang="ts">
import { ref, watch, onMounted } from 'vue';
import { getLimitedArticles } from '@/_services/ArticleService';
import type { Article } from '@/_models/Article';

const baseUrl = import.meta.env.VITE_API_BASE + '/images/uploads/';
const articles = ref<Article[]>([]);
const error = ref<string | null>(null);
const titre = ref<string>('');

const fetchArticles = async () => {
  try {
    const response = await getLimitedArticles(6);
    articles.value = response;
    error.value = null;
  } catch (err) {
    error.value = "Erreur lors de la récupération des articles.";
  }
};

watch(titre, fetchArticles);

onMounted(fetchArticles);
</script>

<template>
  <!--carousel-->
  <div class="container d-none d-lg-block">
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
          aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
          aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
          aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner ">
        <div class="carousel-item active">
          <img src="../assets/Steam-app-on-PC-screen.webp" class="diapo d-block w-100" alt="steam wallpaper">
          <div class="carousel-caption d-none d-md-block bg-dark">
            <h2>PC Master Race</h2>
            <p>Parfait pour les vrai fan de jeu vidéo</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="../assets/wp12873365.jpg" class="diapo d-block w-100" alt="playstation">
          <div class="carousel-caption d-none d-md-block bg-dark">
            <h2>Ne vaut pas le coup</h2>
            <p>Apple du jeu vidéo</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="../assets/417072.webp" class="diapo d-block w-100" alt="nintendo">
          <div class="carousel-caption d-none d-md-block bg-dark">
            <h2>Sympa</h2>
            <p>pour les enfant et nostalgique de nintendo</p>
          </div>
        </div>
      </div>
      <a class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      </a>
      <a class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
      </a>
    </div>
  </div>
  <!--aperçu article-->
  <div class="articles-preview">
    <div class="articles-grid">
      <div v-for="article in articles" :key="article.id" class="article-card">
        <div v-if="article.status == 'ok' || article.status == 'en attente'">
          <RouterLink :to="{ name: 'Article', params: { id: article.id } }" class="article-link">
            <div class="image-container">
              <img 
                v-if="article.image" 
                :src="baseUrl + article.image" 
                :alt="article.titre" 
                class="article-image" 
              />
              <div v-else class="placeholder-image">
                <i class="fa-solid fa-image"></i>
              </div>
            </div>

            <div class="article-content">
              <h3 class="article-title">{{ article.titre }}</h3>
              <div class="article-meta">
                <span class="author">
                  <i class="fa-solid fa-user"></i>
                  {{ article.author?.pseudo }}
                </span>
                <span class="rating">
                  <i class="fa-solid fa-star"></i>
                  {{ article.note_auteur }}/20
                </span>
                <span class="date">
                  <i class="fa-regular fa-calendar"></i>
                  {{ article.created_at }}
                </span>
              </div>
            </div>
          </RouterLink>
        </div>
      </div>
    </div>
  </div>
  
  <!--contact-->
  <div class="container d-none d-lg-block m-5">
    <h3>Vous avez l'âme d'un auteur?<br>
      <svg class="mt-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
        <path
          d="M368.4 18.3L312.7 74.1 437.9 199.3l55.7-55.7c21.9-21.9 21.9-57.3 0-79.2L447.6 18.3c-21.9-21.9-57.3-21.9-79.2 0zM288 94.6l-9.2 2.8L134.7 140.6c-19.9 6-35.7 21.2-42.3 41L3.8 445.8c-3.8 11.3-1 23.9 7.3 32.4L164.7 324.7c-3-6.3-4.7-13.3-4.7-20.7c0-26.5 21.5-48 48-48s48 21.5 48 48s-21.5 48-48 48c-7.4 0-14.4-1.7-20.7-4.7L33.7 500.9c8.6 8.3 21.1 11.2 32.4 7.3l264.3-88.6c19.7-6.6 35-22.4 41-42.3l43.2-144.1 2.7-9.2L288 94.6z" />
      </svg>
    </h3>
    <div class=" p-5">
      Si le jeu vidéo est votre passion et que vous souhaitez partager votre avis avec le monde, n’hésité plus !<br><br>

      Contacter nous pour avoir la chance de transmettre vos idées à d’autre passionné
    </div>
    <router-link class="boutonCall nav-link-custom" to="/contact">Contactez-nous</router-link>
  </div>
  <!--À propos-->
  <div class="container d-none d-lg-block m-5">
    <h3>
      À propos
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
        <path
          d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336l24 0 0-64-24 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l48 0c13.3 0 24 10.7 24 24l0 88 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-80 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
      </svg>
    </h3>
    <div class="mb-5 p-5">
      L’aventure de GameSaga commença en 1242, après que des moines copiste est découvert le bilboquet.<br><br>
      Quelques jours, après avoir joué, il décida d’écrire un essai nommé “bilboquetus nullum” ou il décrivit son
      expérience négative qu’il vécut durant sa partie.
    </div>
    <router-link class="boutonCall nav-link-custom" to="/about">À propos</router-link>
  </div>
</template>
<style scoped>
.diapo {
  height: 500px;
  object-fit: cover;
}

.carousel {
  margin: 50px 0;
  border-radius: 8px;
  overflow: hidden;
}

/* Articles Grid Layout */
.articles-preview {
  padding: 2rem;
  margin-bottom: 3rem;
}

.articles-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 2rem;
  margin: 0 auto;
  max-width: 1200px;
}

.article-card {
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 8px;
  overflow: hidden;
  transition: transform 0.3s ease;
}

.article-card:hover {
  transform: translateY(-5px);
}

.article-link {
  text-decoration: none;
  color: inherit;
}

.image-container {
  aspect-ratio: 16/9;
  overflow: hidden;
  background-color: #1a1a1a;
}

.article-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.placeholder-image {
  width: 100%;
  height: 100%;
  background-color: #2a2a2a;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
  color: #666;
}

.article-content {
  padding: 1rem;
}

.article-title {
  margin-bottom: 1rem;
  font-size: 1.1rem;
  color: #f8f8f8;
}

.article-meta {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 0.5rem;
  font-size: 0.9rem;
  color: #aaa;
}

.article-meta span {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

/* Contact and About sections */
.container {
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 8px;
  padding: 2rem;
  margin: 2rem auto;
  max-width: 1000px;
}

svg {
  height: 40px;
  fill: #f8f8f8;
  margin: 1rem 0;
}

/* Responsive Design */
@media (max-width: 1024px) {
  .articles-grid {
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    padding: 1rem;
  }

  .container {
    margin: 1rem;
    padding: 1.5rem;
  }
}

@media (max-width: 768px) {
  .articles-preview {
    padding: 1rem;
  }

  .articles-grid {
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
  }

  .article-title {
    font-size: 1rem;
  }

  .article-meta {
    font-size: 0.8rem;
  }
}

@media (max-width: 480px) {
  .articles-preview {
    padding: 0.5rem;
  }

  .articles-grid {
    grid-template-columns: 1fr;
  }

  .container {
    margin: 0.5rem;
    padding: 1rem;
  }

  .diapo {
    height: 300px;
  }
}
</style>
<script setup lang="ts">
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
  <!--dernier article-->
  <div class=" carte container d-none d-lg-block my-5">
    <h3>Dernier Article</h3>
    <div class=" row">
      <div class="col"></div>
      <div class="col py-3 pt-1">
        <img src="../assets/valve-software-504f0b01a27a2.webp" class="vignette text-truncate" alt="">
      </div>
      <div class="col-4">
        <div class="row-2 text-align-center">
          <h4>Titre</h4>
        </div>
        <div class="row pb-3">
          Lorem ipsum, dolor sit amet consectetur adipisicing elit. Obcaecati tempora beatae similique ab! Temporibus
          similique et distinctio natus beatae alias commodi consectetur atque ex aliquid, earum vitae aliquam rerum
          harum.
        </div>
        <div class="row-2">
          <button class="boutonCall">Voir les deniers articles</button>
        </div>
      </div>
      <div class="col-2"></div>
    </div>
  </div>
  <!--aperçu article-->
  <div class="container d-none d-lg-block my-3">
    <h3 class="mb-5">Aperçu de nos articles</h3>
    <div class="row">
      <div class="carte col-4">
        <div class="row-8">
          <img src="../assets/valve-software-504f0b01a27a2.webp" class="vignette mt-3" alt="">
        </div>
        <div class="row">
          <div class="col">nom jeux</div>
        </div>
        <div class="row-1 inline">
          <div class="list-inline-item px-3">auteur</div>
          <div class="list-inline-item px-3">JJ/MM/AAAA</div>
        </div>
        <div class="row-2"><i class="fa-regular fa-comment-dots"></i> 666</div>

      </div>
      <div class="carte col-4">
        <div class="row-8">
          <img src="../assets/valve-software-504f0b01a27a2.webp" class="vignette mt-3" alt="">
        </div>
        <div class="row">
          <div class="col">nom jeux</div>
        </div>
        <div class="row-1 inline">
          <div class="list-inline-item px-3">auteur</div>
          <div class="list-inline-item px-3">JJ/MM/AAAA</div>
        </div>
        <div class="row-2"><i class="fa-regular fa-comment-dots"></i> 666</div>

      </div>
      <div class="carte col-4">
        <div class="row-8">
          <img src="../assets/valve-software-504f0b01a27a2.webp" class="vignette mt-3" alt="">
        </div>
        <div class="row">
          <div class="col">nom jeux</div>
        </div>
        <div class="row-1 inline">
          <div class="list-inline-item px-3">auteur</div>
          <div class="list-inline-item px-3">JJ/MM/AAAA</div>
        </div>
        <div class="row-2"><i class="fa-regular fa-comment-dots"></i> 666</div>

      </div>
    </div>
  </div>
  <div class="container d-none d-lg-block mt-3">
    <div class="row">
      <div class="carte col-4">
        <div class="row-8">
          <img src="../assets/valve-software-504f0b01a27a2.webp" class="vignette mt-3" alt="">
        </div>
        <div class="row">
          <div class="col">nom jeux</div>
        </div>
        <div class="row-1 inline">
          <div class="list-inline-item px-3">auteur</div>
          <div class="list-inline-item px-3">JJ/MM/AAAA</div>
        </div>
        <div class="row-2"><i class="fa-regular fa-comment-dots"></i> 666</div>

      </div>
      <div class="carte col-4">
        <div class="row-8">
          <img src="../assets/valve-software-504f0b01a27a2.webp" class="vignette mt-3" alt="">
        </div>
        <div class="row">
          <div class="col">nom jeux</div>
        </div>
        <div class="row-1 inline">
          <div class="list-inline-item px-3">auteur</div>
          <div class="list-inline-item px-3">JJ/MM/AAAA</div>
        </div>
        <div class="row-2"><i class="fa-regular fa-comment-dots"></i> 666</div>

      </div>
      <div class="carte col-4">
        <div class="row-8">
          <img src="../assets/valve-software-504f0b01a27a2.webp" class="vignette mt-3" alt="">
        </div>
        <div class="row">
          <div class="col">nom jeux</div>
        </div>
        <div class="row-1 inline">
          <div class="list-inline-item px-3">auteur</div>
          <div class="list-inline-item px-3">JJ/MM/AAAA</div>
        </div>
        <div class="row-2"><i class="fa-regular fa-comment-dots"></i> 666</div>

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
    <router-link class="boutonCall" to="/about">À propos</router-link>
  </div>
</template>
<style>

.diapo {
  height: 60VH;
}

svg {
  height: 40px;
  fill: #f8f8f8;
}

.vignette {
  height: 15vh;
}

.carte:hover {
  background-color: #3b3b3b;
}
</style>
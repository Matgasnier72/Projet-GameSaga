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
          <img src="../assets/Steam-app-on-PC-screen.webp" class="d-block w-100" alt="steam wallpaper">
          <div class="carousel-caption d-none d-md-block bg-dark">
            <h2>PC Master Race</h2>
            <p>Parfait por les vrai fan de jeu vidéo</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="../assets/wp12873365.jpg" class="d-block w-100" alt="playstation">
          <div class="carousel-caption d-none d-md-block bg-dark">
            <h2>Ne vaut pas le coup</h2>
            <p>Apple du jeu vidéo</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="../assets/417072.webp" class="d-block w-100" alt="nintendo">
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
  <div class="container d-none d-lg-block mt-3">
    <div class=" row">
      <div class="col-3"></div>
      <div class="col py-3">
        <img src="../assets/valve-software-504f0b01a27a2.webp" alt="">
      </div>
      <div class="col-4">
        <div class="row text-align-center">
          <h2>Titre</h2>
        </div>
        <div class="row">
          Lorem ipsum, dolor sit amet consectetur adipisicing elit. Obcaecati tempora beatae similique ab! Temporibus
          similique et distinctio natus beatae alias commodi consectetur atque ex aliquid, earum vitae aliquam rerum
          harum.
        </div>
        <div class="row">
          <button class="btn bg-danger">Voir les deniers articles</button>
        </div>
      </div>
      <div class="col-2"></div>
    </div>
  </div>
  <!--aperçu article-->
  <div class="container d-none d-lg-block mt-3">
    <div class="row">
      <div class="col-4">
        <div class="row-10">
          <img src="../assets/valve-software-504f0b01a27a2.webp" alt="">
        </div>
        <div class="row-1">
          <div class="col">nom jeux</div>
          <div class="col">JJ/MM/AAAA</div>
        </div>
        <div class="row-1">
          <div class="col">auteur</div>
          <div class="col"><i class="fa-regular fa-comment-dots"></i> 666</div>
        </div>
      </div>
      <div class="col-4">
        <div class="row-10">
          <img src="../assets/valve-software-504f0b01a27a2.webp" alt="">
        </div>
        <div class="row-1">
          <div class="col">nom jeux</div>
          <div class="col">JJ/MM/AAAA</div>
        </div>
        <div class="row-1">
          <div class="col">auteur</div>
          <div class="col"><i class="fa-regular fa-comment-dots"></i> 666</div>
        </div>
      </div>
      <div class="col-4">
        <div class="row-10">
          <img src="../assets/valve-software-504f0b01a27a2.webp" alt="">
        </div>
        <div class="row-1">
          <div class="col">nom jeux</div>
          <div class="col">JJ/MM/AAAA</div>
        </div>
        <div class="row-1">
          <div class="col">auteur</div>
          <div class="col"><i class="fa-regular fa-comment-dots"></i> 666</div>
        </div>
      </div>
    </div>
  </div>
  <div class="container d-none d-lg-block mt-3">
    <div class="row">
      <div class="col-4">
        <div class="row-10">
          <img src="../assets/valve-software-504f0b01a27a2.webp" alt="">
        </div>
        <div class="row-1">
          <div class="col">nom jeux</div>
          <div class="col">JJ/MM/AAAA</div>
        </div>
        <div class="row-1">
          <div class="col">auteur</div>
          <div class="col"><i class="fa-regular fa-comment-dots"></i> 666</div>
        </div>
      </div>
      <div class="col-4">
        <div class="row-10">
          <img src="../assets/valve-software-504f0b01a27a2.webp" alt="">
        </div>
        <div class="row-1">
          <div class="col">nom jeux</div>
          <div class="col">JJ/MM/AAAA</div>
        </div>
        <div class="row-1">
          <div class="col">auteur</div>
          <div class="col"><i class="fa-regular fa-comment-dots"></i> 666</div>
        </div>
      </div>
      <div class="col-4">
        <div class="row-10">
          <img src="../assets/valve-software-504f0b01a27a2.webp" alt="">
        </div>
        <div class="row-1">
          <div class="col">nom jeux</div>
          <div class="col">JJ/MM/AAAA</div>
        </div>
        <div class="row-1">
          <div class="col">auteur</div>
          <div class="col"><i class="fa-regular fa-comment-dots"></i> 666</div>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
/* div {
  border: solid #ffffff 1px;
} */
</style>
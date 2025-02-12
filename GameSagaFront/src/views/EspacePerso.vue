<script setup lang="ts">
import * as AccountService from '@/_services/AccountService';
import { ref, onMounted } from 'vue';


// Définir une interface pour le type User (vous pouvez l'adapter à votre modèle)
interface User {
  pseudo: string;
  email: string;
  // Ajoutez d'autres propriétés si nécessaire
}

// Déclare une variable reactive pour stocker l'utilisateur et l'état de l'erreur
const user = ref<User | null>(null); // Spécification du type User
const error = ref<string | null>(null);

// Fonction pour récupérer l'utilisateur et mettre à jour l'état
const loadUser = async () => {
  error.value = null; // Réinitialise l'erreur à chaque clic
  try {
    // Récupère l'utilisateur via le service AccountService
    const userData = await AccountService.getUser(); // Ajoutez 'await' ici
    console.log(userData); // Vérifiez les données récupérées
    user.value = userData; // Assignez les données à la variable reactive
  } catch (err) {
    // Gère les erreurs, par exemple si l'appel API échoue
    console.error('Erreur lors de la récupération de l\'utilisateur:', err);
    error.value = 'Une erreur est survenue lors de la récupération des données.';
  }
};
onMounted(() => {
  loadUser();
});
</script>
<template>
  <main>
    <div class="form-container my-5 py-5">
    <h2>Espace Perso</h2>
    <img src="../assets/valve-software-504f0b01a27a2.webp" class="vignette text-truncate" alt="">
    <div class="container d-none d-lg-block my-5">
      <div v-if="user">
              <h3>{{ user.pseudo }}</h3>
            </div>
      <div class=" row">
        <div class="col">
          <div class="row">
            <div class="col">
              <div v-if="user">
                <p>{{ user.email }}</p>
              </div>
            </div>
            <div class="col">
              JJ/MM/AAAA
            </div>
            <div class="col">
              <i class="fa-regular fa-newspaper"></i> 666
            </div>
          </div>
          <div class="row pb-3">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Obcaecati tempora beatae similique ab! Temporibus
            similique et distinctio natus beatae alias commodi consectetur atque ex aliquid, earum vitae aliquam rerum
            harum.
          </div>
        </div>
      </div>
    </div>
    <!-- Affichage d'un message d'erreur si une erreur survient -->
    <div v-if="error" class="error-message">
      <p>{{ error }}</p>
    </div>
    <h3>Articles crées</h3>
    <div class=" carte container d-none d-lg-block my-5">
      <div class=" row">
        <div class="col carte py-3 pt-1">
          <img src="../assets/valve-software-504f0b01a27a2.webp" class="vignette text-truncate" alt="">
        </div>
        <div class="col-9">
          <div class="row-2 text-align-start">
            <h4>Titre</h4>
          </div>
          <div class="row">
            <div class="col">
              JJ/MM/AAAA
            </div>
            <div class="col">
              <i class="fa-regular fa-comment-dots"></i> 666
            </div>
          </div>
          <div class="row pb-3">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Obcaecati tempora beatae similique ab! Temporibus
            similique et distinctio natus beatae alias commodi consectetur atque ex aliquid, earum vitae aliquam rerum
            harum.
          </div>
          <div class="row-2">
            <button class="boutonCall">Voir l'article</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  </main>
</template>

<style scoped>
.error-message {
  color: red;
  font-weight: bold;
}
</style>

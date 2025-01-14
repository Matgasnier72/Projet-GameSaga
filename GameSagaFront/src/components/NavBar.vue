<script setup lang="ts">
import * as AccountService from '@/_services/AccountService';
import router from '@/router';
import { ref, onMounted } from 'vue';
import { useUserStore } from '@/stores/User';
import SearchBar from './SearchBar.vue';

interface User {
  pseudo: string;
  // Ajoutez d'autres propriétés si nécessaire
}

const user = ref<User | null>(null); // Spécification du type User
const error = ref<string | null>(null);
const userStore = useUserStore();

async function logout() {
  try {
    await AccountService.logout();
    console.log('Déconnexion réussie');
    router.push('/login'); // Redirige vers la page de connexion après la déconnexion
  } catch (error) {
    console.error('Erreur lors de la déconnexion:', error);
  }
}

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
    console.error("Erreur lors de la récupération de l'utilisateur:", err);
    error.value = 'Une erreur est survenue lors de la récupération des données.';
  }
};
onMounted(() => {
  loadUser();
});
</script>

<template>
  <header>
    <nav class="navbar navbar-expand-lg fixed-top bg-danger">
      <router-link class="col te logo" to="/">
        <img
          src="../../public/chibi_controller.png"
          alt="icone de renard menant à l'accueil"
          class="d-print-grid"
        />
      </router-link>
      <SearchBar class="col-4" />
      <router-link class="col nav-link-custom" to="/Blog">Blog</router-link>
      <router-link class="col nav-link-custom" to="/Contact">Contact</router-link>
      <router-link class="col nav-link-custom" to="/GestionCompte">Gestion des Comptes</router-link>
      <router-link class="col nav-link-custom" to="/Redaction">Rédaction</router-link>
      <router-link class="col nav-link-custom" to="/about">À propos</router-link>
      <router-link
        class="col nav-link-custom"
        to="/Inscription"
        v-if="!userStore.islogged"
        >Inscription</router-link
      >
      <router-link
        class="col nav-link-custom"
        to="/Login"
        v-if="!userStore.islogged"
        >Connexion</router-link
      >
      <router-link
        class="col nav-link-custom"
        to="/EspacePerso"
        v-if="userStore.islogged"
        >Compte</router-link
      >
      <router-link class="col" to="/">
        <button @click="logout" v-if="userStore.islogged">❌</button>
      </router-link>
    </nav>
  </header>
</template>

<style scoped>
/* Styles globaux pour les liens */


/* Navbar */
nav {
  padding: 10px;
  margin-bottom: 20px;
  font-weight: bold;
  background-color: #d60505; /* Rouge */
  color: #ffffff;
  height: 50px;
  display: flex;
  align-items: center;
}

img {
  height: 40px;
}

/* Logo pour ajuster l'espacement */
.logo {
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
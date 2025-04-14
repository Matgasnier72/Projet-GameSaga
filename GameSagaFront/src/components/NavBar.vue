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
      <router-link class="col nav-link-custom" to="/Blog">Articles</router-link>
      <router-link class="col nav-link-custom" to="/GestionCompte">Gestion des Comptes</router-link>

      <router-link class="col nav-link-custom" v-if="userStore.islogged && (userStore.user.role=='ROLE_REDACTEUR' || userStore.user.role=='ROLE_ADMIN')" to="/Redaction">Rédaction</router-link>
      <router-link class="col nav-link-custom" to="/Contact">Contact</router-link>
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
        <div @click="logout" v-if="userStore.islogged"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 224c0 17.7 14.3 32 32 32s32-14.3 32-32l0-224zM143.5 120.6c13.6-11.3 15.4-31.5 4.1-45.1s-31.5-15.4-45.1-4.1C49.7 115.4 16 181.8 16 256c0 132.5 107.5 240 240 240s240-107.5 240-240c0-74.2-33.8-140.6-86.6-184.6c-13.6-11.3-33.8-9.4-45.1 4.1s-9.4 33.8 4.1 45.1c38.9 32.3 63.5 81 63.5 135.4c0 97.2-78.8 176-176 176s-176-78.8-176-176c0-54.4 24.7-103.1 63.5-135.4z"/></svg></div>
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
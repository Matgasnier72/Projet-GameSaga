<script setup lang="ts">
import * as AccountService from '@/_services/AccountService';
import router from '@/router';
import { ref, onMounted,onUnmounted } from 'vue';
import { useUserStore } from '@/stores/User';
import SearchBar from './SearchBar.vue';

interface User {
  pseudo: string;
}

const user = ref<User | null>(null);
const error = ref<string | null>(null);
const userStore = useUserStore();
const navbarCollapse = ref<HTMLElement | null>(null);

onMounted(() => {
  navbarCollapse.value = document.getElementById('navbarContent');
  document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
});
function handleClickOutside(event: MouseEvent) {
  if (navbarCollapse.value && window.innerWidth <= 990) {
    const target = event.target as HTMLElement;
    const isNavbarToggler = target.closest('.navbar-toggler');
    const isNavbarCollapse = target.closest('.navbar-collapse');
    
    if (!isNavbarToggler && !isNavbarCollapse) {
      navbarCollapse.value.classList.remove('show');
    }
  }
}
async function logout() {
  try {
    await AccountService.logout();
    console.log('Déconnexion réussie');
    router.push('/login');
  } catch (error) {
    console.error('Erreur lors de la déconnexion:', error);
  }
}
</script>

<template>
  <header>
    <nav class="navbar navbar-expand-lg fixed-top bg-danger">
      <!-- Burger -->
      <button class="navbar-toggler ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Logo -->
      <div class="navbar-brand mx-auto">
        <router-link to="/">
          <img src="../../public/chibi_controller.png" alt="icone de renard menant à l'accueil" class="d-print-grid" />
        </router-link>
      </div>

      <!-- Menu container -->
      <div class="collapse navbar-collapse" id="navbarContent">
        <div class="navbar-nav me-auto mb-2 mb-lg-0">
          <router-link class="nav-link nav-link-custom" to="/Blog">Articles</router-link>
          <router-link class="nav-link nav-link-custom" to="/GestionCompte"
            v-if="userStore.islogged && userStore.user.role == 'ROLE_ADMIN'">Administration</router-link>
          <router-link class="nav-link nav-link-custom"
            v-if="userStore.islogged && (userStore.user.role == 'ROLE_REDACTEUR' || userStore.user.role == 'ROLE_ADMIN')&& userStore.user.statut != 'banni'"
            to="/Redaction">Rédaction</router-link>
            <router-link class="nav-link nav-link-custom"
            v-if="userStore.islogged && (userStore.user.role == 'ROLE_REDACTEUR' || userStore.user.role == 'ROLE_ADMIN')&& userStore.user.statut != 'banni'"
            to="/AjoutImage">Upload Image</router-link>
          <router-link class="nav-link nav-link-custom" to="/Contact"
            v-if="!(userStore.user.role == 'ROLE_ADMIN')">Contact</router-link>
          <router-link class="nav-link nav-link-custom" to="/about">À propos</router-link>
          <router-link class="nav-link nav-link-custom" to="/EspacePerso" v-if="userStore.islogged">Compte</router-link>
        </div>
      </div>

      <!-- connexion/inscription-->
      <div class="ms-auto d-flex align-items-center">
        <router-link class="nav-link nav-link-custom me-2" to="/Login"
          v-if="!userStore.islogged">Connexion</router-link>
        <router-link class="nav-link me-2" to="/" v-if="userStore.islogged">
          <div @click="logout">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20" fill="currentColor">
              <path
                d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 224c0 17.7 14.3 32 32 32s32-14.3 32-32l0-224zM143.5 120.6c13.6-11.3 15.4-31.5 4.1-45.1s-31.5-15.4-45.1-4.1C49.7 115.4 16 181.8 16 256c0 132.5 107.5 240 240 240s240-107.5 240-240c0-74.2-33.8-140.6-86.6-184.6c-13.6-11.3-33.8-9.4-45.1 4.1s-9.4 33.8 4.1 45.1c38.9 32.3 63.5 81 63.5 135.4c0 97.2-78.8 176-176 176s-176-78.8-176-176c0-54.4 24.7-103.1 63.5-135.4z" />
            </svg>
          </div>
        </router-link>
      </div>
    </nav>
  </header>
</template>

<style scoped>
nav {
  padding: 10px;
  margin-bottom: 20px;
  font-weight: bold;
  background-color: #d60505;
  color: #ffffff;
  height: 60px;
  display: flex;
  align-items: center;
}

img {
  height: 40px;
}

.logo {
  display: flex;
  justify-content: center;
  align-items: center;
}

@media (max-width: 990px) {
  .navbar-collapse {
    background-color: #dc3545;
    padding: 1rem;
    position: fixed;
    top: 60px;
    left: 0;
    bottom: 0;
    width: 250px;
    z-index: 1000;
    transform: translateX(-100%);
    transition: transform 0.3s ease-in-out;
  }

  .navbar-collapse.show {
    transform: translateX(0);
  }

  .nav-link {
    padding: 0.5rem 1rem;
    text-align: left;
    white-space: nowrap;
  }

  .navbar-toggler {
    padding: 0.25rem 0.75rem;
    border: 1px solid white;
    position: absolute;
    left: 10px;
  }

  .navbar-brand {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
  }

  .navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
  }
}

.navbar {
  padding: 0.5rem 1rem;
}

.navbar-brand img {
  height: 40px;
}
</style>
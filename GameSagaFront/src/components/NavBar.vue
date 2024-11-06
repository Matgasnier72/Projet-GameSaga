<script setup lang="ts">
import * as AccountService from '@/_services/AccountService';
import router from '@/router';

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
    <nav>
        <router-link to='/'>Accueil</router-link>
        <router-link to='/Blog'>Blog</router-link>
        <router-link to='/Contact'>Contact</router-link>
        <router-link to='/EspacePerso'>Espace Personnel</router-link>
        <router-link to='/GestionCompte'>Gestion des Comptes</router-link>
        <router-link to='/Recherche'>Recherche</router-link>
        <router-link to='/Redaction'>Redaction</router-link>
        <router-link to='/about'>About</router-link>
        <router-link to='/Inscription'>Inscription</router-link>
        <router-link to='/login'>Connexion</router-link>
        <button @click="logout">Déconnexion</button>
    </nav>
</template>
<!-- <style scoped>
nav {
  padding: 10px;
  margin-bottom: 20px;
  border-radius: 5px;
  font-weight: bold;
  background-color: #721c24;
  color: #000000;
}
</style> -->
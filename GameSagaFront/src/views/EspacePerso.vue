<script setup lang="ts">
import * as AccountService from '@/_services/AccountService';
import { ref, onMounted } from 'vue';


// Définir une interface pour le type User (vous pouvez l'adapter à votre modèle)
interface User {
  pseudo: string;
  email:string;
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
    <h1>Espace Perso</h1>
    <!-- Bouton pour récupérer l'utilisateur -->
    <button class="button" @click="loadUser">Flinguer</button>

    <!-- Affichage du pseudo si l'utilisateur est récupéré -->
    <div v-if="user">
      <p>Nom : {{ user.pseudo }}</p>
      <p>email : {{ user.email }}</p>
    </div>

    <!-- Affichage d'un message d'erreur si une erreur survient -->
    <div v-if="error" class="error-message">
      <p>{{ error }}</p>
    </div>
  </main>
</template>

<style scoped>
.error-message {
  color: red;
  font-weight: bold;
}
</style>

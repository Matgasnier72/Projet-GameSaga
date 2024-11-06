<script setup lang="ts">
import { ref } from 'vue';
import router from '@/router';
import * as AccountService from '@/_services/AccountService';

const user = ref({
  email: '',
  password: ''
});

const errorMessage = ref('');
const errors = ref<any>([]);

async function login() {
  errorMessage.value = '';
  try {
    console.log('Login successful', user.value);
    await AccountService.login(user.value);
    router.push('/');
  } catch (error: any) {
    console.error('Login failed:', error);
    errorMessage.value = 'Échec de la connexion';
  }
}
</script>

<template>
  <div>
    <div v-if="errors.email"  v-for="error in errorMessage.email" ></div>
    <div v-if="errorMessage" class="alert error">
      {{ errorMessage }}
    </div>
    <form @submit.prevent="login">
      <h2 class="form-title">Connexion</h2>
      <div class="form-group">
        <label for="user_email">Email</label>
        <input type="text" id="user_email" required v-model="user.email" />
      </div>
      <div class="form-group">
        <label for="user_password">Mot de passe</label>
        <input type="text" id="user_password" required v-model="user.password" />
      </div>
      <div class="form-group">
        <button type="submit" class="button">Connexion</button>
      </div>
    </form>
  </div>
</template>
<style scoped>
/* Styles pour les messages d'erreur et de succès */
.alert {
  padding: 10px;
  margin-bottom: 20px;
  border-radius: 5px;
  font-weight: bold;
}

.success {
  background-color: #d4edda;
  color: #155724;
}

.error {
  background-color: #f8d7da;
  color: #721c24;
}
</style>
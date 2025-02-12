<script setup lang="ts">
import { ref } from 'vue';
import router from '@/router';
import * as AccountService from '@/_services/AccountService';

const user = ref({
  email: '',
  password: ''
});

const errorMessage = ref<any>({});
const errors = ref<any>([]);

async function login() {
  errorMessage.value = '';
  try {
    await AccountService.login(user.value);
    router.push('/');
    console.log('Login successful', user.value);
  } catch (error: any) {
    console.error('Login failed:', error);

    if (error.response && error.response.status === 429) {
      errorMessage.value = {
        general: 'Trop de tentatives, veuillez réessayer ultérieurement.'
      };
    } else {
      errorMessage.value = error.response.data.errors;
    }
  }
}
const showPassword = ref(false);
function togglePasswordVisibility() {
  showPassword.value = !showPassword.value;
}
</script>

<template>
  <div class="form-container my-5 py-5">
    <form @submit.prevent="login">
      <h2 class="form-title">Connexion</h2>

      <div v-if="errorMessage.general" class="error-message general-error">{{ errorMessage.general }}</div>

      <div class="form-group">
        <label for="user_email">Email</label>
        <br>
        <input type="text" id="user_email" v-model="user.email" class="input-field" />
        <div v-if="errorMessage.email" class="error-message" v-for="error in errorMessage.email" :key="error">{{ error
          }}</div>
      </div>

      <div class="form-group">
        <label for="user_password">Mot de passe</label>
        <div class="password-wrapper">
          <input :type="showPassword ? 'text' : 'password'" id="user_password" v-model="user.password"
            class="input-field" />
          <button type="button" class="toggle-password" @click="togglePasswordVisibility">
            <!-- Icône œil ouverte/fermée -->
            <span v-if="showPassword">👁️</span>
            <span v-else>👁️‍🗨️</span>
          </button>
        </div>
        <div v-if="errorMessage.password" class="error-message" v-for="error in errorMessage.password" :key="error">{{
          error }}</div>
      </div>

      <div v-if="errorMessage.credentials" class="error-message" v-for="error in errorMessage.credentials" :key="error">
        {{ error }}</div>

      <div class="form-group">
        <button type="submit" class="boutonCall">Connexion</button>
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
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
  <main>
    <div class="login-container">
      <h2 class="text-center">Connexion</h2>
      <form @submit.prevent="login" class="login-form">
        <div v-if="errorMessage.general" class="error-message general-error">
          {{ errorMessage.general }}
        </div>

        <div class="form-group">
          <label for="user_email">Email</label>
          <input 
            type="text" 
            id="user_email" 
            v-model="user.email" 
            placeholder="Votre email"
            class="input-field" 
            required
          />
          <div v-if="errorMessage.email" class="error-message" v-for="error in errorMessage.email" :key="error">
            {{ error }}
          </div>
        </div>

        <div class="form-group">
          <label for="user_password">Mot de passe</label>
          <div class="password-wrapper">
            <input 
              :type="showPassword ? 'text' : 'password'" 
              id="user_password" 
              v-model="user.password"
              placeholder="Votre mot de passe"
              class="input-field" 
              required
            />
            <button type="button" class="toggle-password" @click="togglePasswordVisibility">
              <span v-if="showPassword">👁️</span>
              <span v-else>👁️‍🗨️</span>
            </button>
          </div>
          <div v-if="errorMessage.password" class="error-message" v-for="error in errorMessage.password" :key="error">
            {{ error }}
          </div>
        </div>

        <div v-if="errorMessage.credentials" class="error-message credentials-error" v-for="error in errorMessage.credentials" :key="error">
          {{ error }}
        </div>

        <div class="form-actions">
          <button type="submit" class="boutonCall">Connexion</button>
        </div>
      </form>
    </div>
  </main>
</template>

<style scoped>
.login-container {
  width: 100%;
  max-width: 600px;
  margin: 0 auto;
  padding: 1rem;
}

h2 {
  margin-top: 5rem;
  margin-bottom: 2rem;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  color: #f8f8f8;
  font-size: 1.1rem;
}

.password-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}

.input-field {
  width: 100%;
  padding: 1rem;
  font-size: 1.1rem;
  background-color: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 4px;
  color: #fff;
}

.input-field:focus {
  outline: none;
  border-color: #d60505;
  background-color: rgba(255, 255, 255, 0.15);
}

.toggle-password {
  position: absolute;
  right: 10px;
  background: none;
  border: none;
  color: #f8f8f8;
  cursor: pointer;
  padding: 5px;
}

.form-actions {
  display: flex;
  justify-content: center;
  margin-top: 2rem;
}

.error-message {
  color: #dc3545;
  font-size: 0.9rem;
  margin-top: 0.5rem;
  text-align: center;
}

.general-error, .credentials-error {
  background-color: rgba(220, 53, 69, 0.1);
  border: 1px solid #dc3545;
  padding: 0.75rem;
  border-radius: 4px;
  margin-bottom: 1rem;
}

/* Responsive Design */
@media (max-width: 768px) {
  .login-container {
    width: 95%;
    padding: 1rem;
  }

  .input-field {
    font-size: 1rem;
    padding: 0.8rem;
  }

  h2 {
    font-size: 1.5rem;
  }
}

@media (max-width: 480px) {
  .login-container {
    width: 98%;
    padding: 0.5rem;
  }

  .input-field {
    padding: 0.7rem;
  }

  .form-group label {
    font-size: 1rem;
  }
}
</style>
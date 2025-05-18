<script setup lang="ts">
import { ref } from 'vue';
import router from '@/router';
import * as AccountService from '@/_services/AccountService';

const form = ref({
  email: '',
  password: '',
  pseudo: '',
  password_confirmation: ''
});

const errorMessage = ref<any>({});
const errors = ref<any>([]);
const acceptPolicy = ref(false);

async function Register() {
  errorMessage.value = '';
  try {
    await AccountService.register(form.value);
    router.push('/');
    console.log('Register successful', form.value);
  } catch (error: any) {
    console.error('Register failed:', error);
    errorMessage.value = error.response.data.errors;
  }

}
const showPassword = ref(false);
function togglePasswordVisibility() {
  showPassword.value = !showPassword.value;
}
</script>

<template>
  <main>
    <div class="register-container">
      <h2 class="text-center">Inscription</h2>
      <form @submit.prevent="Register" class="register-form">
        <div v-if="errorMessage.general" class="error-message general-error">
          {{ errorMessage.general }}
        </div>
        <div class="form-group commentary">
          Ce site est un projet pour une alternance,
          <br> donc à ne pas prendre au sérieux.
          <br> Merci de votre compréhension.
          <br> Si vous ne voulez pas mettre votre vrai email, il existe les <a href="https://proton.me/fr/pass" class="text-danger"> alias de Proton Pass</a>
        </div>
        <div class="form-group">
          <label for="form_email">Email</label>
          <input type="email" id="form_email" v-model="form.email" placeholder="Votre email" class="input-field"
            required />
          <div v-if="errorMessage.email" class="error-message" v-for="error in errorMessage.email" :key="error">
            {{ error }}
          </div>
        </div>
        <div class="form-group">
          <label for="form_pseudo">Nom</label>
          <input type="text" id="form_pseudo" v-model="form.pseudo" placeholder="Votre nom" class="input-field"
            required />
          <div v-if="errorMessage.pseudo" class="error-message" v-for="error in errorMessage.pseudo" :key="error">
            {{ error }}
          </div>
        </div>

        <div class="form-group">
          <label for="form_pseudo">Pseudo</label>
          <input type="text" id="form_pseudo" v-model="form.pseudo" placeholder="Votre pseudo" class="input-field"
            required />
          <div v-if="errorMessage.pseudo" class="error-message" v-for="error in errorMessage.pseudo" :key="error">
            {{ error }}
          </div>
        </div>

        <div class="form-group">
          <label for="form_password">Mot de passe</label>
          <div class="password-wrapper">
            <input :type="showPassword ? 'text' : 'password'" id="form_password" v-model="form.password"
              placeholder="Votre mot de passe" class="input-field" required />
            <button type="button" class="toggle-password" @click="togglePasswordVisibility">
              <span v-if="showPassword">👁️</span>
              <span v-else>👁️‍🗨️</span>
            </button>
          </div>
          <div v-if="errorMessage.password" class="error-message" v-for="error in errorMessage.password" :key="error">
            {{ error }}
          </div>
        </div>

        <div class="form-group">
          <label for="password_confirmation">Confirmation du mot de passe</label>
          <div class="password-wrapper">
            <input :type="showPassword ? 'text' : 'password'" id="password_confirmation"
              v-model="form.password_confirmation" placeholder="Confirmez votre mot de passe" class="input-field"
              required />
            <button type="button" class="toggle-password" @click="togglePasswordVisibility">
              <span v-if="showPassword">👁️</span>
              <span v-else>👁️‍🗨️</span>
            </button>
          </div>
        </div>

        <div v-if="errorMessage.credentials" class="error-message credentials-error"
          v-for="error in errorMessage.credentials" :key="error">
          {{ error }}
        </div>

        <div class="form-group checkbox-wrapper">
          <label class="checkbox-label">
            <input type="checkbox" v-model="acceptPolicy" required class="checkbox-input">
            J'accepte la <router-link to="/Politique" class="policy-link">politique de confidentialité</router-link>
          </label>
        </div>

        <div class="form-actions">
          <button type="submit" class="boutonCall">S'inscrire</button>
        </div>
      </form>
    </div>
  </main>
</template>

<style scoped>
.register-container {
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

.general-error,
.credentials-error {
  background-color: rgba(220, 53, 69, 0.1);
  border: 1px solid #dc3545;
  padding: 0.75rem;
  border-radius: 4px;
  margin-bottom: 1rem;
}

.checkbox-wrapper {
  margin: 1.5rem 0;
  display: flex;
  justify-content: center;
}

.checkbox-label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
  color: #f8f8f8;
  font-size: 1rem;
}

.checkbox-input {
  width: 18px;
  height: 18px;
  cursor: pointer;
  accent-color: #d60505;
}

.policy-link {
  color: #d60505;
  text-decoration: none;
  transition: all 0.3s ease;
}

.policy-link:hover {
  text-decoration: underline;
  color: #ff0000;
}

@media (max-width: 768px) {
  .register-container {
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
  .register-container {
    width: 98%;
    padding: 0.5rem;
  }

  .input-field {
    padding: 0.7rem;
  }

  .form-group label {
    font-size: 1rem;
  }

  .checkbox-label {
    font-size: 0.9rem;
  }
}
</style>
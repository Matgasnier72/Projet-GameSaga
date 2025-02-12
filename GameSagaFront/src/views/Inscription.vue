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
    <div class="form-container my-5 py-5">
        <form @submit.prevent="Register">
            <h2 class="form-title">Inscription</h2>

            <div v-if="errorMessage.general" class="error-message general-error">{{ errorMessage.general }}</div>

            <div class="form-group">
                <label for="form_email">Email</label>
                <br>
                <input type="text" id="form_email" v-model="form.email" class="input-field" />
                <div v-if="errorMessage.email" class="error-message" v-for="error in errorMessage.email" :key="error">{{
                    error }}</div>
            </div>

            <div class="form-group">
                <label for="form_pseudo">Pseudo</label>
                <br>
                <input type="text" id="form_pseudo" v-model="form.pseudo" class="input-field" />
                <div v-if="errorMessage.pseudo" class="error-message" v-for="error in errorMessage.Pseudo" :key="error">
                    {{ error }}</div>
            </div>

            <div class="form-group">
                <label for="form_password">Mot de passe</label>
                <div class="password-wrapper">
                    <input :type="showPassword ? 'text' : 'password'" id="form_password" v-model="form.password"
                        class="input-field" />
                    <button type="button" class="toggle-password" @click="togglePasswordVisibility">
                        <!-- Icône œil ouverte/fermée -->
                        <span v-if="showPassword">👁️</span>
                        <span v-else>👁️‍🗨️</span>
                    </button>
                </div>
                <div v-if="errorMessage.password" class="error-message" v-for="error in errorMessage.password"
                    :key="error">{{ error }}</div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmation du Mot de passe</label>
                <div class="password-wrapper">
                    <input :type="showPassword ? 'text' : 'password'" id="password_confirmation"
                        v-model="form.password_confirmation" class="input-field" />
                    <button type="button" class="toggle-password" @click="togglePasswordVisibility">
                        <!-- Icône œil ouverte/fermée -->
                        <span v-if="showPassword">👁️</span>
                        <span v-else>👁️‍🗨️</span>
                    </button>
                </div>
                <div v-if="errorMessage.password" class="error-message" v-for="error in errorMessage.password"
                    :key="error">{{ error }}</div>
            </div>

            <div v-if="errorMessage.credentials" class="error-message" v-for="error in errorMessage.credentials"
                :key="error">{{ error }}</div>

            <div class="form-group">
                <button type="submit" class="boutonCall mt-5">Inscription</button>
            </div>
        </form>
    </div>
</template>
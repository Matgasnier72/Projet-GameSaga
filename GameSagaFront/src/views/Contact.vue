<script setup lang="ts">
import { ref } from 'vue'

const objet = ref('')
const contenu = ref('')

const handleSubmit = () => {
  console.log('Form submitted:', { objet: objet.value, contenu: contenu.value })
}
</script>

<template>
  <main>
    <div class="contact-container">
      <h2 class="text-center">Contact</h2>
      <form @submit.prevent="handleSubmit" class="contact-form">
        <div class="form-group">
          <label for="objet">Objet</label>
          <input 
            type="text"
            id="objet"
            v-model="objet"
            placeholder="Objet de votre message"
            required
          >
        </div>

        <div class="form-group">
          <label for="contenu">Contenu</label>
          <textarea
            id="contenu"
            v-model="contenu"
            placeholder="Préciser le contenu de votre demande"
            required
          ></textarea>
        </div>

        <div class="form-actions">
          <button type="submit" class="boutonCall">Envoyer</button>
        </div>
      </form>
      <p class="contact-alternative">
        Remplissez le formulaire ci-dessous ou contactez-moi à 
        <a href="mailto:gamesagacontact.twelve017@passinbox.com" class="email-link">
          gamesagacontact.twelve017@passinbox.com
        </a>
      </p>
    </div>
  </main>
</template>

<style scoped>
h2 {
  margin-top: 5rem;
  margin-bottom: 2rem;
}

.contact-container {
  width: 100%;
  max-width: 800px;
  margin: 0 auto;
  padding: 1rem;
}
.contact-alternative {
  text-align: center;
  margin-bottom: 2rem;
  color: #fff;
  line-height: 1.6;
}

.email-link {
  color: #dc3545;
  text-decoration: none;
  transition: all 0.3s ease;
  border-bottom: 1px solid transparent;
}

.email-link:hover {
  color: #ff4757;
  border-bottom-color: #ff4757;
}
.form-group input,
.form-group textarea {
  width: 100%;
  padding: 1rem;
  font-size: 1.1rem;
  background-color: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 4px;
  color: #fff;
}

.form-group textarea {
  min-height: 200px;
  resize: vertical;
}

.form-group input:focus,
.form-group textarea:focus {
  outline: none;
  border-color: #d60505;
  background-color: rgba(255, 255, 255, 0.15);
}

/* Ajustez les media queries existantes */
@media (max-width: 768px) {
  .contact-container {
    padding-left: 1rem;
    padding-right: 1rem;
    margin: 1rem auto;
    width: 95%;
  }

  .form-group input,
  .form-group textarea {
    font-size: 1rem;
    padding: 0.8rem;
  }
  .contact-alternative {
    font-size: 0.9rem;
    padding: 0 1rem;
  }
}

@media (max-width: 480px) {
  .contact-container {
    padding: 0.5rem;
    width: 98%;
  }

  .form-group input,
  .form-group textarea {
    padding: 0.7rem;
  }
  .contact-alternative {
    font-size: 0.85rem;
    padding: 0 0.5rem;
  }
}
</style>
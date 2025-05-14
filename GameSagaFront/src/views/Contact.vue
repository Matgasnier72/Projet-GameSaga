<script setup lang="ts">
</script>

<template>
  <main>
    <div class="form-container my-5 py-5">
      <h2>Contact</h2>
      <div class="form-container my-5 py-5">
        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Objet</label>
          <br>
          <input type="email"class="mx-3 px-2" id="exampleFormControlInput1" placeholder="Objet">
        </div>
        <div class="form-floating">
          <label for="floatingTextarea2">Contenu</label>
          <br>
          <textarea placeholder="Préciser le contenu de votre demande" id="floatingTextarea2"
            style="height: 100px"></textarea>
        </div>
        <button type="submit" class="boutonCall m-5">Envoyer</button>
      </div>
    </div>
  </main>
</template>
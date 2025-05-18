<script setup lang="ts">
</script>

<template>
  <footer class="footer">
    <nav class="zinzin navbar-expand-lg d-flex justify-content-center gap-4 py-3">
      <router-link to="/Contact" class="nav-link nav-link-custom">Contact</router-link>
      <router-link to="/Mention" class="nav-link nav-link-custom">Mention légales</router-link>
      <router-link to="/Politique" class="nav-link nav-link-custom">Politique de confidentialité</router-link>
    </nav>
  </footer>
</template>

<style scoped>
.footer {
  position: relative;
  width: 100%;
  margin-top: auto;
  z-index: 100;
}

.zinzin {
  background-color: rgb(28, 28, 28);
  width: 100%;
}
</style>
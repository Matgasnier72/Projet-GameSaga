<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import NavBar from './components/NavBar.vue'
import Foot from './components/Footer.vue'
</script>

<template>

  <NavBar/>
  <RouterView />
  <Foot />
</template>

<style scoped>
header {
  line-height: 1.5;
  max-height: 100vh;
}
</style>
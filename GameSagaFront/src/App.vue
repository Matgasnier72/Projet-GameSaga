<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import NavBar from './components/NavBar.vue'
import Foot from './components/Footer.vue'
</script>

<template>
  <main>
    <NavBar />
    <RouterView />
    <Foot />
  </main>
</template>
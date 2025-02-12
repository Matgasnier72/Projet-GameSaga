import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import AboutView from '@/views/AboutView.vue'
import Article from '@/views/Article.vue'
import Blog from '@/views/Articles.vue'
import Connexion from '@/views/Login.vue'
import Contact from '@/views/Contact.vue'
import EspacePerso from '@/views/EspacePerso.vue'
import GestionCompte from '@/views/GestionCompte.vue'
import Inscription from '@/views/Inscription.vue'
import Recherche from '@/views/Recherche.vue'
import Redaction from '@/views/Redaction.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Home',
      component: HomeView
    },
    {
      path: '/Article',
      name: 'Article',
      component: Article
    },
    {
      path: '/Blog',
      name: 'Blog',
      component: Blog
    },
    {
      path: '/login',
      name: 'Connexion',
      component: Connexion
    },
    {
      path: '/Contact',
      name: 'Contact',
      component: Contact
    },
    {
      path: '/EspacePerso',
      name: 'EspacePerso',
      component: EspacePerso
    },
    {
      path: '/GestionCompte',
      name: 'GestionCompte',
      component: GestionCompte
    },
    {
      path: '/Inscription',
      name: 'Inscription',
      component: Inscription
    },
    {
      path: '/Recherche',
      name: 'Recherche',
      component: Recherche
    },
    {
      path: '/Redaction',
      name: 'Redaction',
      component: Redaction
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: AboutView
    }
  ]
})

export default router
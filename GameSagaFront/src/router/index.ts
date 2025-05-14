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
import Redaction from '@/views/Redaction.vue'
import AjoutImage from '@/views/AjoutImage.vue'
import Verification from '@/views/Verification.vue'
import { useUserStore } from '@/stores/User'
import * as AccountService from '@/_services/AccountService'
import { role } from '@/_models/Enums'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Home',
      component: HomeView
    },
    {
      path: '/Article/:id',
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
      meta: {'roles':[ 'ROLE_ADMIN'],'islogged':true},
      component: GestionCompte
    },
    {
      path: '/Inscription',
      name: 'Inscription',
      component: Inscription
    },
    {
      path: '/Redaction',
      name: 'Redaction',
      meta: {'roles':[ 'ROLE_ADMIN', 'ROLE_REDACTEUR'],'islogged':true},
      component: Redaction
    },
    {
      path: '/AjoutImage',
      name: 'AjoutImage',
      meta: {'roles':[ 'ROLE_ADMIN', 'ROLE_REDACTEUR'],'islogged':true},
      component: AjoutImage
    },
    {
      path: '/about',
      name: 'about',
      // roue level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: AboutView
    },
    {
      path: '/verification',
      name: 'verification',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: Verification
    }/* ,
    {
      path: '/edition/:id',
      name: 'edition',
      component: Edition
    } */
  ]
})

declare module 'vue-router' {
  interface RouteMeta {
    roles?: string[]
    islogged?: boolean
  }
}

router.beforeResolve(async(to, from, next) => {
  const userStore = useUserStore();

  try {
    const res = await AccountService.getUser();
    userStore.setUser(res);
  } catch(err) {
    userStore.clearUser();
    console.log(err);
  }
  

  if (!userStore.islogged && to.meta.islogged && to.name !== 'Login') {
    return next({ name: 'Connexion'});
  }

  if (userStore.islogged && to.meta.roles && to.name !== 'Login') {
    for(let i= 0; i < to.meta.roles.length; i++){
      if(userStore.user.role == to.meta.roles[i]){
        return next();
      }
    }
    return next({ name: 'Connexion'});
  }
  return next();
})
export default router
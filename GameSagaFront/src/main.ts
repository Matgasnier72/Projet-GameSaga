import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

import { createI18n} from 'vue-i18n';
//import fr from './_locales/fr.json';
//import en from './_locales/en.json';

/*const i128n = createI18n({
    locales: 'fr',
    fallbacklocale: fr,
    messages: {fr,en}
});*/

const app = createApp(App)
/*app.use(Antd);
app.use(i18n);*/
app.use(createPinia());
app.use(router);
app.mount('#app');

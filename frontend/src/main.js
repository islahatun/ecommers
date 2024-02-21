/**
 * main.js
 *
 * Bootstraps Vuetify and other plugins then mounts the App`
 */

// Components
import App from './App.vue'

// Composables
import {
  createApp
} from 'vue'

// Plugins
import {
  registerPlugins
} from '@/plugins'

// Di dalam komponen Vue Anda
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

// multi languagge (Internationalization (i18n))
import i18n from './lang'


const app = createApp(App)
app.use(i18n);
app.use(VueSweetalert2);
registerPlugins(app)

app.mount('#app')

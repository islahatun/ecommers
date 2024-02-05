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

// multi languagge (Internationalization (i18n))
import i18n from './lang'


const app = createApp(App)
app.use(i18n);
registerPlugins(app)

app.mount('#app')

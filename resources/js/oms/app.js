import axios from 'axios'

window.axios = axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.withCredentials = true

import { createApp } from 'vue'
import App from './App.vue'
import ElementPlus from 'element-plus'
import router from './router'

import uiButton from '../ui/buttom/button.vue'

const components = {
  uiButton,
}

const app = createApp(App)
app.config.globalProperties.trans = trans

for (let name in components) {
  app.component(name, components[name])
}

app.
  use(ElementPlus).
  use(router).
  mount('#app')
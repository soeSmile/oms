import axios from 'axios'

window.axios = axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.withCredentials = true

import { createApp } from 'vue'
import App from './App.vue'
import ElementPlus from 'element-plus'
import ui from '../ui'
import router from './router'
import store from './store'

const app = createApp(App)

app.
  use(ElementPlus).
  use(router).
  use(store).
  use(ui).
  mount('#app')
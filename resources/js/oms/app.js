import axios from 'axios'

window.axios = axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.withCredentials = true

import { createApp } from 'vue'
import App from './App.vue'
import ElementPlus from 'element-plus'
import ru from 'element-plus/es/locale/lang/ru'
import router from './router'

const app = createApp(App)
app.config.globalProperties.trans = trans

app.
  use(ElementPlus, { locale: ru }).
  use(router).
  mount('#app')
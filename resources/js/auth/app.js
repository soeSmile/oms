import axios from 'axios'

window.axios = axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

import { createApp } from 'vue'
import App from './App.vue'
import ElementPlus from 'element-plus'
import ru from 'element-plus/es/locale/lang/ru'

createApp(App).
  use(ElementPlus, { locale: ru }).
  mount('#app')
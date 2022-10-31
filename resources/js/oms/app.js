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
import middlewarePipeline from './middlewarePipeline'

/**
 * use middleware
 */
router.beforeEach(async (to, from, next) => {
  if (!to.meta.middleware) {
    return next()
  }

  const middleware = to.meta.middleware
  const context = { to, from, next, store }

  return middleware[0]({
    ...context,
    next: middlewarePipeline(context, middleware, 1),
  })
})

const app = createApp(App)

app.config.globalProperties.user = user

app.
  use(ElementPlus).
  use(router).
  use(store).
  use(ui).
  mount('#app')
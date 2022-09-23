import { createWebHistory, createRouter } from 'vue-router'
import App from './App.vue'

const routers = [
  {
    path: '/oms',
    component: App,
    name: 'App',
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes: routers,
  linkActiveClass: 'active-route-link',
  linkExactActiveClass: 'exact-active-route-link',
})

export default router
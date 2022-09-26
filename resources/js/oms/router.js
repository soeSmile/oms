import { createWebHistory, createRouter } from 'vue-router'
import Error404 from '../Error404.vue'
import omsIndex from './pages/omsIndex.vue'
import omsOfferList from './pages/offer/omsOfferList.vue'

const routers = [
  {
    path: '/oms/:pathMatch(.*)*',
    component: Error404,
    name: '404',
  },
  {
    path: '/oms',
    component: omsIndex,
    name: 'App',
  },
  {
    path: '/oms/offer',
    component: omsOfferList,
    name: 'omsOfferList',
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes: routers,
  linkActiveClass: 'active-route-link',
  linkExactActiveClass: 'exact-active-route-link',
})

export default router
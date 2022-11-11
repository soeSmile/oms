import { createWebHistory, createRouter } from 'vue-router'
import system from './routers/system'
import directories from './routers/directories'
import Error404 from '../Error404.vue'
import omsIndex from './pages/index.vue'
import offerIndex from './pages/offer/offerIndex.vue'

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
    path: '/offer',
    component: offerIndex,
    name: 'offerIndex',
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes: [
    ...routers,
    ...system,
    ...directories,
  ],
  linkActiveClass: 'active-route-link',
  linkExactActiveClass: 'exact-active-route-link',
})

export default router
import { createWebHistory, createRouter } from 'vue-router'
import Error404 from '../Error404.vue'
import omsIndex from './pages/index.vue'
import goodIndex from './pages/good/goodIndex.vue'
import goodPage from './pages/good/goodPage.vue'
import brandIndex from './pages/brand/brandIndex.vue'
import categoryIndex from './pages/category/categoryIndex.vue'
import supplierIndex from './pages/suppliers/supplierIndex.vue'
import userIndex from './pages/users/userIndex.vue'
import userPage from './pages/users/userPage.vue'
import isAdmin from './middleware/isAdmin'
import isManager from './middleware/isManager'
import eventIndex from './pages/event/eventIndex.vue'

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
    path: '/oms/category',
    component: categoryIndex,
    name: 'categoryIndex',
  },
  {
    path: '/oms/good',
    component: goodIndex,
    name: 'goodIndex',
  },
  {
    path: '/oms/good/:id',
    component: goodPage,
    name: 'goodPage',
  },
  {
    path: '/oms/brand',
    component: brandIndex,
    name: 'brandIndex',
  },
  {
    path: '/oms/supplier',
    component: supplierIndex,
    name: 'supplierIndex',
  },
  {
    path: '/oms/user',
    component: userIndex,
    name: 'userIndex',
    meta: {
      middleware: [isAdmin],
    },
  },
  {
    path: '/oms/user/:id',
    component: userPage,
    name: 'userPage',
    meta: {
      middleware: [isAdmin],
    },
  },
  {
    path: '/oms/event',
    component: eventIndex,
    name: 'eventIndex',
    meta: {
      middleware: [isAdmin],
    },
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes: routers,
  linkActiveClass: 'active-route-link',
  linkExactActiveClass: 'exact-active-route-link',
})

export default router
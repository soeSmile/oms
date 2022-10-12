import { createWebHistory, createRouter } from 'vue-router'
import Error404 from '../Error404.vue'
import omsIndex from './pages/index.vue'
import goodIndex from './pages/good/goodIndex.vue'
import brandIndex from './pages/brand/brandIndex.vue'
import categoryIndex from './pages/category/categoryIndex.vue'
import categoryPage from './pages/category/categoryPage.vue'

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
    path: '/oms/category/:id',
    component: categoryPage,
    name: 'categoryPage',
  },
  {
    path: '/oms/good',
    component: goodIndex,
    name: 'goodIndex',
  },
  {
    path: '/oms/brand',
    component: brandIndex,
    name: 'brandIndex',
  },

]

const router = createRouter({
  history: createWebHistory(),
  routes: routers,
  linkActiveClass: 'active-route-link',
  linkExactActiveClass: 'exact-active-route-link',
})

export default router
import categoryIndex from '../pages/category/categoryIndex.vue'
import productIndex from '../pages/product/productIndex.vue'
import productPage from '../pages/product/productPage.vue'
import brandIndex from '../pages/brand/brandIndex.vue'
import supplierIndex from '../pages/suppliers/supplierIndex.vue'

const directories = [
  {
    path: '/oms/category',
    component: categoryIndex,
    name: 'categoryIndex',
  },
  {
    path: '/oms/product',
    component: productIndex,
    name: 'productIndex',
  },
  {
    path: '/oms/product/:id',
    component: productPage,
    name: 'productPage',
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
]

export default directories
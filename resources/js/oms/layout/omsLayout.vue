<template>
  <div class="sp-main" :class="{ 'close': close }">

    <div class="sp-menu" :class="{ 'close': close }">

      <div class="head" :class="{ 'close': close }">
        <div class="logo">
          <img src="/img/logo.png" alt="">
        </div>
        <i class='bx bx-menu sp-fnt size-4 sp-link sp-p-2'
           @click="close = !close"/>
      </div>

      <div class="content">
        <menu-item v-for="val in menu"
                   :menu="val.menu"
                   :item="val"
                   :depth="0"
                   :close="close"/>
      </div>
    </div>

    <router-view/>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import MenuItem from './menuItem.vue'

const close = ref(false)
const route = useRoute()
const menu = ref([
  { name: 'Home', icon: 'bxs-home', link: '/oms', role: [] },
  { name: 'Offer', icon: 'bxs-offer', link: '/offer', role: [] },
  {
    name: 'Directories', icon: 'bxs-grid', link: null, role: [],
    menu: [
      { name: 'Categories', icon: 'bx-category', link: '/oms/category', role: [] },
      { name: 'Products', icon: 'bxs-store', link: '/oms/product', role: [] },
      { name: 'Brands', icon: 'bxs-label', link: '/oms/brand', role: [] },
      { name: 'Suppliers', icon: 'bxs-user-detail', link: '/oms/supplier', role: [] },
    ],
  },
  {
    name: 'System', icon: 'bx-cog', link: null, role: [1],
    menu: [
      {
        name: 'System', icon: 'bx-cog', link: null, role: [1],
        menu: [
          { name: 'Users', icon: 'bxs-group', link: '/oms/user', role: [1] },
        ],
      },
      { name: 'Users', icon: 'bxs-group', link: '/oms/user', role: [1] },
      { name: 'Events', icon: 'bx bx-history', link: '/oms/event', role: [1] },
    ],
  },
])

const checkRole = (item) => {
  if (item.role.length > 0) {
    return item.role.includes(user.role)
  }

  return true
}
</script>
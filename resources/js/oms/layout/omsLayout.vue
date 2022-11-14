<template>
  <div class="sp-main" :class="{ 'close': close }">

    <div class="sp-menu" :class="{ 'close': close }">

      <div class="head" :class="{ 'close': close }">
        <div class="logo">
          <img src="/img/logo.png" alt="">
        </div>
        <i class='bx bx-menu sp-fnt size-4 sp-link sp-p-2'
           @click="closeMenu"/>
      </div>

      <div class="content">
        <menu-item v-for="val in menus"
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
import { computed, provide, ref } from 'vue'
import { useRoute } from 'vue-router'
import MenuItem from './menuItem.vue'

const close = ref(false)
const route = useRoute()
const menus = ref([
  { name: 'Home', icon: 'bxs-home', link: '/oms' },
  { name: 'Offer', icon: 'bxs-offer', link: '/offer' },
  {
    name: 'Directories', icon: 'bxs-grid', link: null, show: false,
    menu: [
      { name: 'Categories', icon: 'bx-category', link: '/oms/category' },
      { name: 'Products', icon: 'bxs-store', link: '/oms/product' },
      { name: 'Brands', icon: 'bxs-label', link: '/oms/brand' },
      { name: 'Suppliers', icon: 'bxs-user-detail', link: '/oms/supplier' },
    ],
  },
  {
    name: 'System', icon: 'bx-cog', link: null, show: false, role: [1],
    menu: [
      {
        name: 'System', icon: 'bx-cog', link: null, show: false, role: [1],
        menu: [
          { name: 'Users', icon: 'bxs-group', link: '/oms/user', role: [1] },
        ],
      },
      { name: 'Users', icon: 'bxs-group', link: '/oms/user', role: [1] },
      { name: 'Events', icon: 'bx bx-history', link: '/oms/event', role: [1] },
    ],
  },
])

const closeMenu = () => {
  close.value = !close.value
  hideRootSub()
}

const hideRootSub = () => {
  menus.value.forEach((e) => {
    e.show = false
  })
}

provide('hideRootSub', (depth) => {
  if (close.value && depth === 0) {
    hideRootSub()
  }
})
</script>
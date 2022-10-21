<template>
  <div class="sp-main" :class="close">
    <div class="sp-menu" :class="close">

      <div class="head" :class="close">
        <div class="logo">
          <div class="title">OMS</div>
        </div>
        <i class='bx bx-menu sp-fnt size-4 sp-link sp-p-2'
           @click="menuHideShow"/>
      </div>

      <div class="content">
        <ul class="links">
          <li v-for="(val,idx) in menu" :title="val.name">
            <router-link class="link"
                         :class="close + ' ' + activeChildMenu(val.name)"
                         @click="closeSubMenu"
                         v-if="val.link"
                         :to="val.link">
              <i class="icon bx" :class="val.icon + ' ' + close"/>
              <span class="title" :class="close">
                {{ val.name }}
              </span>
            </router-link>

            <div class="link"
                 :class="close"
                 @click="subShow(idx)"
                 v-else>
              <i class="icon bx" :class="val.icon + ' ' + close"/>
              <span class="title" :class="close">
                {{ val.name }}
              </span>
              <i v-if="val.show" class='sub-link bx bx-chevron-up' :class="close"/>
              <i v-else class='sub-link bx bx-chevron-down' :class="close"/>
            </div>

            <ul class="sub" :class="(val.show ? 'show' : '') + ' ' + close"
                v-if="val.menu">
              <li v-for="sub in val.menu" :title="sub.name">
                <router-link class="link"
                             :class="activeChildMenu(sub.name)"
                             @click="closeSubMenu"
                             :to="sub.link">
                  <i class="icon bx" :class="sub.icon"/>
                  <span class="title">
                    {{ sub.name }}
                  </span>
                </router-link>
              </li>
            </ul>

          </li>
        </ul>
      </div>
    </div>

    <router-view/>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'

const close = ref(null)
const route = useRoute()
const menu = ref([
  {
    name: 'Home', icon: 'bxs-home', link: '/oms',
    show: false, menu: null,
  },
  {
    name: 'Directories', icon: 'bxs-grid', link: null,
    show: false,
    menu: [
      { name: 'Categories', icon: 'bx-category', link: '/oms/category' },
      { name: 'Goods', icon: 'bxs-store', link: '/oms/good' },
      { name: 'Brands', icon: 'bxs-label', link: '/oms/brand' },
      { name: 'Suppliers', icon: 'bxs-user-detail', link: '/oms/supplier' },
    ],
  },
  {
    name: 'System', icon: 'bx-cog', link: null,
    show: false,
    menu: [
      { name: 'Users', icon: 'bxs-group', link: '/oms/user' },
    ],
  },
])

/**
 * @param name
 * @returns {string}
 */
const activeChildMenu = (name) => {
  let style = ''

  if (name === 'categories' && route.name === 'categoryPage') {
    style = 'active-route-link'
  }

  return style
}

const subShow = (idx) => {
  for (let i in menu.value) {
    if (i != idx) {
      menu.value[i].show = false
    } else {
      menu.value[i].show = !menu.value[i].show
    }
  }
}

const closeSubMenu = () => {
  if (close.value) {
    for (let i in menu.value) {
      menu.value[i].show = false
    }
  }
}

const menuHideShow = () => {
  close.value = close.value ? null : 'close'
}
</script>
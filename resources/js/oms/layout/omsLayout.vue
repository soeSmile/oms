<template>
  <div class="sp-main" :class="close">
    <div class="sp-menu">
      <div class="head" :class="close">
        <div class="logo">
          <img src="/img/logo.png" alt="">
          <div class="title" :class="close">OMS SpecDoc</div>
        </div>
        <i class='bx bx-menu sp-fnt size-4 sp-link sp-p-2'
           @click="menuHideShow"/>
      </div>
      <div class="content">
        <ul class="links">
          <li v-for="(val,idx) in menu" :title="val.name">
            <router-link class="link"
                         :class="close"
                         @click="closeSubMenu"
                         v-if="val.link"
                         :to="val.link">
              <i class="icon bx" :class="val.icon + ' ' + close"/>
              <span class="title" :class="close">{{ val.name }}</span>
            </router-link>

            <div class="link"
                 :class="close"
                 @click="subShow(idx)"
                 v-else>
              <i class="icon bx" :class="val.icon + ' ' + close"/>
              <span class="title" :class="close">{{ val.name }}</span>
              <i v-if="val.show" class='sub-link bx bx-chevron-up' :class="close"/>
              <i v-else class='sub-link bx bx-chevron-down' :class="close"/>
            </div>

            <ul class="sub fadeInLeft" :class="(val.show ? 'show' : '') + ' ' + close"
                v-if="val.menu">
              <li v-for="sub in val.menu">
                <router-link class="link"
                             @click="closeSubMenu"
                             :to="sub.link">
                  <i class="icon bx" :class="sub.icon"/>
                  <span class="title">{{ sub.name }}</span>
                </router-link>
              </li>
            </ul>

          </li>
        </ul>
      </div>
      <div class="footer"></div>
    </div>

    <div class="sp-wrap">
      <div class="sp-head part-2">
        <div class="start"></div>
        <div class="end">
          <div class="item sp-link sp-dark"
               @click="logout">
            <i class='bx bx-log-out-circle sp-fnt size-2'/>
            <span class="sp-ml-1 sp-fnt">Выход</span>
          </div>
        </div>
      </div>

      <router-view/>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'

export default {
  name: 'omsLayout',

  setup () {
    const close = ref(null)
    const menu = ref([
      {
        name: 'Главная', icon: 'bxs-grid-alt', link: '/oms',
        show: false, menu: null,
      },
      {
        name: 'Товары', icon: 'bxs-store', link: null,
        show: false,
        menu: [
          { name: 'Номенклатура товаров', icon: 'bx-list-ul', link: '/oms/index' },
          { name: 'Номенклатура', icon: 'bx-list-ul', link: '/oms/index' },
          { name: 'Номенклатура', icon: 'bx-list-ul', link: '/oms/index' },
          { name: 'Номенклатура', icon: 'bx-list-ul', link: '/oms/index' },
        ],
      },
      {
        name: 'Поставщики', icon: 'bxs-user-detail', link: null,
        show: false,
        menu: [
          { name: 'Список', icon: 'bx-list-ul', link: '/oms/index' },
        ],
      },
      {
        name: 'Логистика', icon: 'bxs-plane-alt', link: '/oms/index',
        show: false, menu: null,
      },
    ])

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
      for (let i in menu.value) {
        menu.value[i].show = false
      }
    }

    const menuHideShow = () => {
      close.value = close.value ? null : 'close'
    }

    const logout = () => {
      axios.post('/api/logout').then(res => {
        window.location.href = '/'
      })
    }

    return {
      menu,
      subShow,
      close,
      menuHideShow,
      closeSubMenu,
      logout,
    }
  },
}
</script>
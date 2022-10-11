<template>
  <div class="sp-main" :class="close">
    <div class="sp-menu" :class="close">
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
          <li v-for="(val,idx) in menu" :title="lang(val.name)">
            <router-link class="link"
                         :class="close"
                         @click="closeSubMenu"
                         v-if="val.link"
                         :to="val.link">
              <i class="icon bx" :class="val.icon + ' ' + close"/>
              <span class="title" :class="close">
                {{ lang(val.name) }}
              </span>
            </router-link>

            <div class="link"
                 :class="close"
                 @click="subShow(idx)"
                 v-else>
              <i class="icon bx" :class="val.icon + ' ' + close"/>
              <span class="title" :class="close">
                {{ lang(val.name) }}
              </span>
              <i v-if="val.show" class='sub-link bx bx-chevron-up' :class="close"/>
              <i v-else class='sub-link bx bx-chevron-down' :class="close"/>
            </div>

            <ul class="sub" :class="(val.show ? 'show' : '') + ' ' + close"
                v-if="val.menu">
              <li v-for="sub in val.menu" :title="lang(sub.name)">
                <router-link class="link"
                             @click="closeSubMenu"
                             :to="sub.link">
                  <i class="icon bx" :class="sub.icon"/>
                  <span class="title">
                    {{ lang(sub.name) }}
                  </span>
                </router-link>
              </li>
            </ul>

          </li>
        </ul>
      </div>
      <div class="footer"></div>
    </div>

    <div class="sp-nav shadow part-2 sp-bg-white">
      <div class="start"></div>
      <div class="end end">
        <div class="item sp-link sp-dark"
             @click="logout">
          <i class='bx bx-log-out-circle sp-fnt size-2'/>
          <span class="sp-ml-1 sp-fnt">
              {{ lang('exit') }}
            </span>
        </div>
      </div>
    </div>

    <router-view/>
  </div>
</template>

<script>
import { ref } from 'vue'
import { lang } from '../../helper/translate'

export default {
  name: 'omsLayout',

  setup () {
    const close = ref(null)
    const menu = ref([
      {
        name: 'main', icon: 'bxs-home', link: '/oms',
        show: false, menu: null,
      },
      {
        name: 'directories', icon: 'bxs-grid', link: null,
        show: false,
        menu: [
          { name: 'categories', icon: 'bx-category', link: '/oms/category' },
          { name: 'goods', icon: 'bxs-store', link: '/oms/good' },
          { name: 'brands', icon: 'bxs-label', link: '/oms/brand' },
          { name: 'suppliers', icon: 'bxs-user-detail', link: '/oms/index' },
        ],
      },
      {
        name: 'reports', icon: 'bxs-report', link: '/oms/index',
        show: false, menu: null,
      },
      {
        name: 'system', icon: 'bx-cog', link: null,
        show: false,
        menu: [
          { name: 'users', icon: 'bxs-group', link: '/oms/index' },
        ],
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
      lang,
    }
  },
}
</script>